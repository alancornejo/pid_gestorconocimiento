<?php
session_start();
require_once ('../../../data/pid_examen.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$id_examen = $_POST['sl_examen'];
$id_user_array = $_POST['sl_usuario'];
$fecha_examen = $_POST['fec_asi'];
$fecha_termino = $_POST['fec_ter'];

//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new examen_usuario();
$n = 0;
foreach($id_user_array as $id_user){
    $n = $n + 1;
    $date = date_create();
    $id_identificador = uniqid().'_'.date_timestamp_get($date);
        
    if($result = $object->insert_asignado($id_examen, $id_user, $fecha_examen, $fecha_termino, $id_identificador) && $result_update = $object->update_usuario_examen($id_user)){
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