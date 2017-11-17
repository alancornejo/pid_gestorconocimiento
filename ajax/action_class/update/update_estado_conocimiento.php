<?php
session_start();
require_once '../../../data/pid_data.php';
require_once '../../../data/pid_view.php';
require_once '../../../data/pid_access.php';
date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Conocimiento */
$id = $_GET['id'];
$id_estado = $_GET['estado'];
if($id_estado == "1"){
    $estado = "0";
}else{
    $estado = "1";
}
/* Fin de Conocimiento */

/* Validar Conocimiento */
$object_view = new pid_view();
$result_view = $object_view->view_contenido($id);
$row = $result_view->fetch_assoc();
/* Fin de Validar Conocimiento */

/* Registro */
$modelo_registro = "1";
$tipo_registro = "3";
$id_modelo = $row['id_atu'];
$contenido_registro = $estado;
$estado_registro = "";
$fecha_registro = date("Y-m-d H:i:s");
$id_user = $_SESSION['id_user_apl'];
/* Fin de Registro */

$bitacora_contenido = "";

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new update_pid();
$object_registro = new insert_pid();
$object_permisos = new pid_permisos();

$result_permisos = $object_permisos->user_permisos($id_user);
$row_permisos = $result_permisos->fetch_assoc();

if($row_permisos['apro_cono'] == "true"){
    if($result = $object->update_estado_conocimiento($id, $estado)){
        echo "true";
        $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
}else{
    echo "sin_permiso";
}
?>
