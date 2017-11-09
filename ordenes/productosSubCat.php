<?php
require '../funciones/quitaTildes.php';
require_once '../funciones/fProductos.php';
$subCat = filter_input(INPUT_POST, 'subcatProd');

if (isset($subCat)) {
    $arr = null;
    $opciones = null;
    
    try {
        $arr = getListadoProductoPorTipos($subCat);
        foreach ($arr as $indice => $registro) {
            $nombre = $registro['nombre_prod'];
            $nombre = reemplazarTildes($nombre);
            echo "<option value=" . $registro['id_productos']. ">" . $nombre . "</option>";
        }
    } catch (Exception $ex) {
        echo "<option value=0>-- Seleccione una SubCategoría --</option>";
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }
}
?>