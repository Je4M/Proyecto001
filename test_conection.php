<?php
try {
    $pdo = new PDO("mysql:host=localhost;dbname=residuosfinal", "root", "brandonmax");
    echo "Conexión exitosa.";
} catch (PDOException $e) {
    echo "Error en la conexión: " . $e->getMessage();
}
?>