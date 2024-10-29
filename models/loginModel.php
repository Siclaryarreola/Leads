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
        //consulta que trae los datos del usuario necesarios para el inicio de sesion 
        $sql = "SELECT id, nombre, correo, contraseña, rol, intentos_fallidos, ultimo_intento FROM usuarios WHERE correo = ?";
        $stmt = $this->db->prepare($sql);
        if (!$stmt) 
        {
            return false;
        }
        //s es el tipo de dato que traera, la funcion enlaza los parametros
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user) 
        {
            //si los intentos fallidos son +3
            if ($user['intentos_fallidos'] >= 3) 
            {
                //bloquea y tiene que esperar 30 minutos
                $lastAttemptTime = new DateTime($user['ultimo_intento']);
                $currentTime = new DateTime();
                if ($currentTime->getTimestamp() - $lastAttemptTime->getTimestamp() < 1800) 
                { // 1800 seconds = 30 minutes
                    return 'blocked';
                }
            }
            
            //verifica la contraseña ingresada con la de la base de datos
            if (password_verify($password, $user['contraseña']))
            {
                //llama a la funcion y los intentos se reinician
                $this->resetFailedAttempts($email); 
                //retorna la informacion del usuario 
                return $user;
            } 
            else 
            {
                //los intentos se agregan al contyadior
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