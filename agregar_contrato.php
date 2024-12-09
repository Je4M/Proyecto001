<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";
include_once "funciones.php";

if (empty($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}

$dni = '';
$cliente = [];
$mensajeContrato = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buscar'])) {
    $dni = $_POST['dni'];
    $cliente = obtenerPersonasContrato($dni);
    echo "<pre>Cliente: "; print_r($cliente); echo "</pre>";
    // Verifica si el cliente tiene un contrato activo
    if (!empty($cliente)) {
        $mensajeContrato = verificarContratoActivo($dni); // Implementa esta función para verificar el contrato
        echo "<pre>Mensaje contrato: $mensajeContrato</pre>";
    } else {
        $mensajeContrato = "No se encontró ningún cliente con el DNI ingresado.";
    }
}
?>

<div class="container">
    <h3>Asignar contrato</h3>
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
        
        <?php if (empty($mensajeContrato) && !empty($cliente)): ?>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="number" name="telefono" class="form-control" id="telefono" placeholder="Ej. 2111568974" required>
            </div>
            <div class="col-5">
                <label for="inicio" class="form-label">Inicio del contrato</label>
                <input type="date" name="inicio" class="form-control" id="inicio" required>
                <label for="final" class="form-label">Fecha final de contrato</label>
                <input type="date" name="final" class="form-control" id="final" required>
            </div>
            <label for="cargo" class="form-label">Cargo</label>
            <select name="cargo" id="cargo" class="form-select" required>
                <?php foreach ($cargo as $car): ?>
                    <option value="<?php echo $car->id_cargo; ?>"><?php echo ucfirst($car->desccargo); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="contrato" class="form-label">Contrato</label>
            <select name="contrato" id="contrato" class="form-select" required>
                <?php foreach ($contratos as $con): ?>
                    <option value="<?php echo $con->id_contrato; ?>"><?php echo ucfirst($con->desccargo); ?></option>
                <?php endforeach; ?>
            </select>
            <div class="text-center mt-3">
                <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
                <a href="clientes.php" class="btn btn-danger btn-lg">Cancelar</a>
                <a href="vender.php" class="btn btn-warning btn-lg">Regresar</a>
            </div>
        <?php endif; ?>
    </form>
</div>