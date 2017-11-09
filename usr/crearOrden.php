<?php
session_start();
if (!isset($_SESSION["cliente_id"]) || $_SESSION["cliente_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}

require_once("../funciones/funcion.php");

require_once ('../funciones/fProductos.php');
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Area de Clientes</title>
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
        <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">


    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <?php
            require ('../includes/head_menu_Cliente.php');
            ?>
            <!-- Left side column. contains the logo and sidebar -->

            <?php
            require ('../includes/left_menuCliente.php');
            ?>


            <div class="content-wrapper">
             <section class="content-header">
                <h1>
                    Solicitud de Orden
                </h1>
            </section>
                <section class="content">
                    <!-- Small boxes (Stat box) -->


                    <div class="row">

                        <div class="col-md-6">
                            <section>

                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Crear Orden</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form role="form" action="../controlador/controllerCrearOrdenCliente.php" method="post">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Mesa:</label>
                                                <select class="form-control select2" style="width: 100%;" name="mesa" id="mesa" required="true">
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
                                                <select class="form-control select2" style="width: 100%;" name="emp" id="emp" required="true">
                                                    <option value="">- Seleccione Empleado-</option>
                                                    <?php
                                                    $empleados = getEmpleados();

                                                    foreach ($empleados as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_empleado'] . ">" . $registro['nombres'] . "-" . $registro['apellidos'] . "</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>  

                                            <div class="form-group">
                                                <label>Tipo Orden:</label>
                                                <select class="form-control select2" style="width: 100%;" name="torden" id="torden" required="true">
                                                    <option value="">- Seleccione-</option>
                                                    <?php
                                                    $tipoOrden = getTiposOrden();

                                                    foreach ($tipoOrden as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_tipoOrd'] . ">" . $registro['tipo_orden'] . "</option>";
                                                    }
                                                    ?>
                                                </select>

                                            </div>  

                                            <div class="form-group">
                                                <label>Estado de la Orden:</label>
                                                <select class="form-control select2" style="width: 100%;" name="estadoOrd" id="estadoOrd" required="true" >
                                                    <option value="1">Pendiente</option>
                                                    
                                                </select>

                                            </div> 

                                            <div class="form-group">
                                                <label>Fecha:</label>

                                                <div class="input-group date">
                                                    <div class="input-group-addon">
                                                        <i class="fa fa-calendar"></i>
                                                    </div>
                                                    <input type="text" class="form-control pull-right" id="fecha" name="fecha">
                                                </div>
                                                <!-- /.input group -->
                                            </div>

                                            <div class="form-group">
                                                <label>Es Cliente</label>
                                                <label>
                                                    <input type="checkbox" class="minimal" name="cliente" value="1">
                                                </label>   
                                            </div>

                                        </div>
                                        <!-- /.box-body -->

                                        <div class="box-footer">
                                            <button type="submit" class="btn btn-primary">Crear</button>
                                            <button type="reset" class="btn btn-danger">Limpiar</button>
                                        </div>

                                    </form>
                                </div>
                            </section>
                        </div> 


                        <div class="col-md-5">
                            <section>
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Detalle Orden</h3>
                                    </div>
                                    <form method="post" id="formulario">
                                        <div class="box-body">
                                            <div class="form-group">
                                                <label>Estado Producto</label>

                                                <select name="cbo_estado" id="cbo_estado" class="col-md-2 form-control" disabled="true">
                                                    <option value="1">Pendiente</option>
                                                </select>
                                            </div>    

                                            <div class="form-group">
                                                <label>Producto:</label>
                                                <select name="cbo_producto" id="cbo_producto" class="col-md-2 form-control" required="true">
                                                    <option value="">- Seleccione-</option>

                                                    <?php
                                                    $productos = getTablaProductos();
                                                    foreach ($productos as $indice => $registro):
                                                        ?>
                                                        <option value="<?php echo $registro['id_productos'] ?>"><?php echo $registro['nombre_prod'] ?></option>
                                                    <?php endforeach; ?>

                                                </select>
                                            </div>  


                                            <div class="form-group">
                                                <label>Cantidad:</label>
                                                <input id="txt_cantidad" name="txt_cantidad" type="text" required="true" class="col-md-2 form-control" placeholder="Ingrese cantidad" autocomplete="off" />
                                            </div>   

                                        </div>    
                                        <div style="margin-top: 19px;">
                                            <button type="button" class="btn btn-success btn-agregar-producto" id="addDetProd">Agregar</button>
                                        </div>
                                    </form>
                                </div>

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
                                                <tbody id="detalleTabla">
                                                    <?php
                                                    if (isset($_SESSION["detalle"])) {
                                                        $datos = $_SESSION["detalle"];
                                                        for ($i = 0; $i < count($datos); $i++) {
                                                            echo '<tr>';
                                                            echo '<td>' . $datos[$i]['producto'] . '</td>';
                                                            echo '<td>' . $datos[$i]['cantidad'] . '</td>';
                                                            echo '<td>' . $datos[$i]['precio'] . '</td>';
                                                            echo '<td>' . $datos[$i]['cantidad'] * $datos[$i]['precio'] . '</td>';
                                                            echo '</tr>';
                                                        }
                                                    } else {
                                                        echo "<div class='panel-body'>No hay productos agregados</div>";
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button type="button" id="vaciarOrden" class="btn btn-sm btn-default guardar-carrito">Vaciar</button>
                                                <button type="submit" class="btn btn-sm btn-default guardar-carrito">Guardar</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </section>
                        </div>




                    </div>


                </section>
                <!-- /.content -->
            </div>


        </div>



        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Sistema Web</b> Oficial
            </div>
            <strong>Derechos Reservados &copy; 2017-2020 <a href="http://almsaeedstudio.com">Senkali</a>.</strong> All rights
            reserved.
        </footer>




        <div class="control-sidebar-bg"></div>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery 2.2.3 -->
    <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="https://code.jquery.com/ui/1.11.4/jquery-ui.min.js"></script>

    <!-- Bootstrap 3.3.6 -->
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <!-- Morris.js charts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="../plugins/morris/morris.min.js"></script>
    <!-- daterangepicker -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="../plugins/daterangepicker/daterangepicker.js"></script>
    <!-- datepicker -->
    <script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Slimscroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="../plugins/fastclick/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <!-- AdminLTE for demo purposes -->
    <script src="../dist/js/demo.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.timepicker/0.2.6/js/bootstrap-timepicker.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#addDetProd').click(function () {
                var estado = $('#cbo_estado').val();
                var codProducto = $('#cbo_producto').val();
                var cantidad = $('#txt_cantidad').val();
                eval = true;
                if (estado === null || estado.length === 0) {
                    eval = false;
                    alert("Debe seleccionar un estado.");
                }
                if (codProducto === null || codProducto.length === 0) {
                    eval = false;
                    alert("Debe seleccionar un producto");
                }
                if (cantidad === null || cantidad.length === 0) {
                    eval = false;
                    alert("Debe ingresar la cantidad");
                }

                if (eval === true) {
                    $.post("ordenHandler.php", {estado: estado, producto: codProducto, cantidad: cantidad}, function (data) {
                        $("#detalleTabla").html(data);
                    });
                }

            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#vaciarOrden').click(function () {
                var vac = 1;

                $.post("ordenHandler.php", {vac: vac}, function (data) {
                    $("#detalleTabla").html(data);
                });
            });
        });
    </script>





    <script>
        $(function () {
            //Initialize Select2 Elements


            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
            });


            //Timepicker
            $(".timepicker").timepicker({
                showInputs: false
            });
        });
    </script>

</body>
</html>

