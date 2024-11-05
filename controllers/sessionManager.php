<?php

class SessionManager 
{
    const TIEMPO_MAXIMO_INACTIVIDAD = 1800; // 30 minutos

    public static function initSession() 
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['ultimo_tiempo_actividad'])) {
            $_SESSION['ultimo_tiempo_actividad'] = time();
        } else {
            self::checkSessionTimeout();
        }
    }

    public static function createSession($user)
    {
        $_SESSION['user'] = $user;
        $_SESSION['ultimo_tiempo_actividad'] = time();
    }

    public static function destroySession() 
    {
        $_SESSION = [];
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }
        session_destroy();
        header("Location: views/login.php"); // Asegura que esta ruta es la correcta para el login
        exit;
    }

    private static function checkSessionTimeout() 
    {
        if (time() - $_SESSION['ultimo_tiempo_actividad'] > self::TIEMPO_MAXIMO_INACTIVIDAD) {
            self::destroySession();
        } else {
            $_SESSION['ultimo_tiempo_actividad'] = time();
        }
    }

    public static function authenticate() 
    {
        if (!isset($_SESSION['user'])) {
            header('Location: views/login.php'); // Asegura que esta ruta es la correcta para el login
            exit();
        }
    }
}

?>