<?php
require_once('config/database.php'); //ruta a la configuracon de la base de datos

class RegisterModel 
{
    private $db;

    public function __construct() 
    {
        $this->db = Database::getInstance()->getConnection();
    }

    //los parametros de la funcion
    public function createUser($name, $email, $password) 
    {
        //hashea la contraseña para almacenarla en la bs
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        //agrega el nuevo usuaro a la tabla usuarios
        $sql = "INSERT INTO usuarios (nombre, correo, contraseña, rol) VALUES (?, ?, ?, 0)";
        $stmt = $this->db->prepare($sql);
        if (!$stmt)
        {
            return false;
        }
        //tipo de dato 
        $stmt->bind_param("sss", $name, $email, $hashedPassword);
        $stmt->execute();
        if ($stmt->affected_rows === 1) 
        {
            //retorna el id de la fila que se actualizo
            return $this->db->insert_id;
        }
        return false;
    }
}