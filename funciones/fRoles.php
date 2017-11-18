<?php
require_once '../conexion/conexion.php';
require_once 'utils.php';
$uri = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
if (isset($uri)) {
    if (array_key_exists('acc', $uri)) {
        $acc = $uri['acc'];
        if ($acc == 1) { //Detecta si se va a crear un nuevo ingrediente
            $nombreIng = filter_input(INPUT_POST, 'nombreIng');
            $costoIng = filter_input(INPUT_POST, 'costoIng');
            $dispoIng = filter_input(INPUT_POST, 'dispIng');
            
            $resultado = registrarRol($nombreIng, $costoIng, $dispoIng);
            
            if ($resultado) {
                print "<script>alert(\"Ingrediente agregado\");window.location='../mantenimiento/crearIngredientes.php';</script>";
            } else {
                print "<script>alert(\"Ocurrió un Problema\");window.location='../mantenimiento/crearIngredientes.php';</script>";
            }
        } else if ($acc == 2) { //Detecta si se va a actualizar el ingrediente
            $iding = $uri['id_ing'];
            $nombreIng = filter_input(INPUT_POST, 'nombreIng');
            $costoIng = filter_input(INPUT_POST, 'costoIng');
            $dispoIng = filter_input(INPUT_POST, 'dispIng');
            $resultado = modificarRol($iding, $nombreIng, $costoIng, $dispoIng);
            
            if ($resultado) {
                print "<script>alert(\"Ingrediente Actualizado\");window.location='../mantenimiento/crearIngredientes.php';</script>";
            } else {
                print "<script>alert(\"Ocurrió un Problema\");window.location='../mantenimiento/crearIngredientes.php';</script>";
            }
        }
    }
}


function registrarRol($nombreIng, $costoIng, $dispoIng){
    $resultado = null;
    try{
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO ingredientes (ingrediente, costo, disponibilidad) values (?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($nombreIng,$costoIng,$dispoIng));
        Database::disconnect();
        $resultado = true;
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarIngrediente");
    }
    return $resultado;
}


function modificarRol($iding, $nombreIng, $costoIng, $dispoIng){
    $resultado = null;
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE ingredientes SET ingrediente=?, costo=?, disponibilidad=? WHERE id_ingrediente=?;";
    
        $q = $pdo->prepare($sql);
        $q->execute(array($iding,$nombreIng,$costoIng,$dispoIng));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "modificarIngrediente");
    }
    return $resultado;
}

function getRolPorId($param) {
    $resultado = null;
    try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from ingredientes WHERE id_ingrediente = " . $param;
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'ERROR: Comunicarse con el Administrador.';
        write_log($e, "getIngredientePorId");
    }
    return $resultado;
}

function getRoles() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM roles";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }
    return $resultado;
}
