<?php

if (!empty(filter_input_array(INPUT_POST))) {
    $usuario = filter_input(INPUT_POST, "user");
    $clave = filter_input(INPUT_POST, "pass");
    if ($usuario <> "" && $clave <> "") {
        include "../conexion/conexion.php";
        try {
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "SELECT id_clientes,nombre,apellido FROM clientes WHERE usuario=\"$usuario\" and clave=\"$clave\" ";
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
            $_SESSION['cliente_id'] = $data['id_clientes'];
            $_SESSION['usuario'] = $data['nombre'] . ' ' . $data['apellido'];
           
           

            //-----------SEGUN EL ROL CON EL QUE SE LOGUEE EL USUARIO, SE DEFINIRÁ LA PAGINA DONDE DEBE ENVIARSE.

            if ($_SESSION['cliente_id'] > 0) {
                ?>
                <script type="text/javascript">
                    window.location = "../usr/cliente.php";
                </script>
                <?php

            }

            if ($_SESSION['cliente_id'] == "" || $_SESSION['cliente_id'] == NULL) {
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