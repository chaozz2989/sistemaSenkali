<?php


$servidor = "localhost";
        $puerto = "3306";
        $basedatos = "senkalidb";
        $usuario = "root";
        $contrasena = "";

        $conexion = new PDO("mysql:host=$servidor;port=$puerto;dbname=$basedatos",
                            $usuario,
                            $contrasena,
                            array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));


 function conectaBaseDatos(){
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

///combo para el estado del cliente
 function comboEstadoUsuario(){
    $resultado = false;
    $consulta = "SELECT * FROM estados_usuario";

    $conexion = conectaBaseDatos();
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



 ?>