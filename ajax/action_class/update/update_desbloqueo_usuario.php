<?php
session_start();
require_once '../../../data/pid_data.php';
require_once '../../../data/pid_access.php';
date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Bloqueo */
$id_user = $_SESSION['id_user_apl'];
$id_bloqueo = $_GET['id'];
$id = $_GET['id'];
$fecha_desbloqueo = date("Y-m-d H:i").":00";
/* Fin de Bloqueo */

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new update_pid();
$object_permisos = new pid_permisos();

$result_permisos = $object_permisos->user_permisos($id_user);
$row_permisos = $result_permisos->fetch_assoc();
if($row_permisos['desc_usua'] == "true"){
    if($result = $object->update_desbloqueo_usuario($fecha_desbloqueo, $id_bloqueo)){
        echo "true";
    }else{
        echo "false";
    }
}else{
    echo "sin_permiso";
}
?>