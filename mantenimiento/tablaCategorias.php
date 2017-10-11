<?php
require_once '../funciones/utils.php';
$tabla = getCategorias();
?>
<table class="table table-bordered table-hover">
    <thead>
    <th>ID Categoría</th>
    <th>Categoría</th>	
    <th></th>
</thead>

<?php foreach ($tabla as $row => $registro) { ?><tr>
        <td><?php echo $registro["id_categoria"]; ?></td>
        <td><?php echo $registro["nombre"]; ?></td>
        <td style="width:150px;">
            <a href="../mantenimiento/editCategoria.php?<?php echo encode_this('idCat=' . $registro["id_categoria"]); ?>" class="btn btn-sm btn-warning">Editar</a>
        </td></tr>
<?php } ?>

</table>
<?php if (!isset($tabla)) { ?>
    <p class="alert alert-warning">No hay resultados</p>
<?php } ?>