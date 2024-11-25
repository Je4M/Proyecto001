<?php
session_start();

if (isset($_POST['ingresar'])) {
    // Verifica si los campos de usuario y contraseña están vacíos
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        echo '
        <div class="alert alert-warning mt-3" role="alert">
            Debes completar todos los datos.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    include_once "funciones.php"; // Asegúrate de que incluya la función iniciarSesion

    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Llama a la función para verificar las credenciales del usuario
    $datosSesion = iniciarSesion($usuario, $password);

    // Verifica si las credenciales son incorrectas
    if (!$datosSesion) {
        echo '
        <div class="alert alert-danger mt-3" role="alert">
            Nombre de usuario y/o contraseña incorrectas.
            <a href="login.php">Regresar</a>
        </div>';
        return;
    }

    // Inicializa las variables de sesión
    $_SESSION['usuario'] = $datosSesion->nomUsuario; // Almacena el nombre de usuario
    $_SESSION['idUsuario'] = $datosSesion->idUsuario; // Almacena el ID del usuario

    // Obtener y guardar el rol en la sesión directamente desde el objeto devuelto
    $_SESSION['rol'] = $datosSesion->rol; // Almacena el rol directamente

    // Redirige al usuario a la página principal
    header("Location: index.php");
    exit(); // Finaliza el script después de redirigir
}
?>