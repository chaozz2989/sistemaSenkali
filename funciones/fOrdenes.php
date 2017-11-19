<?php

if (!session_status() == PHP_SESSION_ACTIVE) {
    session_start();
}

include_once '../conexion/conexion.php';

/* Se registra el detalle de toda la Orden cuando es primera vez, de lo contrario solo se registrarán los agregados a la Orden
 * En este código se registra #1 la Orden, #2 el detalle de la Orden, #3 el código de Orden, #4 si es cliente se registra el número de cliente
 * Esta función devuelve el código de la Orden en caso que todo se registre sin problemas, de lo contrario devuelve un mensaje de error.
 */

function registrarOrdenCompleta($mesa, $empleado, $tipoOrden, $fechaHora, $total, $esCliente, $idCliente) {
    $lastId = 0;
    $resultado = TRUE;
    $mensaje = '';
    Try { //******************PASO #1 Se registrará el encabezado de la Orden
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "INSERT INTO ordenes (id_mesa, id_empleado, id_tipoOrden, id_estadoOrden, fecha_hora, total_orden, es_cliente) values (?,?,?,1,?,?,?)";
        $q = $pdo->prepare($sql);
        $q->execute(array($mesa, $empleado, $tipoOrden, $fechaHora, $total, $esCliente));
        Database::disconnect();
        $lastId = $pdo->lastInsertId();
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarOrdenCompleta");
    }

    if ($lastId != 0 && $resultado) {                               //************ PASO #2 se registra todo el detalle de la Orden
        $resultado = registrarDetalleOrden($lastId);
        if ($resultado) {                                          //************** PASO #3 se genera y se registra el código de la Orden
            $mensaje = getCodigoOrden($lastId, $mesa, $empleado);
            if ($mensaje != 'ERROR DE CODIGO DE ORDEN') {                         //*************** PASO #4 Si es cliente, se registra en el detalle consumo cliente
                if ($esCliente) {
                    registrarSiEsCliente($idCliente, $lastId);
                }
            } else {
                $mensaje = 'Ocurrio un error al Generar y Registrar el Codigo de Orden';
            }
        } else {
            $mensaje = 'Ocurrio un error al registrar el detalle de la Orden';
        }
    } else {
        $mensaje = 'Ocurrio un error al registrar la Orden';
    }

    return $mensaje;
}

function registrarDetalleOrden($idOrden) {//SECUENCIA PARA INGRESAR EL DETALLE DE LA ORDEN A LA BASE DE DATOS; DEVUELVE UN BOOLEAN
    $resultado = true;
    $datos = $_SESSION['detalle'];
    try {
        $pdo = Database::connect();
        for ($i = 0; $i < count($datos); $i++) {
            $idPro = $datos[$i]['id'];
            $estDet = $datos[$i]['estado'];
            $cant = $datos[$i]['cantidad'];
            $subt = $datos[$i]['cantidad'] * $datos[$i]['precio'];
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO detalles_orden (id_orden, id_producto, id_estado_detalleOrd, cantidad_prod, subtotal_orden) values (?,?,?,?,?)";
            $q = $pdo->prepare($sql);
            $q->execute(array($idOrden, $idPro, $estDet, $cant, $subt));
        }
        $_SESSION["detalle"] = null; // Despues de guardar todo el detalle, se vaciará por completo el carrito
        Database::disconnect();
    } catch (Exception $ex) {
        $resultado = false;
        write_log($ex, "registrarDetalleOrden");
    }
    return $resultado;
}

function registrarSiEsCliente($idCliente, $idOrden) {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO detalle_consumo_cliente (id_cliente, id_orden) values (?,?)";
    try {
        $q = $pdo->prepare($sql);
        $q->execute(array($idCliente, $idOrden));
        Database::disconnect();
        $resultado = true;
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarSiEsCliente");
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
        $resultado = 'Ocurrio un problema';
        write_log($e, "getEstadosOrden");
    }
    return $resultado;
}

/*
 * Selecciona:
 * 0 - Código de Orden
 * 1 - Fecha y Hora de Pedido
 * 2 - Estado
 * 3 - Nombre del cliente (si tiene)
 * 4 - Codigo de Mesa
 * 5 - Total de la Orden
 * 6 - Id del Cliente
 */

function getInfoOrdenesPorId($idOrden) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT co.codigo_orden, o.fecha_hora, eo.estado, c.nombre, m.cod_mesa, o.total_orden, c.id_clientes FROM ordenes AS o " .
            "INNER JOIN codigo_orden co ON co.id_orden = o.id_ordenes " .
            "INNER JOIN mesas m ON m.id_mesa = o.id_mesa " .
            "INNER JOIN estados_orden eo ON eo.id_estadosOrden = o.id_estadoOrden " .
            "LEFT JOIN detalle_consumo_cliente dcc ON dcc.id_orden = o.id_ordenes " .
            "LEFT JOIN clientes c ON c.id_clientes = dcc.id_cliente " .
            "WHERE o.id_ordenes = " . $idOrden;
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'Ocurrio un problema';
        write_log($e, "getInfoOrdenes");
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
        $resultado = 'Ocurrio un problema';
        write_log($e, "getTiposOrden");
    }
    return $resultado;
}

