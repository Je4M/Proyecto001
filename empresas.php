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

// Obtener colaboradores y vehículos
$colaboradores = obtenerColaboradores(); // Debes definir esta función
$vehiculos = obtenerVehiculos(); // Debes definir esta función

// Procesar la asignación si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idColaborador = $_POST['colaborador'];
    $idVehiculo = $_POST['vehiculo'];

    if (asignarColaboradorAVehiculo($idColaborador, $idVehiculo)) {
        $mensaje = "Colaborador asignado al vehículo correctamente.";
    } else {
        $mensaje = "Error al asignar el colaborador al vehículo.";
    }
}
?>

<div class="container">
    <div class="alert alert-info" role="alert">
        <h1>Asignar Colaborador a Vehículo</h1>
    </div>

    <?php if (isset($mensaje)) { ?>
        <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php } ?>

    <form method="POST">
        <div class="form-group">
            <label for="colaborador">Seleccionar Colaborador:</label>
            <select name="colaborador" id="colaborador" class="form-control" required>
                <option value="">-- Seleccionar Colaborador --</option>
                <?php foreach ($colaboradores as $colaborador) { ?>
                    <option value="<?= htmlspecialchars($colaborador->id_colaborador) ?>">
                        <?= htmlspecialchars($colaborador->nombre) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="vehiculo">Seleccionar Vehículo:</label>
            <select name="vehiculo" id="vehiculo" class="form-control" required>
                <option value="">-- Seleccionar Vehículo --</option>
                <?php foreach ($vehiculos as $vehiculo) { ?>
                    <option value="<?= htmlspecialchars($vehiculo->id_vehiculo) ?>">
                        <?= htmlspecialchars($vehiculo->placa) ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Asignar</button>
    </form>
</div>