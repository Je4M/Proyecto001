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

// Obtener datos utilizando las funciones
$residuosPorTipo = obtenerResiduosPorTipo();
$estadoContenedores = obtenerEstadoContenedores();
$incidentesPorGravedad = obtenerIncidentesPorGravedad();
?>

<div class="container">
    <div class="alert alert-info" role="alert">
        <h1>Hola, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>
    </div>

    <div class="row mt-2">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4>Residuos por Tipo</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Tipo de Residuo</th>
                                <th>Total de Residuos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($residuosPorTipo as $residuo) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($residuo->nombre) ?></td>
                                    <td><?= htmlspecialchars($residuo->totalResiduos) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4>Estado de Contenedores</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Estado</th>
                                <th>Cantidad de Contenedores</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($estadoContenedores as $estado) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($estado->descestadocont) ?></td>
                                    <td><?= htmlspecialchars($estado->cantidadContenedores) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-2">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h4>Incidentes por Gravedad</h4>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Descripción de Gravedad</th>
                                <th>Total de Incidentes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($incidentesPorGravedad as $gravedad) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($gravedad->descripcion) ?></td>
                                    <td><?= htmlspecialchars($gravedad->totalIncidentes) ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>