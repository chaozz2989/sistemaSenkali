<?php

session_start();
/* if (!isset($_SESSION['idUsuario'])) {
  echo "<script type='text/javascript'>"
  . "window.location = '../login.php';"
  . "</script>";
  } */

require '../conexion/conexion.php';
$codigoProducto = filter_input(INPUT_POST, 'producto');
$cantidad = filter_input(INPUT_POST, 'cantidad');
$estado = filter_input(INPUT_POST, 'estado');
$vaciado = filter_input(INPUT_POST, 'vac');

function encode_this($string) {
    $string = utf8_encode($string);
    $control = "qwerty"; //defino la llave para encriptar la cadena, cambiarla por la que deseamos usar
    $string = $control . $string . $control; //concateno la llave para encriptar la cadena
    $string = base64_encode($string); //codifico la cadena
    return($string);
}

/*
  if (!empty($_POST)) {
  $fechaCompraGlobal = $_POST['fechaCompraGlobal'];
  $total = $_POST['totalGlobal'];
  $valid = true;
  if (empty($fechaCompraGlobal)) {
  $fechaCompraGlobalError = "Ingrese la fecha de compra";
  $valid = false;
  }

  if ($valid){
  header("Location: comprarTodo.php?". encode_this('fecha='. $fechaCompraGlobal . '&total=' . $total));
  }
  } */

if (isset($vaciado)) {
    if ($vaciado == 1) {
        $_SESSION["detalle"] = null;
    }
}

if (isset($_REQUEST['uns'])) {
    //Codigo para eliminar articulos del detalle de compra
    $idArr = $_REQUEST['uns'];
    $arreglo = $_SESSION["detalle"];
    unset($arreglo[$idArr]);
    $_SESSION["detalle"] = array_values($arreglo);
}


if (isset($_SESSION["detalle"])) { //Manejo del carrito de productos de la orden, este se utiliza cuando ya existe algo en el carrito
    if (isset($codigoProducto)) {
        $arreglo = $_SESSION["detalle"];
        $encontro = false;
        $numero = 0;
        for ($i = 0; $i < count($arreglo); $i++) {
            if ($arreglo[$i]['id'] == $codigoProducto) {
                $encontro = true;
                $numero = $i;
            }
        }
        if ($encontro == true) {
            $arreglo[$numero]['cantidad'] = $arreglo[$numero]['cantidad'] + $cantidad;
            $_SESSION["detalle"] = $arreglo;
        } else {
            $nombreProducto = "";
            $precioProducto = 0;
            try {
                $pdo = Database::connect();
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $sql = "SELECT id_productos, nombre_prod, precio_prod from productos WHERE id_productos = ?";
                $q = $pdo->prepare($sql);
                $q->execute(array($codigoProducto));
                $data = $q->fetch(PDO::FETCH_ASSOC);
                Database::disconnect();

                $nombreProducto = $data['nombre_prod'];
                $precioProducto = $data['precio_prod'];

                $datosNuevos = ['id' => $codigoProducto,
                    'producto' => $nombreProducto,
                    'precio' => $precioProducto,
                    'cantidad' => $cantidad,
                    'estado' => $estado,
                ];

                array_push($arreglo, $datosNuevos);
                $_SESSION["detalle"] = $arreglo;
            } catch (Exception $ex) {
                echo $ex;
                write_log($ex, "registrarProducto");
            }
        }
    }
} else { //Si el carrito está vacío, lo empieza a llenar
    if (isset($codigoProducto)) {
        try {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT id_productos, nombre_prod, precio_prod from productos WHERE id_productos = ?";
            $q = $pdo->prepare($sql);
            $q->execute(array($codigoProducto));
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();

            $nombreProducto = $data['nombre_prod'];
            $precioProducto = $data['precio_prod'];

            $arreglo[] = [
                "id" => $codigoProducto,
                "producto" => $nombreProducto,
                "precio" => $precioProducto,
                "cantidad" => $cantidad,
                "estado" => $estado,
            ];

            $_SESSION["detalle"] = $arreglo;
        } catch (Exception $ex) {
            echo $ex;
            write_log($ex, "registrarProducto");
        }
    }
}


if (isset($_SESSION["detalle"])) {
    $condicion = "";
    $html = "";
    $datos = $_SESSION["detalle"];
    for ($i = 0; $i < count($datos); $i++) {
        echo '<tr>';
        echo '<td>' . $datos[$i]['producto'] . '</td>';
        echo '<td>' . $datos[$i]['cantidad'] . '</td>';
        echo '<td>' . $datos[$i]['precio'] . '</td>';
        echo '<td>' . $datos[$i]['cantidad'] * $datos[$i]['precio'] . '</td>';
        echo '</tr>';
    }


/*
    foreach ($pdo as $indice => $row) {
        $html .= '<tr>';
        $html .= '<td>' . $row['producto'] . '</td>';
        $html .= '<td>' . $row['cantidad'] . '</td>';
        $html .= '<td>' . $row['precio'] . '</td>';
        $html .= '<td>' . $row['cantidad'] * $row['precio'] . '</td>';
    }
    echo $html;*/
}
?>
