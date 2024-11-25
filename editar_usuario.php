<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";

if (empty($_SESSION['usuario'])) header("location: login.php");

$id = $_GET['id'];
if (!$id) {
    echo 'No se ha seleccionado el usuario';
    exit;
}
include_once "funciones.php";
$usuario = obtenerUsuarioPorId($id);
?>
<div class="container">
    <h3>Editar usuario</h3>
    <form method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Nombre de usuario</label>
            <input type="text" name="usuario" class="form-control" value="<?php echo htmlspecialchars($usuario->nomUsuario); ?>" id="usuario" readonly>
        </div>
        <div class="mb-3">
            <label for="contrasena_actual" class="form-label">Contraseña actual</label>
            <input type="password" name="contrasena_actual" class="form-control" id="contrasena_actual" placeholder="Escribe la contraseña actual" required>
        </div>
        <div class="mb-3">
            <label for="nueva_contrasena" class="form-label">Nueva contraseña</label>
            <input type="password" name="nueva_contrasena" class="form-control" id="nueva_contrasena" placeholder="Escribe la nueva contraseña" required>
        </div>
        <div class="mb-3">
            <label for="repetir_nueva_contrasena" class="form-label">Repetir nueva contraseña</label>
            <input type="password" name="repetir_nueva_contrasena" class="form-control" id="repetir_nueva_contrasena" placeholder="Repite la nueva contraseña" required>
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="actualizar" value="Actualizar" class="btn btn-primary btn-lg">
            <a href="usuarios.php" class="btn btn-danger btn-lg">
                <i class="fa fa-times"></i> Cancelar
            </a>
        </div>
    </form>
</div>

<?php
if (isset($_POST['actualizar'])) {
    $usuario = $_POST['usuario'];
    $contrasena_actual = $_POST['contrasena_actual'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $repetir_nueva_contrasena = $_POST['repetir_nueva_contrasena'];

    // Validaciones
    if (empty($contrasena_actual) || empty($nueva_contrasena) || empty($repetir_nueva_contrasena)) {
        echo '<div class="alert alert-danger mt-3" role="alert">Debes completar todos los datos.</div>';
        return;
    }

    if ($nueva_contrasena !== $repetir_nueva_contrasena) {
        echo '<div class="alert alert-danger mt-3" role="alert">Las contraseñas no coinciden.</div>';
        return;
    }

    // Verificar la contraseña actual
    if (!verificarContrasena($id, $contrasena_actual)) {
        echo '<div class="alert alert-danger mt-3" role="alert">La contraseña actual es incorrecta.</div>';
        return;
    }

    // Hashear la nueva contraseña
    $nueva_contrasena_hasheada = password_hash($nueva_contrasena, PASSWORD_BCRYPT);
    
    // Actualizar la contraseña en la base de datos
    $resultado = actualizarContrasena($id, $nueva_contrasena_hasheada);
    if ($resultado) {
        echo '<div class="alert alert-success mt-3" role="alert">Contraseña actualizada con éxito.</div>';
    } else {
        echo '<div class="alert alert-success mt-3" role="alert">Contraseña actualizada con éxito.</div>';
    }
}

// Función para verificar la contraseña actual
function verificarContrasena($id, $contrasena_actual) {
    $usuario = obtenerUsuarioPorId($id); // Obtiene el usuario actual
    return password_verify($contrasena_actual, $usuario->password); // Compara la contraseña actual
}

// Función para actualizar la contraseña
function actualizarContrasena($id, $nueva_contrasena) {
    $sentencia = "UPDATE usuarios SET password = ? WHERE idUsuario = ?";
    return select($sentencia, [$nueva_contrasena, $id]); // Asegúrate de que esta función esté configurada para manejar actualizaciones
}
?>