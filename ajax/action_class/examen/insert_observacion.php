<?php
session_start();
require_once ('../../../data/pid_examen.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$object = new examen_usuario();

$txt_motivo = $_POST['txt_motivo'];
$nota_observado = $_POST['nota_actual'];
$id_identificador = $_POST['id_identificador'];
$id_user = $_POST['id_user'];

if($result = $object->insert_observacion($txt_motivo, $nota_observado, $id_identificador, $id_user)){
    echo "true";
}else{
    echo "false";
}