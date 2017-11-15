<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p><?php
                    echo $_SESSION['nomUsuario'];
                    ?></p>
                <?php if ($_SESSION['idRol'] == 1) { ?>
                    <a href="../usr/administrador.php"><i class="fa fa-circle text-success"></i> Online</a>
                    <?php
                }
                ?>

            </div>
        </div>
        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar...">
                <span class="input-group-btn">
                    <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">Menu Principal</li>

            <li class="treeview">
                <a href="../gerente/crearOrden.php">
                    <i class="fa fa-files-o"></i>
                    <span>Clientes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="../clientes/crearCliente.php"><i class="fa fa-circle-o"></i> Nuevo Cliente</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Modificar Cliente</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Empleados</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Nuevo Empleado</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Modificar Empleado</a></li>
                </ul>
            </li>
            <?php if ($_SESSION['idRol'] == 1) { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Reservas</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../empleado/reserva.php"><i class="fa fa-circle-o"></i> Nueva Reservacion</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Nuevo Tipo de Evento</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Modificar Reservacion</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Modificar Tipo de Evento</a></li>
                    </ul>
                </li>
            <?php } ?>
            <?php if ($_SESSION['idRol'] == 1) { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Ordenes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../ordenes/crearOrden.php"><i class="fa fa-circle-o"></i> Nueva Orden</a></li>
                        <li><a href="../pagos/listadoOrdenesPago.php"><i class="fa fa-circle-o"></i> Pagar Orden</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Modificar Reservacion</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Modificar Tipo de Evento</a></li>
                    </ul>
                </li>
            <?php } ?>

            <?php if ($_SESSION['idRol'] == 1) { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Monedero</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../monedero/monedero.php"><i class="fa fa-circle-o"></i> Monedero</a></li>


                    </ul>
                </li>
            <?php } ?>

            <?php if ($_SESSION['idRol'] == 1) { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Productos</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="active"><a href="../productos/crearProducto.php"><i class="fa fa-circle-o"></i>Crear Producto</a></li>
                        <li class="active"><a href="#"><i class="fa fa-circle-o"></i>Modificar Producto</a></li>
                        <li>
                            <a href="#"><i class="fa fa-circle-o"></i> Categorías
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="../mantenimiento/crearCategoria.php"><i class="fa fa-circle-o"></i> Crear Categoría</a></li>
                                <li><a href="../mantenimiento/listaCategorias.php"><i class="fa fa-circle-o"></i> Modificar Categoría</a></li>
                            </ul>
                        </li>
                        <li><a href="../index2.html"><i class="fa fa-circle-o"></i>Crear Promociones</a></li>
                    </ul>
                </li>
            <?php } ?>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-files-o"></i>
                    <span>Ingredientes</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Nuevo Ingrediente</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Modificar Ingrediente</a></li>
                </ul>
            </li>
            <?php if ($_SESSION['idRol'] == 1) { ?>
                <li class="treeview">
                    <a href="#">
                        <i class="fa fa-files-o"></i>
                        <span>Reportes</span>
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li><a href="../reportes/repClientes.php"><i class="fa fa-circle-o"></i> Clientes</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Empleados</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Ordenes</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Monedero</a></li>
                        <li><a href="#"><i class="fa fa-circle-o"></i> Reservas</a></li>
                    </ul>
                </li>
            <?php } ?>
        </ul>
        <!-- /.sidebar -->
</aside>