<?php

class SessionManager 
{
    public static function initSession() 
    {
        //inicia la sesion
        session_start();
        //verifica si se definio la variable de sesion
        if (!isset($_SESSION['ultimo_tiempo_actividad'])) 
        {
            //si no esta inicializada la inicia con la variable time, que cuenta el tiempo en segundos
            $_SESSION['ultimo_tiempo_actividad'] = time();
        }
    }

    public static function createSession($user)
    {
        //Crea una variable de seion que guarda los datos del uaurio
        $_SESSION['user'] = $user;
        //variable de sesion que almacena el tiempo de actividad
        $_SESSION['ultimo_tiempo_actividad'] = time();
    }

    public static function destroySession() 
    {
        //elimina las variables de la sesion, con un array vacio
        $_SESSION = [];
        //destruye la sesion
        session_destroy();
    }
}