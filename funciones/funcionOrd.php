<?php 

class Funcion {


public function conectaBaseDatos(){
    try{
        $servidor = "localhost";
        $puerto = "3306";
        $basedatos = "senkalidb";
        $usuario = "root";
        $contrasena = '';

        $conexion = new PDO("mysql:host=$servidor;port=$puerto;dbname=$basedatos",
                            $usuario,
                            $contrasena,
                            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));

        $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $conexion;
    }
    catch (PDOException $e){
        die ("No se puede conectar a la base de datos". $e->getMessage());
    }
}



function getById($id) {
        $resultado = false;
        $consulta = "SELECT * FROM productos where id_productos=$id";
        $conexion = $this->conectaBaseDatos();
        $sentencia = $conexion->prepare($consulta);

        try {
            if (!$sentencia->execute()) {
                print_r($sentencia->errorInfo());
            }

            $resultado = $sentencia->fetchObject();
            $sentencia->closeCursor();
        } catch (PDOException $e) {
            echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
        }

        return $resultado;
    }

    
    
      function getDetOrden($id){
    $resultado = false;
    $consulta = "SELECT * FROM detalles_orden where id_orden=$id";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}
    
    
    
    
    
    function comboOrden(){
    $resultado = false;
    $consulta = "SELECT * FROM ordenes";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}
    
    
    function get() {
    $resultado = false;
    $consulta = "SELECT * FROM productos";
    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if (!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        } 
        
        $resultado = $sentencia->fetchAll();
        $sentencia->closeCursor();
        
    } catch (PDOException $e) {
        echo "Error al ejecutar la sentencia: \n";
        print_r($e->getMessage());
    }
    
    return $resultado;
}

function comboEstadoReserva(){
    $resultado = false;
    $consulta = "SELECT * FROM estado_reservas";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}



function comboEstadoOrden(){
    $resultado = false;
    $consulta = "SELECT * FROM estados_orden";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}


function comboProductoEsp(){
    $resultado = false;
    $consulta = "SELECT * FROM producto_esp";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}




function comboProducto(){
    $resultado = false;
    $consulta = "SELECT * FROM productos";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}


function comboTipoOrden(){
    $resultado = false;
    $consulta = "SELECT * FROM tipos_orden";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}




function comboMesa(){
    $resultado = false;
    $consulta = "SELECT * FROM mesas";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}


function comboEmpleado(){
    $resultado = false;
    $consulta = "SELECT * FROM empleados";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}



function comboSubCat(){
    $resultado = false;
    $consulta = "SELECT * FROM subcategorias";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}



function comboCliente(){
    $resultado = false;
    $consulta = "SELECT * FROM clientes";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}



function comboTipoEvento(){
    $resultado = false;
    $consulta = "SELECT * FROM  tipo_evento";

    $conexion = $this->conectaBaseDatos();
    $sentencia = $conexion->prepare($consulta);

    try {
        if(!$sentencia->execute()){
            print_r($sentencia->errorInfo());
        }
        $resultado = $sentencia->fetchAll();
        //$resultado = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $sentencia->closeCursor();
    }
    catch(PDOException $e){
        echo "Error al ejecutar la sentencia: \n";
            print_r($e->getMessage());
    }

    return $resultado;
}


}
 ?>
