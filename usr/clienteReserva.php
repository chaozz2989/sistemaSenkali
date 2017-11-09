<?php
session_start();
if (!isset($_SESSION["cliente_id"]) || $_SESSION["cliente_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}

require_once("../funciones/funcion.php");
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

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Solicitud de Reserva
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->


                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-primary">
                                <form role="form" action="../controlador/reservaClienteController.php" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="despcripcion">Descripcion</label>
                                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion">
                                        </div>

                                        <div class="form-group">
                                            <label for="empleado">Empleado</label>
                                            <select class="form-control select2" style="width: 100%;" name="empleado" id="empleado" required="true">
                                                <option value="">- Seleccione un empleado-</option>
<?php
$prod = comboEmpleado();

foreach ($prod as $indice => $registro) {
    echo "<option value=" . $registro['id_empleado'] . ">" . $registro['nombres'] . '-' . $registro['apellidos'] . "</option>";
}
?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="empleado">Cliente</label>

                                            <input type="hidden" class="form-control"  value="<?php echo $_SESSION['cliente_id'] ?>"  name="cliente" id="cliente">
                                            <input type="text" class="form-control"  value="<?php echo $_SESSION['usuario'] ?>"  id="usr" disabled="true">

                                        </div>
                                        <div class="form-group">
                                            <label for="empleado">Tipo de Evento</label>
                                            <select class="form-control select2" style="width: 100%;" name="tipoEvento" id="tipoEvento" required="true">
                                                <option value="">- Seleccione un tipo Evento-</option>
<?php
$prod = comboTipoEvento();

foreach ($prod as $indice => $registro) {
    echo "<option value=" . $registro['id_tipoEvento'] . ">" . $registro['evento'] . "</option>";
}
?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Fecha de la Reserva:</label>

                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" class="form-control pull-right"  name="fcreacion" id="datepicker">
                                            </div>
                                            <!-- /.input group -->
                                        </div>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <label>Hora inicio:</label>

                                                <div class="input-group">
                                                    <input type="text" name="horaI" class="form-control timepicker">

                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                        <div class="bootstrap-timepicker">
                                            <div class="form-group">
                                                <label>Hora fin:</label>

                                                <div class="input-group">
                                                    <input type="text" name="horaf" class="form-control timepicker">

                                                    <div class="input-group-addon">
                                                        <i class="fa fa-clock-o"></i>
                                                    </div>
                                                </div>
                                                <!-- /.input group -->
                                            </div>
                                            <!-- /.form group -->
                                        </div>
                                        <div class="form-group">
                                            <label for="empleado">Cantidad de personas</label>
                                            <input type="text" name="cantPersona" class="form-control" placeholder="# personas"> 
                                        </div>

                                    </div>
                                    <div class="box-footer">
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                        <button type="reset" class="btn btn-danger">Limpiar</button>
                                    </div>
                                </form>
                            </div>
                        </section>

                    </div>

                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->


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