<?php
session_start();
require_once '../../../data/pid_encuesta.php';
require_once '../../../data/pid_access.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Estado de Encuesta */
$id_user = $_SESSION['id_user_apl'];
$id_encuesta = $_GET['id'];
$id_estado = $_GET['estado'];
if($id_estado == "1"){
    $estado_encuesta = "0";
}else{
    $estado_encuesta = "1";
}
/* Fin de Estado de Encuesta */

//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new Encuesta();
$object_permisos = new pid_permisos();

$result_permisos = $object_permisos->user_permisos($id_user);
$row_permisos = $result_permisos->fetch_assoc();

if($row_permisos['esta_enc'] == "true"){
    if($result = $object->update_estado_enc($estado_encuesta, $id_encuesta)){
        echo "true";
        //$result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
}else{
    echo "sin_permiso";
}
?>
