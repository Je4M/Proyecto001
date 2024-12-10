<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if(empty($_SESSION['usuario'])) header("location: login.php");

$clientes = obtenerPersonas();

?>
<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="agregar_persona.php">
            <i class="fa fa-plus"></i>
            Agregar Persona
        </a>
      
    </h1>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>DNI</th>
                <th>NOMBRE</th>
                <th>P.APELLIDO</th>
                <th>S.APELLIDO</th>
                <th>TELEFONO</th>
               
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($clientes as $cliente){
            ?>
                <tr>
                
                    <td><?php echo $cliente->id_persona; ?></td>
                    <td><?php echo $cliente->DNI_Persona; ?></td>
                    <td><?php echo $cliente->nombre; ?></td>
                    <td><?php echo $cliente->primer_apellido; ?></td>
                    <td><?php echo $cliente->segundo_apellido; ?></td>
                    <td><?php echo $cliente->telefono; ?></td>
                   
                    <td>
                        <a class="btn btn-info" href="editar_persona.php?id=<?php echo $cliente->id_persona;?>">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="eliminar_persona.php?id=<?php echo $cliente->id_persona;?>">
                            <i class="fa fa-trash"></i>
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>