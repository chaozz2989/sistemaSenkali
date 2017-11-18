<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
//$_SESSION['detalle'] = array();
require_once('../funciones/fOrdenes.php');
require_once ('../funciones/funcion.php');
require_once ('../funciones/fProductos.php');
require_once ('../funciones/fClientes.php');
require_once ('../funciones/fCategorias.php');

date_default_timezone_set('America/El_Salvador');
/* $objFuncion = new Funcion();
  $resultadoFuncion = $objFuncion->get();
  $ordenes=$objFuncion->comboEstadoOrden(); */
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Area de Administracion</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.6 -->
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
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


    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php
            //MENU
            require_once('../includes/head_menu.php');
            ?>  


            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <?php
                //MENU
                require_once('../includes/left_menu.php');
                ?>  
                <!-- /.sidebar -->
            </aside>


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Area de Administracion
                        <small>Control panel</small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->


                    <div class="row">
                        <!-- Left col -->
                        <div class="col-md-12">
                            <!-- Trigger the modal with a button -->
                            <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal"> Ver Ordenes Pendientes</button>

                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Ordenes Pendientes</h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php
                                            //Table
                                            require_once('../ordenes/listadoOrden.php');
                                            ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>

                                </div>
                            </div> 
                        </div> 
                        <br><br><br><br>
                        <div class="col-md-6">
                            <section>

                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Nueva Orden</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form role="form" action="../ordenes/guardarDetOrden.php" method="post">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Mesa:</label>
                                                <select class="form-control select2" style="width: 100%;" name="lst_mesa" id="lst_mesa" required="true">
                                                    <option value="">- Seleccione una mesa-</option>
                                                    <?php
                                                    $mesas = getMesas();

                                                    foreach ($mesas as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_mesa'] . ">" . $registro['cod_mesa'] . "</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>

                                            <div class="form-group">
                                                <label>Empleado:</label>
                                                <select class="form-control select2" style="width: 100%;" name="lst_emp" id="lst_emp" required="true">
                                                    <option value="">- Seleccione Empleado-</option>
                                                    <?php
                                                    $empleados = getEmpleados();

                                                    foreach ($empleados as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_empleado'] . " ";
                                                        if ($registro['id_empleado'] == $_SESSION['user_id']) {
                                                            echo "selected = true";
                                                        }
                                                        echo ">" . $registro['nombres'] . "-" . $registro['apellidos'] . "</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>  

                                            <div class="form-group">
                                                <label>Tipo Orden:</label>
                                                <select class="form-control select2" style="width: 100%;" name="lst_tipoOrd" id="lst_tipoOrd" required="true">
                                                    <option value="">- Seleccione-</option>
                                                    <?php
                                                    $tipoOrden = getTiposOrden();

                                                    foreach ($tipoOrden as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_tipoOrd'];
                                                        if ($registro['id_tipoOrd'] == 1)
                                                            echo ' selected=true';
                                                        echo ">" . $registro['tipo_orden'] . "</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>  

                                            <div class="form-group">
                                                <label>Estado de la Orden:</label>
                                                <select class="form-control select2" style="width: 100%;" name="lst_estOrd" id="lst_estOrd" required="true" disabled="true" >
                                                    <option value="">- Seleccione-</option>
                                                    <?php
                                                    $estadoOrd = getEstadosOrden();
                                                    foreach ($estadoOrd as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_estadosOrden'];
                                                        if ($registro['id_estadosOrden'] == 1) {
                                                            echo ' selected = true';
                                                        }
                                                        echo ">" . $registro['estado'] . "</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div> 

                                            <div class="form-group">
                                                <label>Fecha:</label>
                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" id="date_fechaOrd" name="date_fechaOrd" 
                                                           value="<?php echo date('m/d/Y'); ?>" >
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <label>Hora:</label>
                                                <div class="input-group">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                    <input type="text" class="form-control timepicker" id="time_horaOrd" name="time_horaOrd" 
                                                           value="<?php echo date("h:i a"); ?>" >
                                                    <!-- /.input group -->
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Es Cliente: </label>
                                                <label>
                                                    <input type="checkbox" class="minimal" name="chk_esCliente" id="chk_esCliente" value="1" onclick="mostrarClientes();" checked>
                                                </label>   
                                            </div>

                                            <div class="form-group" id="listadoClientes">
                                                <label>Cliente: </label>
                                                <select name="lst_cliente" id="lst_cliente" class="form-control select2" required="true">
                                                    <option value="">- Seleccione-</option>
                                                    <?php
                                                    $cliente = getClientes();
                                                    foreach ($cliente as $indice => $registro):
                                                        ?>
                                                        <option value="<?php echo $registro['id_clientes'] ?>"><?php echo $registro['nombre'] . ' ' . $registro['apellido']; ?></option>
                                                    <?php endforeach; ?>

                                                </select>
                                            </div>

                                        </div>
                                        <!-- /.box-body -->
                                        <input type="hidden" id="totalGlobal" name="totalGlobal" >
                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">Crear</button>
                                            <button type="reset" name="reset" id="reset" class="btn btn-danger">Limpiar</button>
                                        </div>

                                    </form>
                                </div>
                            </section>
                        </div> 

                        <div class="col-md-5">

                            <!--***********************SECCIÓN DETALLE DE ORDEN******************************-->
                            <section>
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
                                                       min="1" max="50" step="1" data-bind="value: replyNumber " type="number" data-fv-integer-message="El valor no es un numero entero." required="true"/>
                                            </div>   

                                        </div>    
                                        <div style="margin-top: 19px;">
                                            <button type="button" class="btn btn-success btn-agregar-producto" id="btn_addDetProd">Agregar</button>
                                        </div>
                                        
                                    </form>
                                </div>
                            <!--***********************SECCIÓN DETALLE DE ORDEN******************************-->
                            
                            <!--***********************SECCIÓN CARRITO******************************-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Productos</h3>
                                    </div>
                                    <form action="../ordenes/guardarDetOrden.php" method="post">
                                        <div class="panel-body detalle-producto"  id="resp">

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
                                                <tbody id="tbl_detalleOrden">

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
                                                <!--<button type="submit" class="btn btn-sm btn-default guardar-carrito">Guardar</button>-->
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <!--***********************SECCIÓN CARRITO******************************-->
                            </section>
                            
                        </div>

                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <?php include_once '../includes/footer.php'; ?>

            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->


<!--Este Script funciona para agregar los productos al carrito-->
        <script>
            $(document).ready(function () {
                $('#btn_addDetProd').click(function () {
                    var codProducto = $('#lst_producto').val();
                    var cantidad = $('#txt_cantidad').val();
                    eval = true;
                    if (codProducto === null || codProducto.length === 0) {
                        eval = false;
                        alert("Debe seleccionar un producto");
                        document.getElementById("txt_cantidad").value = 1;
                    }
                    if (cantidad === null || cantidad.length === 0) {
                        eval = false;
                        alert("Debe ingresar la cantidad");
                    }

                    if (eval === true) {
                        $.post("ordenHandler.php", {producto: codProducto, cantidad: cantidad}, function (data) {
                            $("#tbl_detalleOrden").html(data);
                            var tot = $('#totalPre').val();
                            $('#totalGlobal').attr('value', tot);
                            document.getElementById("txt_cantidad").value = 1;
                        });
                    }

                });
            });
        </script>

<!--Script que vacia el carrito completamente-->
        <script>
            $(document).ready(function () {
                $('#btn_vaciarOrden').click(function () {
                    var vac = 1;
                    $.post("ordenHandler.php", {vac: vac}, function (data) {
                        $("#tbl_detalleOrden").html(data);
                    });
                });
            });
        </script>

<!--Script que quita elementos del carrito-->
        <script>
            function unsetProd(uns) {
                $.post("ordenHandler.php", {uns: uns}, function (data) {
                    $("#tbl_detalleOrden").html(data);
                });
            }
        </script>

<!--Scripts para hacer que se muestre el calendario y la hora-->
        <script>
            $(function () {
                //TimePicker
                $('.timepicker').timepicker({
                    showInputs: false
                });

                //Date picker
                $('#date_fechaOrd').datepicker({
                    autoclose: true
                });

                //Select2
                $(".select2").select2();
            });
        </script>

<!--Script que realiza el filtro para mostrar las SUBCATEGORIAS cuando se selecciona una CATEGORIA-->
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

<!--Script que realiza el filtro para mostrar los PRODUCTOS cuando se selecciona una SUBCATEGORIA-->
        <script language="javascript">
            $(document).ready(function () {
                $("#lst_subcatProd").change(function () {
                    $("#lst_subcatProd option:selected").each(function () {
                        subcatProd = $(this).val();
                        $.post("productosSubCat.php", {subcatProd: subcatProd}, function (data) {
                            $("#lst_producto").html(data);
                            console.log(data);
                        });
                    });
                });
            });
        </script>

<!--Script que sirve para mostrar u ocultar el listado de clientes-->
        <script type="text/javascript">
            function mostrarClientes() {
                //Si la opcion con de que ES CLIENTE está activa, mostrará y obligará la selección de un cliente de la lista
                if (document.getElementById('chk_esCliente').checked) {
                    //muestra el div que contiene la lista de clientes
                    document.getElementById('listadoClientes').style.display = 'initial';
                    document.getElementById('lst_cliente').required = true;
                    //por el contrario, si no esta seleccionada
                } else {
                    //oculta el div que contiene la lista de clientes
                    document.getElementById('listadoClientes').style.display = 'none';
                    document.getElementById('lst_cliente').required = false;
                }
            }
        </script>
        
<!--Script que evalua que no se ingresen datos mayores ni menores a los establcidos en la CANTIDAD DE PRODUCTOS-->
        <script>
        $("#txt_cantidad").focusout(function () {
            var cantidad = parseFloat($('#txt_cantidad').val());

            if(cantidad < 0){
                document.getElementById('txt_cantidad').value = 1;
            } else if(cantidad > 50){
                document.getElementById('txt_cantidad').value = 50;
            }
            
            if(cantidad %1 != 0){
                document.getElementById('txt_cantidad').value = parseInt(cantidad);
            }
        });
        </script>
        
        <script>
        $("#reset").click(function () {
            var vac = 1;
            $.post("ordenHandler.php", {vac: vac}, function (data) {
                $("#tbl_detalleOrden").html(data);
            });
            window.location='crearOrden.php';
        });
        </script>
    </body>
</html>
