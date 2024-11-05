
<?php
require_once('models/LoginModel.php');
require_once('SessionManager.php');

class LoginController {
    private $loginModel;

    public function __construct() {
        $this->loginModel = new LoginModel();
    }

    public function showLoginForm() {
        require('views/login.php');
    }

    public function showForgotForm() {
        require('views/forgotPass.php');
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['email']) && !empty($_POST['password'])) {
            $email = strtolower(trim($_POST['email'])); // Normalizar email a minúsculas
            $password = $_POST['password'];

            $user = $this->loginModel->getUserByEmailAndPassword($email, $password);
            if (is_array($user)) {
                SessionManager::createSession($user);
                $this->redirectUserBasedOnRole($user['rol']);
            } else if ($user === 'blocked') {
                $_SESSION['error'] = 'La cuenta está bloqueada temporalmente. Intente de nuevo más tarde.';
                header('Location: index.php?action=showLoginForm');
                exit;
            } else {
                $_SESSION['error'] = 'Credenciales inválidas.';
                header('Location: index.php?action=showLoginForm');
                exit;
            }
        }
    }
//Redirecciona a la vista correspondiente segun el rol 
    private function redirectUserBasedOnRole($role) {
        switch ($role) {
            case 1:
                header('Location: /Portal/views/admin/dashboardAdmin.php');
                break;
            case 2:
                header('Location: /Portal/views/gerente/dashboardGerente.php');
                break;
            case 0:
                header('Location: /Portal/views/user/dashboardUser.php');
                break;
            default:
                $_SESSION['error'] = 'Acceso Denegado: Usuario desconocido.';
                header('Location: index.php?action=showLoginForm');
                break;
        }
        exit;
    }
}
