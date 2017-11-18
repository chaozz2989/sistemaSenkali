<?php
include_once '../funciones/fCategorias.php';
?>
<script language="javascript">
    $(document).ready(function () {
        $("#lst_catProd").change(function () {
            $("#lst_catProd option:selected").each(function () {
                categoria = $(this).val();
                $.post("../productos/subcategorias.php", {categoria: categoria}, function (data) {
                    $("#lst_subcatProd").html(data);
                    console.log(data);

                    $("#lst_subcatProd option:selected").each(function () {
                        subcatProd = $(this).val();
                        $.post("productosSubCat.php", {subcatProd: subcatProd}, function (data) {
                            $("#lst_producto").html(data);
                            console.log(data);
                        });
                    });
                }); //Fin Post
            });//Fin Option
        });//Fin Change
    });
</script>

<script>
    $(document).ready(function () {
        $('#btn_addDetProd').click(function () {
            var codProducto = $('#lst_producto').val();
            var cantidad = $('#txt_cantidad').val();
            eval = true;
            if (codProducto === null || codProducto.length === 0) {
                eval = false;
                alert("Debe seleccionar un producto");
            }
            if (cantidad === null || cantidad.length === 0) {
                eval = false;
                alert("Debe ingresar la cantidad");
            }

            if (eval === true) {
                $.post("ordenHandler.php", {producto: codProducto, cantidad: cantidad}, function (data) {
                    $("#tbl_masProdOrden").html(data);
                    var tot = $('#totalPre').val();
                    $('#totalGlobal').attr('value', tot);
                });
            }

        });
    });
</script>

<script>
    $(document).ready(function () {
        $('#btn_vaciarOrden').click(function () {
            var vac = 1;

            $.post("ordenHandler.php", {vac: vac}, function (data) {
                $("#tbl_masProdOrden").html(data);
            });
        });
    });
</script>

<script>
    function unsetProd(uns) {
        $.post("ordenHandler.php", {uns: uns}, function (data) {
            $("#tbl_masProdOrden").html(data);
        });
    }
</script>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Detalle Orden</h3>
    </div>
    <form method="post" id="formulario">
        <div class="box-body">
            <div class="form-group">
                <label>Categoría</label>

                <select name="lst_catProd" id="lst_catProd" class="col-md-2 form-control" required="true">
                    <option value="">-Seleccione-</option>

                    <?php
                    $categorias = getCategorias();
                    foreach ($categorias as $indice => $registro) {
                        echo "<option value=" . $registro['id_categoria'] . ">" . $registro['nombre'] . "</option>";
                    }
                    ?>

                </select>
            </div>

            <div class="form-group">
                <label for="subcatProd">SubCategoría del Producto</label>
                <select class="col-md-2 form-control" style="width: 100%;" name="lst_subcatProd" id="lst_subcatProd" required="true">
                    <option value="">-Seleccione una SubCategoría-</option>
                </select>
            </div>

            <div class="form-group">
                <label>Producto:</label>
                <select name="lst_producto" id="lst_producto" class="col-md-2 form-control" required="true">
                    <option value="">- Seleccione-</option>
                </select>
            </div>
            <div class="form-group">
                <label>Cantidad:</label>
                <input id="txt_cantidad" name="txt_cantidad" class="col-md-2 form-control" placeholder="Ingrese cantidad" 
                       min="1" max="50" step="1" type="number" required="true"/>
            </div>   

        </div>    
        <div style="margin-top: 19px;">
            <button type="button" class="btn btn-success btn-agregar-producto" id="btn_addDetProd">Agregar</button>
        </div>

    </form>
</div>


<!--***********************SECCIÓN CARRITO******************************-->
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">Productos</h3>
    </div>
    <form action="../ordenes/agregarProductosOrden.php" method="post">
        <input type="hidden" name="idOrden" id="idOrden" value="<?php echo $idOrden;?>">
        <div class="panel-body detalle-producto" id="resp">

            <table class="table">
                <thead>
                    <tr>
                        <th>Descripci&oacute;n</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbl_masProdOrden">

                    <?php
                    $totalGlobal = 0;
                    if (isset($_SESSION["detalle"])) {
                        $datos = $_SESSION["detalle"];
                        for ($i = 0; $i < count($datos); $i++) {
                            echo '<tr>';
                            echo '<td>' . $datos[$i]['producto'] . '</td>';
                            echo '<td>' . $datos[$i]['cantidad'] . '</td>';
                            echo '<td>' . $datos[$i]['precio'] . '</td>';
                            echo '<td>' . $datos[$i]['cantidad'] * $datos[$i]['precio'] . '</td>';
                            echo '<td>';
                            echo '<a class="btn btn-danger" onclick="unsetProd(' . $i . ')">Quitar</a>';
                            echo '</td>';
                            echo '</tr>';
                            $totalGlobal += ($datos[$i]['cantidad'] * $datos[$i]['precio']);
                        }
                        echo "<tr><td colspan=5><h2>TOTAL: $" . $totalGlobal . "</h2><input type='hidden' id='totalPre' name='totalPre' value='" . $totalGlobal . "'></td></tr>";
                    } else {
                        echo "<tr><td colspan=5>No hay productos agregados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" id="btn_vaciarOrden" class="btn btn-sm btn-default guardar-carrito">Vaciar</button>
                <button type="submit" class="btn btn-sm btn-default guardar-carrito">Agregar a la Orden</button>
            </div>
        </div>
    </form>
</div>
<!--***********************SECCIÓN CARRITO******************************-->