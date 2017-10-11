<?php 

session_start();  
//Formateo de Fechas
$variable = $_POST['fcreacion'];
$partes = array();
$partes = explode("/",$variable);
$arreglo = array($partes[2], $partes[0], $partes[1]);
$nueva_fecha = implode("-", $arreglo);


//CAPTURA DE DATOS DE FORMULARIO
$tipo = $_POST['tipoEvento'];
$des = $_POST['descripcion'];
$emp = $_POST['empleado'];
$clie = $_POST['cliente'];
$estadoRes = $_POST['estadoReserva'];
$codRes = $_POST['codReserva'];
$cantP = $_POST['cantPersona'];
//$horaI = strtotime($_POST['horaI']);
//$horaf =  strtotime($_POST['horaf']);
$horaI = date("H:i:s",strtotime($nueva_fecha.' '.$_POST['horaI']));
$horaf =  date("H:i:s",strtotime($nueva_fecha.' '.$_POST['horaf']));



echo $nueva_fecha;
$idMax="";
$sql=false;
$con=mysqli_connect("localhost","root",'',"senkalidb")  or die($connect_error);;



if (mysqli_connect_errno())
  {
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }


$result = mysqli_query($con, "SELECT MAX(id_reservas) AS max_page FROM reservas");

    while ($row = mysqli_fetch_assoc($result)) {
        $idGenerado = $row['max_page'];

            }

            $idMax= $idGenerado+1;
    //echo "maximios: $idMax";




/*
try{
	$sql=mysql_query("INSERT INTO reservas (id_reservas,id_estadoRes,id_empleado,id_cliente,id_tipoEvento,codigo_reserva,descripcion,fecha,hora_inicio,hora_final,cant_personas)VALUES ($idMax,$estadoRes,$emp,$clie,$tipo,'$codRes','$des','$nueva_fecha','$horaI','$horaf','$cantP')");

}catch (all $e){
print "<script>alert(\"Fallo.  \");window.location='../empleado/reserva.php';</script>";

}
*/
$sql=mysqli_query($con, "INSERT INTO reservas (id_reservas,id_estadoRes,id_empleado,id_cliente,id_tipoEvento,codigo_reserva,descripcion,fecha,hora_inicio,hora_final,cant_personas)VALUES ($idMax,$estadoRes,$emp,$clie,$tipo,'$codRes','$des','$nueva_fecha','$horaI','$horaf','$cantP')");
if ($sql===true) {
	print "<script>alert(\"Agregado exitosamente.\");window.location='../empleado/reserva.php';</script>";
}else{
	
print "<script>alert(\"Fallo. \");window.location='../empleado/reserva.php';</script>";
//mysql_error($con)

}




$con->close();

 ?>
