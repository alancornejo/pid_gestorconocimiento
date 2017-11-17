<?php
session_start();
require_once '../../../data/pid_examen.php';
require_once '../../../data/pid_access.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Estado */
$id = $_GET['id'];
$id_estado = $_GET['estado'];
if($id_estado == "1"){
    $estado = "0";
}else{
    $estado = "1";
}
$id_user = $_SESSION['id_user_apl'];
/* Fin de Estado */

$object = new examen_usuario();
$object_permisos = new pid_permisos();

$result_permisos = $object_permisos->user_permisos($id_user);
$row_permisos = $result_permisos->fetch_assoc();

if($row_permisos['chg_exam'] == "true"){
    if($result = $object->update_estado_examen($id, $estado)){
        echo "true";
    }else{
        echo "false";
    }
}else{
    echo "sin_permiso";
}
?>
