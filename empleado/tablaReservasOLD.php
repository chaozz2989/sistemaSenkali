<?php
$r = getTablaReserva();
?>

<table class="table table-bordered table-hover">
    <thead>
    <th>Codigo Reserva</th>
    <th>Descripcion</th>
    <th>Fechas</th>	
    <th>Estado</th>	
    <th></th>
</thead>

<?php
foreach ($r as $row => $registro) {
    ?><tr>
        <td><?php echo $registro["codigo_reserva"]; ?></td>
        <td><?php echo $registro["descripcion"]; ?></td>
        <td><?php echo $registro["fecha"]; ?></td>
        <td><?php echo $registro["estado_reserva"]; ?></td>
        <td style="width:150px;">
            <a href="../empleado/editEmpleado.php?id_reservas=<?php echo $registro["id_reservas"]; ?>" class="btn btn-sm btn-warning">Editar</a>
        </td></tr>
<?php } ?>

</table>
<?php if (!isset($r)) { ?>
    <p class="alert alert-warning">No hay resultados</p>
<?php } ?>
