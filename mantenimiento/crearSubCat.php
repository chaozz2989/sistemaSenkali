<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
require_once '../conexion/conexion.php';
require "../funciones/fCategorias.php";
require_once '../funciones/fSubCategorias.php';

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>SubCategorias</title>
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
                        SubCategorías
                        <small>Nueva SubCategoría</small>
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">

                        <section class="col-lg-3 connectedSortable">
                            <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Ver Listado de SubCategorías</button>

                            <!-- Modal -->
                            <div id="myModal" class="modal fade" role="dialog">
                                <div class="modal-dialog">

                                    <!-- Modal content-->
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Listado de SubCategorías</h4>
                                        </div>

                                        <div class="modal-body">
                                            <?php include 'tablaSubCat.php'; ?>
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
                                    <h3 class="box-title">Registrar la Nueva SubCategoría</h3>
                                </div>
                                <form role="form" action="../funciones/fSubCategorias.php?<?php echo encode_this('acc=1'); ?>" method="post"><!--Hace referencia al archivo que controla todas las consultas referentes a Categorías-->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="nombreProd">Nombre de la SubCategoría</label>
                                            <input type="text" class="form-control" id="nombreSubCat" name="nombreSubCat" placeholder="Nombre de la Nueva SubCategoría" required="true">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="catProd">Categoría Madre</label>
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
                                                <label>Activa</label>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" id="dispIng" name="rbActiva" value="1" checked> 
                                                        SI
                                                    </label>
                                                </div>
                                                <div class="radio">
                                                    <label>
                                                        <input type="radio" id="dispIng" name="rbActiva" value="0">
                                                        NO
                                                    </label>
                                                </div>
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
            <!-- Se incluye el pie de página-->
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
            $(document).ready(function () {
                $("#catProd").change(function () {
                    $("#catProd option:selected").each(function () {
                        categoria = $(this).val();
                        $.post("subcategorias.php", {categoria: categoria}, function (data) {
                            $("#subcatProd").html(data);
                        });
                    });
                });
            });
        </script>
    </body>
</html>