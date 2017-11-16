<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
date_default_timezone_set('America/El_Salvador');
setlocale(LC_MONETARY, 'es_SV');
//$_SESSION['detalle'] = array();
require_once ('../funciones/utils.php');
require_once('../funciones/fOrdenes.php');
require_once('../funciones/fMonedero.php');
require_once '../funciones/fPagos.php';

$idRe = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));
$idOrdenAPagar = $idRe['idOrdenAPagar'];
//$detalleOrden = getDetalleOrdenPorId($idOrdenAPagar);
$html = getHtmlDetalleAPagar($idOrdenAPagar);
$infoOrden = getInfoOrdenesPorId($idOrdenAPagar);
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
                        Pagos
                        <small>Pago de Orden</small>
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
                                            <?php
                                            if ($infoOrden[0][2] == 'Pendiente') {
                                                echo "<span class='label label-warning'>" . $infoOrden[0][2] . "</span>";
                                            } elseif ($infoOrden[0][2] == 'Atendida') {
                                                echo "<span class='label label-primary'>" . $infoOrden[0][2] . "</span>";
                                            } elseif ($infoOrden[0][2] == 'Cancelada') {
                                                echo "<span class='label label-danger'>" . $infoOrden[0][2] . "</span>";
                                            } elseif ($infoOrden[0][2] == 'Pagada') {
                                                echo "<span class='label label-success'>" . $infoOrden[0][2] . "</span>";
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

                    <div class="row">
                        <!-- Left col -->
                        <div class="col-md-6">
                            <section>

                                <!--***********************SECCIÓN DETALLE ORDEN******************************-->
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <h3 class="panel-title">Productos</h3>
                                    </div>
                                    <form action="#" method="post">
                                        <div class="panel-body detalle-producto"  id="resp">

                                            <table class="table">
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
                                            <div id="div_TotalPago">
                                                <h2>TOTAL A PAGAR: <strong>$<?php echo $infoOrden[0][5]; ?></strong></h2>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                                <!--***********************SECCIÓN DETALLE ORDEN******************************-->

                            </section>
                        </div> 

                        <div class="col-md-5">
                            <section>

                                <!--***********************SECCIÓN FIDELIZACION******************************-->
                                <?php
                                $disponible = 0;
                                if ($infoOrden[0][6] != null) {
                                    $acumulado = getMonederoPorIdCliente($infoOrden[0][6]);
                                    $disponible = number_format($acumulado[0][1], 2);
                                    ?>
                                    <div class="box box-primary">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">Fidelizacion</h3>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">Disponible: </th>
                                                    <td>$ <label id="lblDisponible"><?php echo number_format($acumulado[0][1], 2); ?></label></td>
                                                </tr>
                                                <tr>
                                                    <th>Acumulable: </th>
                                                    <td>$ <label id="lblAcumulable"><?php echo number_format(getAcumulable($infoOrden[0][5]), 2); ?></label>
                                                        <input type="hidden" id="hAcumulable" 
                                                               value="<?php
                                                               if (getAcumulable($infoOrden[0][5]) != null): echo number_format(getAcumulable($infoOrden[0][5]), 2);
                                                               else: echo '0';
                                                               endif;
                                                               ?>"</td>
                                                </tr>
                                                <?php if ($infoOrden[0][2] != 'Pagada') { ?>
                                                <tr>
                                                    <th>Redimir</th>
                                                    <td><label>
                                                            No
                                                            <input type="radio" id="rbRedimir" name="rbRedimir" class="minimal" onclick="handleMonedero(this);" value="0" checked>
                                                        </label>
                                                        <label>
                                                            Si
                                                            <input type="radio" id="rbRedimir" name="rbRedimir" class="minimal" onclick="handleMonedero(this);" value="1" <?php
                                                            if ($acumulado[0][1] == 0): echo "disabled";
                                                            endif;
                                                            ?> >
                                                        </label></td>
                                                </tr>
                                                <?php } ?>
                                                <tr>
                                                    <th></th>
                                                    <td>
                                                        <table style="border-style:dashed; border-width: 2; display: none;" id="tablaRedencion">
                                                            <tr>
                                                                <td>
                                                                    <label>Cantidad: </label>
                                                                </td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                        <input type="number" min="0" id="txtDescuento" class="form-control">
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <th></th>
                                                                <td>
                                                                    <div></div>
                                                                    <?php if ($acumulado[0][1] != 0) { ?>
                                                                        <button type="button" class="btn btn-info btn-redimir" id="btn_redimir">Redimir</button>
                                                                    <?php } ?>

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                <?php } ?>
                                <!--***********************SECCIÓN FIDELIZACION******************************-->

                                <!--***********************SECCIÓN PAGO******************************-->
                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">PAGO</h3>
                                    </div>

                                    <form method="post" id="formulario">
                                        <div class="box-body">
                                        <!--<p class="lead">Amount Due 2/22/2014</p>-->

                                            <div class="table-responsive">
                                                <table class="table" border="2" style="border-style: dashed;">
                                                    <tr>
                                                        <th style="width:50%">Subtotal:</th>
                                                        <td>$<?php echo $infoOrden[0][5]; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Descuento:</th>
                                                        <td id="casillaDescuento">$ <label id="lblDescuento">0.00</label>
                                                            <input type="hidden" value="0" id="hDescuento" name="hDescuento"></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total a Pagar:</th>
                                                        <td>$ <label id="lblTotalAPagar"><?php echo $infoOrden[0][5]; ?></label>
                                                            <input type="hidden" value="<?php echo $infoOrden[0][5]; ?>" id="hTotalAPagar" name="fTotalAPagar"></td>
                                                    </tr>
                                                    <?php if ($infoOrden[0][2] != 'Pagada') { ?>
                                                    <tr  border="2">
                                                        <th  border="2">Importe Recibido:</th>
                                                        <td  border="2">
                                                            <div class="input-group">
                                                                <span class="input-group-addon"><i class="fa fa-dollar"></i></span>
                                                                <input type="number" id="importeRecibido" name="importeRecibido" class="form-control">
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                        <tr>
                                                            <td colspan="2"><button type="button" class="btn btn-success btn-agregar-producto" id="btn_pagar">Pagar</button></td>
                                                        </tr>
                                                    <?php } ?>
                                                </table>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!--***********************SECCIÓN PAGO******************************-->
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
                    var totalAPagar = parseFloat($('#hTotalAPagar').val());
                    var importe = parseFloat($('#importeRecibido').val());
                    var redimir = $('input[name="rbRedimir"]:checked').val();
                    //document.getElementById('rbRedimir').checked;
                    var idOrdenAPagar = "<?php echo $idOrdenAPagar; ?>";
                    var esCliente = "<?php echo $infoOrden[0][6]; ?>";



                    if (importe < totalAPagar || isNaN(importe)) {
                        alert("El importe debe ser mayor al Total a Pagar.");
                        document.getElementById('importeRecibido').value = 0;
                        $('#importeRecibido').focus();
                    } else {
                        var pagar = confirm("Seguro que desea realizar el pago?");
                        if (pagar == true) {
                            if (esCliente == 0) {
                                redirect_by_post('../pagos/pagosHandler.php', {esCliente: esCliente, idOrdenAPagar: idOrdenAPagar, totalAPagar: totalAPagar, importe: importe}, true);
                            } else {

                                if (redimir == 0) {
                                    var acumulable = document.getElementById('hAcumulable').value;
                                    redirect_by_post('../pagos/pagosHandler.php', {esCliente: esCliente, idOrdenAPagar: idOrdenAPagar, totalAPagar: totalAPagar, importe: importe, acumulable: acumulable}, true);
                                } else if (redimir == 1) {
                                    var descuento = parseFloat($('#hDescuento').val()); //document.getElementById('hDescuento').value;
                                    redirect_by_post('../pagos/pagosHandler.php', {esCliente: esCliente, idOrdenAPagar: idOrdenAPagar, totalAPagar: totalAPagar, importe: importe, descuento: descuento}, true);
                                }
                            }
                        }
                    } 
                    
                });
            });
        </script>

        <script language="javascript">
            $(document).ready(function () {
                $("#btn_redimir").click(function () {
                    if (isNaN(parseFloat(document.getElementById('txtDescuento').value))) {
                        alert('Ingrese el monto a redimir');
                        $('#txtDescuento').focus();
                    } else {
                        //Variables capturadas para realizar operaciones   ---Get
                        var disponible = parseFloat(document.getElementById('lblDisponible').innerHTML);
                        var aDescontar = parseFloat($('#txtDescuento').val());
                        var descuentoActual = parseFloat(document.getElementById('lblDescuento').innerHTML);
                        var subTotal = parseFloat("<?php echo $infoOrden[0][5]; ?>");

                        //Realizacion de Operaciones Necesarias   ---Operaciones
                        var nuevoDisponible = parseFloat(disponible - aDescontar);
                        nuevoDisponible = nuevoDisponible.toFixed(2);
                        var nuevoDescuento = parseFloat(aDescontar + descuentoActual);
                        nuevoDescuento = nuevoDescuento.toFixed(2);
                        //alert('adescontar: ' + aDescontar + ' - descuento: ' + descuentoActual + ' - nuevoDescuento: ' + nuevoDescuento);
                        var nuevoPago = parseFloat(subTotal - nuevoDescuento);
                        nuevoPago = nuevoPago.toFixed(2);

                        //Establecimiento de nuevos valores   ---Set
                        document.getElementById('lblDescuento').innerHTML = nuevoDescuento;
                        document.getElementById('lblDisponible').innerHTML = nuevoDisponible;
                        document.getElementById('lblAcumulable').innerHTML = '0';
                        document.getElementById('lblTotalAPagar').innerHTML = nuevoPago;

                        //Establecimiento de nuevos valores a campos ocultos ---Set Hiddens
                        document.getElementById('hTotalAPagar').value = nuevoPago;
                        document.getElementById('hDescuento').value = nuevoDescuento;
                        document.getElementById('hAcumulable').value = '0';
                    }
                });
            });
            
            $("#txtDescuento").focusout(function () {
                var disponible = parseFloat(document.getElementById('lblDisponible').innerHTML);
                var aDescontar = parseFloat($('#txtDescuento').val());
                
                if (aDescontar > disponible){
                    document.getElementById('txtDescuento').value = disponible;
                } else if(aDescontar < 0){
                    document.getElementById('txtDescuento').value = 0;
                }
            });
            $("#importeRecibido").focusout(function () {
                var importe = parseFloat($('#importeRecibido').val());
                
                if(importe < 0){
                    document.getElementById('importeRecibido').value = 0;
                } else if(importe > 9999){
                    document.getElementById('importeRecibido').value = 0;
                }
            });
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

                    //Codigo que reestablece todos los elementos a su estado Original

                    var disponible = "<?php echo $disponible; ?>";
                    var acumulable = "<?php echo number_format(getAcumulable($infoOrden[0][5]), 2); ?>";
                    var descuento = 0;
                    var subTotal = parseFloat("<?php echo $infoOrden[0][5]; ?>");

                    //Reestablecimiento de datos
                    document.getElementById('lblDescuento').innerHTML = descuento;
                    document.getElementById('lblDisponible').innerHTML = disponible;
                    document.getElementById('lblAcumulable').innerHTML = acumulable;
                    document.getElementById('lblTotalAPagar').innerHTML = subTotal;
                    document.getElementById('txtDescuento').value = '0';
                }
            }
        </script>


    </body>
</html>
