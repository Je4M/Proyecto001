<!-- hola mundo programadores -->
<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";
include_once "funciones.php";


if(empty($_SESSION['usuario'])) header("location: login.php");
$cargo = obtenerCargos();

if (isset($_POST['buscar'])) {
    $dni = $_POST['dni'];
    if (!empty($dni)) {
        $cliente = buscarClientePorDNI($dni);
    }
}

function buscarClientePorDNI($dni) {
    $token = 'apis-token-7410.rcjsAzQ2MeFkxq92XKMITNsQhkfO4bZC';
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => 0,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 2,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'Referer: https://apis.net.pe/consulta-dni-api',
            'Authorization: Bearer ' . $token
        ),
    ));

    $response = curl_exec($curl);
    curl_close($curl);
    
    return json_decode($response, true);
}

?>

<div class="container">
    <h3>Agregar persona</h3>
    <form method="post">
    <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <div class="input-group">
                <input type="number" name="dni" class="form-control" id="dni" placeholder="Ej. 76895547" value="<?php echo isset($dni) ? $dni : ''; ?>">
                <button type="submit" name="buscar" class="btn btn-info">Buscar</button>
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
        <div class="mb-3">
            <label for="direccion" class="form-label">Cargo</label>
            <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ej. Av Collar 1005 Col Las Cruces">
        </div>
        <div class="mb-3">
            
        <label for="cargo" class="form-label">Cargo</label>
        <select name="cargo" id="cargo" class="form-select" required>
             <?php foreach ($cargo as $car): ?>
             <option value="<?php echo htmlspecialchars($car->id_cargo); ?>"><?php echo htmlspecialchars(ucfirst($car->desccargo)); ?></option>
            <?php endforeach; ?>
        </select>
        </div>
        
        <div class="text-center mt-3">
            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
            <a href="clientes.php" class="btn btn-danger btn-lg">
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
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];

    if(empty($dni) || empty($nombre) || empty($apellidopat) || empty($apellidomat)  || empty($telefono) || empty($direccion) ){
        echo'
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    } 
    
    include_once "funciones.php";
    $resultado = registrarCliente($dni, $nombre, $apellidopat, $apellidomat, $telefono, $direccion);
    if($resultado){
        echo'
        <div class="alert alert-success mt-3" role="alert">
            Cliente registrado con éxito.
        </div>';
    }
   
}
?>