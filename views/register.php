<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Ventas - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="icon" href="public/images/favico.png" type="image/x-icon">
    <link rel="shortcut icon" href="public/images/favico.png" type="image/x-icon">
</head>
<body class="bg-white">

<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-md-5">
            <div class="text-center mb-4">
                <img src="public/images/logo-d.png" alt="Company Logo" style="height: 60px;">
            </div>
            <div class="card shadow">
                <div class="card-body">
                    <h2 class="card-title text-center">Crear una cuenta</h2>
                    <p class="text-muted text-center">Por favor, rellena los siguientes datos para registrarte.</p>

                    <form id="registerForm" action="index.php?controller=register&action=register" method="POST">
                    <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Tu nombre" required>
                            <label for="nombre">Nombre</label>
                     </div>
                    <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" name="email" placeholder="usuario@drg.mx" required>
                            <label for="email">Correo Electrónico</label>
                     </div>
                    <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="password" name="password" placeholder="********" required>
                            <label for="password">Contraseña</label>
                     </div>
                        <button type="submit" class="btn btn-primary w-100">Registrarse</button>
                    </form>

                    <p class="text-center mt-3">
                        ¿Ya tienes cuenta? <a href="Login.php" class="text-primary">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="public/js/loginValidation.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>