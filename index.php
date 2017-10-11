<?php
$error = filter_input(INPUT_GET, 'errno');
$textoError = null;
if (isset($error)) {
    if ($error == 1) {
        $textoError = "*Error al conectar con la DB";
    }
    if ($error == 2) {
        $textoError = "*Campos Obligatorios";
    }
    if ($error == 3) {
        $textoError = "*No existe el Usuario y/o contraseña ingresado.";
    }
}
?>
<html>
    <head>
        <title>Ingreso de Usuarios</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    </head>
    <body style=" background-image: url(dist/img/background.jpg);">
        <div class="container">
            <div class="row">

                
         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
              <h3>44</h3>

              <p>Cliente</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <button type="button" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#loginCliente">Ingresar</button>
          </div>
        </div>


<div id="loginCliente" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login Cliente</h4>
      </div>
      <div class="modal-body">
        
                    <form  action="controlador/loginCliente.php" method="post">
                        <div class="form-group">
                            <label for="email">Usuario:</label>
                            <?php
                            if (isset($error)) {
                                if ($error == 2) {
                                    echo "*";
                                }
                            }
                            ?>
                            <input type="text" class="form-control" id="username" name="user" placeholder="Nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Contraseña:</label>
                            <?php
                            if (isset($error)) {
                                if ($error == 2) {
                                    echo "*";
                                }
                            }
                            ?>
                            <input type="password" class="form-control" id="password" name="pass" placeholder="Contrase&ntilde;a">
                        </div>
                        <button type="submit" class="btn btn-success">Acceder</button>
                        <br>
                        <?php
                        if (isset($error)) {
                            echo $textoError;
                        }
                        ?>
                    </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
        





         <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue">
            <div class="inner">
              <h3>44</h3>

              <p>Personal de Restaurante</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
           <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal">Ingresar</button>
          </div>
        </div>
            






<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Login</h4>
      </div>
      <div class="modal-body">
        
                    <form  action="controlador/login.php" method="post">
                        <div class="form-group">
                            <label for="email">Usuario:</label>
                            <?php
                            if (isset($error)) {
                                if ($error == 2) {
                                    echo "*";
                                }
                            }
                            ?>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Nombre de usuario">
                        </div>
                        <div class="form-group">
                            <label for="pwd">Contraseña:</label>
                            <?php
                            if (isset($error)) {
                                if ($error == 2) {
                                    echo "*";
                                }
                            }
                            ?>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Contrase&ntilde;a">
                        </div>
                        <button type="submit" class="btn btn-success">Acceder</button>
                        <br>
                        <?php
                        if (isset($error)) {
                            echo $textoError;
                        }
                        ?>
                    </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>


            </div>
        </div>
    </body>
</html>