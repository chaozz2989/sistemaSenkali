<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
require_once("../funciones/funcion.php");

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
                        Area de Empleados
                    </h1>
                </section>
                
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <section class="col-lg-3 connectedSortable">
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Ver Reservas</button>

                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Listado de Reservas</h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php include "tablaReservas.php"; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        </div>


                                    </div>

                                </div>
                            </div>

                        </section>


                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title">Realizar Reserva</h3>
                                </div>
                                <form role="form" action="../controlador/reservaController.php" method="post">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="despcripcion">Descripcion</label>
                                            <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="descripcion">
                                        </div>
                                        <div class="form-group">
                                            <label for="estadoReserva">Estado de la Reserva</label>
                                            <select class="form-control select2" style="width: 100%;" name="estadoReserva" id="estadoReserva" required="true">
                                                <option value="">- Seleccione estado-</option>
                                                <?php
                                                $prod = comboEstadoReserva();

                                                foreach ($prod as $indice => $registro) {
                                                    echo "<option value=" . $registro['id_estadoRes'] . ">" . $registro['estado_reserva'] . "</option>";
                                                }
                                                ?>
                                            </select>
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
                                            <select class="form-control select2" style="width: 100%;" name="cliente" id="cliente" required="true">
                                                <option value="">- Seleccione un Cliente-</option>
                                                <?php
                                                $prod = comboCliente();

                                                foreach ($prod as $indice => $registro) {
                                                    echo "<option value=" . $registro['id_clientes'] . ">" . $registro['nombre'] . '-' . $registro['apellido'] . "</option>";
                                                }
                                                ?>
                                            </select>
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
                                            <label for="empleado">Codigo Reserva</label>
                                            <input type="text" class="form-control" id="codReserva" name="codReserva" placeholder="codigo reserva">
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