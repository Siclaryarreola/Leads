<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Ventas - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="icon" href="public/images/favico.png" type="image/x-icon">
    <link rel="shortcut icon" href="public/images/favico.png" type="image/x-icon">
</head>
<body class="bg-blue d-flex align-items-center justify-content-center min-vh-100">

<div class="container d-flex justify-content-center " style="max-width: 850px; height: auto;">
    <div class="row shadow-lg rounded overflow-hidden" style="width: 103%; min-height: 60vh;"> <!-- Ajusta la altura aquí si es necesario -->
        
        <!-- Columna de imagen -->
        <div class="col-md-6 p-0">
            <img src="public/images/bannerLogin.jpg" alt="Banner Image" class="img-fluid h-100" style="object-fit: cover;">
        </div>
        
        <!-- Columna del formulario -->
        <div class="col-md-6 d-flex align-items-center bg-white">
            <div class="p-4 w-100">
                <div class="text-center mb-4">
                    <img src="public/images/logo-d.png" alt="Company Logo" style="height: 60px;">
                </div>
                <h2 class="card-title text-center">Portal Ventas</h2>
                <p class="text-muted text-center">Bienvenido a nuestro portal. Por favor, inicia sesión para continuar.</p>

                <form id="loginForm" action="index.php?controller=login&action=login" method="POST">
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="email" name="email" placeholder="usuario@drg.mx" required>
                        <label for="email">Correo Electrónico</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="********" required autocomplete="current-password">
                        <label for="password">Contraseña</label>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="recuerdame">
                            <label class="form-check-label" for="recuerdame">Recuérdame</label>
                        </div>
                        <a href="ForgotPassword.php" class="text-decoration-none">Olvidé mi contraseña</a>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">INGRESAR</button>
                </form>

                <p class="text-center mt-3">
                    ¿No tienes una cuenta? <a href="Register.php" class="text-primary">Regístrate</a>
                </p>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
