<?php
require 'funciones.php'; // Asegúrate de incluir tu archivo de funciones

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomUsuario = $_POST['nomUsuario'];
    $password = $_POST['password'];
    $rol = $_POST['rol'];

    // Inserta el nuevo usuario
    $sentencia = "INSERT INTO usuarios (nomUsuario, password, rol) VALUES (?, ?, ?)";
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $exito = insertar($sentencia, [$nomUsuario, $hashedPassword, $rol]);

    if ($exito) {
        echo "<p>Usuario creado con éxito.</p>";
    } else {
        echo "<p>Error al crear el usuario.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario</title>
    <style>
        body { 
            font-family: Arial, sans-serif;

        }
        form { max-width: 400px; margin: auto; }
        input, select { width: 100%; margin: 10px 0; padding: 8px; }
        button { padding: 10px; background-color: #28a745; color: white; border: none; cursor: pointer; }
        button:hover { background-color: #218838; }
        .tit_usuario{ 
            margin-left: 860px;

        }


    </style>
</head>
<body>
<div class= "tit_usuario"><h2>Crear Usuario</h2></div>

<form method="POST" action="">
    <label for="nomUsuario">Nombre de Usuario:</label>
    <input type="text" id="nomUsuario" name="nomUsuario" required>

    <label for="password">Contraseña:</label>
    <input type="password" id="password" name="password" required>

    <label for="rol">Rol:</label>
    <select id="rol" name="rol" required>
        <option value="admin">Admin</option>
        <option value="usuario">Usuario</option>
        <option value="invitado">Invitado</option>
    </select>

    <button type="submit">Crear Usuario</button>
</form>

</body>
</html>