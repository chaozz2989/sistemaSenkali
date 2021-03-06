<?php

function encode_this($string) {
    $string = utf8_encode($string);
    $control = "qwerty"; //defino la llave para encriptar la cadena, cambiarla por la que deseamos usar
    $string = $control . $string . $control; //concateno la llave para encriptar la cadena
    $string = base64_encode($string); //codifico la cadena
    return($string);
}

function decode_get2($string) {
    if (strpos($string, '?')) {
        $cad = explode("?", $string); //separo la url desde el ?
        $string = $cad[1]; //capturo la url desde el separador ? en adelante
        $string = base64_decode($string); //decodifico la cadena
        $control = "qwerty"; //defino la llave con la que fue encriptada la cadena,, cambiarla por la que deseamos usar
        $string = str_replace($control, "", "$string"); //quito la llave de la cadena
//procedo a dejar cada variable en el $_GET
        $cad_get = explode("&", $string); //separo la url por &
        foreach ($cad_get as $value) {
            $val_get = explode("=", $value); //asigno los valores al GET
            $SA[$val_get[0]] = utf8_decode($val_get[1]);
        }
    } else {
        $SA = null;
    }

    return $SA;
}

function numeroRecibo($idComprobante) {

    if ($idComprobante < 10) {
        $recibo = '00000' . $idComprobante;
    } elseif ($idComprobante > 10 && $idComprobante < 100) {
        $recibo = '0000' . $idComprobante;
    } elseif ($idComprobante > 100 && $idComprobante < 1000){
        $recibo = '000' . $idComprobante;
    } elseif ($idComprobante > 1000 && $idComprobante < 10000){
        $recibo = '00' . $idComprobante;
    } elseif ($idComprobante > 10000 && $idComprobante < 100000){
        $recibo = '0' . $idComprobante;
    } else{
        $recibo = $recibo;
    }

    return $recibo;
}

?>