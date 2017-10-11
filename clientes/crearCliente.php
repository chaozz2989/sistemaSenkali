<?php
session_start();
 include '../funciones/funcion.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Area de Administracion</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <!-- daterange picker -->
        <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../plugins/datepicker/datepicker3.css">
        <!-- iCheck for checkboxes and radio inputs -->
        <link rel="stylesheet" href="../plugins/iCheck/all.css">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="../plugins/colorpicker/bootstrap-colorpicker.min.css">
        <!-- Bootstrap time Picker -->
        <link rel="stylesheet" href="../plugins/timepicker/bootstrap-timepicker.min.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../plugins/select2/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">
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

            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Area de Administracion
                        <small>Control panel</small>
                    </h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-8">
                            <section>

                                <div class="box box-primary">
                                    <div class="box-header with-border">
                                        <h3 class="box-title">Creacion de Clientes</h3>
                                    </div>
                                    <!-- /.box-header -->
                                    <!-- form start -->
                                    <form role="form" action="../controlador/guardarCliente.php" method="post">
                                        <div class="box-body">
                                            <fieldset class="fieldset">
                                                <legend>Datos del Usuario</legend>
                                                <div class="form-group">
                                                    <label for="estadoReserva">Estado Cliente</label>
                                                    <select class="form-control select2" style="width: 100%;" name="eusuario" id="eusuario" required="true">
                                                        <option value="">- Seleccione estado-</option>
                                                        <?php
                                                        $prod = comboEstadoUsuario();

                                                        foreach ($prod as $indice => $registro) {
                                                            echo "<option value=" . $registro['id_estUsuario'] . ">" . $registro['estado_usuario'] . "</option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </div>

                                                <div class="form-group">
                                                    <label for="usr">Usuario:</label>
                                                    <input type="text" class="form-control" id="usr" name="usr" required="true">
                                                </div>

                                                <div class="form-group">
                                                    <label for="pwd">Password:</label>
                                                    <input type="password" class="form-control" id="pwd" name="pwd" required="true" >
                                                </div>
                                            </fieldset>
                                            <fieldset class="fieldset">
                                                <legend>Datos del Cliente</legend>
                                                <div class="form-group">
                                                    <label for="usr">Nombre Completo:</label>
                                                    <input type="text" class="form-control" id="nom" name="nom" required="true" >
                                                </div>
                                                 <div class="form-group">
                                                    <label for="usr">Apellidos:</label>
                                                    <input type="text" class="form-control" id="ap" name="ap" required="true" >
                                                </div>
                                                 <div class="form-group">
                                                    <label for="usr">Dui:</label>
                                                    <input type="text" class="form-control" id="dui" name="dui" required="true" >
                                                 </div>
                                                 <div class="form-group">
                                                     <label for="usr">Telefono:</label>
                                                     <input type="text" class="form-control" id="tel" name="tel" required="true" >
                                                 </div>
                                                 <div class="form-group">
                                                     <label for="email">Email:</label>
                                                     <input type="email" class="form-control" id="email" name="email" required="true" >
                                                 </div>
                                                
                                                <div class="form-group">
                                                     <label for="email">Direccion:</label>
                                                     <textarea class="form-control" rows="3" id="dir" name="dir" required="true" ></textarea>
                                                 </div>
                                            </fieldset>
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



    </body>
</html>
