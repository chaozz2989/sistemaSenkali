<?php

if (!empty(filter_input_array(INPUT_POST))) {
    $usuario = filter_input(INPUT_POST, "username");
    $clave = filter_input(INPUT_POST, "password");
    if ($usuario <> "" && $clave <> "") {
        include "../conexion/conexion.php";
        try {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "select id_empleado, id_rol, usu_empleado, clave_empleado, nombres, apellidos, id_rol from empleados where "
                    . "usu_empleado=\"$usuario\" and clave_empleado=\"$clave\" ";
            //$sql = "select * from usuario where usuario_login='" . $usuario . "' and password_usuario='" . $pass . "'";
            $q = $pdo->prepare($sql);
            $q->execute();
            $data = $q->fetch(PDO::FETCH_ASSOC);
            Database::disconnect();
        } catch (Exception $ex) {
            ?>
            <script type="text/javascript">
                window.location = "../index.php?errno=1"; //error con la base de datos
            </script>
            <?php

        }

        if (!empty($data)) {
            session_start();
            $_SESSION['nomUsuario'] = $data['nombres'] . ' ' . $data['apellidos'];
            $_SESSION['user_id'] = $data['id_empleado'];
            $_SESSION['idRol'] = $data['id_rol'];

            //-----------SEGUN EL ROL CON EL QUE SE LOGUEE EL USUARIO, SE DEFINIRÁ LA PAGINA DONDE DEBE ENVIARSE.

            if ($_SESSION['idRol'] == 1) {
                ?>
                <script type="text/javascript">
                    window.location = "../usr/administrador.php";
                </script>
                <?php

            }

            if ($_SESSION['idRol'] == 2) {
                ?>
                <script type="text/javascript">
                     window.location = "../usr/administrador.php";
                </script>
                <?php

            }

            if ($_SESSION['idRol'] == 3) {
                ?>
                <script type="text/javascript">
                    window.location = "../usr/administrador.php";
                </script>
                <?php
            }
            if ($_SESSION['idRol'] == "" || $_SESSION['idRol'] == NULL) {
                ?>
                <script type="text/javascript">
                    window.location = "../index.php?errno=2";
                </script>
                <?php
            }
        } else {
            ?>
                <script type="text/javascript">
                    window.location = "../index.php?errno=3";
                </script>
                <?php
        }

    } else {
        ?>
        <script type="text/javascript">
            window.location = "../index.php?errno=2";
        </script>
        <?php
    }
}
?>