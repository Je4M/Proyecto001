<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if(empty($_SESSION['usuario'])) header("location: coches.php");

$clientes = obtenervehiculos();
?>
<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="coches.php">
            <i class="fa fa-plus"></i>
            Agregar contenedor 
        </a>
      
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID_VEHICULO</th>
                <th>PLACA</th>
                <th>MARCA</th>
                <th>ESTADO</th>
                <th>MODELO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($clientes as $cliente){
            ?>
                <tr>
                
                    <td><?php echo $cliente->id_vehiculo; ?></td>
                    <td><?php echo $cliente->placa; ?></td>
                    <td><?php echo $cliente->descmarca; ?></td>
                    <td><?php echo $cliente->descvehiculo; ?></td>
                    <td><?php echo $cliente->descmodelo ; ?></td>
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