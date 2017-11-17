<?php
session_start();
require_once ('../../../data/pid_encuesta.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$opciones_array = $_POST['txt_opcion'];
$id_enc_pregunta = $_POST['sl_pregunta'];
$object = new Encuesta();

foreach($opciones_array as $txt){
    $txt_opciones = addslashes($txt);
    if($result_opciones = $object->insert_enc_opciones($txt_opciones, $id_enc_pregunta)){
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
