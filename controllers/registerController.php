<?php
require_once('models/RegisterModel.php'); //ruta al Modelo de Registro

class RegisterController 
{
    //variable privada
    private $registerModel;

    public function __construct() 
    {
        //Es igual a lo que haya en el modelo de Registro
        $this->registerModel = new RegisterModel();
    }

    public function showRegistrationForm() 
    {
        require('views/register.php'); // Ruta a la vista Registro
    }

    public function register() 
    {
        // trim, Verifica que los datos estén presentes y no solo llenos de espacios
        $nombre = trim($_POST['nombre'] ?? ''); //elimina los espacios en blanco
        $email = strtolower(trim($_POST['email'] ?? '')); // Convertir el email a minúsculas, no funciona!!
        $password = trim($_POST['password'] ?? ''); // Asegurarse de que no haya espacios al inicio o al final
    
        //Verifica que no esten vacios
        if (!empty($nombre) && !empty($email) && !empty($password)) 
        {
            try 
            {
                // Validar que el email cumpla con el formato deseado
                if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !str_ends_with($email, '@drg.mx')) 
                {
                    //Mensaje de error que se guarda en la sesion 
                    $_SESSION['error'] = 'Por favor, introduzca una dirección de correo electrónico válida que termine en @drg.mx';
                    header('Location: index.php?controller=register&action=showRegistrationForm'); //Ruta a la vista de registro
                    exit();
                }
    
                // Asegúrate de que la contraseña no contenga espacios en el medio
                if (preg_match('/\s/', $password)) 
                {
                    //Se guarda el error en la variable de sesion
                    $_SESSION['error'] = 'La contraseña no puede contener espacios.';
                    header('Location: index.php?controller=register&action=showRegistrationForm');
                    exit();
                }
    
                //la variable es igual al modelo de registro, y son los parametros de entrada
                $result = $this->registerModel->createUser($nombre, $email, $password);
                if ($result) 
                {
                    $_SESSION['success'] = 'Registro exitoso';
                    header('Location: index.php?controller=login&action=showLoginForm');
                    exit();
                } 
                else 
                {
                    $_SESSION['error'] = 'Error en el registro. Es posible que el correo electrónico ya esté registrado.';
                    header('Location: index.php?controller=register&action=showRegistrationForm');
                    exit();
                }
            } 
            //almacena el error en una variable
            catch (Exception $e) 
            {

                //funcion de mensaje de error
                error_log('Error en el registro: ' . $e->getMessage());
                $_SESSION['error'] = 'Internal server error.';
                header('Location: index.php?controller=register&action=showRegistrationForm');//Ruta a la vista de registro
                exit();
            }
        } 
        else 
        {
            $_SESSION['error'] = 'Todos los campos son obligatorios.';
            header('Location: index.php?controller=register&action=showRegistrationForm');//Ruta a la vista de registro
            exit();
        }
    } 
}