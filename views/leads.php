<?php 
$activePage = 'leads';
include('components/header.php'); 
require_once(__DIR__ . '/../controllers/leadsController.php');

$leadsController = new LeadsController();
$leads = $leadsController->index();
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
            "url": "../public/js/Spanish.json" 
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
                <th>Fecha de Prospección</th>
                <th>Cotización</th>
                <th>Gerente Responsable</th>
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
                    <td><?= htmlspecialchars($lead['fecha_prospeccion'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['cotizacion'] ?? 'N/D') ?></td>
                    <td><?= htmlspecialchars($lead['gerente_responsable'] ?? 'N/D') ?></td>
                    <td>
                        <?php if (!empty($lead['archivo'])): ?>
                            <a href="../Leads/<?= htmlspecialchars($lead['archivo']) ?>" target="_blank" download="<?= htmlspecialchars($lead['archivo']) ?>">Descargar archivo</a>
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
                <form id="addLeadForm" action="javascript:void(0);" method="POST" enctype="multipart/form-data">
                    <!-- Formulario para agregar lead -->
                    <div class="form-group">
                        <label for="empresa">Empresa</label>
                        <input type="text" class="form-control" id="empresa" name="empresa" required>
                    </div>
                    <div class="form-group">
                        <label for="localidad">Localidad</label>
                        <input type="text" class="form-control" id="localidad" name="localidad" >
                    </div>
                    <div class="form-group">
                        <label for="giro">Giro</label>
                        <input type="text" class="form-control" id="giro" name="giro" >
                    </div>
                    <div class="form-group">
                        <label for="sucursal">Sucursal</label>
                        <input type="text" class="form-control" id="sucursal" name="sucursal" >
                    </div>
                    <div class="form-group">
                        <label for="contacto">Contacto</label>
                        <input type="text" class="form-control" id="contacto" name="contacto" >
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" >
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="email" class="form-control" id="correo" name="correo" >
                    </div>
                    <div class="form-group">
                        <label for="medioContacto">Medio de Contacto</label>
                        <select class="form-control" id="mediocontacto" name="medioContacto" required>
                            <option value="Expo">Expo</option>
                            <option value="Llamada" selected>Llamada</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Pagina web">Página Web</option>
                            <option value="Generacion propia">Generación Propia</option>
                            <option value="Generacion propia" selected>Seleccionar</option>
                          
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fecha_prospeccion">Fecha de Prospección</label>
                        <input type="date" class="form-control" id="fecha_prospeccion" name="fecha_prospeccion" >
                    </div>
                    <div class="form-group">
                        <label for="cotizacion">Cotización</label>
                        <textarea class="form-control" id="cotizacion" name="cotizacion" ></textarea>
                    </div>
                    <!-- Lista desplegable de gerentes encargados de sucursal-->
                    <div class="form-group">
                        <label for="gerente">Gerente Resposable</label>
                        <select class="form-control" id="gerente" name="gerente" required>
                            <option value="Ana Velez"> Ana Velez - Saltillo / MTY</option>
                            <option value="Llamada" selected>Bertha Diaz - Cd. Juárez</option>
                            <option value="WhatsApp">Pamela Hernández - Durango</option>
                            <option value="Pagina web">Iván Martínez - Puebla</option>
                            <option value="Pagina web">Yaneth Gonzáles - Tijuana</option>
                            <option value="Pagina web">Ajelet Sánchez - Chihuahua</option>
                            <option value="Pagina web">Paola Martínez Queretaro / San Luis</option>
                            <option value="Pagina web">Sin Gerente - León</option>
                            <option value="Pagina web">Nadia Villanueva - Laguna</option>
                            <option value="Generacion propia" selected>Seleccionar</option>
                          
                        </select>
                    <div class="form-group">
                        <label for="notas">Notas</label>
                        <textarea class="form-control" id="notas" name="notas" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="estatus">Estatus</label>
                        <select class="form-control" id="estatus" name="estatus" required>
                            <option value="Nuevo">Nuevo</option>
                            <option value="Prospecto" selected>Prospecto</option>
                            <option value="En seguimiento">En seguimiento</option>
                            <option value="Interesado">Interesado</option>
                            <option value="Cotizacion" selected>Cotizacion Enviada</option>
                            <option value="Contactado">Contactado</option>
                            <option value="No contesta">No contesta</option>
                            <option value="Pendiente" selected>Pendiente</option>
                            <option value="Inservible">Inservible</option>
                            <option value="Cerrado-Ganado">Cerrado-Ganado</option>
                            <option value="Seleccionar" selected>Seleccionar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="archivo">Archivo</label>
                        <input type="file" class="form-control" id="archivo" name="archivo" accept=".pdf">
                    </div>
                    <button type="submit" onclick="submitLeadForm()" class="btn btn-success">Guardar</button>
                    </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
function submitLeadForm() {
    const form = document.getElementById('addLeadForm');
    const formData = new FormData(form);
    fetch('/Portal/controllers/LeadsController.php?action=addLead', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        Swal.fire({
            title: data.success ? 'Éxito' : 'Error',
            text: data.message,
            icon: data.success ? 'success' : 'error'
        }).then((result) => {
            if (result.isConfirmed) {
                $('#addLeadModal').modal('hide');
                location.reload(); // Opcional: Recargar la página o actualizar la tabla de leads.
            }
        });
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire('Error', 'No se pudo guardar el lead.', 'error');
    });
}
</script>

<?php include('components/footer.php'); ?>