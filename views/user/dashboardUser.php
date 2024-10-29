<?php 
$activePage = 'users';
include('components/header.php');
?>

<main class="container mt-5">
    <div class="row align-items-center">
        <!-- Descripción del propósito del módulo de usuarios -->
        <div class="col-md-6">
            <h2>Gestión de Usuarios</h2>
            <p>
                En este módulo, podrás gestionar los perfiles de todos los usuarios registrados en el sistema. 
                Aquí puedes agregar nuevos usuarios, editar detalles de usuarios existentes y asignar roles 
                específicos para controlar los permisos y accesos a diversas áreas del portal. 
                Este sistema garantiza un manejo seguro y eficiente de la información de cada usuario,
                asegurando que solo los roles autorizados tengan acceso a funcionalidades críticas.
            </p>
        </div>

        <!-- Imagen a la derecha -->
        <div class="col-md-6 text-center">
            <img src="public/images/user_management.jpg" alt="Gestión de Usuarios" class="img-fluid rounded shadow">
        </div>
    </div>
</main>

<?php
include('components/footer.php');
?>
