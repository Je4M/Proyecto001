<?php
// asfasdasdd

define("PASSWORD_PREDETERMINADA", "Jeampierre");
define("HOY", date("Y-m-d"));
function iniciarSesion($usuario, $password) {
    // Modifica la consulta para incluir el rol
    $sentencia = "SELECT idUsuario, nomUsuario, rol FROM usuarios WHERE nomUsuario = ?";
    $resultado = select($sentencia, [$usuario]);
    
    if ($resultado) {
        $usuario = $resultado[0];
        $verificaPass = verificarPassword($usuario->idUsuario, $password);
        
        if ($verificaPass) {
            return $usuario; // Devuelve el objeto que ahora incluye 'rol'
        }
    }
    
    return null; // Retorna null si no se verifica
}

function verificarPassword($idUsuario, $password){
    $sentencia = "SELECT password FROM usuarios WHERE idUsuario = ?";
    $contrasenia = select($sentencia, [$idUsuario])[0]->password;
    $verifica = password_verify($password, $contrasenia);
    if($verifica) return true;
}

function obtenerRol($idUsuario) {
    $pdo = conectarBaseDatos(); 
    $sentencia = "SELECT rol FROM usuarios WHERE idUsuario = ?";
    $stmt = $pdo->prepare($sentencia);
    $stmt->execute([$idUsuario]);
    $rol = $stmt->fetch(PDO::FETCH_OBJ);
    return $rol ? $rol->rol : null;
}

function cambiarPassword($idUsuario, $password){
    $nueva = password_hash($password, PASSWORD_DEFAULT);
    $sentencia = "UPDATE usuarios SET password = ? WHERE id = ?";
    return editar($sentencia, [$nueva, $idUsuario]);
}

function eliminarUsuario($id){
    $sentencia = "DELETE FROM usuarios WHERE idUsuario = ?";
    return eliminar($sentencia, $id);
}

function editarUsuario($usuario, $nombre, $telefono, $direccion, $id){
    $sentencia = "UPDATE usuarios SET usuario = ?, nombre = ?, telefono = ?, direccion = ? WHERE id = ?";
    $parametros = [$usuario, $nombre, $telefono, $direccion, $id];
    return editar($sentencia, $parametros);
}

function obtenerUsuarioPorId($id){
    $sentencia = "SELECT idUsuario, nomUsuario,password FROM usuarios WHERE idUsuario = ?";
    return select($sentencia, [$id])[0];
}

function obtenerUsuarios(){
    $sentencia = "SELECT idUsuario, nomUsuario, password FROM usuarios";
    return select($sentencia);
}


function registrarUsuario($usuario, $contrasena, $rol) {
    // Aquí deberías implementar la lógica para insertar el nuevo usuario en la base de datos.
    $sentencia = "INSERT INTO usuarios (nomUsuario, password, rol) VALUES (?, ?, ?)";
    
    // Asegúrate de que la función select esté correctamente implementada para ejecutar consultas de inserción.
    return select($sentencia, [$usuario, $contrasena, $rol]);
}

function usuarioExiste($usuario) {
    $sentencia = "SELECT COUNT(*) as count FROM usuarios WHERE nomUsuario = ?";
    $resultado = select($sentencia, [$usuario]);
    
    // Asegúrate de que estás accediendo como un objeto
    return $resultado[0]->count > 0; // Devuelve true si el usuario existe
}




function eliminarCliente($idPersona){
    $sentencia = "DELETE FROM personas WHERE id_persona = ?";
    return eliminar($sentencia, $idPersona);
}

function eliminarEmpresa($id_Empresa){
    $sentencia = "DELETE FROM empresa WHERE RUC = ?";
    return eliminar($sentencia, $id_Empresa);
}

function eliminarProveedor($id_Proveedor){
    $sentencia = "DELETE FROM proveedores WHERE id_Proveedor = ?";
    return eliminar($sentencia, $id_Proveedor);
}

function editarCliente($DNI_Persona, $Nombres, $PrimerApellido, $SegundoApellido, $Telefonocli) {
    $sentencia = "UPDATE personas SET nombre = ?, primer_apellido = ?, segundo_apellido = ?, telefono = ? WHERE DNI_Persona = ?";
    $parametros = [$Nombres, $PrimerApellido, $SegundoApellido, $Telefonocli, $DNI_Persona];
    return editar($sentencia, $parametros);
}

function editarEmpresa($RUC, $NombreEmpresa, $TelefonoEmpresa, $DireccionEmpresa, $EmailEmpresa) {
    $sentencia = "UPDATE empresa SET NombreEmpresa = ?, TelefonoEmpresa = ?, DireccionEmpresa = ?, EmailEmpresa = ? WHERE RUC = ?";
    $parametros = [$NombreEmpresa, $TelefonoEmpresa, $DireccionEmpresa, $EmailEmpresa, $RUC];
    return editar($sentencia, $parametros);
}

