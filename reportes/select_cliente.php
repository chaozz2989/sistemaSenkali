<?php
include './db_reportes.php';
$cliente = new reporte();
$nombre = filter_input(INPUT_POST, 'nombre');
$dui = filter_input(INPUT_POST, 'dui');
$estado = filter_input(INPUT_POST, 'estado');

$html = "";

$html = $cliente->obtener_cliente($nombre,$dui,$estado);

echo $html;
?>