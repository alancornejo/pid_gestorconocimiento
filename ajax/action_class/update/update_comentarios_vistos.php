<?php
require_once ('../../../data/pid_data.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
$id_tabla = $_GET['id'];
$id = $_GET['id'];
$fec_leido = date("Y-m-d H:i:s");
$object = new comentarios_pid();
$object_update = new update_pid();
$result = $object->update_comentarios_vistos($id_tabla, $fec_leido);
if($_GET['permisos'] == "true"){
    if($_GET['comentario_nuevo'] == "1"){
        $result_update = $object_update->update_leer_comentarios($id);
    }
}