function editarProveedor($RUC_Prov, $NombreEmpresa,$Condicion,$Estado, $telefono_Proveedor, $Direccion_Proveedor,$EmailProv,$id_Proveedor){
    $sentencia = "UPDATE proveedores SET RUC_Prov = ?, NombreEmpresa = ?,Condicion =?, Estado=?, telefono_Proveedor = ?, Direccion_Proveedor=?, EmailProv=? WHERE id_Proveedor = ?";
    $parametros = [$RUC_Prov, $NombreEmpresa,$Condicion,$Estado, $telefono_Proveedor, $Direccion_Proveedor,$EmailProv,$id_Proveedor];
    return editar($sentencia, $parametros);
}

function obtenerClientePorId($idPersona){
    $sentencia = "SELECT * FROM personas WHERE id_persona = ?";
    $cliente = select($sentencia, [$idPersona]);
    if($cliente) return $cliente[0];
}
function obtenerClientes7($search, $offset, $limit) {
    $bd = conectarBaseDatos();

    // Consulta SQL con búsqueda
    $sql = "SELECT * FROM personas WHERE DNI_Persona LIKE :search LIMIT :offset, :limit";
    $stmt = $bd->prepare($sql);
    
    // Usar parámetros con PDO
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
    $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
    
    $stmt->execute();
    return $stmt->fetchAll();
}
function obtenerEmpresaPorId($id_Empresa){
    $sentencia = "SELECT * FROM empresa WHERE RUC = ?";
    $cliente = select($sentencia, [$id_Empresa]);
    if($cliente) return $cliente[0];
}

function obtenerProveedorPorId($id_Proveedor){
    $sentencia = "SELECT * FROM proveedores WHERE id_Proveedor = ?";
    $cliente = select($sentencia, [$id_Proveedor]);
    if($cliente) return $cliente[0];
}
function contarClientes($search) {
    $bd = conectarBaseDatos();

    // Consulta SQL para contar registros
    $sql = "SELECT COUNT(*) as total FROM personas WHERE DNI_Persona LIKE :search";
    $stmt = $bd->prepare($sql);
    
    // Usar parámetros con PDO
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam, PDO::PARAM_STR);
    
    $stmt->execute();
    return $stmt->fetch()->total; // Retorna el total
}

function obtenerPersonas(){
    $sentencia = "SELECT * from personas p
join colaboradores cl on cl.fk_id_persona = p.id_persona
JOIN cargos c on cl.fk_id_cargo =c.id_cargo
;";
    return select($sentencia);
}
function obtenerPersonasContrato($dni) {
    // Consulta para obtener el nombre completo de la persona según el DNI
    $sentencia = "SELECT concat(nombre, ' ', primer_apellido, ' ', segundo_apellido) AS nombres FROM personas WHERE DNI_Persona = ?";
    return select($sentencia, [$dni]); // Asegúrate de que esta función esté definida
}

function verificarContratoActivo($dni) {
    // Consulta para verificar si el colaborador tiene un contrato activo
    $sentencia = "SELECT * FROM colaboradores c 
                  JOIN contratos co ON co.id_contrato = c.fk_id_contrato 
                  JOIN personas p ON c.fk_id_persona = p.id_persona 
                  WHERE p.DNI_Persona = ? AND co.descripcion = '0';"; // Asegúrate que '0' sea el valor correcto para "activo"
    
    $resultado = select($sentencia, [$dni]); // Asegúrate de que esta función esté definida

    if (!empty($resultado)) {
        return "Esta persona ya tiene un contrato activo.";
    }
    return ""; // Sin mensaje si no hay contrato activo
}
function estadoContrato($dni) {
    $sentencia = "SELECT co.descripcion FROM colaboradores c 
                  JOIN contratos co ON co.id_contrato = c.fk_id_contrato 
                  JOIN personas p ON c.fk_id_persona = p.id_persona 
                  WHERE p.DNI_Persona = ?";

    $resultado = select($sentencia, [$dni]);

    if (!empty($resultado)) {
        return $resultado[0]->descripcion; // Devuelve '0' o '1' como string
    }
    
    return null; // Sin contrato
}
function buscarDescContrato($dni) {
    $estadoContrato = estadoContrato($dni); // Obtiene el estado del contrato

    // Ahora compara con un entero
    if ($estadoContrato === 0) { // Cambia '0' a 0
        return 'Activo'; // Contrato activo
    } elseif ($estadoContrato === 1) {
        return 'Caducado'; // Contrato caducado
    }
    
    return 'Sin contrato'; // Indica que no hay contrato
}

function obtenerIncidentes(){
    $sentencia = "SELECT * FROM incidentes i
    join colaboradores c on c.id_colaborador=i.fk_id_colaborador
    join personas p on p.id_persona = c.fk_id_persona
    join gravedad_incidente gi on i.fk_id_gravedad=gi.id_gravedad
    join recuperacion r on r.fk_id_incidente=i.id_incidentes";
    return select($sentencia);
}
function obtenerCargos() {
    $sentencia = "SELECT * FROM cargos"; 
    return select($sentencia); 
}
function obtenerContratos2() {
    $sentencia = " select * from contratos c
 join estado_contrato ec on c.fk_id_estado = ec.id_estado
 join colaboradores col on col.fk_id_contrato=c.id_contrato
 join personas p on  p.id_persona = col.fk_id_persona"; 
    return select($sentencia); 
}
function obtenercontenedores() {
    $sentencia = "  SELECT  * from contenedores cn
inner join  puntos_criticos  pc on fk_idpuntocritico = id_puntocritico;"; 
    return select($sentencia); 
}

