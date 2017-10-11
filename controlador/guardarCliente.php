<?php

include "../funciones/funciones.php";



$sql="INSERT INTO clientes (id_clientes,id_estadoUsu,usuario,clave,nombre,apellido,dui,telefono,email,direccion) VALUES(null,:eu,:us,:pwd,:nom,:ap,:dui,:tel,:email,:dir)";

$stmt = $conexion->prepare($sql);                                  
$stmt->bindParam(':eu',$eusuario=$_POST['eusuario'], PDO::PARAM_INT);       
$stmt->bindParam(':us',$_POST['usr'], PDO::PARAM_STR);    
$stmt->bindParam(':pwd', $_POST['pwd'], PDO::PARAM_STR);
$stmt->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
$stmt->bindParam(':ap', $_POST['ap'], PDO::PARAM_STR);
$stmt->bindParam(':dui', $_POST['dui'], PDO::PARAM_STR);
$stmt->bindParam(':tel', $_POST['tel'], PDO::PARAM_STR);
$stmt->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
$stmt->bindParam(':dir', $_POST['dir'], PDO::PARAM_STR);
$stmt->execute(); 




if ($stmt != null) {
    print "<script>alert(\"Guardado exitosamente.\");window.location='../clientes/crearCliente.php';</script>";
} else {
    print "<script>alert(\"No se pudo actualizar.\");window.location='../clientes/crearCliente.php';</script>";
}

