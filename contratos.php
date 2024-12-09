<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if(empty($_SESSION['usuario'])) header("location: login.php");

$clientes = obtenerContratos();

?>
<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="agregar_contrato.php">
            <i class="fa fa-plus"></i>
            Agregar nuevo contrato
        </a>
      
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>DNI</th>
                <th>ID CONTRATO</th>
                <th>DESCRIPCION CONTRATO</th>
                <th>FECHA INICIO</th>
                <th>FECHA FIN</th>
                <th>SUELDO</th>
                <th>DES ESTADO</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($clientes as $cliente){
            ?>
                <tr>
                    <td><?php echo $cliente->DNI_Persona; ?></td>
                    <td><?php echo $cliente->id_contrato; ?></td>
                    <td>
                    <?php
                    echo ($cliente->descripcion == 1) ? 'Caducado' : 'Activo';
                    ?>
                    </td>
                    <td><?php echo $cliente->fecha_inicio; ?></td>
                    <td><?php echo $cliente->fecha_final; ?></td>
                    <td><?php echo $cliente->sueldo; ?></td>
                    <td> <?php
                    echo ($cliente->descripcion_estad == 1) ? 'Temporal' : 'Fijo';
                    ?>
                    </td>
                    <td>
                        <a class="btn btn-info" href="editar_cliente.php?id=<?php echo $cliente->DNI_Persona;?>">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="eliminar_cliente.php?id=<?php echo $cliente->DNI_Persona;?>">
                            <i class="fa fa-trash"></i>
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>