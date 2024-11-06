<?php
// Ruta: controllers/ProfileController.php

require_once('../../models/profileModel.php'); // Asegúrate de que la ruta es correcta
require_once('../../controllers/SessionManager.php'); // Para gestionar la sesión del usuario

class ProfileController {
    private $profileModel;

    public function __construct() {
        $this->profileModel = new ProfileModel(); // Crear instancia del modelo de perfil
    }

    // Método para mostrar el perfil del usuario actual
    public function showProfile() {
        SessionManager::initSession();
        SessionManager::authenticate();

        // Obtener el ID del usuario desde la sesión
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId) {
            header('Location: login.php');
            exit();
        }

        // Obtener los datos del perfil desde el modelo
        $profileData = $this->profileModel->getUserProfileById($userId);

        if (!$profileData) {
            echo "Error: No se encontraron datos del perfil.";
            exit();
        }

        include('../../views/profile.php');
    }

    // Método para actualizar la foto de perfil
    public function updateProfilePhoto() {
        SessionManager::initSession();
        $userId = $_SESSION['user']['id'] ?? null;

        if (!$userId || $_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_FILES['foto_perfil'])) {
            header('Location: profile.php');
            exit();
        }

        $file = $_FILES['foto_perfil'];
        if ($file['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (in_array($file['type'], $allowedTypes)) {
                $destinationPath = "../../uploads/" . basename($file['name']);
                if (move_uploaded_file($file['tmp_name'], $destinationPath)) {
                    // Guardar la ruta en la base de datos
                    $this->profileModel->updateProfilePhoto($userId, $destinationPath);
                    $_SESSION['success'] = "Foto de perfil actualizada correctamente.";
                } else {
                    $_SESSION['error'] = "Error al subir el archivo.";
                }
            } else {
                $_SESSION['error'] = "Formato de archivo no permitido.";
            }
        } else {
            $_SESSION['error'] = "Error en el archivo.";
        }

        header('Location: profile.php');
        exit();
    }
}
