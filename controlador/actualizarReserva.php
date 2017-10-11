<?php 
include "../conexion/conexion.php";


$des=$_POST['descripcion'];
$codRes=$_POST['codReserva'];
$id=$_POST['id'];
$state=$_POST['estado'];
$resultado = null;
Try {
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "UPDATE reservas SET descripcion=?,codigo_reserva=?, id_estadoRes=? WHERE id_reservas=?;";
    
        $q = $pdo->prepare($sql);
        $q->execute(array($des, $codRes, $state, $id));
        Database::disconnect();
        $resultado = TRUE;
    } catch (PDOException $e) {
        $resultado = FALSE;
        write_log($e, "modificarProducto");
    }

/*$sql="UPDATE reservas SET descripcion	=:des,codigo_reserva=:codRes, id_estadoRes=:estado  WHERE  id_reservas=:id ";


$query = $con->query($sql);
			if($query!=null){
				print "<script>alert(\"Actualizado exitosamente.\");window.location='../empleado/reserva.php';</script>";
			}else{
				print "<script>alert(\"No se pudo actualizar.\");window.location='../empleado/reserva.php';</script>";

			}




$stmt = $conexion->prepare($sql);                                  
$stmt->bindParam(':des',$des=$_POST['descripcion'], PDO::PARAM_STR);       
$stmt->bindParam(':codRes',$_POST['codReserva'], PDO::PARAM_STR);    
$stmt->bindParam(':estado', $_POST['estado'], PDO::PARAM_STR);
$stmt->bindParam(':id', $_POST['id'], PDO::PARAM_INT);   
$stmt->execute(); 
*/

	if($resultado){
					print "<script>alert(\"Actualizado exitosamente.\");window.location='../empleado/reserva.php';</script>";
				}else{
					print "<script>alert(\"No se pudo actualizar.\");window.location='../empleado/reserva.php';</script>";

				}

 ?>
