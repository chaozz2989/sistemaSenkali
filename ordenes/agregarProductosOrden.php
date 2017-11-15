<?php

session_start();

if (!isset($_SESSION['detalle']) || $_SESSION['detalle'] == null) {
    print "<script>alert(\"Debe agregar productos a la Orden.\");window.location='crearOrden.php';</script>";
} else {
    require_once '../funciones/fOrdenes.php';
    include_once '../conexion/conexion.php';
    include_once '../funciones/utils.php';

    $idOrden = filter_input(INPUT_POST, 'idOrden');
    $idOrdenEncyp = encode_this("idOr=" . $idOrden);
    if (isset($idOrden)) {
        $resultadoIngreso = registrarDetalleOrden($idOrden);
        if ($resultadoIngreso){
            updateTotalOrden($idOrden);
            $_SESSION['detalle'] = null;
        }
       print "<script>alert(\"Productos agregados a la Orden!\");window.location='edicionOrden.php?$idOrdenEncyp';</script>";
    } else {
       print "<script>alert(\"Ocurrio un problema al agregar los productos!\");window.location='edicionOrden.php?". $idOrdenEncyp ."';</script>";
    }
}









/*


$lastId = 0;
//detalle de la orden
$resultado = null;
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sql = "INSERT INTO ordenes (id_mesa,id_empleado,id_tipoOrden,id_estadoOrden,es_cliente,fecha) values (?,?,?,?,?,?)";
try {
    $q = $pdo->prepare($sql);
    $q->execute(array($mesa, $emp, $torden, $estadoOrd, $cliente, $nueva_fecha));
    Database::disconnect();
    $lastId = $pdo->lastInsertId();
    $resultado = true;
} catch (PDOException $e) {
    $resultado = false;
    write_log($e, "registrarProducto");
}

if ($lastId != 0) {
    if (isset($_SESSION['detalle'])) {
        $datos = $_SESSION['detalle'];
        //SECUENCIA PARA INGRESAR LAS COMPRAS A LA BASE DE DATOS
        try {
            $pdo = Database::connect();
            for ($i = 0; $i < count($datos); $i++) {
                $idPro = $datos[$i]['id'];
                $estDet = $datos[$i]['estado'];
                $cant = $datos[$i]['cantidad'];
                $subt = $datos[$i]['cantidad'] * $datos[$i]['precio'];
                

                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "INSERT INTO detalles_orden (id_orden,id_producto,id_estado_detalleOrd,cantidad_prod,subtotal_orden) values (?,?,?,?,?)";
                $q = $pdo->prepare($sql);
                $q->execute(array($lastId, $idPro, $estDet, $cant, $subt));
            }
            $resultado = true;
        } catch (Exception $ex) {
            $resultado = false;
            write_log($ex, "registrarProducto");
        }
    }
}

if ($resultado){
    print "<script>alert(\"ORDEN REGISTRADA.\");window.location='../ordenes/crearOrden.php';</script>";
} else {
    print "<script>alert(\"OCURRIO UN PROBLEMA.\");window.location='../ordenes/crearOrden.php';</script>";
}


//$obj = new Funcion();


/*

if (count($_SESSION['detalle']) > 0) {

$id = 0;


    try {

        $sql = "INSERT INTO ordenes (id_ordenes,id_mesa,id_empleado,id_tipoOrden,id_estadoOrden,es_cliente,fecha) values (null,$mesa,$emp,$torden,$estadoOrd,$cliente,'$nueva_fecha')";
        $conn = $obj->conectaBaseDatos();
        $statements = $conn->prepare($sql);
        $statements->execute();

        $statments = $conn->prepare("SELECT @@identity AS id");
        $statments->execute();
        $resultado = $statments->fetchAll();
        
        foreach ($resultado as $row) {
            $id = $row["id"];
        }

       $_SESSION['detOrdenId']=$id;

        foreach ($_SESSION['detalle'] as $k => $detalle) {
            $idPro = $detalle['id'];
            echo $detalle['producto'];
            $cant = $detalle['cantidad'];
            $detalle['precio'];
            $subt = $detalle['cantidad']*$detalle['precio'];
            //$subt = $detalle['subtotal'];
            $estDet = $detalle['estado'];

            $sql2 = "INSERT INTO detalles_orden (id_orden,id_producto,id_estado_detalleOrd,cantidad_prod,subtotal_orden) "
                    . "values ($id,$idPro,$estDet,$cant,$subt)";

            $conns = $obj->conectaBaseDatos();
            $state = $conns->prepare($sql2);
            $state->execute();
            
            
            
          
        }

        print "<script>alert(\"Agregado exitosamente.\");window.location='../ordenes/impresionDetOrden.php';</script>";
    } catch (Exception $ex) {

        echo "Failed: " . $e->getMessage();
    }
} else {
    print "<script>alert(\"ingrese el detalle.\");window.location='../ordenes/crearOrden.php';</script>";
}


*/