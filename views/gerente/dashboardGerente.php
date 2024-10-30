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
            El sistema está dirigido a facilitar el proceso desde la creación
             de cotizaciones hasta su cierre, proporcionando funcionalidades como la creación 
             de nuevas cotizaciones, actualización de información de clientes, seguimiento de 
             cotizaciones en diferentes etapas, y generación de reportes para análisis de desempeño. 
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
