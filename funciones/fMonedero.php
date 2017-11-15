<?php

include_once '../conexion/conexion.php';

function getTablaMonedero() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT * FROM monedero m, clientes c where m.id_clientes = c.id_clientes";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        echo "Error al ejecutar la sentencia: \n";
        write_log($e, 'getTablaMonedero');
    }
    return $resultado;
}

function getMonederoPorIdCliente($idCliente) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id_monedero, total_acumulado FROM monedero WHERE id_cliente = $idCliente";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = NULL;
        write_log($e, 'getMonederoPorIdCliente');
    }
    return $resultado;
}

function getPorcentajeAplicable() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT porcentaje FROM porcentaje_monedero WHERE activo = 1";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        $porcentaje = $resultado[0][0];
        Database::disconnect();
    } catch (PDOException $e) {
        $porcentaje = 0;
        write_log($e, 'getPorcentajeAplicable');
    }
    return $porcentaje;
}

function getAcumulable($totalOrden) {
    $porcentaje = getPorcentajeAplicable();

    $acumulabe = $totalOrden * ($porcentaje / 100);

    return $acumulabe;
}

function acumular($idCliente, $acumulable) {
    $monedero = getMonederoPorIdCliente($idCliente);
    $acumuladoMonedero = $monedero[0][1];
    if ($acumuladoMonedero == null) {
        crearNuevoMonedero($idCliente);
        $acumuladoMonedero = 0.00;
    }
    $nuevoAcumulado = number_format($acumuladoMonedero + $acumulable, 2);
    try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE monedero set total_acumulado=? WHERE id_cliente = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nuevoAcumulado, $idCliente));
        Database::disconnect();
        $resultado = $nuevoAcumulado;
    } catch (PDOException $e) {
        $resultado = -1;
        write_log($e, 'acumular');
    }
    return $resultado;
}

function redimir($idCliente, $descuento) {
    $monedero = getMonederoPorIdCliente($idCliente);
    $acumuladoMonedero = $monedero[0][1];
    
    $nuevoAcumulado =  number_format($acumuladoMonedero - $descuento, 2);
    try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "UPDATE monedero set total_acumulado=? WHERE id_cliente = ?";
        $q = $pdo->prepare($sql);
        $q->execute(array($nuevoAcumulado, $idCliente));
        Database::disconnect();
        $resultado = $nuevoAcumulado;
    } catch (PDOException $e) {
        $resultado = -1;
        write_log($e, 'redimir');
    }
    return $resultado;
}

/*
 * Función que registra los movimientos del monedero, los movimientos son de tipo BOOLEAN numérico:
 * 0 - Redimir
 * 1 - Acumular
 */

function registrarMovimientoMonedero($idOrden, $idMonedero, $cantidad, $movimiento, $fecha) {
    try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO detalle_monedero (id_orden, id_monedero, cantidad_mov, movimiento, fecha_movimiento) VALUES (?, ?, ?, ?, ?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($idOrden, $idMonedero, $cantidad, $movimiento, $fecha));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, 'registrarMovimientoMonedero');
    }
    //return $resultado;
}

function crearNuevoMonedero($idCliente) {
    try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO monedero (id_cliente, total_acumulado) VALUES (?, 0.00)";
        $q = $pdo->prepare($sql);
        $q->execute(array($idCliente));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, 'crearNuevoMonedero');
    }
    return $resultado;
}
/*
 * Función que recoge los datos del último movimiento de un monedero:
 * 0 - id de Orden
 * 1 - Cantidad Movida
 * 2 - Tipo de Movimiento siendo: 0-Redime, 1-Acumula
 * 3 - Fecha en que se realizo la transaccion
 */
function getUltimoMovimientoMonedero($idMonedero){
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id_orden, cantidad_mov, movimiento, fecha_movimiento FROM detalle_monedero "
            . "WHERE id_monedero = $idMonedero ORDER BY fecha_movimiento DESC LIMIT 1";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = "ERROR EN OBTENER ULTIMO MOVIMIENTO MONEDERO";
        write_log($e, 'ultimoMovimientoMonedero');
    }
    return $resultado;
}