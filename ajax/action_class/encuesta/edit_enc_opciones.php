<?php
session_start();
require_once ('../../../data/pid_encuesta.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$opciones_array = $_POST['txt_opcion'];
$id_enc_opcion = $_POST['id_opcion'];
$object = new Encuesta();

foreach(array_keys($opciones_array) as $i){
    $txt_opciones = addslashes($opciones_array[$i]);
    $id_opc = $id_enc_opcion[$i];
    if($result_opciones = $object->edit_enc_opciones($txt_opciones, $id_opc)){
        $valor = "true";
    }else{
        $valor = "false";
    }
}

if(substr($valor, -5) == "false"){
    echo "false";
}else{
    echo "true";
}