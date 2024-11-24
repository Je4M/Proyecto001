<?php
session_start(); // Asegúrate de que la sesión esté iniciada

if (isset($_POST['ingresar'])) {
    // Verifica si el usuario y la contraseña están definidos
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        echo '
        <div class="alert alert-warning mt-3" role="alert">
            Debes completar todos los datos.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    include_once "funciones.php";

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $datosSesion = iniciarSesion($usuario, $password); // Asegúrate de que esta función esté definida

    if (!$datosSesion) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Nombre de usuario y/o contraseña incorrectas.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    // Inicializa las variables de sesión
    $_SESSION['usuario'] = $datosSesion->nomUsuario;  // Asumiendo que tienes 'usuario' en tu objeto
    $_SESSION['idUsuario'] = $datosSesion->idUsuario; // Asumiendo que tienes 'idUsuario'
    
    // Obtener y guardar el rol en la sesión
    $_SESSION['rol'] = obtenerRol($datosSesion->rol); // Asegúrate de que esto esté correcto

    // Redirige al usuario al índice
    header("Location: index.php");
    exit(); // Termina el script después de redirigir
}
?>