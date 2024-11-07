<?php
// Ruta: models/ProfileModel.php

class ProfileModel {
    private $db;

    public function __construct() {
        // Conectar a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener el perfil de un usuario por su ID
    public function getUserProfileById($userId) {
        $query = "SELECT nombre, email, fecha_creacion, ultimo_login,  foto_perfil, notificaciones, rol 
                  FROM usuarios WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $userId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar la foto de perfil de un usuario
    public function updateProfilePhoto($userId, $filePath) 
    {
        $query = "UPDATE usuarios SET foto_perfil = :foto_perfil WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['foto_perfil' => $filePath, 'id' => $userId]);
    }

    // Método opcional para actualizar otros datos del perfil
    public function updateProfileInfo($userId, $data) {
        $query = "UPDATE usuarios SET nombre = :nombre, email = :email, genero = :genero, notificaciones = :notificaciones 
                  WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([
            'nombre' => $data['nombre'],
            'email' => $data['email'],
            'genero' => $data['genero'],
            'notificaciones' => $data['notificaciones'],
            'id' => $userId
        ]);
    }
}
