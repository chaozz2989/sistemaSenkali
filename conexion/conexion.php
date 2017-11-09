<?php
date_default_timezone_set('America/El_Salvador');
class Database {

    private static $dbName = 'senkalidb';
    private static $dbHost = 'localhost';
    private static $dbUsername = 'root';
    private static $dbUserPassword = '';
    private static $con = null;

    public function __construct() {
        exit('Init function is not allowed');
    }

    public static function connect() {
        // One connection through whole application
        if (null == self::$con) {
            try {
                self::$con = new PDO("mysql:host=" . self::$dbHost . ";" . "dbname=" . self::$dbName, self::$dbUsername, self::$dbUserPassword);
            } catch (PDOException $e) {
                die($e->getMessage());
                write_log($e, "CONEXION");
            }
        }
        return self::$con;
    }

    public static function disconnect() {
        self::$con = null;
    }

}


/**
* Esta función permite escribir en un Log los errores que se provocan al momento de realizar
 * transacciones con la base de datos.
*
* @$mensaje String que captura el mensaje de error generado 
* @$ubicacion indica la función en la que se generó el error
*/
function write_log($mensaje, $ubicacion){
	$arch = fopen(realpath( '..' )."/logs/snklog_".date("Y-m-d").".txt", "a+"); 

	fwrite($arch, "---------------------\n".
                "[".date("Y-m-d H:i:s")." ".$_SERVER['REMOTE_ADDR']." - $ubicacion ] ".
                $mensaje."\n".
                "---------------------\n\n");
	fclose($arch);
}

?>
