<?php
require_once ("../../../data/pid_encuesta.php");
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
session_start();
$object = new Encuesta();
$qid = $_POST['qid'];
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
    foreach($qid as $enc_pre => $id_enc_pregunta){
        $rpta_enc = $_POST[$id_enc_pregunta];
        if($rpta_enc == NULL || $rpta_enc == "" || empty($rpta_enc)){
            $valor = "false";
        }else{
            $fecha_resultado = date("Y-m-d h:i:s");
            $ip_resultado = $_SERVER['REMOTE_ADDR'];
            $id_user = $_SESSION['id_user_apl'];
            $id_encuesta = $_SESSION['portal_id_encuesta'];
            if($result = $object->finalizar_encuesta($id_enc_pregunta, $rpta_enc, $ip_resultado, $fecha_resultado) && $object->restringir_mini_encuesta($id_user, $id_encuesta)){
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
    }
}