<?php
session_start();
require_once ('../../../data/pid_encuesta.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
$txt_pregunta = addslashes($_POST['txt_pregunta']);
$tipo_pregunta = $_POST['sl_opciones'];
$num_opciones = $_POST['num_opciones'];
$date_creacion = date("Y-m-d H:i:s");
$creador_pregunta = $_SESSION['id_user_apl'];
$estado_pregunta = $_POST['sl_estado'];
$id_encuesta = $_POST['sl_asignar'];

//$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new Encuesta();

$result_encuesta = $object->view_encuesta($id_encuesta);
$row = $result_encuesta->fetch_assoc();

if($row['habilitar_comentario'] == 0 && $tipo_pregunta == 1){
    echo "comentario_deshabilitado";
}else{
    if($tipo_pregunta == 1){
        if($result = $object->insert_enc_pregunta_comentario($txt_pregunta, $tipo_pregunta, $date_creacion, $creador_pregunta, $estado_pregunta, $id_encuesta)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        if($result = $object->insert_enc_pregunta($txt_pregunta, $tipo_pregunta, $num_opciones, $date_creacion, $creador_pregunta, $estado_pregunta, $id_encuesta)){
            echo "true";
        }else{
            echo "false";
        }
    }
}