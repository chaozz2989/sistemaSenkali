<?php
require_once '../conexion/conexion.php';
require_once 'utils.php';
$uri = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
if (isset($uri)) {
    if (array_key_exists('acc', $uri)) {
        $acc = $uri['acc'];
        if ($acc == 1) { //Detecta si se va a crear la Categoría
            $nombreCat = filter_input(INPUT_POST, 'nombreCat');
            
            $resultado = registrarCategoria($nombreCat);
            
            if ($resultado) {
                print "<script>alert(\"Categoría Creada\");window.location='../mantenimiento/crearCategoria.php';</script>";
            } else {
                print "<script>alert(\"Ocurrió un Problema\");window.location='../mantenimiento/crearCategoria.php';</script>";
            }
        } else if ($acc == 2) { //Detecta si se va a actualizar una Categoría
            $idCat = $uri['idCat'];
            $nombreCat = filter_input(INPUT_POST, 'nombreCat');
            $chkActiva = filter_input(INPUT_POST, 'chkActiva');
            $resultado = modificarCategoria($idCat, $nombreCat, $chkActiva);
            if ($resultado) {
                print "<script>alert(\"Categoría Actualizada\");window.location='../mantenimiento/crearCategoria.php';</script>";
            } else {
                print "<script>alert(\"Ocurrió un Problema\");window.location='../mantenimiento/crearCategoria.php';</script>";
            }
        }
    }
}


function registrarCategoria($nombreCategoria){
    try{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO categorias (nombre, estado) values (?, 1)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nombreCategoria));
        Database::disconnect();
        $resultado = true;
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarCategoria");
    }
    return $resultado;
}


function modificarCategoria($idCategoria, $nombreCategoria, $chkActiva){
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE categorias SET nombre=?, estado=? WHERE id_categoria=?;";
        $q = $pdo->prepare($sql);
        $q->execute(array($nombreCategoria, $chkActiva, $idCategoria));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "modificarCategoria");
    }
    return $resultado;
}

function getCategoriaPorId($param) {
    $resultado = null;
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from categorias WHERE id_categoria = " . $param . " AND estado=1";
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'ERROR: Comunicarse con el Administrador.';
        write_log($e, "getCategoriaPorId");
    }
    return $resultado;
}

function getCategorias() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM categorias WHERE estado=1";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "getCategorias");
    }
    return $resultado;
}

/*
function getSubCategorias() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM subcategorias WHERE estado=1";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "getSubcategorias");
    }
    return $resultado;
}
*/

function getFullCategorias() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM categorias";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "getFullCategorias");
    }
    return $resultado;
}

function getFullCategoriaPorId($param) {
    $resultado = null;
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from categorias WHERE id_categoria = " . $param;
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'ERROR: Comunicarse con el Administrador.';
        write_log($e, "getFullCategoriaPorId");
    }
    return $resultado;
}