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
$id_atu = $_POST['id_atu'];
$id_apli = $_POST['sl_aplicativo'];
$id_examen = implode(',', $_POST['sl_asignar']);
$dificultad = $_POST['sl_dificultad'];
$id_pregunta = $_POST['id_pregunta'];

//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new examen_usuario();
if($result = $object->update_pregunta($nom_pregunta, $respuesta_1, $respuesta_2, $respuesta_3, $respuesta_4, $respuesta_correcta, $id_atu, $id_apli, $id_examen, $dificultad, $id_pregunta)){
    echo "true";
}else{
    echo "false";
}