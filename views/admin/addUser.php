<?php
$activePage = 'addUser';
require_once('components/header.php'); // Asegúrate de que esta ruta es correcta
require_once('../../models/userModel.php'); // Asegúrate de que esta ruta es correcta

// Crear instancia del modelo de usuario
$userModel = new UserModel();

// Obtener listas de sucursales y puestos
$sucursales = $userModel->getSucursales();
$puestos = $userModel->getPuestos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../public/css/styleDashboard.css">
</head>
<body>
<main class="container mt-5">
    <h1 class="text-center mb-4">Agregar Usuario:</h1>

    <!-- Contenedor del formulario centrado -->
    <div class="form-container mx-auto" style="background-color: white; padding: 30px; border: 1px solid #ddd; border-radius: 8px; max-width: 500px;">
        <form action="index.php?controller=user&action=register" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre:</label>
                <input type="text" name="nombre" id="nombre" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="sucursal">Sucursal:</label>
                <select name="sucursal" id="sucursal" class="form-control" required>
                    <option value="">Seleccione una sucursal</option>
                    <?php if (!empty($sucursales)): ?>
                        <?php foreach ($sucursales as $sucursal): ?>
                            <option value="<?php echo $sucursal['id']; ?>">
                                <?php echo htmlspecialchars($sucursal['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="puesto">Puesto:</label>
                <select name="puesto" id="puesto" class="form-control" required>
                    <option value="">Seleccione un puesto</option>
                    <?php if (!empty($puestos)): ?>
                        <?php foreach ($puestos as $puesto): ?>
                            <option value="<?php echo $puesto['id']; ?>">
                                <?php echo htmlspecialchars($puesto['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary mt-3 w-100">Agregar Usuario</button>
        </form>
    </div>
</main>

<?php include('components/footer.php'); ?>

<!-- Scripts necesarios para Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
