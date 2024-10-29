<?php 
$activePage = 'dashboard';
include('components/header.php');
?>

<main class="container mt-5">
    <div class="row align-items-center">
        <!-- Descripción del propósito del proyecto -->
        <div class="col-md-6">
            <h2>Bienvenido al Portal de Administración de Cotizaciones</h2>
            <p>
                Este portal está diseñado para gestionar las operaciones de ventas y usuarios del sistema.
                Como administrador, puedes gestionar usuarios, revisar estadísticas de ventas y optimizar el 
                flujo de trabajo de la organización. El objetivo es proporcionar una plataforma eficiente y 
                amigable para realizar todas las tareas administrativas de manera centralizada.
            </p>
        </div>

        <!-- Imagen a la derecha -->
        <div class="col-md-6 text-center">
        <img src="../../public/images/banner_portal.jpg" alt="Imagen de administración" class="img-fluid rounded shadow">

        </div>
    </div>
</main>

<?php
include('components/footer.php');
?>
