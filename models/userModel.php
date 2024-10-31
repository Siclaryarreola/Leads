<?php
require_once('../../config/database.php'); 
class UserModel 
{
    private $db;

    public function __construct() 
    {
        // Obtiene la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todos los usuarios con sus roles, puestos y sucursales
    public function getUsuarios() 
    {
        // Consulta con JOINs para obtener los datos de las tablas relacionadas
        $query = "
            SELECT 
                usuarios.nombre,
                usuarios.correo,
                roles.rol AS rol,
                usuarios.estado,
                detalleusuarios.ultimo_acceso,
                sucursales.sucursal AS sucursal,
                puestos.puesto AS puesto
            FROM 
                usuarios
            LEFT JOIN detalleusuarios ON usuarios.id = detalleusuarios.id
            LEFT JOIN roles ON usuarios.rol = roles.id
            LEFT JOIN sucursales ON usuarios.sucursal = sucursales.id
            LEFT JOIN puestos ON usuarios.puesto = puestos.id
        ";

        $result = $this->db->query($query);

        if ($result === false) {
            die("Error en la consulta SQL: " . $this->db->error);
        }

        // Procesar resultados
        $usuarios = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $usuarios[] = $row;
            }
        }

        return $usuarios;
    }



    // Obtiene el usuario por correo electrónico
    public function getUserByEmail($email) 
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Guarda el token de recuperación de contraseña y su expiración en la base de datos
    public function savePasswordResetToken($email, $token) 
    {
        $expiry = time() + 3600; // Establece la expiración del token a 1 hora desde ahora
        $stmt = $this->db->prepare("UPDATE usuarios SET reset_token = ?, reset_expiry = ? WHERE correo = ?");
        $stmt->bind_param("sis", $token, $expiry, $email);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Verifica si el token de recuperación es válido y no ha expirado
    public function verifyPasswordResetToken($token) 
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE reset_token = ? AND reset_expiry > ?");
        $current_time = time();
        $stmt->bind_param("si", $token, $current_time);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Actualiza la contraseña del usuario y elimina el token de recuperación
    public function updatePassword($token, $hashed_password) 
    {
        $stmt = $this->db->prepare("UPDATE usuarios SET contraseña = ?, reset_token = NULL, reset_expiry = NULL WHERE reset_token = ?");
        $stmt->bind_param("ss", $hashed_password, $token);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>
