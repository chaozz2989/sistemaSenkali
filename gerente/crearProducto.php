<?php
session_start();
if(!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==null){
  print "<script>alert(\"Acceso invalido!\");window.location='index.php';</script>";
}

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
        Area de Administracion
        <small>Control panel</small>
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      
      <?php 
   //MENU
    require_once('../funciones/funcion.php');
  ?>  
      <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
      
           <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Crear Producto</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <form role="form" action="../controlador/addProducto.php" method="post">
                <div class="box-body">
                  <div class="form-group">
                    <label for="nombreProd">Nombre del Producto</label>
                    <input type="text" class="form-control" id="nomProd" name="nomProd" placeholder="Nombre del Producto">
                  </div>
                  <div class="form-group">
                    <label>Sub Categoria</label>
                    <select class="form-control select2" style="width: 100%;" name="idSub" id="idSub" required="true">
                                                <option value="">- Seleccione una Sub Categoria-</option>
                                                <?php
                                                $prod = comboSubCat();

                                                foreach ($prod as $indice => $registro) {
                                                    echo "<option value=" . $registro['id_subcategoria'] . ">". $registro['nombre'] ."</option>";
                                                }
                                                ?>
                                            </select>

                  </div>
                   <div class="form-group">
                    <label for="nombreProd">Precio del Producto</label>
                    <input type="text" class="form-control" id="preProd" name="preProd" placeholder="Precio del Producto">
                  </div>
                   <div class="form-group">
                    <label for="nombreProd">Especialidad</label>
                    <input type="text" class="form-control" id="esProd" name="esProd" placeholder="Nombre del Producto">
                  </div>                
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

<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
</body>
</html>
