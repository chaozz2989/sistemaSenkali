<?php
//include_once '../mpdf60/mpdf.php';
include_once '../core/pdf/mpdf.php';
include '../../database.php';

function obtener_producto($producto='',$proveedor = '',$tipo_producto = '')
  {
    $condicion = "";
    $html = "";
    $condicion_proveedor = "";
    $condicion_producto  ="";
    $condicion_tipo = "";

    if (!empty($proveedor)) {
      $condicion_proveedor = " pr.codigo_proveedor LIKE '%".$proveedor."%' OR pr.nombre_empresa LIKE '%".$proveedor."%' ";
    }if (!empty($producto)) {
      $condicion_producto = " pd.codigo_producto LIKE '%".$producto."%' OR pd.nombre_producto LIKE '%".$producto."%' ";
    }if (!empty($tipo_producto) && $tipo_producto <> "0") {
      $condicion_tipo = " tp.codigo_tipoproducto = '".$tipo_producto."' ";
    }

    if (!empty($condicion_producto) && !empty($condicion_proveedor) && !empty($condicion_tipo)) {
      $condicion  = " WHERE (".$condicion_producto.") OR (".$condicion_proveedor.") OR (".$condicion_proveedor.")";
    }elseif (!empty($condicion_producto) && !empty($condicion_proveedor)) {
      $condicion = " WHERE (" . $condicion_producto.") OR (".$condicion_proveedor.") ";
    }elseif (!empty($condicion_producto) && !empty($condicion_tipo)) {
      $condicion = " WHERE (" . $condicion_producto.") OR (".$condicion_tipo.") ";
    }elseif (!empty($condicion_proveedor) && !empty($condicion_tipo)) {
      $condicion = " WHERE (" . $condicion_proveedor.") OR (".$condicion_tipo.") ";
    }elseif (!empty($condicion_producto)) {
      $condicion = " WHERE " . $condicion_producto;
    }elseif (!empty($condicion_proveedor)) {
      $condicion = " WHERE " . $condicion_proveedor;
    }elseif (!empty($condicion_tipo)) {
      $condicion = " WHERE " . $condicion_tipo;
    }

        $pdo = Database::connect();
        $sql = "SELECT pd.codigo_producto, pd.nombre_producto, pr.nombre_empresa, tp.nombre_tipoproducto, pd.precio_venta, pd.presentacion from producto pd
            INNER JOIN proveedor pr ON pd.codigo_proveedor = pr.codigo_proveedor
            INNER JOIN tipo_producto tp ON pd.codigo_tipoproducto = tp.codigo_tipoproducto " . $condicion;
    
    foreach ($pdo->query($sql) as $row) {
       $html .=  '<tr>';
                                                $html .=  '<td>' . $row['codigo_producto'] . '</td>';
                                                $html .=  '<td>' . $row['nombre_producto'] . '</td>';
                                                $html .=  '<td>' . $row['nombre_empresa'] . '</td>';
                                                $html .=  '<td>' . $row['nombre_tipoproducto'] . '</td>';
                                                $html .=  '<td>' . $row['presentacion'] . '</td>';
                                                $html .=  '<td>' . $row['precio_venta'] . '</td>';
                                                $html .=  '</tr>';
    }
    Database::disconnect();
    return $html;
  }


$nombre_institucion = "SISCOMED";
$fecha = date('d/m/Y');

$valor = "";
$proveedor = "";
$producto = "";
$tipo = "";

if (isset($_POST['producto'])) {
  $producto = $_POST['producto'];
}if (isset($_POST['proveedor'])) {
  $proveedor = $_POST['proveedor'];
}if (isset($_POST['tipo'])) {
  $tipo = $_POST['tipo'];
}


$datos = obtener_producto($producto,$proveedor,$tipo);


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
      <h1>Reporte de clientes</h1>
      <div id="company" class="clearfix">
        <div>'.$nombre_institucion. '</div>        
      </div>
      <div id="project">        
        <div><span>FECHA IMPRESIÓN: </span>'.$fecha.'</div>        
        <!--><div><span>DUE DATE</span> September 17, 2015</div>-->
      </div>
    </header>
    <main>
      <table>
        <thead>
          <tr>
                <th>Codigo</th>
                                                <th>Nombre Producto</th>
                                                <th>Proveedor</th>
                                                <th>Tipo Producto</th>
                                                <th>Presentacion</th>
                                                <th>Precio Venta</th>
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
        
          
$pdf = new mPDF('c','A4');
$pdf->writeHTML($html);
$pdf->Output("reporte.pdf","I");


?>