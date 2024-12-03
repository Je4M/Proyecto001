<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if(empty($_SESSION['usuario'])) header("location: contenedores.php");

$clientes = obtenercontenedores();

?>
<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="contenedores.php">
            <i class="fa fa-plus"></i>
            Agregar contenedor 
        </a>
      
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID_CONTENEDOR</th>
                <th>CAPACIDAD</th>
                <th>UBICACION</th>
                <th>MATERIAL</th>
                <th>FECHA INSTALACION</th>
                <th>PUNTO CRITICO</th>
                <th>FECHA REGISTRO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($clientes as $cliente){
            ?>
                <tr>
                
                    <td><?php echo $cliente->id_contenedor; ?></td>
                    <td><?php echo $cliente->capacidad; ?></td>
                    <td><?php echo $cliente->ubicacion; ?></td>
                    <td><?php echo $cliente->materialconstruccion; ?></td>
                    <td><?php echo $cliente->fechainstalacion; ?></td>
                    <td><?php echo $cliente->ubicacionpc; ?></td>
                    <td><?php echo $cliente->fecharegistro; ?></td>
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