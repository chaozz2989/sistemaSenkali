<?php

require_once '../conexion/conexion.php';
require '../funciones/quitaTildes.php';
$categoria = filter_input(INPUT_POST, 'categoria');
$subCat = filter_input(INPUT_POST, 'subcategoria'); //esta se usa cuando se va a modificar un producto seleccionado

if (isset($categoria)) {
    $arr = null;
    $opciones = null;
    $pdo = Database::connect();
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = "select * from subcategorias where id_categoria = $categoria";
    try {
        $q = $pdo->prepare($sql);
        $q->execute();
        $arr = $q->fetchAll();
        Database::disconnect();
        foreach ($arr as $indice => $registro) {
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

        //echo $opciones;
    } catch (PDOException $e) {
        echo "<option value=1>-- Seleccione una SubCategoría --</option>";
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }
}
?>