<?php  
$activePage = 'leads';
include('components/header.php'); 
require_once(__DIR__ . '/../controllers/LeadsController.php');

// Instancia del controlador
$leadsController = new LeadsController();
$leads = $leadsController->index();

// Obtener el rol del usuario desde la sesión
$rolUsuario = $_SESSION['user']['rol'] ?? null;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Leads</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<main class="container-fluid mt-5">
    <h1>Leads</h1>
    <div class="mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addLeadModal">Agregar nuevo lead</button>
    </div>

    <!-- Tabla de Leads -->
    <table class="table table-striped" id="leadsTable">
        <thead>
            <tr>
                <th>Período</th>
                <th>Gerente Responsable</th>
                <th>Fecha de Generación</th>
                <th>Medio de Contacto</th>
                <th>Estatus</th>
                <?php if ($rolUsuario === 'gerente'): ?>
                    <th>Monto Cotización</th>
                <?php endif; ?>
                <th>Línea de Negocio</th>
                <th>Notas</th>
                <?php if ($rolUsuario === 'gerente'): ?>
                    <th>Archivo</th>
                <?php endif; ?>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <!-- Aquí se cargarán los leads desde el backend -->
        </tbody>
    </table>
</main>

<!-- Modal para Agregar Nuevo Lead -->
<div class="modal fade" id="addLeadModal" tabindex="-1" role="dialog" aria-labelledby="addLeadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addLeadModalLabel">Agregar Nuevo Lead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addLeadForm" action="javascript:void(0);" method="POST">
                    <div class="row">
                        <div class="col-md-6">
                            <!-- Campo de Período -->
                            <!-- ... otros campos ... -->
                            <!-- Campo de Monto Cotización -->
                            <?php if ($rolUsuario === 'gerente'): ?>
                                <div class="form-group">
                                    <label for="monto_cotizacion">Monto Cotización</label>
                                    <input type="number" class="form-control" id="monto_cotizacion" name="monto_cotizacion" required>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <!-- Campo de Estatus -->
                            <!-- ... otros campos ... -->
                            <!-- Campo de Archivo -->
                            <?php if ($rolUsuario === 'gerente'): ?>
                                <div class="form-group">
                                    <label for="archivo">Archivo</label>
                                    <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include('components/footer.php'); ?>
