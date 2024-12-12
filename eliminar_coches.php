<?php
$id = $_GET['id'];
if (!$id) {
    echo 'No se ha seleccionado el coche';
    exit;
}
include_once "funciones.php";

$resultado = eliminarCoche($id);


header("Location: coches.php");
?>