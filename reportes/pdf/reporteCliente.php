<?php

include_once '../core/pdf/mpdf.php';
//include_once '../mpdf60/mpdf.php';
include_once '../../conexion/conexion.php';
require_once '../db_reportes.php';

$nombre = filter_input(INPUT_POST, 'nombre');
$dui = filter_input(INPUT_POST, 'dui');
$estado = filter_input(INPUT_POST, 'estado');

$cliente = new reporte();

$datos = $cliente->obtener_cliente($nombre, $dui, $estado);

$nombre_institucion = "SENKALI";
$fecha = date('d/m/Y');

$valor = "";

$html = '<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte de clientes</title>
    <link rel="stylesheet" href="estilo_reporte.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="logo1SNK.jpg" width="100px">
      </div>
      <h1>Reporte de clientes</h1>
      <div id="company" class="clearfix">
        <div>' . $nombre_institucion . '</div>        
      </div>
      <div id="project">        
        <div><span>FECHA IMPRESIÓN: </span>' . $fecha . '</div>        
        <!--><div><span>DUE DATE</span> September 17, 2015</div>-->
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>ID Cliente</th>
            <th>Nombre Completo</th>
            <th>Usuario</th>
            <th>DUI</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Estado</th>
           </tr>
        </thead>
        <tbody>';
$html .= $datos;


$html .= '</tbody>
      </table>
     
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