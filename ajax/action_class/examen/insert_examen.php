<?php
session_start();
require_once ('../../../data/pid_examen.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$titulo_examen = addslashes($_POST['txt_titulo']);
$fecha_examen = $_POST['fec_inicio'];
$fecha_revision = $_POST['fec_rev'];
$tiempo_examen = ($_POST['num_duracion'])*60;
$num_preguntas = $_POST['num_pregunta'];
$num_facil = $_POST['num_facil'];
$num_dificil = $_POST['num_dificil'];
$ver_portal = $_POST['sl_portal'];

$object = new examen_usuario();

if($ver_portal == "1"){
    $result_portal = $object->update_exam_portal();
}

//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new examen_usuario();

if($result = $object->insert_examen($titulo_examen, $fecha_examen, $fecha_revision, $tiempo_examen, $num_preguntas, $num_facil, $num_dificil, $ver_portal)){
    echo "true";
}else{
    echo "false";
}
