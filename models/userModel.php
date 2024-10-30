<?php
require_once('../../config/database.php'); // Asegúrate de que la ruta es correcta

class UserModel 
{
    private $db;

    public function __construct() 
    {
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
}
