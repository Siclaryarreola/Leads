<?php include('components/header.php'); ?>

<!-- Incluir CSS de DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.css">

<!-- Incluir jQuery -->
<script type="text/javascript" charset="utf8" src="https://code.jquery.com/jquery-3.5.1.js"></script>
<!-- Incluir JS de DataTables -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.js"></script>
<script>
$(document).ready(function() {
    // Inicialización de la DataTable
    $('#leadsTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
        },
        "initComplete": function() {
            this.api().columns().every(function() {
                var column = this;
                var select = $('<select><option value=""></option></select>')
                    .appendTo($(column.header()).empty())
                    .on('change', function() {
                        var val = $.fn.dataTable.util.escapeRegex(
                            $(this).val()
                        );

                        column
                            .search(val ? '^' + val + '$' : '', true, false)
                            .draw();
                    });

                column.data().unique().sort().each(function(d, j) {
                    select.append('<option value="' + d + '">' + d + '</option>')
                });
            });
        }
    });
});
</script>

<main class="container-fluid mt-5">
    <h1>Leads</h1>
    <div class="mb-3">
        <button class="btn btn-primary" onclick="window.location.href='addLead.php'">Agregar Nuevo Lead</button>
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
            <?php if (!empty($leads)): ?>
                <?php foreach ($leads as $lead): ?>
                    <tr>
                        <td><?php echo $lead['empresa']; ?></td>
                        <td><?php echo $lead['localidad']; ?></td>
                        <!-- Otros campos... -->
                        <td>
                            <a href="viewLead.php?id=<?php echo $lead['id']; ?>" class="btn btn-info btn-sm">Detalle</a>
                            <a href="editLead.php?id=<?php echo $lead['id']; ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a href="deleteLead.php?id=<?php echo $lead['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Seguro que desea eliminar?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="12" class="text-center">No hay leads disponibles.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php include('components/footer.php'); ?>