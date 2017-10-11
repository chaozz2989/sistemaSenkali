<?php

$lstOrden= getOrdenes();

?>


<script>
$(document).on('ready',function(){       
    $('#btn-ingresar').click(function(){
        var url = "../ordenes/edicionOrden.php";
        $.ajax({                        
           type: "POST",
           url: url,
           data: $("#form").serialize(),
           success: function(data)
           {
             $('#resp').html(data);               
           }
       });
    });
});
</script>

<table class="table">
<tr>
  <th  class="danger" >Fecha</th>
  <th class="danger" >Id</th>
   <th class="danger" >Acciones</th>
</tr>
<tr>
  <?php foreach ($lstOrden as $indice => $registro) { ?>
    <tr>
    <td class="info" ><?php echo $registro['fecha']; ?></td>
    <td class="info" ><?php echo $registro['id_ordenes']; ?></td>
    
    <td class="info">
        
     
        <form method="post" id="form" >
            <input type="hidden" name="idOr" value="<?php $registro['id_ordenes']; ?>" />
            <button type="button"   id="btn-ingresar" class="btn btn-danger">Edicion</button>
        </form>
    </td>
    </tr>
  <?php } ?>

</table>


