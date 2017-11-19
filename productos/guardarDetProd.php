<?php

session_start();

require_once '../funciones/fProductos.php';
include_once '../conexion/conexion.php';


//************NUEVA CAPTURA DE VARIABLES
$nombreProd = filter_input(INPUT_POST, 'nombreProd');
$precioProd = filter_input(INPUT_POST, 'precioProd');
$subCategoria = filter_input(INPUT_POST, 'subcatProd');
$especial = filter_input(INPUT_POST, 'chkProdEspecial');

//$idOrden = filter_input(INPUT_POST, 'idOrden');

if (!isset($especial) || $especial == null) {
    $especial = 0;
}


$mensaje = registrarProductoCompleto($subCategoria, $nombreProd, $precioProd, $especial);
print "<script>alert('" . $mensaje . "');window.location='crearProducto.php';</script>";

