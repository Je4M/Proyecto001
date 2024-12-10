<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if (empty($_SESSION['usuario'])) {
    header("location: login.php");
}

// Obtener los contratos con paginación y búsqueda
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 25; // Número de registros por página
$offset = ($page - 1) * $limit;

$clientes = obtenerContratos($search, $limit, $offset);
$totalClientes = contarContratos($search);
$totalPages = ceil($totalClientes / $limit);
?>
<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="agregar_contrato.php">
            <i class="fa fa-plus"></i>
            Agregar nuevo contrato
        </a>
    </h1>

    <!-- Campo de búsqueda -->
    <div class="mb-3">
        <form method="GET" action="">
            <input type="text" name="search" class="form-control" placeholder="Buscar por DNI" value="<?php echo htmlspecialchars($search); ?>" onkeyup="this.form.submit()">
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>DNI</th>
                <th>ID CONTRATO</th>
                <th>DESCRIPCION CONTRATO</th>
                <th>FECHA INICIO</th>
                <th>FECHA FIN</th>
                <th>SUELDO</th>
                <th>DES ESTADO</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($clientes as $cliente) { ?>
                <tr>
                    <td><?php echo htmlspecialchars($cliente->DNI_Persona); ?></td>
                    <td><?php echo htmlspecialchars($cliente->id_contrato); ?></td>
                    <td><?php echo ($cliente->descripcion == 1) ? 'Caducado' : 'Activo'; ?></td>
                    <td><?php echo htmlspecialchars($cliente->fecha_inicio); ?></td>
                    <td><?php echo htmlspecialchars($cliente->fecha_final); ?></td>
                    <td><?php echo htmlspecialchars($cliente->sueldo); ?></td>
                    <td><?php echo ($cliente->descripcion_estad == 1) ? 'Temporal' : 'Fijo'; ?></td>
                    <td>
                        <a class="btn btn-info" href="editar_cliente.php?id=<?php echo htmlspecialchars($cliente->DNI_Persona); ?>">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="eliminar_cliente.php?id=<?php echo htmlspecialchars($cliente->DNI_Persona); ?>">
                            <i class="fa fa-trash"></i>
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <!-- Paginación -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php } ?>
        </ul>
    </nav>
</div>