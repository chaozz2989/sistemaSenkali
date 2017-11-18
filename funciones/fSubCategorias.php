<?php
require_once '../conexion/conexion.php';
require_once 'utils.php';
$uri = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
if (isset($uri)) {
    if (array_key_exists('acc', $uri)) {
        $acc = $uri['acc'];
        if ($acc == 1) { //Detecta si se va a crear la Categoría
            $nombreSubCat = filter_input(INPUT_POST, 'nombreSubCat');
            $idCatMadre = filter_input(INPUT_POST, 'catProd');
            $estado = filter_input(INPUT_POST, 'rbActiva');
            $resultado = registrarSubCategoria($nombreSubCat, $idCatMadre, $estado);
            
            if ($resultado) {
                print "<script>alert(\"SubCategoría Creada\");window.location='../mantenimiento/crearSubCat.php';</script>";
            } else {
                print "<script>alert(\"Ocurrió un Problema\");window.location='../mantenimiento/crearSubCat.php';</script>";
            }
        } else if ($acc == 2) { //Detecta si se va a actualizar una Categoría
            $idSubCat = $uri['idSubCat'];
            $nombreCat = filter_input(INPUT_POST, 'nombreSubCat');
            $idCat = filter_input(INPUT_POST, 'catProd');
            $estado = filter_input(INPUT_POST, 'rbActiva');
            $resultado = modificarSubCategoria($idCat, $nombreCat, $estado, $idSubCat);
            if ($resultado) {
                print "<script>alert(\"Categoría Actualizada\");window.location='../mantenimiento/crearSubCat.php';</script>";
            } else {
                print "<script>alert(\"Ocurrió un Problema\");window.location='../mantenimiento/crearSubCat.php';</script>";
            }
        }
    }
}


function registrarSubCategoria($nombreSubCat, $idCatMadre, $estado){
    try{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO subcategorias (id_categoria, nombre, estado) values (?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($idCatMadre, $nombreSubCat, $estado));
        Database::disconnect();
        $resultado = true;
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarSubCategoria");
    }
    return $resultado;
}


function modificarSubCategoria($idCatMadre, $nombreSubCat, $estado, $idSubCat){
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE subcategorias SET id_categoria=?, nombre=?, estado=? WHERE id_subcategoria=?;";
        $q = $pdo->prepare($sql);
        $q->execute(array($idCatMadre, $nombreSubCat, $estado, $idSubCat));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "modificarSubCategoria");
    }
    return $resultado;
}

function getSubCatPorIdCat($param) {
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from subcategorias where id_categoria = $param AND estado=1";
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'ERROR: Comunicarse con el Administrador.';
        write_log($e, "getSubCatPorIdCat");
    }
    return $resultado;
}

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
        write_log($e, "getSubCategorias");
    }
    return $resultado;
}

function getFullSubCategorias() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM subcategorias";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "getFullSubCategorias");
    }
    return $resultado;
}

/*
 * 0 - Id Subcategoria
 * 1 - Id Categoria
 * 2 - Nombre de Subcategoria
 * 3 - estado
 */
function getFullSubCatPorId($param) {
    $resultado = null;
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from subcategorias WHERE id_subcategoria = " . $param;
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'ERROR: Comunicarse con el Administrador.';
        write_log($e, "getFullSubCatPorId");
    }
    return $resultado;
}

function getListaCompletaSubCat(){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT sc.id_subcategoria, c.nombre as nombreCat, sc.nombre, sc.estado FROM subcategorias sc "
            . "INNER JOIN categorias c ON c.id_categoria = sc.id_categoria";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "getListaCompletaSubCat");
    }
    return $resultado;
}