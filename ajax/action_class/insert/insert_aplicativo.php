<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
/* Aplicativo */
$txt_apli = addslashes($_POST['nom_apli']);
$sl_flujo = $_POST['sl_flujo'];
$sl_grupo = $_POST['sl_grupo'];
/* Fin de Aplicativo */

/* Registro */
$modelo_registro = "3";
$tipo_registro = "1";
$id_modelo = addslashes(strtoupper($_POST['nom_apli']));
$contenido_registro = addslashes(strtoupper($_POST['nom_apli']));
$estado_registro = "";
$fecha_registro = date("Y-m-d H:i:s");
$id_user = $_SESSION['id_user_apl'];
/* Fin de Registro*/

$bitacora_contenido = "";

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new insert_pid();
if($result = $object->insertar_aplicativo($txt_apli, $sl_flujo, $sl_grupo)){
    echo "true";
    $result_registro = $object->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
}else{
    echo "false";
}
?>
