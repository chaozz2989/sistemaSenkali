<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
date_default_timezone_set('America/El_Salvador');
//$_SESSION['detalle'] = array();
require_once ('../funciones/utils.php');
require_once('../funciones/fOrdenes.php');
require_once('../funciones/fMonedero.php');
require_once '../funciones/fPagos.php';

$idRe = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
$idOrden = $idRe['idOrden'];
$idComprobante = $idRe['idPago'];
$detalleOrden = getDetalleOrdenPorId($idOrden);
$infoOrden = getInfoOrdenesPorId($idOrden);
$infoPago = getInfoPagoPorId($idComprobante);
$html = getHtmlDetalleAPagar($idOrden);
$totalConDescuento = getTotalConDescuento($idOrden, $idComprobante);
$monedero = NULL;
$ultimoMovMon = NULL;
$saldoAnterior = NULL;

if ($infoOrden[0][6] != NULL){
    $monedero = getMonederoPorIdCliente($infoOrden[0][6]);
}


if ($monedero != null){
    $ultimoMovMon = getUltimoMovimientoMonedero($monedero[0][0]);
    if ($ultimoMovMon[0][2]==0){
        $saldoAnterior = $monedero[0][1] + $ultimoMovMon[0][1];
    } elseif ($ultimoMovMon[0][2]==1){
        $saldoAnterior = $monedero[0][1] - $ultimoMovMon[0][1];
    }
    
}

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Pagar Orden</title>
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
                        Recibo 
                        <small>#<?php echo numeroRecibo($idComprobante); ?></small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="invoice">
                    <!-- title row -->
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="page-header">
                                <i class="fa fa-globe"></i> SENKALI.
                                <small class="pull-right">Date: <?php echo date('m/d/Y');?></small>
                            </h2>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- info row -->
                    <div class="row invoice-info">
                        <div class="col-sm-4 invoice-col">
                            Cliente
                            <address>
                                <?php if ($infoOrden[0][6] != null ){ 
                                    echo "<strong>" . $infoOrden[0][3] . "</strong><br>";
                                } else {
                                    echo "<strong> NA </strong><br>";
                                }
                                ?>
<!--                                <strong>Admin, Inc.</strong><br>
                                795 Folsom Ave, Suite 600<br>
                                San Francisco, CA 94107<br>
                                Phone: (804) 123-5432<br>
                                Email: info@almasaeedstudio.com-->
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            Monedero
                            <address>
                                <?php if ($infoOrden[0][6] != null ){ ?>
                                <table class="table">
                                    <tr>
                                        <th style="width:30%">Saldo anterior: </th>
                                        <td><?php echo "<strong>" . $saldoAnterior . "</strong><br>"; ?></td>
                                    </tr>
                                    <tr>
                                        <?php if ($ultimoMovMon[0][2] == 0){ //Si redime ?>
                                            <th>Redimido: </th>
                                        <?php }else{ ?>
                                            <th>Acumulado: </th>
                                        <?php } ?>
                                        <td><?php echo "<strong>" . $ultimoMovMon[0][1] . "</strong><br>"; ?></td></td>
                                    </tr>
                                    <tr>
                                        <th>Nuevo Saldo: </th>
                                        <td><?php echo "<strong>" . $monedero[0][1] . "</strong><br>"; ?></td>
                                    </tr>
                                </table>
                                <?php } else { echo '<strong>NA</strong>'; }?>
                            </address>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-4 invoice-col">
                            <b>Recibo #<?php echo numeroRecibo($idComprobante); ?></b><br>
                            <br>
                            <b>Orden #:</b> <?php echo numeroRecibo($idOrden); ?><br>
                            <b>Mesa:</b> <?php echo $infoOrden[0][4]; ?><br>
                            <b>Fecha:</b> <?php echo date('m/d/Y');?><br>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- Table row -->
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Descripci&oacute;n</th>
                                        <th>Cantidad</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_detalleOrden">
                                    <?php
                                    echo $html;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <!-- accepted payments column -->
                        <div class="col-xs-6">
