<?php
session_start();

include_once '../reportes/core/pdf/mpdf.php';
//include_once '../mpdf60/mpdf.php';
include_once '../conexion/conexion.php';
//require_once '../db_reportes.php';
include_once '../funciones/fOrdenes.php';

/*$nombre = filter_input(INPUT_POST, 'nombre');
$dui = filter_input(INPUT_POST, 'dui');
$estado = filter_input(INPUT_POST, 'estado');
*/
$idOrden = filter_input(INPUT_POST, 'idOrden');

$encabezado = getInfoOrdenesPorId($idOrden);
$detalle = getHtmlDetalleOrden($idOrden);

$cliente = 'NA';
if ($encabezado[0][3] != null){
    $cliente = $encabezado[0][3];
}

//$cliente = new reporte();

//$datos = $cliente->obtener_cliente($nombre, $dui, $estado);

$nombre_institucion = "SENKALI";
$fecha = date('d/m/Y');

$valor = "";

$html = '<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Recibo de Orden</title>
    <link rel="stylesheet" href="../reportes/pdf/estilo_reporte.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="../reportes/pdf/logo1SNK.jpg" width="100px">
      </div>
      <h1>Recibo de Orden ' .  $encabezado[0][0] . '</h1>
      <div id="company" class="clearfix">
        <div>' . $nombre_institucion . '</div>        
      </div>
      <div id="project">
        <div><span>CLIENTE: </span>' . $cliente . '</div>
        <div><span>FECHA IMPRESIÓN: </span>' . $fecha . '</div>
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Estado</th>
            <th>Subtotal</th>
           </tr>
        </thead>
        <tbody>';
$html .= $detalle;


$html .= '</tbody>
      </table>
     <h1>Total a pagar: $' .  $encabezado[0][5] . '</h1>
    </main>
    <footer>
     	
    </footer>
  </body>
</html>';

try{
    $pdf = new mPDF('c', 'A4');
    $pdf->writeHTML($html);
    $pdf->Output("reporte.pdf", "I");
} catch (Exception $ex) {
    write_log($ex, "reporteCliente");
}

?>