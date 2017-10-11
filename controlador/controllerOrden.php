<?php
session_start();
if(isset($_GET["page"])){
	$page=$_GET["page"];
}else{
	$page=0;
}


require_once '../funciones/funcionOrd.php';
 

$objProducto = new Funcion();

$_SESSION['d']=$page;




switch ($page) {

    case 1:

        if (isset($_POST['cbo_producto']) && $_POST['cbo_producto'] != '' && isset($_POST['txt_cantidad']) && $_POST['txt_cantidad'] != '') {
            try {
                
                $estadoOrd=$_POST['cbo_estado'];
                $idProducto = $_POST['cbo_producto'];
                $cantidad = $_POST['txt_cantidad'];
                $resultado_producto = $objProducto->getById($idProducto);
                $descripcion = $resultado_producto->nombre_prod;
                $precio = $resultado_producto->precio_prod;
                $subtotal = $cantidad * $precio;



                $_SESSION['detalle'][$idProducto] = array('id' => $idProducto, 'producto' => $descripcion, 'cantidad' => $cantidad, 'precio' => $precio, 'subtotal' => $subtotal
                        ,'estado'=>$estadoOrd);

                

                 
            

               
            } catch (PDOException $e) {
                $json['msj'] = $e->getMessage();
                $json['success'] = false;
                echo json_encode($json);
            }
        } else {
            $json['msj'] = 'Ingrese un producto y/o ingrese cantidad';
            $json['success'] = false;
            echo json_encode($json);
        }
        
        break;
        
        
        
        
        case 2:
            
		$json = array();
		$json['msj'] = 'Producto Eliminado';
		$json['success'] = true;
	
		if (isset($_POST['id'])) {
			try {
				unset($_SESSION['detalle'][$_POST['id']]);
				$json['success'] = true;
	
				echo json_encode($json);
	
			} catch (PDOException $e) {
				$json['msj'] = $e->getMessage();
				$json['success'] = false;
				echo json_encode($json);
			}
		}
		break;
        
        
}	


/*

switch($page){

	case 1:
		$objProducto = new Funcion();
		$json = array();
		$json['msj'] = 'Producto Agregado';
		$json['success'] = true;
	
		if (isset($_POST['producto_id']) && $_POST['producto_id']!='' && isset($_POST['cantidad']) && $_POST['cantidad']!='') {
			try {
				$cantidad = $_POST['cantidad'];
				$producto_id = $_POST['producto_id'];
				
				$resultado_producto = $objProducto->getById($producto_id);
				$producto = $resultado_producto->fetchObject();
				$descripcion = $producto->nombre_prod;
				$precio = $producto->precio_prod;
				
				$subtotal = $cantidad * $precio;
				
				$_SESSION['detalle'][$producto_id] = array('id'=>$producto_id, 'producto'=>$descripcion, 'cantidad'=>$cantidad, 'precio'=>$precio, 'subtotal'=>$subtotal);

				$json['success'] = true;

				echo json_encode($json);
	
			} catch (PDOException $e) {
				$json['msj'] = $e->getMessage();
                                $json['success'] = false;
				echo json_encode($json);
			}
		}else{
			$json['msj'] = 'Ingrese un producto y/o ingrese cantidad';
			$json['success'] = false;
			echo json_encode($json);
		}
		break;

	case 2:
		$json = array();
		$json['msj'] = 'Producto Eliminado';
		$json['success'] = true;
	
		if (isset($_POST['id'])) {
			try {
				unset($_SESSION['detalle'][$_POST['id']]);
				$json['success'] = true;
	
				echo json_encode($json);
	
			} catch (PDOException $e) {
				$json['msj'] = $e->getMessage();
				$json['success'] = false;
				echo json_encode($json);
			}
		}
		break;
		
	case 3:
		$objProducto = new Producto();
		$json = array();
		$json['msj'] = 'Guardado correctamente';
		$json['success'] = true;
		$json['idventa'] = '';
	
		if (count($_SESSION['detalle'])>0) {
			try {
				$objProducto->guardarVenta();
				$registro_ultima_venta = $objProducto->getUltimaVenta();
				$result_ultima_venta = $registro_ultima_venta->fetchObject();
				$idventa = $result_ultima_venta->ultimo;
				foreach($_SESSION['detalle'] as $detalle):
					$idproducto = $detalle['id'];
					$cantidad = $detalle['cantidad'];
					$precio = $detalle['precio'];
					$subtotal = $detalle['subtotal'];
					$objProducto->guardarDetalleVenta($idventa, $idproducto, $cantidad, $precio, $subtotal);
				endforeach;
				
				$_SESSION['detalle'] = array();
						
				$json['success'] = true;
				$json['idventa'] = $idventa;
	
				echo json_encode($json);
	
			} catch (PDOException $e) {
				$json['msj'] = $e->getMessage();
				$json['success'] = false;
				echo json_encode($json);
			}
		}else{
			$json['msj'] = 'No hay productos agregados';
			$json['success'] = false;
			echo json_encode($json);
		}
		break;




}

*/


