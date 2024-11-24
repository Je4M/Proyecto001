<?php
include_once "encabezado.php"; // Incluye el encabezado o configuraciones necesarias

session_start(); // Asegúrate de que la sesión se inicie al principio

if (isset($_POST['ingresar'])) {
    // Verifica si los campos de usuario y contraseña están vacíos
    if (empty($_POST['usuario']) || empty($_POST['password'])) {
        echo '
        <div class="alert alert-warning mt-3" role="alert">
            Debes completar todos los datos.
            <a href="login.php">Regresar</a>
        </div>';
        return; // Termina la ejecución si los campos están vacíos
    }

    include_once "funciones.php"; // Asegúrate de que este archivo contenga las funciones necesarias

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
        return; // Termina la ejecución si las credenciales son incorrectas
    }

    // Si las credenciales son correctas, inicializa las variables de sesión
    $_SESSION['usuario'] = $datosSesion->nomUsuario; // Almacena el nombre de usuario
    $_SESSION['idUsuario'] = $datosSesion->idUsuario; // Almacena el ID del usuario

    // Obtiene el rol del usuario y lo almacena en la sesión
    $_SESSION['rol'] = obtenerRol($datosSesion->rol);

    // Redirige al usuario a la página principal
    header("Location: index.php");
    exit(); // Termina el script después de redirigir
}
?>