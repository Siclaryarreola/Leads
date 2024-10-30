<?php 
$activePage = 'users';
require_once('components/header.php');
require_once('../../models/userModel.php'); // Asegúrate de que la ruta es correcta

// Crear instancia del modelo y obtener los usuarios
$userModel = new UserModel();
$usuarios = $userModel->getUsuarios();
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
                    <td colspan="8">No se encontraron usuarios.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</main>

<?php include('components/footer.php'); ?>
