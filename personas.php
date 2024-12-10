<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php"; // Asegúrate de que contenga las funciones necesarias
include_once "sesion.php";

if (empty($_SESSION['usuario'])) {
    header("location: login.php");
    exit();
}

// Inicializar parámetros de paginación y búsqueda
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? $_GET['search'] : '';
$limit = 25; // Número de registros por página
$offset = ($page - 1) * $limit;

// Consultar la base de datos para obtener los clientes
$clientes = obtenerClientes7($search, $offset, $limit);
$totalClientes = contarClientes($search); // Total de clientes que coinciden con la búsqueda
$totalPages = ceil($totalClientes / $limit); // Calcular total de páginas

?>
<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="agregar_persona.php">
            <i class="fa fa-plus"></i>
            Agregar Persona
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
                <th>ID</th>
                <th>DNI</th>
                <th>NOMBRE</th>
                <th>P.APELLIDO</th>
                <th>S.APELLIDO</th>
                <th>TELEFONO</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($clientes) > 0): ?>
                <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente->id_persona; ?></td>
                        <td><?php echo $cliente->DNI_Persona; ?></td>
                        <td><?php echo $cliente->nombre; ?></td>
                        <td><?php echo $cliente->primer_apellido; ?></td>
                        <td><?php echo $cliente->segundo_apellido; ?></td>
                        <td><?php echo $cliente->telefono; ?></td>
                        <td>
                            <a class="btn btn-info" href="editar_persona.php?id=<?php echo $cliente->id_persona; ?>">
                                <i class="fa fa-edit"></i>
                                Editar
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="eliminar_persona.php?id=<?php echo $cliente->id_persona; ?>">
                                <i class="fa fa-trash"></i>
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No se encontraron resultados.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</div>