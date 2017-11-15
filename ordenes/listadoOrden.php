<?php
$lstOrden = getListadoOrdenes(TRUE);
require_once '../funciones/utils.php';
?>

<table class="table">
    <thead>
    <th class="danger" >Codigo de Orden</th>
    <th class="danger" >Mesa</th>
    <th class="danger" >Estado</th>
    <th class="danger" ></th>
</thead>
<?php foreach ($lstOrden as $indice => $registro) { ?>
    <tr>
        <td class="info" ><?php echo $registro['codigo_orden']; ?></td>
        <td class="info" ><?php echo $registro['cod_mesa']; ?></td>
        <td class="info" ><?php echo $registro['estado']; ?></td>
        <td style="width:150px;">
            <a href="../ordenes/edicionOrden.php?<?php echo encode_this('idOr=' . $registro["id_ordenes"]); ?>" class="btn btn-info">Ver Orden</a>
        </td>
    </tr>
<?php } ?>

</table>


