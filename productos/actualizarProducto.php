<?php 
include "../conexion/conexion.php";


$nombreProd= filter_input(INPUT_POST, 'nombreProd');
$precioProd= filter_input(INPUT_POST, 'precioProd');
$idCategoria= filter_input(INPUT_POST, 'catProd');
$nombreProd= filter_input(INPUT_POST, 'nombreProd');
$nombreProd= filter_input(INPUT_POST, 'nombreProd');



$sql="UPDATE reservas SET descripcion	=:des,codigo_reserva=:codRes, id_estadoRes=:estado  WHERE  id_reservas=:id ";

/*
$query = $con->query($sql);
			if($query!=null){
				print "<script>alert(\"Actualizado exitosamente.\");window.location='../empleado/reserva.php';</script>";
			}else{
				print "<script>alert(\"No se pudo actualizar.\");window.location='../empleado/reserva.php';</script>";

			}

*/


$stmt = $conexion->prepare($sql);                                  
$stmt->bindParam(':des',$des=$_POST['descripcion'], PDO::PARAM_STR);       
$stmt->bindParam(':codRes',$_POST['codReserva'], PDO::PARAM_STR);    
$stmt->bindParam(':estado', $_POST['estado'], PDO::PARAM_STR);
$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);   
$stmt->execute(); 


	if($stmt!=null){
					print "<script>alert(\"Actualizado exitosamente.\");window.location='../empleado/reserva.php';</script>";
				}else{
					print "<script>alert(\"No se pudo actualizar.\");window.location='../empleado/reserva.php';</script>";

				}

 ?>
