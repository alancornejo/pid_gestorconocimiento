<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
/* Bitacora */
$fec_bitacora = $_POST['fec_bitacora'];
$sl_impacto = $_POST['sl_impacto'];
$num_afectados = $_POST['num_afectados'];
$num_correos = $_POST['num_correos'];
$sl_asignado = $_POST['sl_asignado'];
$sl_afectado = $_POST['sl_afectado'];
$txt_bitacora = strtoupper(addslashes($_POST['txt_bitacora']));
$txt_responsable = strtoupper(addslashes($_POST['txt_responsable']));
$num_caso = $_POST['num_caso'];
$sl_estado = strtoupper($_POST['sl_estado']);
$fec_apertura = $_POST['fec_apertura'];
$fec_recepcion = $_POST['fec_recepcion'];
$contenido = addslashes($_POST['contenido']);
/* Fin de Bitacora */

/* Registro */
$modelo_registro = "2";
$tipo_registro = "1";
$id_modelo = $_POST['num_caso'];
$contenido_registro = addslashes($_POST['contenido']);
$estado_registro = $sl_estado;
$fecha_registro = date("Y-m-d H:i:s");
$id_user = $_SESSION['id_user_apl'];
/* Fin de Registro */

$bitacora_contenido = "";

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new insert_pid();
if($result = $object->insertar_bitacora($fec_bitacora, $sl_impacto, $num_afectados, $num_correos, $sl_asignado, $sl_afectado, $txt_bitacora, $txt_responsable, $num_caso, $sl_estado, $fec_apertura, $fec_recepcion, $contenido)){
    echo "true";
    $result_registro = $object->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
}else{
    echo "false";
}
?>
