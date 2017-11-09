<?php
$r = getTablaProductos();
require_once '../funciones/utils.php';
?>

<table class="table table-bordered table-hover">
    <thead>
    <th>Producto</th>
    <th>SubCategoría</th>	
    <th>Precio</th>	
    <th></th>
</thead>

<?php foreach ($r as $row => $registro) { ?>
    <tr>
        <td><?php echo $registro["nombre_prod"]; ?></td>
        <td><?php echo $registro["subCate"]; ?></td>
        <td><?php echo $registro["precio_prod"]; ?></td>
        <td style="width:150px;">
            <a href="../productos/editProducto.php?<?php echo encode_this('idProd=' . $registro["id_productos"]); ?>" class="btn btn-sm btn-warning">Editar</a>
        </td>
    </tr>
<?php } ?>

</table>
<?php if (!isset($r)) { ?>
    <p class="alert alert-warning">No hay resultados</p>
<?php } ?>
