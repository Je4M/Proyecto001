<?php
include '../PHP/MetodosGuiaRemision.PHP';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guia de Remisión</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../CSS/CSSHeader.css">
    <link rel="stylesheet" href="../CSS/Pedidos.css">
</head>
<body>
<header>
    <div class="lateral-header">
      <br><br><br><h1>Cargas Perú S.A.C.</h1>
      <div class="user-section">
        <img src="../Imagenes/icons8-usuario-masculino-en-círculo-64.png" alt="Usuario">
        <!-- <h3>John Doe</h3> -->
      </div><br>
      <nav>
        <ul>
        <li><a href="Header.html">Inicio</a></li>
          <li><a href="InterfazFacturacion.php">Interfaz Facturacion</a></li>
          <li><a href="InterfazGuiaRemision.php">Interfaz Guia Remision</a></li>
          <li><a href="InterfazPedidos.php">Interfaz Pedidos</a></li>
          <li><a href="InterfazRevisionTecnica.php">Interfaz Revision Tecnica</a></li>
        </ul>
      </nav>
    </div>
  
    <button class="menu-toggle">
      <span class="bar"></span>
      <span class="bar"></span>
      <span class="bar"></span>
    </button>
  </header>
  <div class="main-content">
    
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" enctype="multipart/form-data">   
    <h1>Guia de remision</h1>
        <label for="id_remi_trans">Guia de remision:</label>
        <select id="id_remi_trans" name="id_remi_trans" required>
            <?php
            // Consulta SQL para obtener los valores de placas
            $sql = "SELECT id_Guias_Remision_Transportista FROM Guias_Remision_Transportista";
            $result = $conn->query($sql);
            ?>
            <option value="">Seleccione una guia de transportista</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["id_Guias_Remision_Transportista"] . "'>" . $row["id_Guias_Remision_Transportista"] . "</option>";
                }
            } else {
                echo "<option value=''>No se encontraron id_guia_remision </option>";
            }
            ?>
        </select><br><br>

        <label for="dni">Dni:</label>
        <select id="dni" name="dni" required>
            <?php
             // Consulta SQL para obtener los valores de fk_dni_ruc
             $sql = "SELECT fk_dni_ruc FROM trabajadores WHERE fk_id_cargo = 2  " ;
             $result = $conn->query($sql);
             ?>
            <option value="">Seleccione un dni</option>
            <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row["fk_dni_ruc"] . "'>" . $row["fk_dni_ruc"] . "</option>";
                }
            } else {
                echo "<option value=''>No hay dni's registrados</option>";
            }
            ?>
        </select><br><br>


        <label for="Fecha_emisión">Fecha de emisión:</label>
        <input type="date" id="Fecha_emisión" name="Fecha_emisión" required><br><br>

        <label for="Observación">Observación:</label>
        <input type="text" id="Observación" name="Observación" required><br><br>

        <label for="Cantidad">Cantidad:</label>
        <input type="number" id="Cantidad" name="Cantidad" required><br><br>

        <label for="U-medida">Unidades de medida:</label>
        <input type="text" id="U-medida" name="U-medida" required><br><br>

        <label for="Guia_Remi">Guias de Remisión de transporte:</label>
        <input type="file" id="Guia_Remi" name="Guia_Remi"  accept="application/pdf" required><br><br>
        
        <input type="hidden" name="accion1" value="Agregar">
        <input type="submit" value="Registrar Guia de Remisión">
    </form>
        
    <div class="container my-5">
        <?php
        // Incluir archivo de conexión
        // include '../PHP/MetodosGuiaRemision.PHP';

        // Realizar consulta SQL
        $sql = "SELECT id_Guias_Remision, Fecha_Emision,Observacion,Cantidad,U_medida,guia_remi_trans  FROM guias_remision";
      //  $sql = "SELECT placa  FROM vehiculos";
      //  $sql = "SELECT fk_dni_ruc  FROM trabajadores";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<caption><h1 class='mb-4'>Tabla Guias De Remision</h1></caption>";
            echo "<table class='table table-striped table-hover bg-white'>";
            echo "<thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Emision</th>
                        <th>Observacion</th>
                        <th>Cantidad</th>
                        <th>Unidades de medida</th>
                        <th>Guia de Remision de Transportista</th>
                        <th>Acciones</th>
                    </tr>
                  </thead>";

            echo "<tbody>";
            while($row = $result->fetch_assoc()) {
               echo "<tr>
                        <td>" . $row["id_Guias_Remision"] . "</td>
                        <td>" . $row["Fecha_Emision"] . "</td>
                        <td>" . $row["Observacion"] . "</td>
                        <td>" . $row["Cantidad"] . "</td>
                        <td>" . $row["U_medida"] . "</td>
                        <td>" . $row["guia_remi_trans"] . "</td>
                        <td>
                        <form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "'>
                        <input type='hidden' name='accion2' value='eliminar'>
                        <input type='hidden' name='Guia' value='" . $row["id_Guias_Remision"] . "'>
                        <input type='submit' name='submit' value='Eliminar'>
                        </form>
                        </td>
                      </tr>";
                
            }

          //  <td>" . $row["placa"] . "</td>
          //  <td>" . $row["fk_dni_ruc"] . "</td>
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "<h1 class='text-center'>No se encontraron guias de remision.</h1>";
        }

        // Cerrar conexión
        $conn->close();
        ?>
    </div></div>

    <!-- Incluir Bootstrap JS -->
    <script src="../JavaScrip/JSHeader.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>