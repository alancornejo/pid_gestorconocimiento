<?php
session_start();
require_once '../../../data/pid_data.php';
require_once '../../../data/pid_view.php';
require_once '../../../data/pid_access.php';
date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Usuario */
$user_id = $_GET['id'];
$id = $_GET['id'];
/* Fin de Usuario */

/* Validar Usuario */
$object_view = new pid_view();
$result_view = $object_view->view_usuario($id);
$row = $result_view->fetch_assoc();
/* Fin de Validar Usuario */

/* Registro */
$modelo_registro = "5";
$tipo_registro = "3";
$id_modelo = $_GET['id'];
$contenido_registro = $row['claro_user'];
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
if($row_permisos['desc_usua'] == "true"){
    if($result = $object->update_estado_usuario($user_id)){
        echo "true";
        $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
}else{
    echo "sin_permiso";
}
?>