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
                detalleusuarios.intentos_fallidos,
                detalleusuarios.ultimo_intento,
                sucursales.sucursal AS sucursal,
                puestos.puesto AS puesto
            FROM 
                usuarios
            LEFT JOIN detalleusuarios ON usuarios.detalle_id = detalleusuarios.id
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
        // Modificación para incluir la unión con detalleusuarios
        $query = "
            SELECT 
                usuarios.id,
                usuarios.nombre,
                usuarios.correo,
                usuarios.contraseña,
                usuarios.rol,
                usuarios.puesto,
                usuarios.sucursal,
                usuarios.estado,
                detalleusuarios.intentos_fallidos,
                detalleusuarios.ultimo_intento,
                detalleusuarios.ultimo_acceso,
                detalleusuarios.reset_token,
                detalleusuarios.reset_expiry
            FROM 
                usuarios
            LEFT JOIN detalleusuarios ON usuarios.detalle_id = detalleusuarios.id
            WHERE 
                usuarios.correo = ?
        ";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Guarda el token de recuperación de contraseña y su expiración en la tabla `detalleusuarios`
    public function savePasswordResetToken($email, $token) 
    {
        $expiry = time() + 3600; // Establece la expiración del token a 1 hora desde ahora
        
        // Consulta para actualizar en la tabla detalleusuarios en lugar de usuarios
        $query = "
            UPDATE 
                detalleusuarios
            SET 
                reset_token = ?, 
                reset_expiry = ?
            WHERE 
                id = (SELECT detalle_id FROM usuarios WHERE correo = ?)
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("iis", $token, $expiry, $email);
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }

    // Verifica si el token de recuperación es válido y no ha expirado
    public function verifyPasswordResetToken($token) 
    {
        $current_time = time();
        
        // Consultar en `detalleusuarios` para verificar el token y la expiración
        $query = "
            SELECT 
                usuarios.id, 
                usuarios.nombre, 
                usuarios.correo, 
                detalleusuarios.reset_token, 
                detalleusuarios.reset_expiry 
            FROM 
                detalleusuarios
            JOIN 
                usuarios ON detalleusuarios.id = usuarios.detalle_id
            WHERE 
                detalleusuarios.reset_token = ? 
                AND detalleusuarios.reset_expiry > ?
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $token, $current_time);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    // Actualiza la contraseña del usuario y elimina el token de recuperación
    public function updatePassword($token, $hashed_password) 
    {
        // Actualizar en la tabla usuarios y limpiar token en detalleusuarios
        $query = "
            UPDATE 
                usuarios 
            JOIN 
                detalleusuarios ON usuarios.detalle_id = detalleusuarios.id
            SET 
                usuarios.contraseña = ?, 
                detalleusuarios.reset_token = NULL, 
                detalleusuarios.reset_expiry = NULL
            WHERE 
                detalleusuarios.reset_token = ?
        ";
        
        $stmt = $this->db->prepare($query);
        $stmt->bind_param("si", $hashed_password, $token); 
        $stmt->execute();
        return $stmt->affected_rows > 0;
    }
}
?>
