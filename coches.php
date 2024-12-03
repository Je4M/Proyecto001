<!-- hola mundo -->
<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "funciones.php";
include_once "sesion.php";

if(empty($_SESSION['usuario'])) header("location: login.php");
$nombreCategoria = (isset($_POST['nombreCategoria'])) ? $_POST['nombreCategoria'] : null;

$categorias = obtenerCategorias($nombreCategoria);

$cartas = [
    
    ["titulo" => "No. Categorias", "icono" => "fa fa-box", "total" => count($categorias), "color" => "#3578FE"],
    ["titulo" => "Total productos", "icono" => "fa fa-shopping-cart", "total" => obtenerNumeroProductos(), "color" => "#4F7DAF"],
    
];
?>
<div class="container mt-3">
    <h1>
        <a class="btn btn-success btn-lg" href="agregar_categoria.php">
            <i class="fa fa-plus"></i>
            Agregar
        </a>
        Categoria
    </h1>
    <?php include_once "cartas_totales.php"; ?>

    <form action="" method="post" class="input-group mb-3 mt-3">
        <input autofocus name="nombreCategoria" type="text" class="form-control" placeholder="Escribe el nombre o código del producto que deseas buscar" aria-label="Nombre producto" aria-describedby="button-addon2">
        <button type="submit" name="buscarCategoria" class="btn btn-primary" id="button-addon2">
            <i class="fa fa-search"></i>
            Buscar
        </button>
    </form>
    <table class="table">
        <thead>
            <tr>
                <th>CODIGO</th>
                <th>TIPO</th>
               
            </tr>
        </thead>
        <tbody>
            <?php
            foreach($categorias as $categoria){
            ?>
                <tr>
                    <td><?= $categoria->idCategoria; ?></td>
                    <td><?= $categoria->categoria; ?></td>
                   
                    <td>
                        <a class="btn btn-info" href="editar_categoria.php?id=<?= $categoria->idCategoria; ?>">
                            <i class="fa fa-edit"></i>
                            Editar
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="eliminar_categoria.php?id=<?= $categoria->idCategoria; ?>">
                            <i class="fa fa-trash"></i>
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
