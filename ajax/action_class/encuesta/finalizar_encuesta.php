<?php
require_once ("../../../data/pid_encuesta.php");
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
session_start();
$object = new Encuesta();
$qid = $_POST['qid'];
$sl_comentario = $_POST['sl_comentario'];
$txt_comentario = $_POST['enc_comentario'];
$i = 0;
foreach($qid as $enc_pre => $id_enc_pregunta){
    $i = $i + 1;
    if(empty($_POST[$id_enc_pregunta])){
        $valor[$i] = "vacio";
    }else{
        $valor[$i] = "lleno";
    }
}

if(in_array("vacio", $valor)) {
    echo "false";
}else{
    if($sl_comentario != NULL || $txt_comentario != NULL || strlen(utf8_decode($txt_comentario)) > 0){
        foreach($qid as $enc_pre => $id_enc_pregunta){
            $rpta_enc = $_POST[$id_enc_pregunta];
            if($rpta_enc == NULL || $rpta_enc == "" || empty($rpta_enc)){
                $valor = "false";
            }else{
                $fecha_resultado = date("Y-m-d h:i:s");
                $ip_resultado = $_SERVER['REMOTE_ADDR'];
                if($result = $object->finalizar_encuesta($id_enc_pregunta, $rpta_enc, $ip_resultado, $fecha_resultado)){
                    $valor = "true";
                }else{
                    $valor = "false";
                }
            }
        }
        if(substr($valor, -5) == "false"){
            echo "false";
        }else{
            echo "true";
            $id_encuesta = $_POST['id_encuesta'];
            $id_enc_pre_comentario = $_POST['id_enc_pre_comentario'];
            $ip_comentario = $_SERVER['REMOTE_ADDR'];
            $fecha_comentario = date("Y-m-d h:i:s");
            $result_com = $object->finalizar_encuesta_comentario($id_encuesta, $sl_comentario, $txt_comentario, $id_enc_pre_comentario, $ip_comentario, $fecha_comentario);
        }
    }else{
        echo "false";
    }
}