<!--                            <p class="lead">Payment Methods:</p>
                            <img src="../../dist/img/credit/visa.png" alt="Visa">
                            <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                            <img src="../../dist/img/credit/american-express.png" alt="American Express">
                            <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                            <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
                                dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                            </p>-->
                        </div>
                        <!-- /.col -->
                        
                        <div class="col-xs-6">
                            <!--<p class="lead">Amount Due 2/22/2014</p>-->

                            <div class="table-responsive">
                                <table class="table">
                                    <tr>
                                        <th style="width:50%">Subtotal:</th>
                                        <td>$<?php echo $infoOrden[0][5];?></td>
                                    </tr>
                                    <tr>
                                        <th>Descuento</th>
                                        <td>$<?php if ($infoPago[0][1] == 1): echo $infoPago[0][2]; else: echo '0.00'; endif;?> </td>
                                    </tr>
                                    <tr>
                                        <th>Total a Pagar</th>
                                        <td>$<?php echo $totalConDescuento;?></td>
                                    </tr>
                                    <tr>
                                        <th>Recibido:</th>
                                        <td>$<?php echo $infoPago[0][0];?></td>
                                    </tr>
                                    <tr>
                                        <th>Cambio:</th>
                                        <td>$<?php echo $infoPago[0][0] - $totalConDescuento;?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->

                    <!-- this row will not appear when printing -->
                    <div class="row no-print">
                        <div class="col-xs-12">
                            <a href="#" onclick="window.print();" class="btn btn-default"><i class="fa fa-print"></i> Imprimir</a>
                            
                        </div>
                    </div>
                </section>
                <!-- /.content -->
                <div class="clearfix"></div>
            </div>
            <!-- /.content-wrapper -->

            <?php include_once '../includes/footer.php'; ?>

            <div class="control-sidebar-bg"></div>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery 2.2.3 -->
        <script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- Bootstrap 3.3.6 -->
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../dist/js/demo.js"></script>


        <script>

            function redirect_by_post(purl, pparameters, in_new_tab) {
                pparameters = (typeof pparameters == 'undefined') ? {} : pparameters;
                in_new_tab = (typeof in_new_tab == 'undefined') ? true : in_new_tab;

                var form = document.createElement("form");
                $(form).attr("id", "reg-form").attr("name", "reg-form").attr("action", purl).attr("method", "post").attr("enctype", "multipart/form-data");
                if (in_new_tab) {
                    $(form).attr("target", "_blank");
                }
                $.each(pparameters, function (key) {
                    $(form).append('<input type="text" name="' + key + '" value="' + this + '" />');
                });
                document.body.appendChild(form);
                form.submit();
                document.body.removeChild(form);

                return false;
            }

            $(document).ready(function () {
                $('#btn_pagar').click(function () {
                    var totalAPagar = parseFloat($('#fTotalAPagar').val());
                    var importe = parseFloat($('#importeRecibido').val());
                    var redimir = document.getElementById('rbRedimir').value;
                    var idOrdenAPagar = "<?php echo $idOrdenAPagar; ?>";
                    var esCliente = "<?php echo $infoOrden[0][6]; ?>";
                    var acumulable = document.getElementById('hAcumulable').value;
                    var descuento = document.getElementById('hDescuento').value;

                    if (importe < totalAPagar || importe == '') {
                        alert("El importe debe ser mayor al Total a Pagar.");
                        $('#importeRecibido').focus();
                    } else {
                        if (esCliente == 0) {
                            redirect_by_post('../pagos/pagosHandler.php', {esCliente: esCliente, idOrdenAPagar: idOrdenAPagar, totalAPagar: totalAPagar, importe: importe}, true);
                        } else {
                            if (redimir == 0) {
                                redirect_by_post('../pagos/pagosHandler.php', {esCliente: esCliente, idOrdenAPagar: idOrdenAPagar, totalAPagar: totalAPagar, importe: importe, acumulable: acumulable}, true);
                            } else {
                                redirect_by_post('../pagos/pagosHandler.php', {esCliente: esCliente, idOrdenAPagar: idOrdenAPagar, totalAPagar: totalAPagar, importe: importe, descuento: descuento}, true);
                            }
                        }
                    }
                });
            });
        </script>

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

        <!--Script que valida si se aplica el monedero o no-->
        <script>
            var currentValue = 0;
            function handleMonedero(rbRedimir) {
                currentValue = rbRedimir.value;
                if (currentValue == 1) {
                    document.getElementById('tablaRedencion').style.display = 'block';
                } else if (currentValue == 0) {
                    document.getElementById('tablaRedencion').style.display = 'none';
                }
            }
        </script>
    </body>
</html>
