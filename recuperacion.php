<?php
session_start();
ob_start(); // Inicia el buffer de salida

include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";
include_once "funciones.php";

if (isset($_GET['id'])) {
    $id_incidente = $_GET['id'];

    // Verifica si el ID del incidente existe
    $sentencia = "SELECT * FROM incidentes WHERE id_incidentes = ?";
    $resultado = select($sentencia, [$id_incidente]);

    if (empty($resultado)) {
        echo '<div class="alert alert-danger">El incidente no existe.</div>';
        exit;
    }
} else {
    echo '<div class="alert alert-danger">No se ha proporcionado un ID de incidente.</div>';
    exit;
}

if (isset($_POST['registrar_recuperacion'])) {
    $fecha_inicio_rec = $_POST['fecha_inicio_rec'];
    $fecha_final_rec = $_POST['fecha_final_rec'];

    // Verifica que las fechas no estén vacías
    if (empty($fecha_inicio_rec) || empty($fecha_final_rec)) {
        echo '<div class="alert alert-danger">Ambas fechas son obligatorias.</div>';
    } else {
        // Lógica para registrar la recuperación
        $resultado = registrarRecuperacion($id_incidente, $fecha_inicio_rec, $fecha_final_rec);
        if ($resultado) {
            echo '<div class="alert alert-success">Recuperación registrada exitosamente.</div>';
        } else {
            echo '<div class="alert alert-danger">Error al registrar la recuperación.</div>';
        }
    }
}
?>

<div class="container">
    <h3>Registrar Recuperación</h3>
    <form method="post">
        <div class="mb-3">
            <label for="fecha_inicio_rec" class="form-label">Fecha de Inicio de Recuperación</label>
            <input type="date" name="fecha_inicio_rec" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fecha_final_rec" class="form-label">Fecha Final de Recuperación</label>
            <input type="date" name="fecha_final_rec" class="form-control" required>
        </div>
        <button type="submit" name="registrar_recuperacion" class="btn btn-primary">Registrar Recuperación</button>
    </form>
</div>