<?php 
$activePage = 'users';
require_once('components/header.php');
require_once('../../config/database.php');

// Obtener la conexión a la base de datos
$db = Database::getInstance()->getConnection();

// Consulta con JOINs para obtener datos de las tablas `usuarios`, `detalleusuarios`, y `roles`
$query = "
    -- selecciona de la tabla usuarios nombre, correo y rol
    SELECT usuarios.nombre, 
           usuarios.correo, 
           roles.rol AS rol,  -- Aquí usamos roles.rol para evitar ambigüedad
           -- Selecciona de la tabla detalleusuarios estdo y ultimo_acceso
           detalleusuarios.estado, 
           detalleusuarios.ultimo_acceso
    FROM usuarios 
    LEFT JOIN detalleusuarios ON usuarios.detalle_id = detalleusuarios.id
    LEFT JOIN roles ON usuarios.rol = roles.id
";
$result = $db->query($query);

// Verificar si la consulta se ejecutó correctamente
if ($result === false) {
    echo "<p>Error en la consulta SQL: " . $db->error . "</p>";
    exit;
}

// Procesar resultados
$usuarios = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuarios[] = $row;
    }
}
?>

<main class="container mt-5">
    <h1>Gestión de Usuarios</h1>
    <p>Listado y gestión de usuarios del sistema.</p>

    <!-- Botón para añadir un nuevo usuario -->
    <div class="mb-3">
        <button class="btn btn-primary" onclick="window.location.href='addUser.php'">Añadir Usuario</button>
    </div>

    <!-- Tabla de usuarios -->
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Nombre de Usuario</th>
                <th>Correo Electrónico</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Último Acceso</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($usuarios) > 0): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['estado']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['ultimo_acceso']); ?></td>
                        <td>
                            <a href="edit_user.php?id=<?php echo urlencode($usuario['nombre']); ?>" class="btn btn-sm btn-warning">Editar</a>
                            <a href="delete_user.php?id=<?php echo urlencode($usuario['nombre']); ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php include('components/footer.php'); ?>
