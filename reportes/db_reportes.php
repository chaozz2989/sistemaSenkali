<?php

include_once '../conexion/conexion.php';

class reporte {

    function __construct() {
        # code...
    }

    public function obtener_cliente25($nombre = '', $dui = '', $estado = '') {
        $condicion = "";
        $html = "";
        $value = trim($value);
        if (!empty($value)) {
            $condicion = " WHERE nombre LIKE '%" . $nombre . "%' OR apellido LIKE '%" . $nombre . "%' 
			OR apellido_cliente LIKE '%" . $value . "%' OR correo LIKE '%" . $value . "%' OR telefono LIKE '%" . $value . "%' 
			OR direccion LIKE '%" . $value . "%' OR departamento LIKE '%" . $value . "%' OR municipio LIKE '%" . $value . "%' ";
        }
        $pdo = Database::connect();
        $sql = 'SELECT c.id_clientes, e.estado_usuario, c.usuario, c.clave, c.nombre, c.apellido, c.dui, c.telefono, c.email, c.direccion FROM clientes c ' .
                'INNER JOIN estados_usuario e ON e.id_estUsuario = c.id_estadoUsu ' . $condicion . ' ORDER BY codigo_cliente ASC';
        foreach ($pdo->query($sql) as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['codigo_cliente'] . '</td>';
            $html .= '<td>' . $row['nombre_cliente'] . '</td>';
            $html .= '<td>' . $row['apellido_cliente'] . '</td>';
            $html .= '<td>' . $row['correo'] . '</td>';
            $html .= '<td>' . $row['telefono'] . '</td>';
            $html .= '<td>' . $row['direccion'] . '</td>';
            $html .= '<td>' . $row['departamento'] . '</td>';
            $html .= '<td>' . $row['municipio'] . '</td>';
            $html .= '</tr>';
        }
        Database::disconnect();
        return $html;
    }

    public function obtener_empleado($value = '') {
        $condicion = "";
        $html = "";
        $value = trim($value);
        if (!empty($value)) {
            $condicion = " WHERE codigo_empleado LIKE '%" . $value . "%' OR nombre_empleado LIKE '%" . $value . "%' 
			OR apellido_empleado LIKE '%" . $value . "%' OR correo LIKE '%" . $value . "%' OR telefono LIKE '%" . $value . "%' 
			OR nombre_cargo LIKE '%" . $value . "%' OR fecha_ingreso LIKE '%" . $value . "%' OR dui LIKE '%" . $value . "%' ";
        }
        $pdo = Database::connect();
        $sql = 'SELECT codigo_empleado,nombre_empleado,apellido_empleado,nombre_cargo,correo,telefono,fecha_ingreso,
        dui FROM empleado
        INNER JOIN cargo cr ON cr.codigo_cargo = empleado.codigo_cargo ' . $condicion . ' ORDER BY codigo_empleado ASC';
        foreach ($pdo->query($sql) as $row) {
            $html .= '<tr>';
            $html .= '<td>' . $row['codigo_empleado'] . '</td>';
            $html .= '<td>' . $row['nombre_empleado'] . '</td>';
            $html .= '<td>' . $row['apellido_empleado'] . '</td>';
            $html .= '<td>' . $row['nombre_cargo'] . '</td>';
            $html .= '<td>' . $row['correo'] . '</td>';
            $html .= '<td>' . $row['telefono'] . '</td>';
            $html .= '<td>' . $row['fecha_ingreso'] . '</td>';
            $html .= '<td>' . $row['dui'] . '</td>';
        }
        Database::disconnect();
        return $html;
    }

    public function obtener_cliente($nombre = '', $dui = '', $estado = '') {
        $condicion = "";
        $html = "";
        $condicion_nombre = "";
        $condicion_dui = "";
        $condicion_estado = "";
        $nombre = trim($nombre);
        $dui = trim($dui);
        $estado = trim($estado);

        if (!empty($nombre)) {
            $condicion_nombre = " c.nombre LIKE '%" . $nombre . "%' OR c.apellido LIKE '%" . $nombre . "%' ";
        }if (!empty($dui)) {
            $condicion_dui = " c.dui LIKE '%" . $dui . "%' ";
        }if (!empty($estado) && $estado <> "0") {
            $condicion_estado = " c.id_estadoUsu = '" . $estado . "' ";
        }

        if (!empty($condicion_nombre) && !empty($condicion_dui) && !empty($condicion_estado)) {
            $condicion = " WHERE (" . $condicion_nombre . ") AND (" . $condicion_dui . ") AND (" . $condicion_estado . ")";
        } elseif (!empty($condicion_nombre) && !empty($condicion_dui)) {
            $condicion = " WHERE (" . $condicion_nombre . ") AND (" . $condicion_dui . ") ";
        } elseif (!empty($condicion_nombre) && !empty($condicion_estado)) {
            $condicion = " WHERE (" . $condicion_nombre . ") AND (" . $condicion_estado . ") ";
        } elseif (!empty($condicion_dui) && !empty($condicion_estado)) {
            $condicion = " WHERE (" . $condicion_dui . ") AND (" . $condicion_estado . ") ";
        } elseif (!empty($condicion_nombre)) {
            $condicion = " WHERE " . $condicion_nombre;
        } elseif (!empty($condicion_dui)) {
            $condicion = " WHERE " . $condicion_dui;
        } elseif (!empty($condicion_estado)) {
            $condicion = " WHERE " . $condicion_estado;
        }
        try {
            $pdo = Database::connect();
            $sql = "SELECT c.id_clientes, c.id_estadoUsu, e.estado_usuario, c.usuario, c.clave, c.nombre, c.apellido, c.dui, c.telefono, c.email, c.direccion FROM clientes c 
                INNER JOIN estados_usuario e ON e.id_estUsuario = c.id_estadoUsu " . $condicion;

            foreach ($pdo->query($sql) as $row) {
                $html .= '<tr>';
                $html .= '<td>' . $row['id_clientes'] . '</td>';
                $html .= '<td>' . $row['nombre'] . ' ' . $row['apellido'] . '</td>';
                $html .= '<td>' . $row['usuario'] . '</td>';
                $html .= '<td>' . $row['dui'] . '</td>';
                $html .= '<td>' . $row['telefono'] . '</td>';
                $html .= '<td>' . $row['email'] . '</td>';
                $html .= '<td>' . $row['estado_usuario'] . '</td>';
                $html .= '</tr>';
            }
            Database::disconnect();
        } catch (Exception $ex) {
            $html = "Ocurrio un problema.";
            write_log($ex, "db_reportes->obtener_cliente");
        }

        return $html;
    }

    public function obtener_tipo_producto() {
        $html = "";
        $pdo = Database::connect();
        $sql = 'SELECT codigo_tipoproducto, nombre_tipoproducto FROM tipo_producto 
        ORDER BY nombre_tipoproducto ASC';
        foreach ($pdo->query($sql) as $row) {
            $html .= "<option value='" . $row['codigo_tipoproducto'] . "'>" . $row['nombre_tipoproducto'] . "</option>";
        }
        return $html;
    }

}

?>