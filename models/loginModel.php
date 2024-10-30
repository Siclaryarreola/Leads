<?php
require_once('config/database.php');//ruta a la conexion de la bd

class LoginModel
{
    private $db;

    public function __construct() 
    {
        //es igual a los datos de la bd
        $this->db = Database::getInstance()->getConnection();
    }

    public function getUserByEmailAndPassword($email, $password) 
    {
        $sql = "SELECT id, nombre, correo, contraseña, rol, puesto, sucursal, estado, intentos_fallidos, ultimo_intento FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) {
            return false;
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) {
            if ($user['intentos_fallidos'] >= 3) {
                // Verificar si ultimo_intento no es NULL antes de intentar crear DateTime
                if ($user['ultimo_intento'] !== NULL) {
                    $lastAttemptTime = new DateTime($user['ultimo_intento']);
                    $currentTime = new DateTime();
                    if (($currentTime->getTimestamp() - $lastAttemptTime->getTimestamp()) < 1800) { // 1800 seconds = 30 minutes
                        return 'blocked';
                    }
                }
            }

            if (password_verify($password, $user['contraseña'])) {
                $this->resetFailedAttempts($email);
                return $user;
            } else {
                $this->incrementFailedAttempts($email);
            }
        }
        return null;
    }

    private function incrementFailedAttempts($email) 
    {
        //actualiza la columna de intentos fallidos
        $sql = "UPDATE usuarios SET intentos_fallidos = intentos_fallidos + 1, ultimo_intento = NOW() WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }

    private function resetFailedAttempts($email)
    {
        //actualiza los intentos fallidos a 0 cuando ya inicio sesoin 
        $sql = "UPDATE usuarios SET intentos_fallidos = 0 WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
    }
}
