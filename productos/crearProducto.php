<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
require_once ('../conexion/conexion.php');
require_once ('../funciones/fProductos.php');
//include_once "../funciones/funcion.php";
require_once ('../funciones/fCategorias.php');
require_once ('../funciones/fIngredientes.php');

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-type" content="text/html" charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Productos</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
           folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="../plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="../plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="../plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php
            //MENU
            require_once('../includes/head_menu.php');
            ?>  

            <?php
            //MENU
            require_once('../includes/left_menu.php');
            ?>  

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Productos
                        <small>Nuevo Producto</small>
                    </h1>
                </section>
                
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    
                    <div class="row">

                        <div class="col-md-12">
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Ver Listado de Productos</button>

                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Listado de Productos</h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <?php include "tablaProductos.php"; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                        <!-- Left col -->
                        <section>
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Registrar el Nuevo Producto</h3>
                                </div>

                                <form role="form" action="../productos/guardarDetProd.php" method="post" onsubmit="return validarEspecialidad();">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="nombreProd">Nombre del Producto</label>
                                            <input type="text" class="form-control" id="nombreProd" name="nombreProd" placeholder="Nombre del Nuevo Producto" required="true">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="precioProd">Precio del Producto</label>
                                            <input type="text" class="form-control" id="precioProd" name="precioProd" placeholder="Precio del Producto" required="true">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="catProd">Categoría del Producto</label>
                                            <select class="form-control select2" style="width: 100%;" name="catProd" id="catProd" required="true">
                                                <option value="">-Seleccione una Categoría-</option>
                                                <?php
                                                $cate = getCategorias();

                                                foreach ($cate as $indice => $registro) {
                                                    echo "<option value=" . $registro['id_categoria'] . ">" . $registro['nombre'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="subcatProd">SubCategoría del Producto</label>
                                            <select class="form-control select2" style="width: 100%;" name="subcatProd" id="subcatProd" required="true">
                                                <option value="">-Seleccione una SubCategoría-</option>
                                            </select>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Es producto especial?</label>
                                            <label>
                                                <input type="checkbox" class="minimal" name="chkProdEspecial" id="chkProdEspecial" value="1" onclick="mostrarIngredientes();">
                                            </label> 
                                        </div>
                                        
                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary" >Guardar</button>
                                        <button type="reset" class="btn btn-danger">Limpiar</button>
                                    </div>
                                </form>
                            </div>
                        </section>
                        </div>
                        
                        <div class="col-md-5">
                            <!--***********************SECCIÓN DETALLE DE INGREDIENTES******************************-->
                            <section id="addIngredientes" hidden>
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Ingredientes</h3>
                                    </div>
                                    <form method="post" id="formulario">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Ingrediente</label>

                                                <select name="lst_ingredientes" id="lst_ingredientes" class="col-md-2 form-control" required="true">
                                                    <option value="">-Seleccione-</option>

                                                    <?php
                                                    $ingredientes = getIngredientesDisponibles();
                                                    foreach ($ingredientes as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_ingrediente'] . ">" . $registro['ingrediente'] . "</option>";
                                                    }
                                                    ?>

                                                </select>
                                            </div>

                                        </div>    
                                        <div style="margin-top: 19px;">
                                            <button type="button" class="btn btn-success btn_addIngrediente" id="btn_addIngrediente">Agregar</button>
                                        </div>
                                        
                                    </form>
                                </div>
                            <!--***********************SECCIÓN DETALLE DE ORDEN******************************-->
                            
                            <!--***********************SECCIÓN CARRITO******************************-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Ingredientes del Producto</h3>
                                    </div>
                                    <form action="#" method="post">
                                        <div class="panel-body detalle-producto"  id="resp">

                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Ingrediente</th>
                                                        <th>Cantidad</th>
                                                        <th>Costo</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tbl_detalleIngredientes">

                                                    <?php
                                                    $totalGlobal = 0;
                                                    if (isset($_SESSION["especialidad"])) {
                                                        $datos = $_SESSION["especialidad"];
                                                        for ($i = 0; $i < count($datos); $i++) {
                                                            echo '<tr>';
                                                            echo '<td>' . $datos[$i]['ingrediente'] . '</td>';
                                                            echo '<td>' . $datos[$i]['cantidad'] . '</td>';
                                                            echo '<td>' . $datos[$i]['costo'] . '</td>';
                                                            echo '<td>';
                                                            echo '<a class="btn btn-danger" onclick="unsetIng(' . $i . ')">Quitar</a>';
                                                            echo '</td>';
                                                            echo '</tr>';
                                                            $totalGlobal += ($datos[$i]['cantidad'] * $datos[$i]['costo']);
                                                        }
                                                        echo "<tr><td colspan=5><h2>Costo Total: $" . $totalGlobal . "</h2><input type='hidden' id='totalIng' name='totalIng' value='" . $totalGlobal . "'></td></tr>";
                                                    } else {
                                                        echo "<tr><td colspan=5>No hay ingredientes agregados<input type='hidden' id='totalIng' name='totalIng' value='0'></td></tr>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="button" id="btn_vaciarIng" class="btn btn-sm btn-default">Vaciar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <!--***********************SECCIÓN CARRITO******************************-->
                            </section>
                            
                        </div>
                    </div>
                </section>
            </div>
            <!-- /.content-wrapper -->
            
            <?php include '../includes/footer.php';?>
            
            <div class="control-sidebar-bg"></div>
        </div>




        <!-- jQuery 2.2.3 -->
        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- Select2 -->
        <script src="../plugins/select2/select2.full.min.js"></script>
        <!-- InputMask -->
        <script src="../plugins/input-mask/jquery.inputmask.js"></script>
        <script src="../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="../plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <!-- date-range-picker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
        <script src="../plugins/daterangepicker/daterangepicker.js"></script>
        <!-- bootstrap datepicker -->
        <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
        <!-- bootstrap color picker -->
        <script src="../plugins/colorpicker/bootstrap-colorpicker.min.js"></script>
        <!-- bootstrap time picker -->
        <script src="../plugins/timepicker/bootstrap-timepicker.min.js"></script>
        <!-- SlimScroll 1.3.0 -->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- iCheck 1.0.1 -->
        <script src="../plugins/iCheck/icheck.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../dist/js/demo.js"></script>

        <script language="javascript">
            $(document).ready(function(){
               $("#catProd").change(function () {
                       $("#catProd option:selected").each(function () {
                        categoria=$(this).val();
                        $.post("subcategorias.php", { categoria: categoria }, function(data){
                        $("#subcatProd").html(data);
                        });
                    });
               });
            });
        </script>

<!--Script que evalua si es un producto especial, de ser asi muestra el menu para agregar ingredientes-->
        <script type="text/javascript">
            function mostrarIngredientes() {
                //Si la opcion ESPECIALIDAD está activa, mostrará y obligará la selección de al menos un ingrediente.
                if (document.getElementById('chkProdEspecial').checked) {
                    //muestra la seccion que contiene la lista de ingredientes
                    document.getElementById('addIngredientes').style.display = 'initial';
                    //por el contrario, si no esta seleccionada
                } else {
                    //Vacia el carrito de ingredientes
                    var vac = 1;
                    $.post("prodEspHandler.php", {vac: vac}, function (data) {
                        $("#tbl_detalleIngredientes").html(data);
                    });
                    //oculta el div que contiene la lista de clientes
                    document.getElementById('addIngredientes').style.display = 'none';
                    $('#btn_vaciarIng').click(function () {
                    
                });
                }
            }
        </script>

<!--Script que vacia el carrito de ingredientes completamente-->
        <script>
            $(document).ready(function () {
                $('#btn_vaciarIng').click(function () {
                    var vac = 1;
                    $.post("prodEspHandler.php", {vac: vac}, function (data) {
                        $("#tbl_detalleIngredientes").html(data);
                    });
                });
            });
        </script>

<!--Script que quita elementos del carrito de ingredientes -->
        <script>
            function unsetIng(uns) {
                $.post("prodEspHandler.php", {uns: uns}, function (data) {
                    $("#tbl_detalleIngredientes").html(data);
                });
            }
        </script>
        
        
<!--Este Script funciona para agregar los ingredientes del producto al carrito-->
        <script>
            $(document).ready(function () {
                $('#btn_addIngrediente').click(function () {
                    var codIngrediente = $('#lst_ingredientes').val();
                    eval = true;
                    if (codIngrediente === null || codIngrediente.length === 0) {
                        eval = false;
                        alert("Debe seleccionar un ingrediente");
                    }
                    
                    if (eval === true) {
                        var prevTot = $('#totalIng').val();
                        $.post("prodEspHandler.php", {codIngrediente: codIngrediente}, function (data) {
                            $("#tbl_detalleIngredientes").html(data);
                            var tot = $('#totalIng').val();
                            $('#totalGlobal').attr('value', tot);
                            if (prevTot == tot){
                                alert('El ingrediente ya esta agregado!');
                            }
                        });
                    }

                });
            });
        </script>
            
        <script>
            function validarEspecialidad() {
                var continuar = true;

                if (document.getElementById('chkProdEspecial').checked) {
                    //muestra el div que contiene la lista de clientes
                    var totalCostoIng = document.getElementById('totalIng').value;
                    if (totalCostoIng <= 0 || totalCostoIng==null || isNaN(totalCostoIng)){
                        continuar = false;
                        
                        $('#lst_ingredientes').focus();
                    }
                }
                if (continuar == false){
                    if(event.preventDefault){
                        event.preventDefault();
                    }else{
                        event.returnValue = false; // for IE as dont support preventDefault;
                    }
                    alert("Debe agregar ingredientes a la Especialidad.");
                }
                
                return continuar;
            }
        </script>
    </body>
</html>