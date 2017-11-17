<?php
require_once ('../../../data/pid_data.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
$id_tabla = $_POST['id_tabla'];
$contenido = addslashes($_POST['contenido_comentario']);
$id_user = $_POST['id_user'];
$fec_comentario = date("Y-m-d H:i:s");

$object = new comentarios_pid();
$object_update = new update_pid();


if($result = $object->insertar_comentario($id_tabla, $contenido, $id_user, $fec_comentario) && $result_update_comentario = $object_update->update_comentarios_nuevos($id_tabla)){
    echo "true";
}else{
    echo "false";
}