	<?php 

	include '../conexion/conexiond.php';

	

	/*$sqlmax = "SELECT MAX(id_productos) FROM productos";
	$statement = $conexion->prepare($sqlmax);
	$statement->execute(); // no need to add `$sql` here, you can take that out
	//$item_id = $statement->fetchColumn();*/
    $item_id=1;


	$stmt = $conexion->prepare("INSERT INTO productos (id_productos,id_subCat,nombre_prod,precio_prod,especialidad) 
		VALUES (:item, :nom, :sub, :pre, :es )");
	$stmt->bindParam('item',$item_id);
	$stmt->bindParam('nom',$nomProd);
	$stmt->bindParam('sub',$idSub);
	$stmt->bindParam('pre',$preProd);
	$stmt->bindParam('es',$esProd);
	
	$nomProd= $_POST['nomProd'];
	$idSub=$_POST['idSub'];
	$preProd=$_POST['preProd'];
	$esProd=$_POST['esProd'];
echo "$nomProd";


	$stmt->execute();

/*
	$stmt = $this->pdo->prepare("SELECT COUNT(*) FROM users WHERE email=:email");
$stmt->bindParam(":email", $_POST['email']);
$stmt->execute();
$stmt->fetch(PDO::FETCH_ASSOC);
*/
	 ?>