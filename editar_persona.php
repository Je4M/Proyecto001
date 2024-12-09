<?php
// ob_start(); // Iniciar almacenamiento en búfer de salida

include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";
include_once "funciones.php";

if (empty($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$idPersona = $_GET['id'];
if (!$idPersona) {
    echo 'No se ha seleccionado el cliente';
    exit;
}

$cliente = obtenerClientePorId($idPersona);
if (!$cliente) {
    echo 'Cliente no encontrado';
    exit;
}

if (isset($_POST['editar'])) {
    $DNI_Persona = $_POST['dni'];
    $Nombres = $_POST['nombres'];
    $PrimerApellido = $_POST['primerapellido'];
    $SegundoApellido = $_POST['segundoapellido'];
    $Telefonocli = $_POST['telefono'];

    if (empty($DNI_Persona) || empty($Nombres) || empty($PrimerApellido) || empty($SegundoApellido) || empty($Telefonocli)) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    }

    $resultado = editarCliente($DNI_Persona, $Nombres, $PrimerApellido, $SegundoApellido, $Telefonocli);

    if ($resultado) {
        echo '
        <div class="alert alert-success mt-3" role="alert">
            Información del cliente actualizada con éxito.
        </div>';
        
        // Redirigir después de la actualización

        exit();
    } else {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Ocurrió un error al actualizar la información.
        </div>';
    }
}

?>
<div class="container">
    <h3>Editar persona</h3>
    <form method="post">
        <div class="mb-3">
            <label for="dni" class="form-label">Se muestra el DNI</label>
            <input type="text" name="dni" class="form-control" value="<?php echo htmlspecialchars($cliente->DNI_Persona); ?>" id="dni" readonly>
        </div>
        <div class="mb-3">
            <label for="nombres" class="form-label">Se muestra el nombre</label>
            <input type="text" name="nombres" class="form-control" value="<?php echo htmlspecialchars($cliente->nombre); ?>" id="nombres" readonly>
        </div>
        <div class="mb-3">
            <label for="primerapellido" class="form-label">Se muestra el primer apellido</label>
            <input type="text" name="primerapellido" class="form-control" value="<?php echo htmlspecialchars($cliente->primer_apellido); ?>" id="primerapellido" readonly>
        </div>
        <div class="mb-3">
            <label for="segundoapellido" class="form-label">Se muestra el segundo apellido</label>
            <input type="text" name="segundoapellido" class="form-control" value="<?php echo htmlspecialchars($cliente->segundo_apellido); ?>" id="segundoapellido" readonly>
        </div>
        <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="number" name="telefono" class="form-control" value="<?php echo htmlspecialchars($cliente->telefono); ?>" id="telefono" placeholder="Ej. 76894456">
        </div>
        <div class="text-center mt-3">
            <input type="submit" name="editar" value="Guardar Cambios" class="btn btn-primary btn-lg">
            <a href="personas.php" class="btn btn-danger btn-lg">
                <i class="fa fa-times"></i> 
                Cancelar
            </a>
        </div>
    </form>
</div>

<?php
//ob_end_flush(); // Enviar el contenido del búfer al navegador
?>