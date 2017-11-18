<?php

require_once '../conexion/conexion.php';
require '../funciones/quitaTildes.php';
require_once '../funciones/fSubCategorias.php';
$categoria = filter_input(INPUT_POST, 'categoria');
$subCat = filter_input(INPUT_POST, 'subcategoria'); //esta se usa cuando se va a modificar un producto seleccionado

if (isset($categoria)) {
    $sql = getSubCatPorIdCat($categoria);
    foreach ($sql as $indice => $registro) {
        $nombre = $registro['nombre'];
        $nombre = reemplazarTildes($nombre);
        echo "<option value=" . $registro['id_subcategoria'];
        if (isset($subCat)) {
            if ($subCat == $registro['id_subcategoria']) {
                echo " selected='true' ";
            }
        }
        echo ">" . $nombre . "</option>";
    }
}
?>