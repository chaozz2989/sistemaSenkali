<?php
//include_once '../mpdf60/mpdf.php';
include_once '../core/pdf/mpdf.php';
include '../../database.php';

function obtener_empleado($value='')
  {
    $condicion = "";
    $html = "";
    $value = trim($value);
    if (!empty($value)) {
      $condicion = " WHERE codigo_empleado LIKE '%".$value."%' OR nombre_empleado LIKE '%".$value."%' 
      OR apellido_empleado LIKE '%".$value."%' OR correo LIKE '%".$value."%' OR telefono LIKE '%".$value."%' 
      OR nombre_cargo LIKE '%".$value."%' OR fecha_ingreso LIKE '%".$value."%' OR dui LIKE '%".$value."%' ";
    }
        $pdo = Database::connect();
        $sql = 'SELECT codigo_empleado,nombre_empleado,apellido_empleado,nombre_cargo,correo,telefono,fecha_ingreso,
        dui FROM empleado
        INNER JOIN cargo cr ON cr.codigo_cargo = empleado.codigo_cargo '.$condicion.' ORDER BY codigo_empleado ASC';
    foreach ($pdo->query($sql) as $row) {
      $html .= '<tr>';
            $html .= '<td>' . $row['codigo_empleado'] . '</td>';
            $html .= '<td>' . $row['nombre_empleado'] . '</td>';
          $html .= '<td>' . $row['apellido_empleado'] . '</td>';
            $html .= '<td>' . $row['nombre_cargo'] . '</td>';
            $html .= '<td>' . $row['correo'] . '</td>';
          $html .= '<td>' . $row['telefono'] . '</td>';
            $html .= '<td>' . $row['fecha_ingreso'] . '</td>';
            $html .= '<td>' . $row['dui'] . '</td>';                                              
        }
    Database::disconnect();
    return $html;
  }


$nombre_institucion = "SISCOMED";
$fecha = date('d/m/Y');

$valor = "";
$datos = "";

if (isset($_POST['texto'])) {
  $valor = $_POST['texto'];
}
$datos = obtener_empleado($valor);


$html = '<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Reporte de empleados</title>
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
              <th>Codigo Empleado</th>
              <th>Nombres Empleado</th>
              <th>Apellidos Empleado</th>
              <th>Cargo</th>
              <th>Correo</th>
              <th>Telefono</th>
              <th>Fecha Ingreso</th>
              <th>DUI</th>

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