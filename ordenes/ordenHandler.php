<?php

session_start();
/* if (!isset($_SESSION['idUsuario'])) {
  echo "<script type='text/javascript'>"
  . "window.location = '../login.php';"
  . "</script>";
  } */
include_once "../funciones/fOrdenes.php";
include_once  '../conexion/conexion.php';
include_once '../funciones/utils.php';

$codigoProducto = filter_input(INPUT_POST, 'producto');
$cantidad = filter_input(INPUT_POST, 'cantidad');
$estado = 1;//filter_input(INPUT_POST, 'estado');    *********El estado ya no se manda a llamar porque al agregar productos siempre estarán pendientes.
$vaciado = filter_input(INPUT_POST, 'vac');
$idDetalleAtendido = filter_input(INPUT_POST, 'estadoDetalleAtendido'); // Se utiliza para cambiar el estado del producto a ATENDIDO
$idDetalleCancelado = filter_input(INPUT_POST, 'estadoDetalleCancelado'); // Se utiliza para cambiar el estado del producto a CANCELADO

$idOrden = filter_input(INPUT_POST, 'idOrden');  //Se utiliza para cambiar el estado del producto a ATENDIDO

if (isset($vaciado)) {
    if ($vaciado == 1) {
        $_SESSION["detalle"] = null;
    }
}

if (isset($_REQUEST['uns'])) {
    //Codigo para eliminar articulos del detalle de compra
    $idArr = $_REQUEST['uns'];
    $arreglo = $_SESSION["detalle"];
    unset($arreglo[$idArr]);
    $_SESSION["detalle"] = array_values($arreglo);
    //print "<script>window.location='crearOrden.php';</script>";
}

if (isset($idDetalleAtendido)){ //esta funcion cambia el estado del producto cuando ya ha sido atendido
    $cambioEstado = updateEstadoProducto($idDetalleAtendido, 2);
    $cambiarEstado = checkEstadoDetalleOrden($idOrden);
    if (!$cambiarEstado){
        echo getHtmlDetalleOrden($idOrden);
        exit();
    } else {
        echo getHtmlDetalleOrden($idOrden);
        print "<script>$('#encabezadoOrden' ).load(window.location.href + ' #encabezadoOrden' ); $('#divRecibo' ).load(window.location.href + ' #divRecibo' ); </script>";
        
        exit();
    }
}

if (isset($idDetalleCancelado)){ //esta funcion cambia el estado del producto cuando este se cancela (osea que ya no lo quieren pues)
    $cambioEstado = updateEstadoProducto($idDetalleCancelado, 4); //Cambia el estado del producto a CANCELADA
    $cambiarEstado = checkEstadoDetalleOrden($idOrden); //Verifica si debe cambiar el estado a la ORDEN
    $descuento  = updateTotalOrden($idOrden);
    if (!$cambiarEstado){
        echo getHtmlDetalleOrden($idOrden);
        print "<script>$('#div_TotalPago' ).load(window.location.href + ' #div_TotalPago' );</script>";
        exit();
    } else {
        echo getHtmlDetalleOrden($idOrden);
        print "<script>$('#encabezadoOrden' ).load(window.location.href + ' #encabezadoOrden' ); $('#div_TotalPago' ).load(window.location.href + ' #div_TotalPago' ); $('#divRecibo' ).load(window.location.href + ' #divRecibo' ); </script>";
        exit();
    }
}


if (isset($_SESSION["detalle"])) { //Manejo del carrito de productos de la orden, este se utiliza cuando ya existe algo en el carrito
    if (isset($codigoProducto)) {
        $arreglo = $_SESSION["detalle"];
        $encontro = false;
        $numero = 0;
        for ($i = 0; $i < count($arreglo); $i++) {
            if ($arreglo[$i]['id'] == $codigoProducto) {
                $encontro = true;
                $numero = $i;
            }
        }
        if ($encontro == true) {
            $arreglo[$numero]['cantidad'] = $arreglo[$numero]['cantidad'] + $cantidad;
            $_SESSION["detalle"] = $arreglo;
        } else {
            /*$nombreProducto = "";
            $precioProducto = 0;*/
            try {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT id_productos, nombre_prod, precio_prod from productos WHERE id_productos = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($codigoProducto));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                Database::disconnect();

                $nombreProducto = $data['nombre_prod'];
                $precioProducto = $data['precio_prod'];

                $datosNuevos = ['id' => $codigoProducto,
                    'producto' => $nombreProducto,
                    'precio' => $precioProducto,
                    'cantidad' => $cantidad,
                    'estado' => $estado,
                ];

                array_push($arreglo, $datosNuevos);
                $_SESSION["detalle"] = $arreglo;
            } catch (Exception $ex) {
                echo $ex;
                write_log($ex, "registrarProducto");
            }
        }
    }
} else { //Si el carrito está vacío, lo empieza a llenar
    if (isset($codigoProducto)) {
        try {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT id_productos, nombre_prod, precio_prod from productos WHERE id_productos = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($codigoProducto));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

            $nombreProducto = $data['nombre_prod'];
            $precioProducto = $data['precio_prod'];

            $arreglo[] = [
                "id" => $codigoProducto,
                "producto" => $nombreProducto,
                "precio" => $precioProducto,
                "cantidad" => $cantidad,
                "estado" => $estado,
            ];

            $_SESSION["detalle"] = $arreglo;
        } catch (Exception $ex) {
            echo $ex;
            write_log($ex, "registrarProducto");
        }
    }
}


if (isset($_SESSION["detalle"])) {
//    $condicion = "";
//    $html = "";
    $datos = $_SESSION["detalle"];
    $totalGlobal = 0;
    for ($i = 0; $i < count($datos); $i++) {
        echo '<tr>';
        echo '<td>' . $datos[$i]['producto'] . '</td>';
        echo '<td>' . $datos[$i]['cantidad'] . '</td>';
        echo '<td>' . $datos[$i]['precio'] . '</td>';
        echo '<td>' . $datos[$i]['cantidad'] * $datos[$i]['precio'] . '</td>';
        echo '<td>';
        echo '<a class="btn btn-danger" onclick="unsetProd(' . $i . ')">Quitar</a>';
        echo '</td>';
        echo '</tr>';
        $totalGlobal += ($datos[$i]['cantidad'] * $datos[$i]['precio']);
    }
    echo "<tr><td colspan=5><h2>TOTAL: $" . $totalGlobal . "</h2><input type='hidden' id='totalPre' name='totalPre' value='" . $totalGlobal . "'></td></tr>";
} else {
    echo "<tr><td colspan=5>No hay productos agregados.</td></tr>";
}


?>
