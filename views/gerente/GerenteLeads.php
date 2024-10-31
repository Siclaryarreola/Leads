<?php include('components/header.php'); ?>

<main class="container mt-5">
    <h1>Leads</h1>
    <div class="mb-3">
        <button class="btn btn-primary" onclick="window.location.href='addLead.php'">Agregar Nuevo Lead</button>
    </div>

    <!-- Filtros -->
    <form method="GET" class="mb-3">
        <div class="row">
            <div class="col-md-3">
                <select name="estado" class="form-control">
                    <option value="">Filtrar por Estado</option>
                    <!-- Opciones dinámicas de estado -->
                </select>
            </div>
            <div class="col-md-3">
                <select name="giro" class="form-control">
                    <option value="">Filtrar por Giro</option>
                    <!-- Opciones dinámicas de giro -->
                </select>
            </div>
            <div class="col-md-3">
                <select name="estatus" class="form-control">
                    <option value="">Filtrar por Estatus</option>
                    <!-- Opciones dinámicas de estatus -->
                </select>
            </div>
            <!-- Agrega otros filtros necesarios aquí -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-info">Filtrar</button>
            </div>
        </div>
    </form>

    <!-- Tabla de Leads -->
    <table class="table table-striped">
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
            <!-- Datos de leads desde el backend -->
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
        </tbody>
    </table>
</main>

<?php include('components/footer.php'); ?>