/*
 * Esta funcion obtiene el correlativo de la Orden del Dia y genera el codigo
 * Invoca a la funcion de registrar el codigo
 * Devuelve un String con el codigo de la Orden.
 */

function getCodigoOrden($idOrden, $idMesa, $idEmpleado) {
    $codigo = null;
    try {
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "SELECT id_ordenes FROM ordenes WHERE DATE(fecha_hora) = DATE(NOW()) AND id_ordenes <= " . $idOrden;
        $q = $pdo->prepare($sql);
        $q->execute();
        $noOrdenDia = count($q->fetchAll());
        Database::disconnect();
    } catch (PDOException $ex) {
        $noOrdenDia = 'Ocurrio un problema';
        write_log($ex, "getCodigoOrden");
    }

    if ($noOrdenDia != null && $noOrdenDia != 'Ocurrio un problema') {
        $codigo = 'O' . $idMesa . $idEmpleado . '-' . $noOrdenDia;
        $registrado = registrarCodigoOrden($idOrden, $codigo);
        if (!$registrado) {
            $codigo = 'ERROR DE CODIGO DE ORDEN';
        }
    } else {
        $codigo = 'ERROR DE CODIGO DE ORDEN';
    }
    return $codigo;
}

/*
 * Esta funcion registra el codigo generado, devuelve un BOOLEAN
 */

function registrarCodigoOrden($idOrden, $codigoOrden) {
    $resultado = false;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "INSERT INTO codigo_orden (id_orden, codigo_orden) values (?,?)";
    try {
        $q = $pdo->prepare($sql);
        $q->execute(array($idOrden, $codigoOrden));
        $resultado = true;
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = false;
        write_log($e, "registrarCodigoOrden");
    }
    return $resultado;
}

function getListadoOrdenes($pendientes = FALSE) {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT o.id_ordenes, co.codigo_orden, cm.cod_mesa, em.nombres, es.estado FROM ordenes o INNER JOIN " .
            "codigo_orden co ON co.id_orden = o.id_ordenes INNER JOIN " .
            "mesas cm ON cm.id_mesa = o.id_mesa INNER JOIN " .
            "empleados em ON em.id_empleado = o.id_empleado INNER JOIN " .
            "estados_orden es ON es.id_estadosOrden = o.id_estadoOrden";

    if ($pendientes) {
        $sql = $sql . " WHERE es.estado = 'Pendiente'";
    }
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $ex) {
        $resultado = 'Ocurrio un problema';
        write_log($ex, "getListadoOrdenes");
    }
    return $resultado;
}

/*
 * Obtiene la siguiente información:
 * 0 - ID del detalle de la Orden
 * 1 - Nombre del Producto
 * 2 - Cantidad del Producto
 * 3 - Subtotal de la Orden
 * 4 - Estado del Producto
 */

function getDetalleOrdenPorId($idOrden) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT do.id_detOrden, p.nombre_prod, do.cantidad_prod, do.subtotal_orden, eo.estado FROM detalles_orden AS do " .
            "INNER JOIN productos p ON p.id_productos = do.id_producto " .
            "INNER JOIN estados_orden eo ON eo.id_estadosOrden = do.id_estado_detalleOrd " .
            "WHERE id_orden = " . $idOrden;

    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = 'Ocurrio un problema';
        write_log($e, "getDetalleOrdenPorId");
    }
    return $resultado;
}

function getHtmlDetalleOrden($idOrden) {
    $consulta = getDetalleOrdenPorId($idOrden);
    $html = '';
    try {
        foreach ($consulta as $registro => $row) {
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

            $html .= '<td>' . $row['estado'] . '</td>';

            if ($row['estado'] == "Cancelada") {
                $html .= '<td><del>' . $row['subtotal_orden'] . '</del></td>';
            } else {
                $html .= '<td>' . $row['subtotal_orden'] . '</td>';
            }
            if ($row['estado'] == "Atendida" || ($row['estado'] == "Cancelada")) {
                $html .= '';
            } else {
                $html .= '<td> <a class="btn btn-info" onclick="detalleAtendido(' . $row["id_detOrden"] . ')">Atendido</a></td>';
                $html .= '<td> <a class="btn btn-info" onclick="detalleCancelado(' . $row["id_detOrden"] . ')">Cancelar</a></td>';
            }
            $html .= '</tr>';
        }
    } catch (Exception $ex) {
        $html = "Ocurrio un problema al obtener el Detalle.";
        write_log($ex, "getHtmlDetalleOrden");
    }

    return $html;
}

/*
 * 
 * @$idDetalleProducto
 * @alEstado indica uno de 3 posibles estados: Pendiente-1; Atendido-2; Cancelado-4
 */

function updateEstadoProducto($idDetalleProducto, $alEstado) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE detalles_orden SET id_estado_detalleOrd=? WHERE id_detOrden=?";
    try {
        $q = $pdo->prepare($sql);
        $q->execute(array($alEstado, $idDetalleProducto));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "updateEstadoProducto");
    }
    return $resultado;
}

