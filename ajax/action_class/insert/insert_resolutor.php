<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Resolutor */
$txt_res = addslashes($_POST['txt_res']);
$area_res = addslashes($_POST['txt_area']);
$jefe_res = addslashes($_POST['txt_jefe']);
$cargo_res = addslashes($_POST['txt_cargo']);
/* Fin de Resolutor */

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new insert_pid();
if($result = $object->insertar_resolutor($txt_res, $area_res, $jefe_res, $cargo_res)){
    echo "true";
}else{
    echo "false";
}
?>
