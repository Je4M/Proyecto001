<!-- hola mundo programadores -->
<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";
include_once "funciones.php";


if(empty($_SESSION['usuario'])) header("location: login.php");
$cargo = obtenerCargos();
$contratos = obtenerContratos2();
if (isset($_POST['buscar'])) {
    $dni = $_POST['dni'];
    if (!empty($dni)) {
        $cliente = buscarClientePorDNI($dni);
    }
}



?>

<div class="container">
    <h3>Agregar vehiculo</h3>
    <form method="post">
    <div class="mb-3">

        <div class="mb-3">
            <label for="placa" class="form-label"  id="placa" >PLACA</label>
            <input  name="placa" class="form-control" id="placa" placeholder="Ej. ABC-456">
         </div>
        
         <div class="mb-3">
            <label for="yardas" class="form-label"  id="yardas" >YARDAS CUBICAS</label>
            <input name="yardas" class="form-control" id="marca" placeholder="Ej. 2111568974">
         </div>
         <div class="mb-3">
            <label for="colaborador" class="form-label"  id="colaborador" >COLABORADOR</label>
            <input name="cola" class="form-control" id="marca" placeholder="Ej. 2111568974">
         </div>
         <div class="mb-3">
            <label for="marca" class="form-label"  id="marca" placeholder="VOLVO">MARCA</label>
            <input  name="marca" class="form-control" id="marca" placeholder="Ej. volvo">
         </div>
         <div class="mb-3">
            <label for="estadp" class="form-label"  id="esvehiculo" >ESTADO DEL VEHICULO</label>
            <input  name="estado" class="form-control" id="estado" placeholder="seleccionar">
         </div>
        
        
        <div class="text-center mt-3">
            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
            <a href="personas.php" class="btn btn-danger btn-lg">
                <i class="fa fa-times"></i> 
                Cancelar
            </a>
            <a href="vender.php" class="btn btn-warning btn-lg">
                <i class="fa fa-times"></i> 
                Regresar
            </a>
        </div>
    </form>
</div>

<?php
if(isset($_POST['registrar'])){
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellidopat = $_POST['apellidopat'];
    $apellidomat = $_POST['apellidomat'];
    $telefono = $_POST['telefono'];
 


    if(empty($dni) || empty($nombre) || empty($apellidopat) || empty($apellidomat)  || empty($telefono) ){
        echo'
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    } 
    
    include_once "funciones.php";
    $resultado = registrarCliente($dni, $nombre, $apellidopat, $apellidomat, $telefono);
    if($resultado){
        echo'
        <div class="alert alert-success mt-3" role="alert">
            Persona registrada con éxito.
        </div>';
    }
   
}
?>