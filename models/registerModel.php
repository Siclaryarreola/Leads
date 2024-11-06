<?php
require_once('config/database.php'); // Ruta a la configuración de la base de datos

class RegisterModel 
{
    private $db;

    public function __construct() 
    {
        $this->db = Database::getInstance()->getConnection();
        if (!$this->db) 
        {
            die("Error de conexión a la base de datos.");
        }
    }

    // Función para crear un usuario con los datos de nombre, email, contraseña, puesto y sucursal
    public function createUser($name, $email, $password, $puesto, $sucursal) 
    {
        // Hashea la contraseña para almacenarla de manera segura
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Inserta el nuevo usuario en la tabla usuarios
        $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol, puesto, sucursal) VALUES (?, ?, ?, 0, ?, ?)";
        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        // Vincula los parámetros a la consulta SQL
        $stmt->bind_param("sssss", $name, $email, $hashedPassword, $puesto, $sucursal);
        $stmt->execute();

        // Verifica si se insertó correctamente
        if ($stmt->affected_rows === 1) {
            return $this->db->insert_id;
        }
        return false;
    }

    // Función para obtener todas las sucursales desde la tabla `sucursales`
    public function getSucursales() 
    {
        $sucursales = [];
        $sql = "SELECT id, sucursal FROM sucursales ORDER BY sucursal ASC"; // Cambiado a `sucursales`
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sucursales[] = $row;
            }
        }
        
        return $sucursales;
    }

    // Función para obtener todos los puestos desde la tabla `puestos`
    public function getPuestos() 
    {
        $puestos = [];
        $sql = "SELECT id, puesto FROM puestos ORDER BY puesto ASC"; // Cambiado a `puestos`
        $result = $this->db->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $puestos[] = $row;
            }
        }

        return $puestos;
    }
}