function obtenerContratos($search, $limit, $offset) {
    $bd = conectarBaseDatos();
    $query = "SELECT c.*, ec.descripcion_estad, p.DNI_Persona FROM contratos c
              JOIN estado_contrato ec ON c.fk_id_estado = ec.id_estado
              JOIN colaboradores col ON col.fk_id_contrato = c.id_contrato
              JOIN personas p ON p.id_persona = col.fk_id_persona
              WHERE p.DNI_Persona LIKE ?
              LIMIT ? OFFSET ?";
              
    $stmt = $bd->prepare($query);
    $stmt->execute(["%$search%", $limit, $offset]);
    return $stmt->fetchAll();
}
function contarContratos($search) {
    $bd = conectarBaseDatos();
    $query = "SELECT COUNT(*) as total FROM contratos c
              JOIN estado_contrato ec ON c.fk_id_estado = ec.id_estado
              JOIN colaboradores col ON col.fk_id_contrato = c.id_contrato
              JOIN personas p ON p.id_persona = col.fk_id_persona
              WHERE p.DNI_Persona LIKE ?";
              
    $stmt = $bd->prepare($query);
    $stmt->execute(["%$search%"]);
    return $stmt->fetch()->total;
}
function obtenerContratosPorDNI($dni){
    $sentencia = "SELECT DNI_Persona AS idCliente, CONCAT(Nombres, ' ', PrimerApellido, ' ', SegundoApellido) AS nombre, Telefonocli AS telefono, direccioncli AS direccion FROM persona WHERE DNI_Persona = ?";
    $resultados = select($sentencia, [$dni]);
    return count($resultados) > 0 ? $resultados[0] : null;
}
function obtenerEmpresas(){
    $sentencia = "SELECT * FROM empresa";
    return select($sentencia);
}

function registrarCliente($dni, $nombre, $apellidopat, $apellidomat, $telefono){
    $sentencia = "INSERT INTO personas (DNI_Persona, nombre, primer_apellido, segundo_apellido,telefono) VALUES (?,?,?,?,?)";
    $parametros = [$dni, $nombre, $apellidopat, $apellidomat, $telefono];
    return insertar($sentencia, $parametros);
}

function registrarEmpresa($ruc, $nombre, $telefono, $direccion, $email){
    $sentencia = "INSERT INTO empresa (RUC, NombreEmpresa, TelefonoEmpresa, DireccionEmpresa, EmailEmpresa) VALUES (?,?,?,?,?)";
    $parametros = [$ruc, $nombre, $telefono, $direccion, $email];
    return insertar($sentencia, $parametros);
}

function registrarProveedor($ruc, $nombre,$condicion,$estado, $telefono, $direccion, $email){
    $sentencia = "INSERT INTO proveedores (RUC_Prov, NombreEmpresa,Condicion,Estado, telefono_Proveedor, Direccion_Proveedor, EmailProv) VALUES (?,?,?,?,?,?,?)";
    $parametros = [$ruc, $nombre,$condicion,$estado, $telefono, $direccion, $email];
    return insertar($sentencia, $parametros);
}

function obtenerNumeroVentas(){
    $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM venta";
    return select($sentencia)[0]->total;
}

function obtenerNumeroUsuarios(){
    $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM colaboradores";
    return select($sentencia)[0]->total;
}

function obtenerNumeroClientes(){
    $sentencia = "SELECT 
    (SELECT COUNT(*) FROM persona) + 
    (SELECT COUNT(*) FROM empresa) AS total";
    return select($sentencia)[0]->total;
}
function obtenervehiculos(){
    $sentencia = " SELECT  * from vehiculos 
inner join marcas on  marcas.id_marca = vehiculos.fk_id_marca
inner join estado_vehiculos on vehiculos.fk_id_estadovehiculo =  estado_vehiculos.id_estadovehiculo
inner join modelos on modelos.id_modelo = vehiculos.fk_id_modelo ;
";
return select($sentencia);
}

function obtenerVentasPorUsuario(){
    $sentencia = "SELECT SUM(v.totalVenta) AS totalVenta, c.Usuario, COUNT(*) AS numeroVentas 
    FROM venta v
    INNER JOIN colaboradores c ON c.idColaborador = v.fk_idColaborador
    GROUP BY v.fk_idColaborador
    ORDER BY totalVenta DESC";
    return select($sentencia);
}

function obtenerVentasPorCliente(){
    $sentencia = "SELECT ec.descestadocont, 
                         COUNT(c.id_contenedor) AS cantidadContenedores 
                  FROM estado_contenedores ec
                  LEFT JOIN contenedores c ON c.fk_idestadocontenedor = ec.id_estadocontenedor
                  GROUP BY ec.id_estadocontenedor
                  ORDER BY cantidadContenedores DESC;";
    return select($sentencia);
}

