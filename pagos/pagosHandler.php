<?php

date_default_timezone_set('America/El_Salvador');
//includes necesarios
include_once '../funciones/utils.php';
include_once '../funciones/fOrdenes.php';
include_once '../funciones/fPagos.php';
include_once '../funciones/fMonedero.php';

//captura de variables
$idOrdenAPagar = filter_input(INPUT_POST, 'idOrdenAPagar');
$totalAPagar = filter_input(INPUT_POST, 'totalAPagar');
$importe = filter_input(INPUT_POST, 'importe');
$descuento = filter_input(INPUT_POST, 'descuento');
$acumulable = filter_input(INPUT_POST, 'acumulable');
$idCliente = filter_input(INPUT_POST, 'esCliente'); // Esta es una variable que llama el ID del cliente, de no se cliente la variable se setea con CERO.
//$idTotalAPagar = filter_input(INPUT_POST, 'ordenAPagar');
//print "<script>alert('acumulable = " . $acumulable . " : descuento = " . $descuento . "');</script>";

if (isset($idCliente)) {
    $mensaje = 'Pago realizado con éxito!';
    $idPago = registrarPagoVO($idOrdenAPagar, $importe, $idCliente, $descuento);
    if ($idPago == 0) {
        $mensaje = 'Ocurrio un error al realizar el Pago.';
    } else {
        if ($acumulable != 0) {
            $nuevoSaldo = registrarAcumulacion($idCliente, $acumulable);
            $monedero = getMonederoPorIdCliente($idCliente);
            $idMonedero = $monedero[0][0];
            $movimiento = registrarMovimientoMonedero($idOrdenAPagar, $idMonedero, $acumulable, 1, date('Y-m-d H:i:s'));
            $mensaje = $mensaje . '; Nuevo Saldo de Monedero: $' . $nuevoSaldo;
        } elseif (isset($descuento) && $descuento != 0) {
            $nuevoSaldo = registrarRedencion($idCliente, $descuento);
            $monedero = getMonederoPorIdCliente($idCliente);
            $idMonedero = $monedero[0][0];
            $registrarDescuento = registrarDescuento($idPago, $descuento);
            $movimiento = registrarMovimientoMonedero($idOrdenAPagar, $idMonedero, $descuento, 0, date('Y-m-d H:i:s'));
            $mensaje = $mensaje . '; Nuevo Saldo de Monedero: $' . $nuevoSaldo;
        }
    }
    $variablesURL = encode_this('idOrden=' . $idOrdenAPagar . '&idPago=' . $idPago);
    print "<script>alert('" . $mensaje . "');window.location='recibo.php?" . $variablesURL . "';</script>";
}

function registrarPagoVO($idOrden, $importe, $idCliente, $descuento) {
    if ($idCliente != 0) {
        if (isset($descuento)) {
            $idPago = registrarPagoDO($idOrden, $importe, 1);
        } else {
            $idPago = registrarPagoDO($idOrden, $importe, 0);
        }
    } else {
        $idPago = registrarPagoDO($idOrden, $importe, 0);
    }
    if ($idPago != 0) {
        updateEstadoOrden($idOrden, 3);
    }
    return $idPago;
}

function registrarAcumulacion($idCliente, $acumulable) {
    $nuevoSaldo = acumular($idCliente, $acumulable);
    return $nuevoSaldo;
}

function registrarRedencion($idCliente, $descuento) {
    $nuevoSaldo = redimir($idCliente, $descuento);
    return $nuevoSaldo;
}
