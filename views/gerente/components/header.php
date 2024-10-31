<?php
require_once('../../controllers/SessionController.php');
SessionController::initSession();
SessionController::authenticate();

$user = $_SESSION['user'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio - Gerentes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/styleDashboard.css">
    <link rel="icon" href="../../public/images/favico.png" type="image/x-icon">
    <link rel="shortcut icon" href="../../public/images/favico.png" type="image/x-icon">
</head>
<body>
<header class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="../../public/images/logo-d.png" alt="Company Logo" style="height: 50px;">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item <?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">
                    <a class="nav-link" href="dashboarGerente.php">Inicio</a>
                </li>
                <li class="nav-item <?php echo ($activePage == 'leads') ? 'active' : ''; ?>">
                    <a class="nav-link" href="leadsManagement.php">Leads</a>
                </li>
                <li class="nav-item <?php echo ($activePage == 'Contactos') ? 'active' : ''; ?>">
                    <a class="nav-link" href="contactosManagement.php">Contactos</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Bienvenido, <?php echo htmlspecialchars($user['nombre']); ?>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="userProfile.php">Mi Perfil</a>
                        <a class="dropdown-item" href="../../controllers/logout.php" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</header>
<!-- Form hidden for logout -->
<form id="logout-form" action="../../controllers/logout.php" method="POST" style="display:none;"></form>

<!-- Scripts necesarios para Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>