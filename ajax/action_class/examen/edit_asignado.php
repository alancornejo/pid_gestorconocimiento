<?php
session_start();
require_once ('../../../data/pid_examen.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$fecha_examen = $_POST['fec_asi_edit'];
$fecha_termino = $_POST['fec_ter_edit'];
$id_asignado = $_POST['id_asignado'];
        
//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new examen_usuario();
if($result = $object->update_asignado($fecha_examen, $fecha_termino, $id_asignado)){
    echo "true";
}else{
    echo "false";
}