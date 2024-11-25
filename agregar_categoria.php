
<?php
include_once "encabezado.php";
include_once "navbar.php";
include_once "sesion.php";

if(empty($_SESSION['usuario'])) header("location: login.php");

?>
<div class="container">
    <h3>Agregar categoria</h3>
    <form method="post">
        <div class="mb-3">
            <label for="categoria" class="form-label">Ingrese una nueva categoria</label>
            <input type="text" name="categoria" class="form-control" id="categoria" placeholder="Escribe una nueva categoria">
        </div>   
        </div>
        <div class="text-center mt-3">
            <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
            
            </input>
            <a class="btn btn-danger btn-lg" href="categorias.php">
                <i class="fa fa-times"></i> 
                Cancelar
            </a>
        </div>
    </form>
</div>
<?php
if(isset($_POST['registrar'])){
    $categoria = $_POST['categoria'];
    if(empty($categoria) 
    ){
        echo'
        <div class="alert alert-danger mt-3" role="alert">
            Debes completar todos los datos.
        </div>';
        return;
    } 
    
    include_once "funciones.php";
    $resultado = registrarCategoria($categoria);
    if($resultado){
        echo'
        <div class="alert alert-success mt-3" role="alert">
            Producto registrado con éxito.
        </div>';
    }
    
}
?>