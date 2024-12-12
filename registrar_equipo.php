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

// Obtener plantas para la lista desplegable
$plantas = obtenerPlantas(); // Debes definir esta función

// Procesar el registro si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombreEquipo = $_POST['nombre_equipo'];
    $descripcion = $_POST['descripcion'];
    $fkPlanta = $_POST['planta'];

    if (registrarEquipo($nombreEquipo, $descripcion, $fkPlanta)) {
        $mensaje = "Equipo registrado correctamente.";
    } else {
        $mensaje = "Error al registrar el equipo.";
    }
}
?>

<div class="container">
    <div class="alert alert-info" role="alert">
        <h1>Registrar Nuevo Equipo</h1>
    </div>

    <?php if (isset($mensaje)) { ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php } ?>

    <form method="POST">
        <div class="form-group">
            <label for="nombre_equipo">Nombre del Equipo:</label>
            <input type="text" name="nombre_equipo" id="nombre_equipo" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" id="descripcion" class="form-control" required></textarea>
        </div>
        <div class="form-group">
            <label for="planta">Seleccionar Planta:</label>
            <select name="planta" id="planta" class="form-control" required>
                <option value="">-- Seleccionar Planta --</option>
                <?php foreach ($plantas as $planta) { ?>
                    <option value="<?= htmlspecialchars($planta->id_planta) ?>">
                        <?= htmlspecialchars($planta->nombre_plant) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </form>
</div>