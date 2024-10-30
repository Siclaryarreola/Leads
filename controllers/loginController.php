<?php
require_once('models/LoginModel.php'); // Ruta al documento de LoginModel
require_once('SessionManager.php');    // Ruta al documento de SessionManager

class LoginController 
{
    private $loginModel;

    public function __construct() 
    {
        $this->loginModel = new LoginModel();
    }

    public function showLoginForm() 
    {
        require('views/login.php'); // Ruta al login
    }

    public function login() 
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password'])) 
        {
            $email = strtolower(trim($_POST['email']));
            $password = $_POST['password'];

            // Recuperar los datos del usuario desde el modelo de login
            $user = $this->loginModel->getUserByEmailAndPassword($email, $password);
            if (is_array($user)) 
            {
                SessionManager::createSession($user);

                // Redirección basada en el rol del usuario
                if ($user['rol'] == 1)
                {
                    header('Location: /Portal/views/admin/dashboardAdmin.php'); // Ruta al dashboard Admin
                } 
                else if ($user['rol'] == 2)
                {
                    header('Location: /Portal/views/gerente/dashboardGerente.php'); // Ruta al dashboard Gerente
                }
                else if ($user['rol'] == 0)
                {
                    header('Location: /Portal/views/user/dashboardUser.php'); // Ruta al dashboard User
                }

                exit;
            } 
            else if ($user === 'blocked')
            {
                $_SESSION['error'] = 'La cuenta está bloqueada temporalmente. Intente de nuevo más tarde.';
                header('Location: index.php?action=showLoginForm'); // Ruta al Login
                exit;
            } 
            else 
            {
                $_SESSION['error'] = 'Credenciales inválidas.';
                header('Location: index.php?action=showLoginForm'); // Ruta al login
                exit;
            }
        }
    }
}
?>
