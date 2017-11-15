<?php

include_once '../conexion/conexion.php';

function getHtmlDetalleAPagar($idOrden) {
    include_once '../funciones/fOrdenes.php';
    $detalle = getDetalleOrdenPorId($idOrden);
    $html = '';
    foreach ($detalle as $registro => $row) {
        $html .= '<tr>';
        if ($row['estado'] == "Cancelada") {
            $html .= '<td><del>' . $row['nombre_prod'] . '</del></td>';
        } else {
            $html .= '<td>' . $row['nombre_prod'] . '</td>';
        }
        
        if ($row['estado'] == "Cancelada") {
            $html .= '<td><del>' . $row['cantidad_prod'] . '</del></td>';
        } else {
            $html .= '<td>' . $row['cantidad_prod'] . '</td>';
        }
        
        
        if ($row['estado'] == "Cancelada") {
            $html .= '<td><del>' . $row['subtotal_orden'] . '</del></td>';
        } else {
            $html .= '<td>' . $row['subtotal_orden'] . '</td>';
        }
        $html .= '</tr>';
    }
    return $html;
}

/*
 * Funcion que registra los pagos, independientemente si es cliente o no.
 * 0 - No hay Descuento
 * 1 - Si hay Descuento
 */
function registrarPagoDO($idOrden, $importe, $hayDescuento) {
    try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO comprobante_pago (id_orden, pago_recibido, esDescuento) VALUES (?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($idOrden, $importe, $hayDescuento));
        Database::disconnect();
        $lastId = $pdo->lastInsertId();
    } catch (PDOException $e) {
        $lastId = 0;
        write_log($e, 'registrarPago');
    }
    return $lastId;
}

function registrarDescuento($idComprobante, $descuento) {
     try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO detalle_descuento (id_comprobante, descuento_realizado) VALUES (?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($idComprobante, $descuento));
        Database::disconnect();
        $resultado = TRUE;
        
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, 'registrarDescuento');
    }
    return $resultado;
}

/*
 * Funcion que manda a llamar el detalle del comprobante de pago.
 * 0 - pago_recibido, es decir, cuanto nos dieron para pagar
 * 1 - esDescuento, 0 si no es descuento y 1 si SI es descuento
 * 2 - descuento_realizado, si hay descuento, este se ve reflejado aqui.
 */

function getInfoPagoPorId($idPago){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT cp.pago_recibido, cp.esDescuento, dd.descuento_realizado FROM comprobante_pago cp "
            . "LEFT JOIN detalle_descuento dd ON dd.id_comprobante = cp.id_comprobante "
            . "WHERE cp.id_comprobante = $idPago";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = "ERROR EN OBTENER EL PAGO POR ID";
        write_log($e, 'getInfoPagoPorId');
    }
    return $resultado;
}

function getTotalConDescuento($idOrden, $idPago){
    $infoOrden = getInfoOrdenesPorId($idOrden);
    $infoPago = getInfoPagoPorId($idPago);
    
    $totalMasDescuento = $infoOrden[0][5];
    if ($infoPago[0][1] == 1){
        $totalMasDescuento = $totalMasDescuento - $infoPago[0][2];
    }
    
    return $totalMasDescuento;
}