function obtenerProductosMasVendidos(){
    $sentencia = "SELECT SUM(pv.cantidad * pv.preciototal) AS total, SUM(pv.cantidad) AS unidades,
    p.nombreProd FROM productoventas pv
    INNER JOIN producto p ON p.idProducto = pv.fk_idproducto
    GROUP BY pv.fk_idproducto
    ORDER BY total DESC
    LIMIT 10";
    return select($sentencia);
}

function obtenerTotalVentas($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(totalVenta),0) AS total FROM venta";
    if(isset($idUsuario)){
        $sentencia .= " WHERE fk_idColaborador = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function obtenerTotalVentasHoy($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(totalVenta),0) AS total FROM venta WHERE DATE(fechaVenta) = CURDATE() ";
    if(isset($idUsuario)){
        $sentencia .= " AND fk_idColaborador = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function obtenerTotalVentasSemana($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(totalVenta),0) AS total FROM venta  WHERE WEEK(fechaVenta) = WEEK(NOW())";
    if(isset($idUsuario)){
        $sentencia .= " AND  fk_idColaborador = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function obtenerTotalVentasMes($idUsuario = null){
    $parametros = [];
    $sentencia = "SELECT IFNULL(SUM(totalVenta),0) AS total FROM venta  WHERE MONTH(fechaVenta) = MONTH(CURRENT_DATE()) AND YEAR(fechaVenta) = YEAR(CURRENT_DATE())";
    if(isset($idUsuario)){
        $sentencia .= " AND  fk_idColaborador = ?";
        array_push($parametros, $idUsuario);
    }
    $fila = select($sentencia, $parametros);
    if($fila) return $fila[0]->total;
}

function calcularTotalVentas($ventas) {
    $total = 0;
    foreach ($ventas as $venta) {
        $total += $venta->totalVenta;
    }
    return $total;
}

function calcularProductosVendidos($ventas) {
    $total = 0;
    foreach ($ventas as $venta) {
        foreach ($venta->producto as $producto) {
            $total += $producto->cantidad;
        }
    }
    return $total;
}

function obtenerGananciaVentas($ventas) {
    $ganancia = 0;
    foreach ($ventas as $venta) {
        foreach ($venta->producto as $producto) {
            $ganancia += ($producto->precioVenta - $producto->precioCompra) * $producto->cantidad;
        }
    }
    return $ganancia;
}

function obtenerVentas($fechaInicio, $fechaFin, $cliente, $usuario) {
    $pdo = conectarBaseDatos();
    $parametros = [];
    $sentencia = "SELECT v.*, c.Usuario AS usuario, 
                  IFNULL(p.Nombres, em.NombreEmpresa) AS cliente
                  FROM venta v
                  INNER JOIN colaboradores c ON c.idColaborador = v.fk_idColaborador
                  LEFT JOIN clienteventa cv ON cv.idCliente = v.fk_clienteVenta
                  LEFT JOIN persona p ON p.DNI_Persona = cv.fk_dni
                  LEFT JOIN empresa em ON em.RUC = cv.fk_ruc";

    $condiciones = [];

    if (!empty($usuario)) {
        $condiciones[] = "v.fk_idColaborador = ?";
        $parametros[] = $usuario;
    }

    if (!empty($cliente)) {
        $condiciones[] = "v.fk_clienteVenta = ?";
        $parametros[] = $cliente;
    }

    if (!empty($fechaInicio) && !empty($fechaFin)) {
        $condiciones[] = "DATE(v.fechaVenta) >= ? AND DATE(v.fechaVenta) <= ?";
        $parametros[] = $fechaInicio;
        $parametros[] = $fechaFin;
    } else {
        $condiciones[] = "DATE(v.fechaVenta) = ?";
        $parametros[] = date('Y-m-d');
    }

    if (!empty($condiciones)) {
        $sentencia .= " WHERE " . implode(" AND ", $condiciones);
    }

    $stmt = $pdo->prepare($sentencia);
    $stmt->execute($parametros);
    $ventas = $stmt->fetchAll(PDO::FETCH_OBJ);
    return agregarProductosVendidos($ventas);
}



function agregarProductosVendidos($ventas){
    foreach($ventas as $venta){
        $venta->producto = obtenerProductosVendidos($venta->idVenta);
    }
    return $ventas;
}


function obtenerProductosVendidos($idVenta) {
    $pdo = conectarBaseDatos();
    $sentencia = "SELECT pv.cantidad, p.precioCompra, p.precioVenta, p.nombreProd AS nombre
                  FROM productoventas pv
                  INNER JOIN producto p ON p.idProducto = pv.fk_idproducto
                  WHERE pv.fk_idventa = ?";
    $stmt = $pdo->prepare($sentencia);
    $stmt->execute([$idVenta]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function registrarVenta($productos, $idUsuario, $idCliente, $total){
    $sentencia =  "INSERT INTO venta (fechaVenta, totalVenta, fk_id, fk_clienteVenta) VALUES (?,?,?,?)";
    $parametros = [date("Y-m-d H:i:s"), $total, $idUsuario, $idCliente];

    $resultadoVenta = insertar($sentencia, $parametros);
    if($resultadoVenta){
        $idVenta = obtenerUltimoIdVenta();
        $productosRegistrados = registrarProductosVenta($productos, $idVenta);
        return $resultadoVenta && $productosRegistrados;
    }
}

function registrarProductosVenta($productos, $idVenta){
    $sentencia = "INSERT INTO productoventas (cantidad, preciototal, fk_idproducto, fk_idventa) VALUES (?,?,?,?)";
    foreach ($productos as $producto ) {
        $parametros = [$producto->cantidad, $producto->precioVenta, $producto->idProducto, $idVenta];
        insertar($sentencia, $parametros);
        descontarProductos($producto->idProducto, $producto->cantidad);
    }
    return true;
}

function descontarProductos($idProducto, $cantidad) {
    $sentencia = "UPDATE producto SET existencia = existencia - ? WHERE idProducto = ?";
    $parametros = [$cantidad, $idProducto];
    return editar($sentencia, $parametros);
}

function obtenerUltimoIdVenta() {
    $bd = conectarBaseDatos();
    $sentencia = "SELECT MAX(idVenta) FROM venta";
    $respuesta = $bd->query($sentencia);
    return $respuesta->fetchColumn();
}


function calcularTotalLista($lista){
    $total = 0;
    foreach($lista as $producto){
        $total += floatval($producto->precioVenta * $producto->cantidad);
    }
    return $total;
}

function agregarProductoALista($producto, $listaProductos){
    if($producto->existencia < 1) return $listaProductos;
    $producto->cantidad = 1;
    
    $existe = verificarSiEstaEnLista($producto->idProducto, $listaProductos);

    if(!$existe){
        array_push($listaProductos, $producto);
    } else{
        $existenciaAlcanzada = verificarExistencia($producto->idProducto, $listaProductos, $producto->existencia);
        
        if($existenciaAlcanzada)return $listaProductos;

        $listaProductos = agregarCantidad($producto->idProducto, $listaProductos);
        }
        
    return $listaProductos;
    
}

function verificarExistencia($idProducto, $listaProductos, $existencia){
    foreach($listaProductos as $producto){
        if($producto->idProducto == $idProducto){
           if($existencia <= $producto->cantidad) return true; 
        }
    }
    return false;
}

function verificarSiEstaEnLista($idProducto, $listaProductos){
    foreach($listaProductos as $producto){
        if($producto->idProducto == $idProducto){
            return true;
        }
    }
    return false;
}

function agregarCantidad($idProducto, $listaProductos){
    foreach($listaProductos as $producto){
        if($producto->idProducto == $idProducto){
            $producto->cantidad++;
        }
    }
    return $listaProductos;
}

function obtenerProductoPorCodigo($codigo){
    $sentencia = "SELECT * FROM producto WHERE codigo = ?";
    $producto = select($sentencia, [$codigo]);
    if($producto) return $producto[0];
    return [];
}

function obtenerNumeroProductos(){
    $sentencia = "SELECT IFNULL(SUM(existencia),0) AS total FROM producto";
    $fila = select($sentencia);
    if($fila) return $fila[0]->total;
}

function obtenerTotalInventario(){
    $sentencia = "SELECT IFNULL(SUM(existencia * precioVenta),0) AS total FROM producto";
    $fila = select($sentencia);
    if($fila) return $fila[0]->total;
}

function calcularGananciaProductos(){
    $sentencia = "SELECT IFNULL(SUM(existencia*precioVenta) - SUM(existencia*precioCompra),0) AS total FROM producto";
    $fila = select($sentencia);
    if($fila) return $fila[0]->total;
}

function eliminarProducto($id){
    $sentencia = "DELETE FROM producto WHERE idProducto = ?";
    return eliminar($sentencia, $id);
}

function eliminarCategoria($idCategoria){
    $sentencia = "DELETE FROM categorias WHERE idCategoria = ?";
    return eliminar($sentencia, $idCategoria);
}

function editarProducto($codigo, $nombre, $compra, $venta, $existencia, $descripcion, $fecha_vencimiento, $categoria, $proveedor, $id){
    $sentencia = "UPDATE producto SET codigo = ?, nombreProd = ?, precioCompra = ?, precioVenta = ?, existencia = ?,descricpionProd = ?,fechavencimiento = ?,fk_idcategoria=?, fk_idproveedor=? WHERE idProducto = ?";
    $parametros = [$codigo, $nombre, $compra, $venta, $existencia, $descripcion, $fecha_vencimiento, $categoria, $proveedor, $id];
    return editar($sentencia, $parametros);
}

function editarCategoria( $idCategoria, $categoria){
    $sentencia = "UPDATE categorias SET  categoria = ? WHERE idCategoria = ?";
    $parametros = [ $categoria,$idCategoria];
    return editar($sentencia, $parametros);
}

function obtenerProductoPorId($id){
    $sentencia = "SELECT * FROM producto WHERE idProducto = ?";
    return select($sentencia, [$id])[0];
}

function obtenerCategoriaPorId($idCategoria){
    $sentencia = "SELECT * FROM categorias WHERE idCategoria = ?";
    return select($sentencia, [$idCategoria])[0];
}

function obtenerProductos($busqueda = null){
    $parametros = [];
    $sentencia = "SELECT * FROM producto";

    if ($busqueda !== null) {
        $sentencia .= " WHERE nombreProd LIKE ? OR codigo LIKE ?";
        $parametros[] = "%".$busqueda."%";
        $parametros[] = "%".$busqueda."%"; 
    } 

    return select($sentencia, $parametros);
}


function obtenerCategorias($busqueda = null){
    $parametros = [];
    $sentencia = "SELECT * FROM categorias ";
    if(isset($busqueda)){
        $sentencia .= " WHERE categoria LIKE ? OR idCategoria LIKE ?";
        array_push($parametros, "%".$busqueda."%", "%".$busqueda."%"); 
    } 
    return select($sentencia, $parametros);
}

function registrarProducto($codigo, $nombre, $compra, $venta, $existencia, $descripcion, $fecha_vencimiento, $categoria, $proveedor) {
    $pdo = conectarBaseDatos();
    $sentencia = "INSERT INTO producto (codigo, nombreProd, precioCompra, precioVenta, existencia, descricpionProd, fechavencimiento, fk_idcategoria, fk_idproveedor) VALUES (?,?,?,?,?,?,?,?,?)";
    $parametros = [$codigo, $nombre, $compra, $venta, $existencia, $descripcion, $fecha_vencimiento, $categoria, $proveedor];
    $stmt = $pdo->prepare($sentencia);
    return $stmt->execute($parametros);
}


function registrarCategoria($categoria){
    $sentencia = "INSERT INTO categorias(categoria) VALUES (?)";
    $parametros = [$categoria];
    return insertar($sentencia, $parametros);
}

function select($sentencia, $parametros = []){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute($parametros);
    return $respuesta->fetchAll();
}

function insertar($sentencia, $parametros ){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    return $respuesta->execute($parametros);
}

function eliminar($sentencia, $id ){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    return $respuesta->execute([$id]);
}

function editar($sentencia, $parametros ){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    return $respuesta->execute($parametros);
}

function conectarBaseDatos() {
    $host = "127.0.0.1";
    $port = "3306";
    $db   = "residuosfinal";
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::ATTR_TIMEOUT            => 10, // Opcional: Ajusta el tiempo de espera de la conexión en segundos
    ];

    $dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";
    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (PDOException $e) {
        // Log the exception message to a file or monitoring system for debugging
        error_log($e->getMessage());
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}
function testConexion() {
    try {
        $pdo = conectarBaseDatos();
        echo "Conexión exitosa.";
    } catch (PDOException $e) {
        echo "Error en la conexión: " . $e->getMessage();
    }
}

function obtenerCategorias2() {
    $pdo = conectarBaseDatos();
    $stmt = $pdo->query("SELECT idCategoria, categoria FROM categorias");
    return $stmt->fetchAll();
}

function obtenerProveedores2() {
    $pdo = conectarBaseDatos();
    $stmt = $pdo->query("SELECT id_Proveedor, NombreEmpresa FROM proveedores");
    return $stmt->fetchAll();
}

function obtenerPersonaPorNombre($dni) {
    $pdo = conectarBaseDatos();
    $sentencia = $pdo->prepare("SELECT * FROM usuarios WHERE nomUsuario = ?");
    $sentencia->execute([$dni]);
    return $sentencia->fetch(PDO::FETCH_OBJ);
}

function obtenerRoles2() {
    $pdo = conectarBaseDatos();
    $sentencia = $pdo->query("SELECT * FROM usuarios");
    return $sentencia->fetchAll(PDO::FETCH_OBJ);
}


function registrarColaborador($usuario, $contrasena, $fk_idPersona, $fk_idRoles){
    $password = password_hash($contrasena, PASSWORD_DEFAULT);
    $sentencia = "INSERT INTO colaboradores (Usuario, password, fk_dni, fk_idRoles) VALUES (?,?,?,?)";
    $parametros = [$usuario, $password, $fk_idPersona, $fk_idRoles];
    return insertar($sentencia, $parametros);
}

function obtenerClientePorDNI($dni){
    $sentencia = "SELECT DNI_Persona AS idCliente, CONCAT(Nombres, ' ', PrimerApellido, ' ', SegundoApellido) AS nombre, Telefonocli AS telefono, direccioncli AS direccion FROM persona WHERE DNI_Persona = ?";
    $resultados = select($sentencia, [$dni]);
    return count($resultados) > 0 ? $resultados[0] : null;
}

function obtenerClientePorRUC($ruc){
    $sentencia = "SELECT RUC AS idCliente, NombreEmpresa AS nombre, TelefonoEmpresa AS telefono, DireccionEmpresa AS direccion FROM empresa WHERE RUC = ?";
    $resultados = select($sentencia, [$ruc]);
    return count($resultados) > 0 ? $resultados[0] : null;
}

function registrarVenta2($productos, $total, $clienteId){
    $idColaborador = $_SESSION['idUsuario'];
    $fechaVenta = date("Y-m-d H:i:s");

    // Verifica que el cliente existe en clienteventa
    if(!clienteExiste($clienteId)){
        throw new Exception("Cliente no existe en la base de datos.");
    }

    $sentencia = "INSERT INTO venta (fechaVenta, totalVenta, fk_idColaborador, fk_clienteVenta) VALUES (?, ?, ?, ?)";
    $parametros = [$fechaVenta, $total, $idColaborador, $clienteId];
    
    $resultado = insertar($sentencia, $parametros);

    if($resultado){
        $idVenta = obtenerUltimoIdVenta();
        foreach($productos as $producto){
            $sentenciaProducto = "INSERT INTO productoventas (fk_idVenta, fk_idProducto, cantidad, preciototal) VALUES (?, ?, ?, ?)";
            $parametrosProducto = [$idVenta, $producto->idProducto, $producto->cantidad, $producto->precioVenta * $producto->cantidad];
            insertar($sentenciaProducto, $parametrosProducto);
            
            // Descontar la cantidad de productos vendidos del inventario
            descontarProductos($producto->idProducto, $producto->cantidad);
        }
        return $idVenta; // Aquí retornamos el idVenta
    }
    return false;
}

function clienteExiste($idCliente) {
    $bd = conectarBaseDatos();
    $sentencia = "SELECT COUNT(*) FROM clienteventa WHERE idCliente = ?";
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute([$idCliente]);
    return $respuesta->fetchColumn() > 0;
}






function registrarContrato($dni, $cargoId, $fechaInicio, $fechaFinal, $sueldo) {
    try {
        $bd = conectarBaseDatos();

        // Verificar si la persona ya existe
        $stmt = $bd->prepare("SELECT id_persona FROM personas WHERE DNI_Persona = ?");
        $stmt->execute([$dni]);
        $persona = $stmt->fetch();

        if ($persona) {
            // Persona existe, obtener el ID
            $idPersona = $persona->id_persona;

            // Verificar si ya hay un contrato existente para esta persona
            $stmt = $bd->prepare("SELECT id_contrato FROM contratos c
                                   JOIN colaboradores col ON c.id_contrato = col.fk_id_contrato
                                   WHERE col.fk_id_persona = ? ORDER BY c.id_contrato DESC LIMIT 1");
            $stmt->execute([$idPersona]);
            $contrato = $stmt->fetch();

            // Determina el estado y la descripción
            $nuevoEstado = empty($fechaFinal) ? 0 : 1; // 0 para "Caducado", 1 para "Activo"
            $descripcion = $nuevoEstado; // Estado del contrato (0 o 1)
            $fk_id_estado = ($descripcion == 1) ? 1 : 2; // 1 para "Activo", 2 para "Caducado"

            if ($contrato) {
                // Actualizar el contrato existente
                $stmt = $bd->prepare("UPDATE contratos SET descripcion = ?, sueldo = ?, fecha_inicio = ?, fecha_final = ?, fk_id_estado = ? WHERE id_contrato = ?");
                $stmt->execute([$descripcion, $sueldo, $fechaInicio, $fechaFinal ?: null, $fk_id_estado, $contrato->id_contrato]);

                return "Contrato actualizado correctamente.";
            } else {
                // No hay contrato existente, insertar uno nuevo
                $stmt = $bd->prepare("INSERT INTO contratos (descripcion, sueldo, fecha_inicio, fecha_final, fk_id_estado) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$descripcion, $sueldo, $fechaInicio, $fechaFinal ?: null, $fk_id_estado]);
                $idContrato = $bd->lastInsertId(); // Obtener el ID del nuevo contrato

                // Insertar en la tabla colaboradores
                $stmt = $bd->prepare("INSERT INTO colaboradores (fk_id_cargo, fk_id_persona, fk_id_contrato) VALUES (?, ?, ?)");
                $stmt->execute([$cargoId, $idPersona, $idContrato]);

                return "Contrato registrado correctamente.";
            }
        } else {
            // Persona no existe, insertar nueva persona
            $stmt = $bd->prepare("INSERT INTO personas (DNI_Persona) VALUES (?)");
            $stmt->execute([$dni]);
            $idPersona = $bd->lastInsertId();

            // Estado y descripción
            $nuevoEstado = empty($fechaFinal) ? 0 : 1; // 0 para "Caducado", 1 para "Activo"
            $descripcion = $nuevoEstado; // Estado del contrato (0 o 1)
            $fk_id_estado = ($descripcion == 1) ? 1 : 2; // 1 para "Activo", 2 para "Caducado"

            // Insertar nuevo contrato
            $stmt = $bd->prepare("INSERT INTO contratos (descripcion, sueldo, fecha_inicio, fecha_final, fk_id_estado) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$descripcion, $sueldo, $fechaInicio, $fechaFinal ?: null, $fk_id_estado]);
            $idContrato = $bd->lastInsertId(); // Obtener el ID del nuevo contrato

            // Insertar en la tabla colaboradores
            $stmt = $bd->prepare("INSERT INTO colaboradores (fk_id_cargo, fk_id_persona, fk_id_contrato) VALUES (?, ?, ?)");
            $stmt->execute([$cargoId, $idPersona, $idContrato]);

            return "Nueva persona y contrato registrado correctamente.";
        }
    } catch (Exception $e) {
        return "Error: " . $e->getMessage();
    }
}



function obtenerColaboradorPorDNI($dni) {
    // Busca la persona por DNI
    $sentenciaPersona = "SELECT id_persona FROM personas WHERE DNI_Persona = ?";
    $persona = select($sentenciaPersona, [$dni]);

    // Si se encuentra la persona, busca el colaborador
    if (!empty($persona)) {
        $id_persona = $persona[0]->id_persona; // Obtener el ID de la persona

        // Ahora busca el colaborador usando el ID de la persona
        $sentenciaColaborador = "
            SELECT c.id_colaborador, p.nombre, p.primer_apellido, p.segundo_apellido 
            FROM colaboradores c
            JOIN personas p ON c.fk_id_persona = p.id_persona
            WHERE c.fk_id_persona = ?";
        $colaborador = select($sentenciaColaborador, [$id_persona]);

        return !empty($colaborador) ? $colaborador[0] : null; // Devuelve el primer resultado o null
    }
    return null; // Si no se encuentra la persona, retornar null
}

// Función para obtener las gravedades de incidentes
function obtenerGravedades() {
    $sentencia = "SELECT id_gravedad, descripcion FROM gravedad_incidente";
    return select($sentencia);
}

// Función para registrar un nuevo incidente
function registrarIncidente($descripcion, $fk_id_colaborador, $fk_id_gravedad) {
    $sentencia = "INSERT INTO incidentes (descripcion_incidente, fk_id_colaborador, fk_id_gravedad) VALUES (?, ?, ?)";
    $resultado = insertar($sentencia, [$descripcion, $fk_id_colaborador, $fk_id_gravedad]);
    
    // Asegúrate de que la función `insertar` esté devolviendo el ID del último incidente
    return obtenerUltimoId(); // Obtener el ID del último incidente insertado
}

// Función para registrar la recuperación
function registrarRecuperacion($id_incidente, $fecha_inicio_rec, $fecha_final_rec) {
    // Verifica que el incidente exista
    $sentencia = "SELECT * FROM incidentes WHERE id_incidentes = ?";
    $resultado = select($sentencia, [$id_incidente]);

    if (empty($resultado)) {
        echo '<div class="alert alert-danger">El incidente no existe.</div>';
        return false; // Maneja el error
    }

    // Si el incidente existe, procede a la inserción
    $sentenciaInsert = "INSERT INTO recuperacion (fk_id_incidente, fecha_inicio_rec, fecha_final_rec) VALUES (?, ?, ?)";
    return insertar($sentenciaInsert, [$id_incidente, $fecha_inicio_rec, $fecha_final_rec]);
}

function obtenerUltimoId() {
    global $pdo; // Asumiendo que tienes una conexión PDO
    return $pdo->lastInsertId();
}

function obtenerResiduosPorTipo() {
    $sentencia = "SELECT tr.nombre, 
                         SUM(r.descresiduo) AS totalResiduos 
                  FROM residuos r
                  INNER JOIN tipo_residuos tr ON r.fk_idtiporesiduo = tr.id_tiporesiduo
                  GROUP BY tr.id_tiporesiduo
                  ORDER BY totalResiduos DESC";
    return select($sentencia);
}
function obtenerEstadoContenedores() {
    $sentencia = "SELECT ec.descestadocont, 
                         COUNT(c.id_contenedor) AS cantidadContenedores 
                  FROM estado_contenedores ec
                  LEFT JOIN contenedores c ON c.fk_idestadocontenedor = ec.id_estadocontenedor
                  GROUP BY ec.id_estadocontenedor
                  ORDER BY cantidadContenedores DESC";
    return select($sentencia);
}
function obtenerIncidentesPorGravedad() {
    $sentencia = "SELECT gi.descripcion, 
                         COUNT(i.id_incidentes) AS totalIncidentes 
                  FROM gravedad_incidente gi
                  LEFT JOIN incidentes i ON i.fk_id_gravedad = gi.id_gravedad
                  GROUP BY gi.id_gravedad
                  ORDER BY totalIncidentes DESC";
    return select($sentencia);
}
function obtenerAuditoria() {
    // Definir la consulta SQL para obtener los registros de auditoría
    $sentencia = "SELECT * from reg_estados";

    // Ejecutar la consulta y devolver los resultados
    return select($sentencia);
}
function asignarColaboradorAVehiculo($idColaborador, $idVehiculo) {
    $sentencia = "UPDATE vehiculos SET fk_id_colaborador = ? WHERE id_vehiculo = ?";
    $parametros = [$idColaborador, $idVehiculo];
    
    return insertar($sentencia, $parametros);
}
function obtenerColaboradores() {
    $sentencia = "SELECT id_colaborador, nombre FROM colaboradores c
join personas p on p.id_persona = c.fk_id_persona"; // Ajusta según tu tabla
    return select($sentencia);
}
function obtenerEquipos() {
    $sentencia = "SELECT e.id_equipo, e.nombre_equipo, e.descripcion, p.nombre AS planta 
                  FROM equipos e 
                  LEFT JOIN plantas p ON e.fk_id_planta = p.id_planta";
    return select($sentencia);
}