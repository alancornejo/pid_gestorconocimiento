<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Resolutor */
$id_res = $_POST['id_res'];
$txt_res = addslashes($_POST['txt_res_edit']);
$area_res = addslashes($_POST['txt_area_edit']);
$jefe_res = addslashes($_POST['txt_jefe_edit']);
$cargo_res = addslashes($_POST['txt_cargo_edit']);
/* Fin de Resolutor */

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new update_pid();
if($result = $object->update_resolutor($txt_res, $area_res, $jefe_res, $cargo_res, $id_res)){
    echo "true";
}else{
    echo "false";
}
?>
