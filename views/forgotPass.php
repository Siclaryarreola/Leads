<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="public/css/style.css">
</head>
<body class="d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f0f2f5;">
<main class="form-container text-center p-4 rounded" style="max-width: 400px; background-color: white; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
    <img src="/Portal/public/images/logo-d.png" alt="Company Logo" style="height: 60px;" class="mb-3">
    <h2>Recuperar Contraseña</h2>
    <p>Por favor, ingrese su correo electrónico y le enviaremos instrucciones para recuperar su contraseña.</p>
    <form action="index.php?controller=auth&action=sendPasswordReset" method="POST">
        <div class="form-floating mb-3">
            <input type="email" name="email" id="email" class="form-control" placeholder="Correo Electrónico" required>
            <label for="email">Correo Electrónico</label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Enviar Correo</button>
    </form>
</main>
</body>
</html>
