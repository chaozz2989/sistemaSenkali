<?php
if (!session_status() == PHP_SESSION_ACTIVE) {
    session_start();
}

include_once '../conexion/conexion.php';
include_once 'utils.php';
$uri = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
function registrarProductoCompleto($subCategoria, $nombreProd, $precioProd, $especial) {
    $lastId = 0;
    $resultado = TRUE;
    try{
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO productos (id_subCat, nombre_prod, precio_prod, especialidad, estado) values (?,?,?,?, 1)";
        $q = $pdo->prepare($sql);
        $q->execute(array($subCategoria, $nombreProd, $precioProd, $especial));
        Database::disconnect();
        $lastId = $pdo->lastInsertId();;
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarProductoCompleto");
    }
    
    if ($lastId != 0 && $resultado) {
         $resultado = registrarDetalleEspecialidad($lastId);
         if ($resultado){
             $mensaje = "Producto CREADO";
         } else {
             $mensaje = "Producto CREADO; Revisar el Log.";
         }
    } else {
        $mensaje = "Ocurrio un problema.";
    }
   
    return $mensaje;
 /*else if ($acc == 2) { //Detecta si se va a actualizar un producto
            //$aux = decode_get2(INPUT_SERVER, 'REQUEST_URI');
            $idProd = $uri['idProd'];
            $nombreProd = filter_input(INPUT_POST, 'nombreProd');
            $precioProd = filter_input(INPUT_POST, 'precioProd');
            $subCategoria = filter_input(INPUT_POST, 'subcatProd');
            $especial = filter_input(INPUT_POST, 'prodEspecial');
            if (!isset($especial)) {
                $especial = 0;
            }
            $resultado = modificarProducto($idProd, $subCategoria, $nombreProd, $precioProd, $especial);
            if ($resultado) {
                print "<script>alert(\"Producto ACTUALIZADO\");window.location='../productos/crearProducto.php';</script>";
            } else {
                print "<script>alert(\"Producto NO ACTUALIZADO\");window.location='../productos/crearProducto.php';</script>";
            }
            //header("Location: ../productos/crearProducto.php");
        }*/
    //}
}

function getListadoProductos(){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM productos";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = "Ocurrio un error.";
        write_log($e, "getListadoProductos");
    }
    return $resultado;
}

function getListadoProductoPorTipos($tipoProducto){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM productos WHERE id_subCat = " . $tipoProducto;
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = "Ocurrio un error.";
        write_log($e, "getListadoProductoPorTipos");
    }
    return $resultado;
}
/*
function registrarProducto($idSubcat, $nombreProd, $precioProd, $especial){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO productos (id_subCat, nombre_prod, precio_prod, especialidad, estado) values (?,?,?,?, 1)";
    try{
        $q = $pdo->prepare($sql);
        $q->execute(array($idSubcat,$nombreProd,$precioProd,$especial));
        Database::disconnect();
        $resultado = $pdo->lastInsertId();;
    } catch (PDOException $e) {
        $resultado = 0;
        write_log($e, "registrarProducto");
    }
    
    return $resultado;
}*/

function registrarDetalleEspecialidad($idProd) {//SECUENCIA PARA INGRESAR EL DETALLE DE LA ORDEN A LA BASE DE DATOS; DEVUELVE UN BOOLEAN
    $resultado = true;
    $datos = $_SESSION['especialidad'];
    try {
        $pdo = Database::connect();
        for ($i = 0; $i < count($datos); $i++) {
            $idIng = $datos[$i]['id'];
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO detalle_prod_ingred (id_ingrediente, id_producto) values (?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($idIng, $idProd));
        }
        $_SESSION["especialidad"] = null; // Despues de guardar todo el detalle, se vaciará por completo el carrito
        Database::disconnect();
    } catch (Exception $ex) {
        $resultado = false;
        write_log($ex, "registrarDetalleEspecialidad");
    }
    return $resultado;
}


function getTablaProductos() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select p.id_productos, p.nombre_prod, c.nombre as Cate, sc.nombre as subCate, p.precio_prod, p.especialidad from productos p "
            . "INNER JOIN subcategorias sc ON sc.id_subcategoria = p.id_subCat "
            . "INNER JOIN categorias c ON sc.id_categoria = c.id_categoria ORDER BY p.nombre_prod ASC";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'ERROR: Comunicarse con el Administrador.';
        write_log($e, "getTablaProductos");
    }
    return $resultado;
    
}

function getProductoPorId($param) {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select p.id_productos, p.id_subCat, p.nombre_prod, c.id_categoria, c.nombre as Cate, sc.nombre as subCate, p.precio_prod, p.especialidad from productos p "
            . "INNER JOIN subcategorias sc ON sc.id_subcategoria = p.id_subCat "
            . "INNER JOIN categorias c ON sc.id_categoria = c.id_categoria "
            . "WHERE p.id_productos = " . $param;
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'ERROR: Comunicarse con el Administrador.';
        write_log($e, "getProductoPorId");
    }
    return $resultado;
}

function modificarProducto($idProd, $idSubcat, $nombreProd, $precioProd, $especial){
    $resultado = null;
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE productos SET id_subCat=?, nombre_prod=?, precio_prod=?, especialidad=? WHERE id_productos=?;";
    
        $q = $pdo->prepare($sql);
        $q->execute(array($idSubcat, $nombreProd, $precioProd, $especial, $idProd));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "modificarProducto");
    }
    return $resultado;
}

function getHtmlProductos(){
    $lista = getTablaProductos();
    $html = '';
    foreach ($lista as $contenido => $row){
        $html .= '<tr>';
        $html .= '<td>' . $row['nombre_prod'] . '</td>' ;
        $html .= '<td>' . $row['Cate'] . '</td>' ;
        $html .= '<td>' . $row['subCate'] . '</td>' ;
        $html .= '<td>' . $row['precio_prod'] . '</td>' ;
        if ($row['especialidad']==1){
            $html .= '<td> SI </td>' ;
        } else {
            $html .= '<td> NO </td>' ;
        }
        $html .= '<td> <a href="../productos/editProducto.php?' . encode_this('idProd=' . $row["id_productos"]) . '" class="btn btn-info")">Editar</a></td>';
        $html .= '</tr>';
    }
    return $html;
}

