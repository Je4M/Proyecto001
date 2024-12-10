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

// Obtener registros de auditoría
$auditoria = obtenerAuditoria();
?>

<div class="container">
    <div class="alert alert-info" role="alert">
        <h1>Registro de Auditoría</h1>
    </div>

    <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Estado</th>
                        <th>Acción</th>
                        <th>Fecha</th>
                        <th>Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($auditoria as $registro) { ?>
                        <tr>
                            <td><?= htmlspecialchars($registro->r_estado) ?></td>
                            <td><?= htmlspecialchars($registro->r_accion) ?></td>
                            <td><?= htmlspecialchars($registro->r_fecha) ?></td>
                            <td><?= htmlspecialchars($registro->r_usuario) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>