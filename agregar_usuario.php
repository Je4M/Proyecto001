<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if (empty($_SESSION['usuario'])) {
    header("Location: login.php");
    exit();
}

$roles = ['admin', 'usuario', 'invitado']; // Definimos los roles directamente
$mensaje = '';

if (isset($_POST['registrar'])) {
    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $rol = $_POST['rol']; // Capturamos el rol directamente

    // Validación básica
    if (empty($usuario) || empty($contrasena)) {
        $mensaje = '<div class="alert alert-danger mt-3" role="alert">Debes completar todos los datos.</div>';
    } else {
        // Verifica si el usuario ya existe
        if (usuarioExiste($usuario)) {
            $mensaje = '<div class="alert alert-danger mt-3" role="alert">El nombre de usuario ya existe. Por favor, elige otro.</div>';
        } else {
            // Hashea la contraseña antes de almacenarla
            $contrasenaHasheada = password_hash($contrasena, PASSWORD_BCRYPT);
            
            // Llama a la función para registrar el nuevo usuario
            $resultado = registrarUsuario($usuario, $contrasenaHasheada, $rol);
            
            if ($resultado) {
                $mensaje = '<div class="alert alert-success mt-3" role="alert">Usuario registrado con éxito.</div>';
            } else {
                $mensaje = '<div class="alert alert-success mt-3" role="alert">Usuario registrado con éxito.</div>';
            }
        }
    }
}

?>

<div class="container">
    <h3>Agregar usuario</h3>
    <form method="post">
        <div class="mb-3">
            <label for="usuario" class="form-label">Nombre de usuario</label>
            <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Escribe el nombre de usuario. Ej. Paco" required>
        </div>
        <div class="mb-3">
            <label for="contrasena" class="form-label">Contraseña</label>
            <input type="password" name="contrasena" class="form-control" id="contrasena" placeholder="Escribe una contraseña" required>
        </div>
        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <?php foreach ($roles as $rol): ?>
                <option value="<?php echo htmlspecialchars($rol); ?>"><?php echo htmlspecialchars(ucfirst($rol)); ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center mt-3">

            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
            <a href="usuarios.php" class="btn btn-danger btn-lg">
                <i class="fa fa-times"></i> Cancelar
            </a>
        </div>
    </form>

    <?php if ($mensaje): ?>
        <?php echo $mensaje; ?>
    <?php endif; ?>
</div>