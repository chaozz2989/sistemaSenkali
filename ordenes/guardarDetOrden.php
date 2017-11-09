<?php

session_start();

if (!isset($_SESSION['detalle']) || $_SESSION['detalle'] == null) {
    print "<script>alert(\"Debe agregar productos a la Orden.\");window.location='crearOrden.php';</script>";
} else {
    require_once '../funciones/fOrdenes.php';
    include_once '../conexion/conexion.php';

    /* Formateo de Fechas
      $variable = $_POST['fecha'];
      $partes = array();
      $partes = explode("/", $variable);
      $arreglo = array($partes[2], $partes[0], $partes[1]);
      $nueva_fecha = implode("-", $arreglo);
      $mesa = $_POST['mesa'];
      $emp = $_POST['emp'];
      $torden = $_POST['torden'];
      $estadoOrd = $_POST['estadoOrd'];
      $cliente = $_POST['esCliente']; */

//************NUEVA CAPTURA DE VARIABLES
    $mesa = filter_input(INPUT_POST, 'lst_mesa');
    $empleado = filter_input(INPUT_POST, 'lst_emp');
    $tipoOrden = filter_input(INPUT_POST, 'lst_tipoOrd');
    $estadoOrden = filter_input(INPUT_POST, 'lst_estOrd');
    $fecha = filter_input(INPUT_POST, 'date_fechaOrd');
    $hora = filter_input(INPUT_POST, 'time_horaOrd');
    $esCliente = filter_input(INPUT_POST, 'chk_esCliente');
    $idCliente = filter_input(INPUT_POST, 'lst_cliente');
    $totalGlobal = filter_input(INPUT_POST, 'totalGlobal');

    $fechaHora = date_format(date_create($fecha . ' ' . $hora), 'Y-m-d H:i:s'); //Fecha formateada MySQL
    /* Se va a crear una página donde agregar mas productos a una Orden, este va a ser el filtro para determinar si una Orden se registra
     * por primera vez o si se van a agregar productos a una Orden ya Existente
     */
    $idOrden = filter_input(INPUT_POST, 'idOrden');

    if (!isset($esCliente) || $esCliente == null) {
        $idCliente = 0;
        $esCliente = FALSE;
    }

    if (!isset($idOrden)) {
        $codigoOrden = registrarOrdenCompleta($mesa, $empleado, $tipoOrden, $fechaHora, $totalGlobal, $esCliente, $idCliente);
        print "<script>alert(\"ORDEN REGISTRADA CON CODIGO: " . $codigoOrden . "\");window.location='crearOrden.php';</script>";
    } else {
        
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