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
        write_log($e, "registrarProducto");
    }

    if ($lastId != 0 && $resultado) {                               //************ PASO #2 se registra todo el detalle de la Orden
        $resultado = registrarDetalleOrden($lastId);
        if ($resultado) {                                          //************** PASO #3 se genera y se registra el código de la Orden
            $resultado = getCodigoOrden($lastId, $mesa, $empleado);
            if ($resultado != 'ERROR DE CODIGO DE ORDEN') {                         //*************** PASO #4 Si es cliente, se registra en el detalle consumo cliente
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

    return $resultado;
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
        write_log($ex, "registrarProducto");
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
        write_log($e, "registrrSiEsCliente");
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
 * Código de Orden
 * Fecha y Hora de Pedido
 * Estado
 * Nombre del cliente (si tiene)
 */

function getInfoOrdenesPorId($idOrden) {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT co.codigo_orden, o.fecha_hora, eo.estado, c.nombre FROM ordenes AS o " .
            "INNER JOIN codigo_orden co ON co.id_orden = o.id_ordenes " .
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
        write_log($ex, "getInfoOrdenes");
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
        write_log($ex, "getTiposOrden");
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
    } catch (PDOException $e) {
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
    } catch (PDOException $e) {
        $resultado = 'Ocurrio un problema';
        write_log($ex, "getListadoOrdenes");
    }
    return $resultado;
}

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
            $html .= '<td>' . $row['nombre_prod'] . '</td>';
            $html .= '<td>' . $row['cantidad_prod'] . '</td>';
            $html .= '<td>' . $row['estado'] . '</td>';
            $html .= '<td>' . $row['subtotal_orden'] . '</td>';
            if ($row['estado'] == "Atendida") {
                $html .= '<td></td>';
            } else {
                $html .= '<td> <a class="btn btn-info" onclick="detalleAtendido(' . $row["id_detOrden"] . ')">Atendido</a></td>';
                $html .= '<td> <a class="btn btn-info" onclick="detalleCancelado(' . $row["id_detOrden"] . ')">Cancelar</a></td>';
            }
            $html .= '</tr>';
        }
        Database::disconnect();
    } catch (Exception $ex) {
        $html = "Ocurrio un problema al obtener el Detalle.";
        write_log($ex, "getHtmlDetalleOrden");
    }

    return $html;
}

/*
 * Estados posibles de los productos: Pendiente-1; Atendido-2; Cancelado-3;
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
    try {
        foreach ($listado as $row => $dato) {//Evalua que el estado de cada item de la orden se haya atendido.
            if ($dato['id_estado_detalleOrd'] == 1) {
                $todoAtendido = FALSE;
            }
        }
        if ($todoAtendido) {
            updateEstadoOrden($idOrden); //Si todo esta atendido, cambia el estado de la orden.
        }
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "checkEstadoDetalleOrden");
    }
    return $resultado;
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
    switch ($alEstado) {
        case 1:
            $sql = "UPDATE ordenes SET id_estadoOrden=1 WHERE id_ordenes=?";
        case 2:
            $sql = "UPDATE ordenes SET id_estadoOrden=2 WHERE id_ordenes=?";
        case 3:
            $sql = "UPDATE ordenes SET id_estadoOrden=3 WHERE id_ordenes=?";
        case 4:
            $sql = "UPDATE ordenes SET id_estadoOrden=4 WHERE id_ordenes=?";
    }

    try {
        $q = $pdo->prepare($sql);
        $q->execute(array($idOrden));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "updateEstadoProducto");
    }
    return $resultado;
}
