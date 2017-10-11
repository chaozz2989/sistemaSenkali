<?php
include_once '../core/pdf/mpdf.php';
//include_once '../mpdf60/mpdf.php';
include '../../database.php';

session_start();
$ultimaFactura = $_SESSION['idUltimaFactura'];
$datos = "";
    
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "Select factura.codigo_factura, factura.fecha_venta, concat(cliente.nombre_cliente, ' ', cliente.apellido_cliente) AS Cliente, "
            . "producto.nombre_producto, detalle_venta.cantidad, detalle_venta.precio_tot_producto, factura.total "
            . "from factura "
            . "INNER JOIN detalle_venta ON detalle_venta.codigo_factura = factura.codigo_factura "
            . "INNER JOIN producto ON producto.codigo_producto = detalle_venta.codigo_producto "
            . "INNER JOIN cliente ON cliente.codigo_cliente = factura.codigo_cliente "
            . "WHERE factura.codigo_factura=" . $ultimaFactura;
    $q = $pdo->prepare($sql);
    $q->execute();
    $data = $q->fetchAll();
    Database::disconnect();
    foreach ($data as $rows) {
        $cliente = $rows['Cliente'];
        $total = $rows['total'];
        $fechaVenta = $rows['fecha_venta'];
    }

    foreach ($data as $rows) {
        $datos .= '<tr>';
        $datos .= '<td>' . $rows['cantidad'] . '</td>';
        $datos .= '<td>' . $rows['nombre_producto'] . '</td>';
        $datos .= '<td>' . $rows['precio_tot_producto'] . '</td>';
        $datos .= '</tr>';
    }
    
    if (isset($ultimaFactura)) {
    if ($ultimaFactura < 9999) {
        if ($ultimaFactura < 999) {
            if ($ultimaFactura < 99) {
                if ($ultimaFactura < 9) {
                    $ultimaFactura = '0000'.$ultimaFactura;
                } else {
                    $ultimaFactura = '000'.$ultimaFactura;
                }
            } else {
                $ultimaFactura = '00'.$ultimaFactura;
            }
        } else {
            $ultimaFactura = '0'.$ultimaFactura;
        }
    } else {
        $ultimaFactura = $ultimaFactura;
    }
}



$nombre_institucion = "SISCOMED";
$fecha = date('d/m/Y');

$html = '<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte de clientes</title>
    <link rel="stylesheet" href="estilo_reporte.css" media="all" />
  </head>
  <body>
    <header class="clearfix">
      <div id="logo">
        <img src="logo_reporte.png" width="100px">
      </div>
      <h1>Factura #' . $ultimaFactura . '</h1>
      <div id="company" class="clearfix">
        <div>'.$nombre_institucion. '</div><br>
        <div>'.$cliente. '</div>
      </div>
      <div id="project">        
        <div><span>FECHA: </span>'.$fechaVenta.'</div>        
        <!--><div><span>DUE DATE</span> September 17, 2015</div>-->
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
            <th>Cantidad</th>
            <th>Detalle</th>
            <th>Sub Total</th>
          </tr>
        </thead>
        <tbody>';
$html .= $datos;


$html .= '</tbody>
      </table>
     <div id="company" class="clearfix">
        <div>Total $'.$total. '</div>
      </div>
    </main>
    <footer>
     	
    </footer>
  </body>
</html>';
        
          
$pdf = new mPDF('c','A4');
$pdf->writeHTML($html);
$pdf->Output("reporte.pdf","I");


?>