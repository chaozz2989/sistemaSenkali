<?php

require_once '../conexion/conexion.php';
require_once 'utils.php';


/*
 * Esta funcion llama al listado de clientes con su respectivo estado.
 */
function getClientes() {
    $resultado = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "SELECT c.id_clientes, e.estado_usuario, c.usuario, c.clave, c.nombre, c.apellido, c.dui, c.telefono, c.email, c.direccion " .
            "FROM clientes c " .
            "INNER JOIN estados_usuario e ON e.id_estUsuario = c.id_estadoUsu";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $resultado = $q->fetchAll();
        Database::disconnect();
    } catch (PDOException $e) {
        $resultado = "Ocurrio un error.";
        write_log($e, "getClientes");
    }
    return $resultado;
}
