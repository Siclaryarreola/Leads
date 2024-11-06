<?php 
$activePage = 'profile';
require_once('components/header.php');
require_once('../../models/userModel.php'); // Asegúrate de que la ruta es correcta

// Crear instancia del modelo y obtener los usuarios
$userModel = new UserModel();
$usuarios = $userModel->getUsuarios();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Usuario</title>
    <link rel="stylesheet" href="public/css/styleProfile.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center min-vh-100">
        <div class="main-container">
            <!-- Sección del perfil -->
            <div class="profile-container">
                <div class="profile-photo">
                    <?php if (!empty($profileData['foto_perfil'])): ?>
                        <img src="<?php echo htmlspecialchars($profileData['foto_perfil']); ?>" alt="Foto del usuario" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                    <?php else: ?>
                        <img src="public/images/default-profile.png" alt="Foto predeterminada" class="img-fluid rounded-circle" style="width: 100px; height: 100px;">
                    <?php endif; ?>
                </div>
                <div class="user-info">
                    <h1><?php echo htmlspecialchars($profileData['nombre']); ?></h1>
                    <p><strong>Correo Electrónico:</strong> <?php echo htmlspecialchars($profileData['email']); ?></p>
                    <p><strong>Creado:</strong> <?php echo htmlspecialchars($profileData['fecha_creacion']); ?></p>
                    <p><strong>Último inicio de sesión:</strong> <?php echo htmlspecialchars($profileData['ultimo_login']); ?></p>
                    <p><strong>Género:</strong> <?php echo htmlspecialchars($profileData['genero']); ?></p>

                    <form action="profileController.php?action=updateProfilePhoto" method="POST" enctype="multipart/form-data">
                        <div class="form-group mt-3">
                            <label for="foto_perfil">Cambiar Foto de Perfil:</label>
                            <input type="file" name="foto_perfil" id="foto_perfil" class="form-control-file" accept="image/*" required>
                        </div>
                        <button type="submit" class="btn btn-primary mt-2">Actualizar Foto</button>
                    </form>
                </div>
            </div>

            <!-- Sección de administrador -->
            <div class="sidebar">
                <h2><?php echo strtoupper(htmlspecialchars($profileData['rol'])); ?></h2>
                <button class="btn btn-warning border-white text-dark rounded">Editar Perfil</button>
                <ul>
                    <li>Acceso a la administración de usuarios</li>
                    <li>Acceso a la configuración</li>
                    <li>Acceso a las notificaciones</li>
                </ul>
            </div>
        </div>
    </div>
</body>
</html>
