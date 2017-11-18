<?php
$r = getEmpleados();
require_once '../funciones/utils.php';
?>

<table class="table table-bordered table-hover">
    <thead>
    <th>Cod. Empleado</th>
    <th>Nombres</th>
    <th>Apellidos</th>
    <th>DUI</th>
    <th>NIT</th>
    <th>Dirección</th>
    <th>Telefono</th>
    <th>Correo</th>
    <th>Sucursal asignada</th>	
    <th>Rol</th>	
    <th>Usuario</th>
    <th>Clave</th>
    <th>Estado</th>
</thead>

<?php
foreach ($r as $row => $registro) {
    ?><tr>
        <td><?php echo $registro["id_empleado"]; ?></td>
        <td><?php echo $registro["nombres"]; ?></td>
        <td><?php echo $registro["apellidos"]; ?></td>
        <td><?php echo $registro["dui"]; ?></td>
        <td><?php echo $registro["nit"]; ?></td>
        <td><?php echo $registro["direccion"]; ?></td>
        <td><?php echo $registro["telefono"]; ?></td>
        <td><?php echo $registro["email"]; ?></td>
        <td><?php echo $registro["id_sucursal"]; ?></td>
        <td><?php echo $registro["id_rol"]; ?></td>
        <td><?php echo $registro["usu_empleado"]; ?></td>
        <td><?php echo $registro["clave_empleado"]; ?></td>
        <td><?php echo $registro["id_estadoUsuario"]; ?></td>
       
        <td style="width:150px;">
            <a href="../empleados/editEmpleado.php?<?php echo encode_this('idEmp='.$registro["id_empleado"]); ?>" class="btn btn-sm btn-warning">Editar</a>
        </td></tr>
<?php } ?>

</table>
<?php if (!isset($r)) { ?>
    <p class="alert alert-warning">No hay resultados</p>
<?php } ?>
