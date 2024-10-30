<?php 
$activePage = 'profile';
include('components/header.php');
?>

<main class="container mt-5">
    <h1>Agregar Usuario</h1>
    <p>Añadir un usuario nuevo.</p>
    
    <!-- Mensajes de éxito o error -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success">
            <?php echo $_SESSION['success']; unset($_SESSION['success']); ?>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
        </div>
    <?php endif; ?>

    <!-- Formulario para agregar usuario -->
    <form action="index.php?controller=user&action=register" method="POST">
        <!-- Campo de nombre -->
        <div class="form-group">
            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>
        </div>

        <!-- Campo de correo electrónico -->
        <div class="form-group">
            <label for="email">Correo Electrónico:</label>
            <input type="email" name="email" id="email" class="form-control" required>
        </div>

        <!-- Campo de contraseña -->
        <div class="form-group">
            <label for="password">Contraseña:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <!-- Lista desplegable para seleccionar la sucursal -->
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

        <!-- Lista desplegable para seleccionar el puesto -->
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

        <!-- Botón para enviar el formulario -->
        <button type="submit" class="btn btn-primary mt-3">Agregar Usuario</button>
    </form>
</main>

<?php include('components/footer.php'); ?>
