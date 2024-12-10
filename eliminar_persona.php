<?php
$idPersona = $_GET['id'];
if (!$idPersona) {
    echo 'No se ha seleccionado el cliente';
    exit;
}
include_once "funciones.php";

$resultado = eliminarCliente($idPersona);


header("Location: personas.php");
?>