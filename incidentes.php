<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if(empty($_SESSION['usuario'])) header("location: login.php");

$clientes =obtenerIncidentes();
?>
<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="agregar_incidente.php">
            <i class="fa fa-plus"></i>
            Agregar
        </a>
        INCIDENTE
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>id</th>
                <th>DESCRIPCION</th>
                <th>Nombre</th>
                <th>Primer apellido</th>
                <th>Segundo apellido</th>
                <th>Condicion</th>
                <th>fecha inicio</th>
                <th>fecha final</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($clientes as $cliente){
            ?>
                <tr>
                    <td><?php echo $cliente->id_incidentes; ?></td>
                    <td><?php echo $cliente->descripcion_incidente; ?></td>
                    <td><?php echo $cliente->nombre; ?></td>
                    <td><?php echo $cliente->primer_apellido; ?></td>
                    <td><?php echo $cliente->segundo_apellido; ?></td>
                    <td><?php echo $cliente->descripcion; ?></td>
                    <td><?php echo $cliente->fecha_inicio_rec; ?></td>
                    <td><?php echo $cliente->fecha_final; ?></td>
                    <td>
                        <a class="btn btn-info" href="editar_proveedor.php?id=<?php echo $cliente->id_Proveedor;?>">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="eliminar_proveedor.php?id=<?php echo $cliente->id_Proveedor;?>">
                            <i class="fa fa-trash"></i>
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>