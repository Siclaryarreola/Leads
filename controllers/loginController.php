<?php
require_once('models/LoginModel.php');//Ruta al documento de LoginModel
require_once('SessionManager.php');//Ruta al documento de SessionManager

class LoginController 
{
    //variable privada 
    private $loginModel;

    //inicializa el objeto loginModel
    public function __construct() 
    {
        // la variable accede al modelo LoginModel
        $this->loginModel = new LoginModel();
    }

    public function showLoginForm() 
    {
        // Mostrar el formulario de login
        require('views/login.php');//ruta al login
    }

    public function login() 
    {
        //verifica el tipo de metodo POST             //verifica si la variable esta vacia
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password'])) 
        {
            $email = strtolower(trim($_POST['email'])); // Normalizar email a minúsculas, no funciona!!
            $password = $_POST['password'];

            //reupera los datos del usuario del Modelo Login
            $user = $this->loginModel->getUserByEmailAndPassword($email, $password);
            if (is_array($user)) 
            {
                SessionManager::createSession($user);
                // Redirección basada en el rol del usuario
                if ($user['rol'] == 1) 
                {
                    header('Location: /Portal/views/admin/dashboardAdmin.php');//Ruta al dashboard Admin
                } 
                else 
                {
                    header('Location: /Portal/views/user/dashboardUser.php'); //Ruta al dashboard User
                }
                exit;
            } 
            //Se bloque al usuario +3 intentos
            else if ($user === 'blocked')
            {
                $_SESSION['error'] = 'La cuenta está bloqueada temporalmente. Intente de nuevo más tarde.';
                header('Location: index.php?action=showLoginForm');//Ruta al Login
                exit;
            } 
            else 
            {
                //Se activa cuando los datos son erroneos
                $_SESSION['error'] = 'Credenciales inválidas.';
                header('Location: index.php?action=showLoginForm');//Ruta al login
                exit;
            }
        }
    }
}
?>