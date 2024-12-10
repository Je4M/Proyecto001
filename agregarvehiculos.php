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
            <label for="placa" class="form-label">PLACA</label>
            <div class="input-group">
                <input type="number" name="dni" class="form-control" id="dni" placeholder="ABC-456" value="<?php echo isset($dni) ? $dni : ''; ?>">
            </div>  
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Escribe el nombre del cliente" value="<?php echo isset($cliente['nombres']) ? $cliente['nombres'] : ''; ?>" readonly>
        </div>
        
        <div class="mb-3">
            <label for="apellidopat" class="form-label">Apellido Paterno</label>
            <input type="text" name="apellidopat" class="form-control" id="apellidopat" placeholder="Escribe el apellido paterno del cliente" value="<?php echo isset($cliente['apellidoPaterno']) ? $cliente['apellidoPaterno'] : ''; ?>"readonly>
        </div>
        <div class="mb-3">
            <label for="apellidomat" class="form-label">Apellido Materno</label>
            <input type="text" name="apellidomat" class="form-control" id="apellidomat" placeholder="Escribe el apellido materno del cliente" value="<?php echo isset($cliente['apellidoMaterno']) ? $cliente['apellidoMaterno'] : ''; ?>"readonly>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="number" name="telefono" class="form-control" id="telefono" placeholder="Ej. 2111568974">
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