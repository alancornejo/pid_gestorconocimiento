<?php
session_start();
require_once ('../../../data/pid_encuesta.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$id_encuesta = $_POST['id_encuesta'];
$titulo_encuesta = addslashes($_POST['txt_titulo']);
$habilitar_comentario = $_POST['sl_comentario'];
$mensaje_encuesta = addslashes($_POST['txt_mensaje']);
$fec_inicio_enc = $_POST['fec_inicio_enc_edit'];
$fec_termino_enc = $_POST['fec_termino_enc_edit'];

//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new Encuesta();

if($result = $object->edit_encuesta($titulo_encuesta, $habilitar_comentario, $mensaje_encuesta, $id_encuesta, $fec_inicio_enc, $fec_termino_enc)){
    echo "true";
}else{
    echo "false";
}