<?php 
$activePage = 'users';
require_once('components/header.php');
require_once('../../config/database.php');

// Obtener la conexión a la base de datos
$db = Database::getInstance()->getConnection();

// Consulta con JOINs para obtener datos de las tablas `usuarios`, `detalleusuarios`, y `roles`
$query = "
    SELECT 
        usuarios.nombre,                   -- Seleccionar el nombre del usuario desde la tabla usuarios
        usuarios.correo,                   -- Seleccionar el correo electrónico del usuario desde la tabla usuarios
        roles.rol AS rol,                  -- Obtener el nombre del rol desde la tabla roles, renombrado como 'rol'
        usuarios.estado,                   -- Obtener el estado del usuario directamente desde la tabla usuarios (Ej.: Activo, Inactivo, Bloqueado)
        detalleusuarios.ultimo_acceso,     -- Obtener la fecha y hora del último acceso del usuario desde la tabla detalleusuarios
        sucursales.sucursal AS sucursal,       -- Obtener el nombre de la sucursal desde la tabla sucursal
        puestos.puesto AS puesto           -- Obtener el nombre del puesto desde la tabla puestos
    FROM 
        usuarios
    -- Relacionar la tabla usuarios con detalleusuarios usando detalle_id de usuarios y id de detalleusuarios
    LEFT JOIN detalleusuarios ON usuarios.id = detalleusuarios.id
    LEFT JOIN roles ON usuarios.rol = roles.id -- Relacionar la tabla usuarios con roles usando rol de usuarios y id de roles para obtener el nombre del rol
    LEFT JOIN sucursales ON usuarios.sucursal = sucursales.id -- Relacionar la tabla usuarios con sucursal usando sucursal de usuarios y id de sucursal para obtener el nombre de la sucursal
    LEFT JOIN puestos ON usuarios.puesto = puestos.id  -- Relacionar la tabla usuarios con puestos usando puesto de usuarios y id de puestos para obtener el nombre del puesto
";


$result = $db->query($query);

// Verificar si la consulta se ejecutó correctamente
if ($result === false) {
    echo "<p>Error en la consulta SQL: " . $db->error . "</p>";
    exit;
}

// Procesar resultados
$usuarios = [];
if ($result->num_rows > 0) 
{
    while ($row = $result->fetch_assoc()) 
    {
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
                <th>Puesto</th>
                <th>Sucursal</th>
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
                        <td><?php echo htmlspecialchars($usuario['puesto']); ?></td>
                        <td><?php echo htmlspecialchars($usuario['sucursal']); ?></td>
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
