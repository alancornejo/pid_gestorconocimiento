<?php
session_start();
require_once ('../../../data/pid_examen.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$nom_pregunta_1 = preg_replace('/<p[^>]*>/','',addslashes($_POST['nom_pregunta']));
$nom_pregunta = preg_replace('/<\/p>/','',$nom_pregunta_1);
$respuesta_1 = addslashes(utf8_encode($_POST['respuesta_1']));
$respuesta_2 = addslashes(utf8_encode($_POST['respuesta_2']));
$respuesta_3 = addslashes(utf8_encode($_POST['respuesta_3']));
$respuesta_4 = addslashes(utf8_encode($_POST['respuesta_4']));
$respuesta_correcta = $_POST['sl_respuesta'];
$usuario_propuesta = $_SESSION['id_user_apl'];
$fec_propuesta = date("Y-m-d H:i:s");

//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new examen_usuario();
if($result = $object->insert_pregunta_propuesta($nom_pregunta, $respuesta_1, $respuesta_2, $respuesta_3, $respuesta_4, $respuesta_correcta, $usuario_propuesta, $fec_propuesta)){
    echo "true";
}else{
    echo "false";
}