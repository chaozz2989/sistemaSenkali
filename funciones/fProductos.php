<?php
require_once '../conexion/conexion.php';
require_once 'utils.php';
$uri = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
if (isset($uri)) {
    if (array_key_exists('acc', $uri)) {
        $acc = $uri['acc'];
        if ($acc == 1) { //Detecta si se va a crear el producto
            $nombreProd = filter_input(INPUT_POST, 'nombreProd');
            $precioProd = filter_input(INPUT_POST, 'precioProd');
            $subCategoria = filter_input(INPUT_POST, 'subcatProd');
            $especial = filter_input(INPUT_POST, 'prodEspecial');

            if (!isset($especial)) {
                $especial = 0;
            }

            $resultado = registrarProducto($subCategoria, $nombreProd, $precioProd, $especial);
            
            if ($resultado) {
                print "<script>alert(\"Producto CREADO\");window.location='../productos/crearProducto.php';</script>";
            } else {
                print "<script>alert(\"Producto NO CREADO\");window.location='../productos/crearProducto.php';</script>";
            }

            //echo "<script>alert(".$mensaje.");</script>";//window.location='../productos/crearProducto.php';
            //header("Location: ../productos/crearProducto.php?add=".$resultado);
            //$add = encode_this('add=' . $resultado);
            //header("Location: ../productos/crearProducto.php?" . $add);
        } else if ($acc == 2) { //Detecta si se va a actualizar un producto
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
            //$mod = encode_this('mod=' . $resultado);
            if ($resultado) {
                print "<script>alert(\"Producto ACTUALIZADO\");window.location='../productos/crearProducto.php';</script>";
            } else {
                print "<script>alert(\"Producto NO ACTUALIZADO\");window.location='../productos/crearProducto.php';</script>";
            }
            //header("Location: ../productos/crearProducto.php");
        }
    }
}

//$acc=filter_input(INPUT_GET, "acc");


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
    $sql = "SELECT * FROM productos WHERE id_subCat =: tipoProducto";
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

function registrarProducto($idSubcat, $nombreProd, $precioProd, $especial){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO productos (id_subCat, nombre_prod, precio_prod, especialidad) values (?,?,?,?)";
    try{
        $q = $pdo->prepare($sql);
        $q->execute(array($idSubcat,$nombreProd,$precioProd,$especial));
        Database::disconnect();
        $resultado = true;
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarProducto");
    }
    
    return $resultado;
}

function getTablaProductos() {
    $resultado = null;
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





