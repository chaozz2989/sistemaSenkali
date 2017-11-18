<?php
require_once '../funciones/utils.php';
$tabla = getListaCompletaSubCat();
?>
<table class="table table-bordered table-hover">
    <thead>
    <th>Categoría</th>
    <th>SubCategoría</th>	
    <th>Estado</th>
    <th></th>
</thead>

<?php foreach ($tabla as $row => $registro) { ?><tr>
        <td><?php echo $registro["nombreCat"]; ?></td>
        <td><?php echo $registro["nombre"]; ?></td>
        <td><?php if ($registro["estado"] == 0): echo "Inactiva"; else: echo "Activa"; endif; ?></td>
        <td style="width:150px;">
            <a href="../mantenimiento/editSubCat.php?<?php echo encode_this('idSubCat=' . $registro["id_subcategoria"]); ?>" class="btn btn-sm btn-warning">Editar</a>
        </td></tr>
<?php } ?>

</table>
<?php if (!isset($tabla)) { ?>
    <p class="alert alert-warning">No hay resultados</p>
<?php } ?>