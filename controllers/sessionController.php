<?php
require_once('SessionManager.php');  // clase que gestiona el inicio y el cierre de sesiones.

class SessionController 
{
    public static function initSession() 
    {
        SessionManager::initSession();
        self::checkSessionTimeout();
    }

    //funcion de tiempo de la sesion
    private static function checkSessionTimeout() 
    {
        define('TIEMPO_MAXIMO_INACTIVIDAD', 1800);  // 30 minutos 

        //verifica la variable sesion
        if (isset($_SESSION['ultimo_tiempo_actividad']) && (time() - $_SESSION['ultimo_tiempo_actividad'] > TIEMPO_MAXIMO_INACTIVIDAD)) 
        {
            self::endSession();
        }
        $_SESSION['ultimo_tiempo_actividad'] = time();
    }

    public static function endSession() 
    {
        //destruye la sesion
        SessionManager::destroySession();
        header("Location: views/login.php");  //ruta al login
        exit;
    }

    public static function authenticate() 
    {
        //si el usuario no ha iniciado sesion
        if (!isset($_SESSION['user'])) 
        {
            header('Location: views/login.php'); //ruta al login 
            exit();
        }
    }
}
?>