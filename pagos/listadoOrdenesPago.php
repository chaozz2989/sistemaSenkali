<?php
session_start();
if (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == null) {
    print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}
//require_once '../funciones/funcion.php';
//require_once './db_reportes.php';
//$cliente = new reporte();
//$html = $cliente->obtener_cliente();
//require_once '../conexion/conexion.php';
//include "../funciones/fClientes.php";

include_once '../funciones/fOrdenes.php';
include_once '../funciones/fClientes.php';
$html = getHtmlOrdenAtendida();
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Pago de Orden</title>
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
        <!-- Select2 -->
        <link rel="stylesheet" href="../plugins/select2/select2.min.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
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
                        PAGOS
                    </h1>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <!-- Left col -->
                        <div class="col-xs-12">
                            <div class="box">
                                <form target="blank" action="pdf/reporteCliente.php" method="POST">
                                    <div class="box-header">
                                        <h3 class="box-title">Pagar Orden</h3>
                                    </div>

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            Buscar Orden
                                        </div>
                                        <div class="panel-body">

                                            <div class="col-md-4">
                                                <label>Codigo</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-user fa"></i></span>
                                                    <input id="nombre" name="nombre" type="text" class="form-control" placeholder="Busque por codigo" aria-describedby="basic-addon1">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <label>Mesa</label>
                                                <div class="input-group">
                                                    <span class="input-group-addon" id="basic-addon1"><i class="fa fa-archive fa"></i></span>
                                                    <input id="dui" name="dui" type="text" class="form-control" placeholder="Busque por Mesa" aria-describedby="basic-addon1">
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?php $data = getClientesAtendidos(); ?>
                                                    <label>Cliente</label>
                                                    <select class="form-control select2" style="width: 100%;" name="cliente" id="cliente">
                                                        <option selected="selected" value="0">Todos</option>
                                                        <?php foreach ($data as $row => $registro) {
                                                            echo "<option value=" . $registro['id_clientes'] . ">" . $registro['nombre'] . ' ' . $registro['apellido'] . "</option>";
                                                        }?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div> 

                                    <!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Código de Orden</th>
                                                    <th>Mesa</th>
                                                    <th>Cliente</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbl_Ordenes_Activas">
                                                <?php echo $html; ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>Código de Orden</th>
                                                    <th>Mesa</th>
                                                    <th>Cliente</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </tfoot>
                                        </table>

                                    </div>
                                    <!-- /.box-body -->
                                </form>
                            </div>
                            <!-- /.box -->
                        </div>
                    </div>
                </section>
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
        <!-- DataTables -->
        <script src="../plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>
        <!-- SlimScroll -->
        <script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
        <!-- Select2 -->
        <script src="../plugins/select2/select2.full.min.js"></script>
        <!-- FastClick -->
        <script src="../plugins/fastclick/fastclick.js"></script>
        <!-- AdminLTE App -->
        <script src="../dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="../dist/js/demo.js"></script>
        <!-- page script -->
        <script>
            $(function () {
                //Initialize Select2 Elements
                $(".select2").select2();

                $('#example1').DataTable({
                    "paging": true,
                    "lengthChange": true,
                    "searching": false,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            });
        </script>

        <!--Script para los filtros-->
        <script>
        $(document).ready(function () {
           
            $('#nombre').keyup(function(){
                var nombre = $('#nombre').val();
                var dui = $('#dui').val();
                var estado = $('#estado').val();
                console.log(nombre);                      
                console.log(dui);                      
                console.log(estado);

                 $.ajax({
                    url:"select_cliente.php",
                    method:"post",
                    data:{nombre: nombre, dui: dui, estado: estado},
                    success:function(data){
                        $('#tablaReporte').html(data);
                        console.log(data);
                    }
                });
            });


            $('#dui').keyup(function(){
                 var nombre = $('#nombre').val();
                var dui = $('#dui').val();
                var estado = $('#estado').val();
                console.log(nombre);                      
                console.log(dui);                      
                console.log(estado);

                 $.ajax({
                    url:"select_cliente.php",
                    method:"post",
                    data:{nombre: nombre, dui: dui, estado: estado},
                    success:function(data){
                        $('#tablaReporte').html(data);
                        console.log(data);                    
                    }
                });
            });



            $('#estado').change(function(){
                 var nombre = $('#nombre').val();
                var dui = $('#dui').val();
                var estado = $('#estado').val();
                console.log(nombre);                      
                console.log(dui);                      
                console.log(estado);

                 $.ajax({
                    url:"select_cliente.php",
                    method:"post",
                    data:{nombre: nombre, dui: dui, estado: estado},
                    success:function(data){
                        $('#tablaReporte').html(data);
                        console.log(data);
                    }
                });
            });
        });
    </script>
    
    </body>
</html>
