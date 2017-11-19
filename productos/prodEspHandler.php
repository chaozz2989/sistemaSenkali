<?php
session_start();
include_once '../funciones/fIngredientes.php';

$codigoIngrediente = filter_input(INPUT_POST, 'codIngrediente');
$vaciado = filter_input(INPUT_POST, 'vac');
$uns = filter_input(INPUT_POST, 'uns');
$cantidad = 1;

if (isset($vaciado)) {
    if ($vaciado == 1) {
        $_SESSION["especialidad"] = null;
    }
}

if (isset($uns)) {
    //Codigo para eliminar ingredientes del carrito de especialidades
    $idArr = $_REQUEST['uns'];
    $arreglo = $_SESSION["especialidad"];
    unset($arreglo[$idArr]);
    $_SESSION["especialidad"] = array_values($arreglo);
    //print "<script>window.location='crearOrden.php';</script>";
}

if (isset($_SESSION["especialidad"])) { //Manejo del carrito de ingredientes de especialidades, este se utiliza cuando ya existe algo en el carrito
    if (isset($codigoIngrediente)) {
        $arreglo = $_SESSION["especialidad"];
        $encontro = false;
        $numero = 0;
        for ($i = 0; $i < count($arreglo); $i++) {
            if ($arreglo[$i]['id'] == $codigoIngrediente) {
                $encontro = true;
                $numero = $i;
            }
        }
        if ($encontro == true) {
            /*$arreglo[$numero]['cantidad'] = $arreglo[$numero]['cantidad'] + $cantidad;*/
            $_SESSION["especialidad"] = $arreglo;
        } else {
            try {
                $data = getIngredientePorId($codigoIngrediente);

                $nombreIngrediente = $data['ingrediente'];
                $precioIngrediente = $data['costo'];
                
                $datosNuevos = [
                    "id" => $codigoIngrediente,
                    "ingrediente" => $nombreIngrediente,
                    "costo" => $precioIngrediente,
                    "cantidad" => $cantidad,
                ];

                array_push($arreglo, $datosNuevos);
                $_SESSION["especialidad"] = $arreglo;
            } catch (Exception $ex) {
                echo $ex;
                write_log($ex, "Carrito de Ingredientes");
            }
        }
    }
} else { //Si el carrito está vacío, lo empieza a llenar
    if (isset($codigoIngrediente)) {
        try {
            $data = getIngredientePorId($codigoIngrediente);

            $nombreIngrediente = $data['ingrediente'];
            $precioIngrediente = $data['costo'];

            $arreglo[] = [
                "id" => $codigoIngrediente,
                "ingrediente" => $nombreIngrediente,
                "costo" => $precioIngrediente,
                "cantidad" => $cantidad,
            ];

            $_SESSION["especialidad"] = $arreglo;
        } catch (Exception $ex) {
            echo $ex;
            write_log($ex, "Carrito de Ingredientes");
        }
    }
}


if (isset($_SESSION["especialidad"])) {

    $datos = $_SESSION["especialidad"];
    $totalGlobal = 0;
    for ($i = 0; $i < count($datos); $i++) {
        echo '<tr>';
        echo '<td>' . $datos[$i]['ingrediente'] . '</td>';
        echo '<td>' . $datos[$i]['cantidad'] . '</td>';
        echo '<td>' . $datos[$i]['costo'] . '</td>';
        echo '<td>';
        echo '<a class="btn btn-danger" onclick="unsetIng(' . $i . ')">Quitar</a>';
        echo '</td>';
        echo '</tr>';
        $totalGlobal += ($datos[$i]['cantidad'] * $datos[$i]['costo']);
    }
    echo "<tr><td colspan=5><h2>Costo Total: $" . $totalGlobal . "</h2><input type='hidden' id='totalIng' name='totalIng' value='" . $totalGlobal . "'></td></tr>";
} else {
    echo "<tr><td colspan=5>No hay ingredientes agregados.<input type='hidden' id='totalIng' name='totalIng' value='0'></td></tr>";
}