<?php
require_once '../funciones/utils.php';
$tabla = getIngredientes();
$dispo = "";
?>
<table class="table table-bordered table-hover">
    <thead>
    <th>N° Ingrediente</th>
    <th>Ingrediente</th>	
    <th>Costo</th>
    <th>Disponibilidad</th>
</thead>

<?php foreach ($tabla as $row => $registro) { ?><tr>
        <td><?php echo $registro["id_ingrediente"]; ?></td>
        <td><?php echo $registro["ingrediente"]; ?></td>
        <td><?php echo $registro["costo"]; ?></td>
        <?php

                                                    if ($registro["disponibilidad"] == 1) {
                                                            $dispo="SI";
                                                            
                                                        }else {
                                                            $dispo="NO";
                                                        }
                                                       ?>
         

        <td><?php echo $dispo ?></td>
       
        
        <td style="width:150px;">
            <a href="../mantenimiento/editIngrediente.php?<?php echo encode_this('id_ing=' . $registro["id_ingrediente"]); ?>" class="btn btn-sm btn-warning">Editar</a>
        </td></tr>
<?php } ?>

</table>
<?php if (!isset($tabla)) { ?>
    <p class="alert alert-warning">No hay resultados</p>
<?php } ?>