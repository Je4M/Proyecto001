<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$database = "residuosfinal";
// var_dump($_FILES);
// Crear conexión
// documentos
$conn = new mysqli($servername, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Procesar las acciones de registro, eliminación y modificación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si se ha enviado el archivo y no hay errores
    if (isset($_FILES["Guia_Remi"]) && $_FILES["Guia_Remi"]["error"] == 0) {
        // Directorio donde se guardarán los documentos
        $directorio_destino = "C:\\xampp\\htdocs\\Proyecto\\Proyecto\\documentos1\\"; // Reemplaza con la ruta correcta en tu servidor

        // Nombre del archivo   
        $nombre_archivo = basename($_FILES["Guia_Remi"]["name"]);

        // Ruta completa del archivo en el servidor
        $ruta_archivo = $directorio_destino . $nombre_archivo;

        // Mover el archivo desde la ubicación temporal a la carpeta destino
        if (move_uploaded_file($_FILES["Guia_Remi"]["tmp_name"], $ruta_archivo)) {
            // Obtener los datos del formulario
            $VariableSeleccionIdGuia = $_POST["id_remi_trans"]; 

            $VariableSeleccionDni = $_POST["dni"]; 
            $consultaIdDni = "SELECT id_Trabajador FROM Trabajadores WHERE fk_dni_ruc = '$VariableSeleccionDni'";
            $ResultadoId = $conn->query($consultaIdDni);
            $FilaResultado = $ResultadoId->fetch_assoc();

            $VariableIdTrabajadores = $FilaResultado['id_Trabajador']; 

            $VariableEmision = $_POST["Fecha_emisión"];
            $VariableObservacion = $_POST["Observación"];
            $VariableCantidad = $_POST["Cantidad"];
            $VariableU_medida = $_POST["U-medida"];
            $VariableGuiaRemision = $nombre_archivo; // Guardar el nombre del archivo en la base de datos

            // Construir la consulta SQL para insertar el nuevo tipo de cargamento
            $sql = "INSERT INTO Guias_Remision (
                        fk_id_Guias_Remision_Transportista,
                        fk_id_Trabajador,
                        Fecha_Emision,
                        Observacion,
                        Cantidad,
                        U_medida,
                        guia_remi_trans
                    ) VALUES (
                        '$VariableSeleccionIdGuia',
                        '$VariableIdTrabajadores',
                        '$VariableEmision',
                        '$VariableObservacion',
                        '$VariableCantidad',
                        '$VariableU_medida',
                        '$VariableGuiaRemision'
                    )";

            // Ejecutar la consulta SQL y verificar si la inserción fue exitosa
            if ($conn->query($sql) === TRUE) {
                echo "<div class='modal' tabindex='-1' role='dialog' style='display: block;'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Éxito</h5>
                </div>
                <div class='modal-body'>
                    <p>Se registro la guia de remision.</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary' onclick='this.parentNode.parentNode.parentNode.parentNode.style.display = \"none\";'>Cerrar</button>
                </div>
                </div>
            </div>
            </div>";
            } else {
                echo "<div class='modal' tabindex='-1' role='dialog' style='display: block;'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Éxito</h5>
                </div>
                <div class='modal-body'>
                    <p>Error.</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary' onclick='this.parentNode.parentNode.parentNode.parentNode.style.display = \"none\";'>Cerrar</button>
                </div>
                </div>
            </div>
            </div>";
            }
        } 
    }
    // Eliminación de una factura
    elseif (isset($_POST["accion2"]) && $_POST["accion2"] == "eliminar") { 
        // Verifica si se ha enviado la acción "delete" en el formulario.
        $VariableIDGuia = $_POST["Guia"]; 
        // Obtiene el ID de la factura a eliminar.
        $sql = "DELETE FROM guias_remision WHERE id_Guias_Remision = $VariableIDGuia"; 
        // Construye la consulta SQL para eliminar la factura.
        if ($conn->query($sql) === TRUE) { 
            // Ejecuta la consulta SQL y verifica si la eliminación fue exitosa.
            echo "<div class='modal' tabindex='-1' role='dialog' style='display: block;'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Éxito</h5>
                </div>
                <div class='modal-body'>
                    <p>Se elimino correctamente la guia de remision.</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary' onclick='this.parentNode.parentNode.parentNode.parentNode.style.display = \"none\";'>Cerrar</button>
                </div>
                </div>
            </div>
            </div>";
            // Muestra un mensaje de éxito.
        } else {
            echo "<div class='modal' tabindex='-1' role='dialog' style='display: block;'>
            <div class='modal-dialog modal-dialog-centered' role='document'>
                <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title'>Éxito</h5>
                </div>
                <div class='modal-body'>
                    <p>Error.</p>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-primary' onclick='this.parentNode.parentNode.parentNode.parentNode.style.display = \"none\";'>Cerrar</button>
                </div>
                </div>
            </div>
            </div>";
            // Muestra un mensaje de error.
        }
    }
}
?>
