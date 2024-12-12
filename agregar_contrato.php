<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";
include_once "funciones.php";

if (empty($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}

$cargo = obtenerCargos();
$contratos = obtenerContratos2();
$dni = '';
$cliente = [];
$mensajeContrato = '';
$resultado = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    $dni = $_POST['dni'];
    $cliente = obtenerPersonasContrato($dni);
    
    if (!empty($cliente)) {
        $descripcionContrato = buscarDescContrato($dni); // Obtiene la descripción del contrato
    } else {
        $mensajeContrato = "No se encontró ningún cliente con el DNI ingresado.";
    }

    // Para depuración:
   
}
?>

<div class="container">
    <h3>Asignar contrato</h3>
    
    <?php if ($resultado): ?>
        <div class="alert alert-info"><?php echo $resultado; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI</label>
            <div class="input-group">
                <input type="number" name="dni" class="form-control" id="dni" placeholder="Ej. 12345678" value="<?php echo $dni; ?>" required>
                <button type="submit" name="buscar" class="btn btn-info">Buscar</button>
            </div>  
        </div>

        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre y Apellidos</label>
            <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Escribe el nombre del cliente" value="<?php echo !empty($cliente) ? htmlspecialchars($cliente[0]->nombres) : ''; ?>" readonly>
        </div>

        <?php if ($mensajeContrato): ?>
            <div class="alert alert-warning" role="alert">
                <?php echo $mensajeContrato; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($cliente)): ?>
            <label for="cargo" class="form-label">Cargo</label>
            <select name="descripcion" id="descripcion" class="form-select" required>
                <?php foreach ($cargo as $car): ?>
                    <option value="<?php echo $car->id_cargo; ?>"><?php echo ucfirst($car->desccargo); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="col-5">
                <label for="inicio" class="form-label">Inicio del contrato</label>
                <input type="date" name="inicio" class="form-control" id="inicio" required>
                <label for="final" class="form-label">Fecha final de contrato</label>
                <input type="date" name="final" class="form-control" id="final"> <!-- Removido el required -->
            </div>
            
            <div class="mb-3">
                <label for="sueldo" class="form-label">Sueldo</label>
                <input type="number" name="sueldo" class="form-control" id="sueldo" placeholder="Ej. 2000" required>
            </div>

            <?php if ($descripcionContrato): ?>
                <div class="alert alert-info">Estado del contrato: <?php echo $descripcionContrato; ?></div>
            <?php endif; ?>
            
            <div class="text-center mt-3">
                <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
                <a href="clientes.php" class="btn btn-danger btn-lg">Cancelar</a>
                <a href="vender.php" class="btn btn-warning btn-lg">Regresar</a>
            </div>
        <?php endif; ?>
    </form>
</div>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar'])) {
    $dni = $_POST['dni'];
    $cargoId = $_POST['descripcion']; // Este es el ID del cargo seleccionado
    $fechaInicio = $_POST['inicio'];
    $fechaFinal = $_POST['final'] ?? null; // La fecha final puede ser nula
    $sueldo = $_POST['sueldo'];

    // Depuración: Imprimir datos recibidos


    // Llamar a la función registrarContrato
    $resultado = registrarContrato($dni, $cargoId, $fechaInicio, $fechaFinal, $sueldo);
    echo $resultado; // Mostrar el resultado de la operación
}
?>