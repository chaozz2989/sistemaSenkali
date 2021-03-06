<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
require_once '../conexion/conexion.php';
require "../funciones/fEmpleados.php";
require "../funciones/fSucursales.php";
require "../funciones/fRoles.php";
require "../funciones/funcion.php";
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
                        Empleados
                        <small>Nuevo Empleado</small>
                    </h1>
                </section>
                
                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <section class="col-lg-3 connectedSortable">
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Ver Listado de Empleados</button>

                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Listado de Empleados</h4>
                                        </div>
                                        
                                        <div class="modal-body">
                                            <?php include 'tablaEmpleado.php'; ?>
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
                                    <h3 class="box-title">Registrar un Nuevo Empleado</h3>
                                </div>
                                <form role="form" action="../funciones/fEmpleados.php?<?php echo encode_this('acc=1');?>" method="post"><!--Hace referencia al archivo que controla todas las consultas referentes a empleados-->
                                    <div class="box-body">

                                        <div class="form-group">
                                            <label>Nombres del Empleado</label>
                                            <input type="text" class="form-control" id="nombreEmp" name="nombreEmp" placeholder="Ingrese nombres del empleado" required="true">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Apellidos del Empleado</label>
                                            <input type="text" class="form-control" id="apeEmp" name="apeEmp" placeholder="Ingrese apellidos del empleado" required="true">
                                        </div>

                                        <div class="form-group">
                                            <label>DUI</label>
                                            <input type="text" class="form-control" id="duiEmp" name="duiEmp" placeholder="Documento Unico de Identidad" required="true">
                                        </div>
                                        
                                       <div class="form-group">
                                            <label>NIT</label>
                                            <input type="text" class="form-control" id="nitEmp" name="nitEmp" placeholder="N° de Impuesto Tributario" required="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Dirección</label>
                                            <input type="text" class="form-control" id="dirEmp" name="dirEmp" placeholder="Dirección del empleado" required="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Telefono</label>
                                            <input type="text" class="form-control" id="telEmp" name="telEmp" placeholder="Telefono del empleado" required="true">
                                        </div>

                                        <div class="form-group">
                                            <label>email</label>
                                            <input type="text" class="form-control" id="emailEmp" name="emailEmp" placeholder="Direccion de correro electronico" required="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Sucursal</label>
                                            <select class="form-control select2" style="width: 100%;" name="sucursalEmp" id="sucursalEmp" required="true">
                                                <option value="">-Seleccione una sucursal-</option>
                                                <?php
                                                $suc = getSucursales();

                                                foreach ($suc as $indice => $registro) {
                                                    echo "<option value=" . $registro['id_sucursal'] . ">" . $registro['descripcion_suc'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                            <label>Rol</label>
                                            <select class="form-control select2" style="width: 100%;" name="rolEmp" id="rolEmp" required="true">
                                                <option value="">-Seleccione un rol-</option>
                                                <?php
                                                $rol = getRoles();

                                                foreach ($rol as $indice => $registro) {
                                                    echo "<option value=" . $registro['id_rol'] . ">" . $registro['rol'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <div class="form-group">
                                                <label>Estado</label>
                                            <input type="radio" id="estEmp" name="estEmp" value="1" required="true">Activo &nbsp;&nbsp;
                                            <input type="radio" id="estEmp" name="estEmp" value="0" required="true">Inactivo <br>
                                        </div>

                                        <div class="form-group">
                                            <label>Usuario</label>
                                            <input type="text" class="form-control" id="userEmp" name="userEmp" placeholder="Nombre de usuario" required="true">
                                        </div>

                                        <div class="form-group">
                                            <label>Clave</label>
                                            <input type="text" class="form-control" id="claveEmp" name="claveEmp" placeholder="Clave de usuario" required="true">
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




    </body>
</html>