<?php
include_once "sesion.php"; // Asegúrate de que esto incluya session_start()

$rol = isset($_SESSION['rol']) ? $_SESSION['rol'] : null;
error_log("Rol de usuario: " . print_r($rol, true));  // Inicializa $rol desde la sesión
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-2 shadow rounded">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="fandfur4.png" alt="" width="40" height="40" class="d-inline-block align-text-top">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="index.php">
            <i class="fa fa-home"></i>
            Inicio
          </a>
        </li>
        
        <?php if ($rol === 'admin') { ?>
        <li class="nav-item">
            <a class="nav-link active" href="usuarios.php">
            <i class="fa fa-users"></i>
            Usuarios
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="personas.php">
            <i class="fa fa-user-friends"></i>
            Personas
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="contratos.php">
            <i class="fa fa-user-friends"></i>
            Colaboradores
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="incidentes.php">
            <i class="fa fa-user-friends"></i>
            Incidentes
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="productos.php">
                <i class="fa fa-shopping-cart"></i>
                Productos
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="categorias.php">
                <i class="fa fa-shopping-cart"></i>
                Categorias
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="coches.php">
                <i class="fa fa-shopping-cart"></i>
                coches
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="contenedores.php">
                <i class="fa fa-shopping-cart"></i>
                contenedores
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="reporte_ventas.php">
            <i class="fa fa-file-alt"></i>
            Estadisticas
            </a>
        </li>
        <?php } ?>
        
        
        <li class="nav-item">
            <a class="nav-link active" href="empresas.php">
            <i class="fa fa-user-friends"></i>
            Asig Colaborador vehiculo
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="vender.php">
            <i class="fa fa-cash-register"></i>
            Auditorias
            </a>
        </li>
      </ul>
      <ul class="navbar-nav">
          <li class="nav-item">
              <a href="perfil.php" class="btn btn-info">Perfil</a>
          </li>
          &nbsp
          <li class="nav-item">
              <a href="cerrar_sesion.php" class="btn btn-warning">Salir</a>
          </li>
      </ul>
    </div>
  </div>
</nav>