/*
 * Funciones que sirven exclusivamente para automatizar el estado de la Orden:
 * -checkEstadoDetalleOrden
 * -
 */

function checkEstadoDetalleOrden($idOrden) {
    $listado = listadoEstadoDetalleOrden($idOrden);
    $todoAtendido = TRUE;
    $resultado = FALSE;
    try {
        foreach ($listado as $row => $dato) {//Evalua que el estado de cada item de la orden se haya atendido.
            if ($dato['id_estado_detalleOrd'] == 1) {
                $todoAtendido = FALSE;
            }
        }
        if ($todoAtendido) {
            if (checkTodoCancelado($idOrden)) {
                $resultado = updateEstadoOrden($idOrden, 4); //Si todo esta CANCELADA, cambia el estado de la orden a CANCELADA.
            } else {
                $resultado = updateEstadoOrden($idOrden, 2); //Si todo esta ATENDIDO, cambia el estado de la orden a ATENDIDA.
            }
        } else {
            $resultado = updateEstadoOrden($idOrden, 1); //Si hay algo PENDIENTE, se actualiza a PENDIENTE.
        }
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "checkEstadoDetalleOrden");
    }
    return $resultado;
}

/*
 * Esta función se encarga de verificar si todos los productos se catalogan como CANCELADOS, 
 * de ser así, el estado de la orden debe cambiar a CANCELADA.
 */

function checkTodoCancelado($idOrden) {
    $listadoCancelado = listadoEstadoDetalleOrden($idOrden);
    $todoCancelado = TRUE;
    foreach ($listadoCancelado as $row => $dato) {//Evalua que el estado de cada item de la orden se haya atendido.
        if ($dato['id_estado_detalleOrd'] != 4) {
            $todoCancelado = FALSE;
        }
    }
    return $todoCancelado;
}

function listadoEstadoDetalleOrden($idOrden) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT id_estado_detalleOrd FROM detalles_orden WHERE id_orden =?";
    try {
        $q = $pdo->prepare($sql);
        $q->execute(array($idOrden));
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = NULL;
        write_log($e, "listadoEstadoDetalleOrden");
    }
    return $resultado;
}

/*
 * Estados de una Orden: Pendiente-1, Atendida-2, Pagada-3, Cancelada-4
 */

function updateEstadoOrden($idOrden, $alEstado) { //la variable $alEstado determina por defecto que se cambiara al estado Atendi
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE ordenes SET id_estadoOrden=? WHERE id_ordenes=?";

    try {
        $q = $pdo->prepare($sql);
        $q->execute(array($alEstado, $idOrden));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "updateEstadoOrden");
    }
    return $resultado;
}

function updateTotalOrden($idOrden) {
    $nuevoTotal = recalcularTotalOrden($idOrden);
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE ordenes SET total_orden=? WHERE id_ordenes=?";

    try {
        $q = $pdo->prepare($sql);
        $q->execute(array($nuevoTotal, $idOrden));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "descontarCancelados");
    }
    return $resultado;
}

function recalcularTotalOrden($idOrden) {
    $detallesOrden = getDetalleOrdenPorId($idOrden);
    $nuevaCuenta = 0;
    $descuento = 0;
    foreach ($detallesOrden as $row => $dato) {              //Se recorre el arreglo para obtener el monto a descontar.
        $nuevaCuenta += $dato[3];
        if ($dato[4] == 'Cancelada') {
            $descuento += $dato[3];
        }
    }
    $nuevoTotal = $nuevaCuenta - $descuento;

    return $nuevoTotal;
}

function getOrdenesAtendidas() {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT o.id_ordenes, co.codigo_orden, cm.cod_mesa, c.nombre, c.apellido, o.total_orden, es.estado FROM ordenes o " .
            "INNER JOIN codigo_orden co ON co.id_orden = o.id_ordenes " .
            "INNER JOIN mesas cm ON cm.id_mesa = o.id_mesa " .
            "LEFT JOIN detalle_consumo_cliente dcc ON dcc.id_orden = o.id_ordenes " .
            "LEFT JOIN clientes c ON c.id_clientes = dcc.id_cliente " .
            "LEFT JOIN estados_orden es ON es.id_estadosOrden = o.id_estadoOrden " .
            "WHERE es.estado = 'Atendida'";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $ex) {
        $resultado = 'Ocurrio un problema';
        write_log($ex, "getOrdenesAtendidas");
    }
    return $resultado;
}

function getHtmlOrdenAtendida() {
    include_once 'utils.php';
    $detalle = getOrdenesAtendidas();
    $html = '';
    foreach ($detalle as $registro => $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row['codigo_orden'] . '</td>';
        $html .= '<td>' . $row['cod_mesa'] . '</td>';
        $html .= '<td>' . $row['nombre'] . ' ' . $row['apellido'] . '</td>';
        $html .= '<td> $' . $row['total_orden'] . '</td>';
        $html .= '<td> <a href="../pagos/pagarOrden.php?' . encode_this('idOrdenAPagar=' . $row["id_ordenes"]) . '" class="btn btn-info")">Pagar</a></td>';
        $html .= '</tr>';
    }
    return $html;
}

