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

// Obtener todos los equipos
$equipos = obtenerEquipos();
?>

<div class="container">
    <div class="alert alert-info" role="alert">
        <h1>Lista de Equipos</h1>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre del Equipo</th>
                <th>Descripción</th>
                <th>Planta Asociada</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($equipos as $equipo) { ?>
                <tr>
                    <td><?= htmlspecialchars($equipo->id_equipo) ?></td>
                    <td><?= htmlspecialchars($equipo->nombre_equipo) ?></td>
                    <td><?= htmlspecialchars($equipo->descripcion) ?></td>
                    <td><?= htmlspecialchars($equipo->planta ?: 'Sin planta asociada') ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>