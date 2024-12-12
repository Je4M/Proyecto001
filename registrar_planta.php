<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

// Verificar si el usuario está autenticado
if (empty($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}

// Procesar el registro si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombrePlanta = $_POST['nombre_planta'];
    $capacidadPlanta = $_POST['capacidad_planta'];

    if (registrarPlanta($nombrePlanta, $capacidadPlanta)) {
        $mensaje = "Planta registrada correctamente.";
    } else {
        $mensaje = "Error al registrar la planta.";
    }
}
?>

<div class="container">
    <div class="alert alert-info" role="alert">
        <h1>Registrar Nueva Planta</h1>
    </div>

    <?php if (isset($mensaje)) { ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php } ?>

    <form method="POST">
        <div class="form-group">
            <label for="nombre_planta">Nombre de la Planta:</label>
            <input type="text" name="nombre_planta" id="nombre_planta" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="capacidad_planta">Capacidad de la Planta (en unidades):</label>
            <input type="number" step="0.01" name="capacidad_planta" id="capacidad_planta" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>