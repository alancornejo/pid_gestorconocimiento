<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Bitacora */
$id_bitacora = $_POST['id_bitacora'];
$sl_estado = strtoupper($_POST['sl_estado']);
$fec_solucionado = $_POST['fec_solucionado'];
$fec_apertura = $_POST['fec_apertura'];
$fec_reasi = $_POST['fec_re_asignado'];
$fec_cerrado = $_POST['fec_cerrado'];
/* Fin de Bitacora */

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new update_pid();

if($result = $object->update_fecha_bitacora($id_bitacora, $fec_apertura, $fec_reasi, $fec_solucionado, $fec_cerrado)){
    echo "true";
}else{
    echo "false";
}
?>
