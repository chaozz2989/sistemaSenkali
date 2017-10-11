<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
require_once '../conexion/conexion.php';
include "../funciones/fProductos.php";
include '../funciones/fCategorias.php';
include '../funciones/funcion.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Area de Productos</title>
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
                        Actualizar Producto
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->


                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-7 connectedSortable">

                            <?php
                            $idRe = decode_get2(filter_input(INPUT_SERVER, 'REQUEST_URI'));

                            //$user_id = null;
                            $query = getProductoPorId($idRe['idProd']);
                            ?>

                            <?php if ($query != null): ?>
                                <div class="box-body">
                                    <form role="form" method="post" action="../funciones/fProductos.php?<?php echo encode_this("acc=2&idProd=".$idRe['idProd']);?>">
                                        <?php foreach ($query as $resultado => $campoProducto) { ?>
                                            <div class="form-group">
                                                <label for="nombreProd">Producto</label>
                                                <input type="text" class="form-control" value="<?php echo $campoProducto['nombre_prod']; ?>" name="nombreProd" required>
                                            </div>

                                            <div class="form-group">
                                                <label for="precioProd">Precio del Producto</label>
                                                <input type="text" class="form-control" value="<?php echo $campoProducto['precio_prod']; ?>" name="precioProd">
                                            </div>

                                            <div class="form-group">
                                                <label for="catProd">Categoría del Producto</label>
                                                <select class="form-control select2" style="width: 100%;" name="catProd" id="catProd" required="true">
                                                    <option value="">-Seleccione una Categoría-</option>
                                                    <?php
                                                    $cate = getCategorias();

                                                    foreach ($cate as $indice => $registro) {
                                                        echo "<option value=" . $registro['id_categoria'] . "";
                                                        if ($registro['id_categoria'] == $campoProducto['id_categoria']) {
                                                            echo " selected=true ";
                                                        }
                                                        echo ">" . $registro['nombre'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </div>

                                            <input hidden="true" value="<?php echo $campoProducto['id_subCat']; ?>" name="subCatHidden" id="subCatHidden">

                                            <div class="form-group">
                                            <label for="subcatProd">SubCategoría del Producto</label>
                                            <select class="form-control select2" style="width: 100%;" name="subcatProd" id="subcatProd" required="true">
                                                <option value="">-Seleccione una SubCategoría-</option>
                                            </select>
                                        </div>

                                            <div class="form-group">
                                                <label>Es producto especial?</label>
                                                <label>
                                                    <input type="checkbox" class="minimal" name="prodEspecial" value="<?php echo $campoProducto['especialidad']; ?>">
                                                </label> 
                                            </div>

                                        <?php } ?>
                                        <button type="submit" class="btn btn-default">Actualizar</button>
                                        <button type="button" class="btn btn-default">Regresar</button>
                                    </form>
                                <?php else: ?>
                                    <p class="alert alert-danger">404 No se encuentra</p>
                                <?php endif; ?>
                            </div>

                        </section>

                    </div>
                </section>

            </div>
            <!-- /.content-wrapper -->
            <?php require_once '../includes/footer.php'; ?>


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


        <script language="javascript">
            $(document).ready(function () {
                $("#catProd").change(function () {
                    $("#catProd option:selected").each(function () {
                        categoria = $(this).val();
                        var subcategoria = $("#subCatHidden").val();
                        $.post("subcategorias.php", {categoria: categoria, subcategoria: subcategoria}, function (data) {
                            $("#subcatProd").html(data);
                        });
                    });
                });
            });
        </script>

    </body>
</html>
