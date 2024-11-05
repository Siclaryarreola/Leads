<?php 
$activePage = 'leads';
include('components/header.php'); 
require_once('../../controllers/leadController.php');

$leadController = new LeadsController();
$leads = $leadController->index();
?>

<!-- Incluir CSS de DataTables y Bootstrap -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">

<!-- Incluir jQuery y DataTables -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.1/js/bootstrap.min.js"></script>

<!-- Inicialización de DataTables -->
<script>
$(document).ready(function() {
    $('#leadsTable').DataTable({
        "language": {
            "url": "../../public/js/Spanish.json" 
        },
        "order": [[0, "asc"]]
    });
});
</script>

<main class="container-fluid mt-5">
    <h1>Leads</h1>
    <div class="mb-3">
        <button class="btn btn-primary" data-toggle="modal" data-target="#addLeadModal">Agregar nuevo lead</button>
    </div>

    <!-- Tabla de Leads -->
    <table class="table table-striped" id="leadsTable">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Localidad</th>
                <th>Giro</th>
                <th>Estado</th>
                <th>Contacto</th>
                <th>Teléfono</th>
                <th>Correo</th>
                <th>Fecha de Prospección</th>
                <th>Cotización</th>
                <th>Notas</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($leads as $lead): ?>
                <tr>
                    <td><?= htmlspecialchars($lead['empresa'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['localidad'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['giro'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['estado'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['contacto'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['telefono'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['correo'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['fecha_prospeccion'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['cotizacion'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['notas'] ?? 'N/D') ?></td>
                    <td>
                        <?php if (!empty($lead['archivo'])): ?>
                            <a href="<?= htmlspecialchars($lead['archivo']) ?>" target="_blank">Ver archivo</a>
                        <?php else: ?>
                            N/D
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="viewLead.php?id=<?= $lead['id'] ?>" class="btn btn-info btn-sm">Detalle</a>
                        <a href="editLead.php?id=<?= $lead['id'] ?>" class="btn btn-warning btn-sm">Editar</a>
                        <a href="deleteLead.php?id=<?= $lead['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que desea eliminar?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</main>

<!-- Modal para Agregar Nuevo Lead -->
<div class="modal fade" id="addLeadModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Agregar nuevo lead</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="addLead.php" method="POST">
                    <!-- Formulario para agregar lead -->
                    <div class="form-group">
                        <label for="empresa">Empresa</label>
                        <input type="text" class="form-control" id="empresa" name="empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" required>
                    </div>
                    <div class="form-group">
                        <label for="giro">Giro</label>
                        <input type="text" class="form-control" id="giro" name="giro" required>
                    </div>
                    <div class="form-group">
                        <label for="estado">Estado</label>
                        <input type="text" class="form-control" id="estado" name="estado" required>
                    </div>
                    <div class="form-group">
                        <label for="contacto">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>
                    <div class="form-group">
                        <label for="fechaProspeccion">Fecha de Prospección</label>
                        <input type="date" class="form-control" id="fechaProspeccion" name="fechaProspeccion" required>
                    </div>
                    <div class="form-group">
                        <label for="cotizacion">Cotización</label>
                        <textarea class="form-control" id="cotizacion" name="cotizacion" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="notas">Notas</label>
                        <textarea class="form-control" id="notas" name="notas" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="archivo">Archivo</label>
                        <input type="file" class="form-control" id="archivo" name="archivo">
                    </div>
                    <button type="submit" class="btn btn-success">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('components/footer.php'); ?>