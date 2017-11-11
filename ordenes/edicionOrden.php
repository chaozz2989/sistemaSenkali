<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
//$_SESSION['detalle'] = array();
require_once ('../funciones/fOrdenes.php');
require_once ('../funciones/funcion.php');
require_once ('../funciones/utils.php');

date_default_timezone_set('America/El_Salvador');
$idRe = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
//$user_id = null;
$idOrden = $idRe['idOr'];
$infoOrden = getInfoOrdenesPorId($idOrden );
$detalleOrden = getDetalleOrdenPorId($idOrden );
$html = getHtmlDetalleOrden($idOrden);
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
                        Ordenes
                        <small>Detalle de Orden</small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="box box-default">
                        <div class="box-header with-border">
                            <h2 class="box-title">Código de Orden: <strong><?php echo $infoOrden[0][0]; ?></strong></h2>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <div id="encabezadoOrden" class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h4 class="box-title">Cliente: <strong><?php
                                            if ($infoOrden[0][3] == null): echo 'NA';
                                            else: echo $infoOrden[0][3];
                                            endif;
                                            ?></strong>
                                    </h4>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="box-title">Mesa: <strong><?php echo $infoOrden[0][4]; ?></strong></h4>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <h4 class="box-title">Estado: <strong>
                                            <?php if ($infoOrden[0][2] == 'Pendiente'){
                                                echo "<span class='label label-warning'>" . $infoOrden[0][2] . "</span>";
                                            }elseif ($infoOrden[0][2] == 'Atendida') {
                                                echo "<span class='label label-success'>" . $infoOrden[0][2] . "</span>";
                                            }elseif ($infoOrden[0][2] == 'Cancelada') {
                                                echo "<span class='label label-danger'>" . $infoOrden[0][2] . "</span>";
                                            }
                                                 ?>
                                        </strong>
                                    </h4>
                                </div>
                                <!-- /.col -->
                                <div class="col-md-6">
                                    <h4 class="box-title">Fecha y Hora: <strong><?php echo $infoOrden[0][1]; ?></strong></h4>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                    </div>

                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h2 class="box-title">Detalle</h2>
                        </div>
                        <div class="box-body">
                            <div id="divRecibo">
                                <?php if($infoOrden[0][2] == 'Atendida' || $infoOrden[0][2] == 'Pendiente'){ ?>
                               <input id="addProducto" type="button"  class="btn btn-info" value="Agregar Productos">
                            <?php echo ""; }?>
                                
                            <?php if($infoOrden[0][2] == 'Atendida'){ ?>
                                <input id="btn_generarRecibo" type="button" onclick="generarRecibo()" class="btn btn-success" value="Generar Recibo">
                            <?php echo ""; }?>
                            </div>
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_detalleOrden">
<?php echo $html; ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Producto</th>
                                        <th>Cantidad</th>
                                        <th>Estado</th>
                                        <th>Subtotal</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            </table>
                            <div id="div_TotalPago">
                                <h2>TOTAL A PAGAR: <strong>$<?php echo $infoOrden[0][5]; ?></strong></h2>
                            </div>
                        </div>
                    </div>
<button type="button" name="return" class="btn btn-default" onclick="history.back()">Regresar</button>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

<?php include_once '../includes/footer.php'; ?>

            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <script>
            function detalleAtendido(idDetalleOrd) {
                var idOrden = "<?php echo $idOrden; ?>";
                $.post("ordenHandler.php", {estadoDetalleAtendido: idDetalleOrd, idOrden:idOrden}, function (data) {
                    $("#tbl_detalleOrden").html(data);
                    
                });
            }
            function detalleCancelado(idDetalleOrd) {
                var idOrden = "<?php echo $idOrden; ?>";
                $.post("ordenHandler.php", {estadoDetalleCancelado: idDetalleOrd, idOrden:idOrden}, function (data) {
                    $("#tbl_detalleOrden").html(data);
                });
            }
            
            
function redirect_by_post(purl, pparameters, in_new_tab) {
    pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
    in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;

    var form = document.createElement("form");
    $(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", purl).attr("method", "post").attr("enctype", "multipart/form-data");
    if (in_new_tab) {
        $(form).attr("target", "_blank");
    }
    $.each(pparameters, function(key) {
        $(form).append('<input type="text" name="' + key + '" value="' + this + '" />');
    });
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

    return false;
}

            function generarRecibo(){
                var idOrden = "<?php echo $idOrden; ?>";
                redirect_by_post('../ordenes/impresionDetOrden.php', {
                    idOrden: idOrden
                }, true);

            }
        </script>

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
    </body>
</html>
