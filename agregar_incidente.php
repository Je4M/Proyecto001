<?php
session_start(); // Inicia la sesión

include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";
include_once "funciones.php";

// Inicializa variables
$colaborador = null;
$dni = '';

// Verifica si se ha enviado el formulario de búsqueda
if (isset($_POST['buscar'])) {
    $dni = $_POST['dni'];
    $colaborador = obtenerColaboradorPorDNI($dni); // Busca el colaborador por DNI

    if ($colaborador) {
        // Almacena el colaborador en la sesión
        $_SESSION['colaborador'] = $colaborador;
        echo '<div class="alert alert-info">Colaborador encontrado: ' . htmlspecialchars($colaborador->nombre) . ' ' . htmlspecialchars($colaborador->primer_apellido) . ' ' . htmlspecialchars($colaborador->segundo_apellido) . '</div>';
    } else {
        echo '<div class="alert alert-danger">Colaborador no encontrado.</div>';
    }
}

// Recupera el colaborador de la sesión
$colaborador = isset($_SESSION['colaborador']) ? $_SESSION['colaborador'] : null;

if (isset($_POST['registrar'])) {
    $descripcion = $_POST['descripcion_incidente'];
    $fk_id_gravedad = $_POST['fk_id_gravedad'];

    // Mensajes de depuración
    echo '<pre>';
    echo 'Descripción: ' . htmlspecialchars($descripcion) . "\n";
    echo 'Gravedad ID: ' . htmlspecialchars($fk_id_gravedad) . "\n";
    echo 'Colaborador: ' . ($colaborador ? 'Encontrado (ID: ' . $colaborador->id_colaborador . ')' : 'No encontrado') . "\n";
    echo '</pre>';

    // Verifica que los campos no estén vacíos
    if (empty($descripcion) || empty($fk_id_gravedad) || !$colaborador) {
        echo '<div class="alert alert-danger">Todos los campos son obligatorios y el colaborador debe ser válido.</div>';
    } else {
        // Lógica para registrar el incidente
        $id_incidente = registrarIncidente($descripcion, $colaborador->id_colaborador, $fk_id_gravedad);
        if ($id_incidente) {
            echo '<div class="alert alert-success">Incidente registrado exitosamente.</div>';
            echo '<script>window.open("recuperacion.php?id=' . $id_incidente . '", "_blank");</script>';
        } else {
            echo '<div class="alert alert-danger">Error al registrar el incidente.</div>';
        }
    }
}
?>

<div class="container">
    <h3>Registrar Incidente</h3>
    
    <!-- Formulario de Búsqueda por DNI -->
    <form method="post">
        <div class="mb-3">
            <label for="dni" class="form-label">DNI del Colaborador</label>
            <input type="text" name="dni" class="form-control" required value="<?php echo isset($dni) ? htmlspecialchars($dni) : ''; ?>">
            <button type="submit" name="buscar" class="btn btn-secondary mt-2">Buscar Colaborador</button>
        </div>
    </form>

    <!-- Mostrar información del colaborador encontrado -->
    <?php if ($colaborador): ?>
        <div class="alert alert-info">
            Colaborador encontrado: <?php echo htmlspecialchars($colaborador->nombre) . ' ' . htmlspecialchars($colaborador->primer_apellido) . ' ' . htmlspecialchars($colaborador->segundo_apellido); ?>
        </div>
    <?php endif; ?>

    <!-- Formulario de Registro del Incidente -->
    <form method="post">
        <div class="mb-3">
            <label for="descripcion_incidente" class="form-label">Descripción del Incidente</label>
            <input type="text" name="descripcion_incidente" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="fk_id_gravedad" class="form-label">Gravedad</label>
            <select name="fk_id_gravedad" class="form-control" required>
                <option value="">Seleccione gravedad</option>
                <?php
                // Aquí puedes obtener las gravedades desde la base de datos
                $gravedades = obtenerGravedades(); // Asumiendo que tienes una función para esto
                foreach ($gravedades as $gravedad): ?>
                    <option value="<?php echo $gravedad->id_gravedad; ?>">
                        <?php echo htmlspecialchars($gravedad->descripcion); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" name="registrar" class="btn btn-primary">Registrar Incidente</button>
    </form>
</div>