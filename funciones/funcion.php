<?php 
require_once '../conexion/conexion.php';

function comboEstadoReserva(){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM estado_reservas";
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

function getEstadoReserva() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id_estadoRes, estado_reserva from estado_reservas";
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

function comboEmpleado(){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM empleados";
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

function comboCliente(){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM clientes";
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

function comboTipoEvento(){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM tipo_evento";
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

function getTablaReserva() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select r.id_reservas, r.codigo_reserva, r.descripcion, r.fecha, e.estado_reserva from reservas r INNER JOIN estado_reservas e ON e.id_estadoRes = r.id_estadoRes";
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

function getReservaPorId($param) {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from reservas where id_reservas = $param";
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

function actualizarReserva($descripcion, $codReserva, $idReserva, $idEstadoRes) {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE reservas SET descripcion=:desc,codigo_reserva=:codRes, id_estadoRes=:idEstadoRes  WHERE  id_reservas=:idReserva";
    try {
        $q = $pdo->prepare($sql);
        $q->bindParam(':desc', $des = $descripcion, PDO::PARAM_STR);
        $q->bindParam(':codRes', $codReserva, PDO::PARAM_STR);
        $q->bindParam(':idEstadoRes', $idEstadoRes, PDO::PARAM_INT);
        $q->bindParam(':idReserva', $descripcion, PDO::PARAM_INT);
        $q->execute();
        Database::disconnect();
        print "<script>alert(\"Actualizado exitosamente.\");window.location='../empleado/reserva.php';</script>";
    } catch (PDOException $e) {
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
        print "<script>alert(\"No se pudo actualizar.\");window.location='../empleado/reserva.php';</script>";
    }
}

//FUNCION DE CATEGORIAS Y SUBCATEGORIAS




function getMesas() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM mesas";
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

function getEmpleados() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM empleados";
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

function getTiposOrden() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM tipos_orden";
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

function getEstadosOrden() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM estados_orden";
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

function getOrdenes(){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM ordenes";
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

 function comboEstadoUsuario(){
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM estados_usuario";
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

?>