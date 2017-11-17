<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

$id_noticia = $_POST['id_noticia_edit'];
$txt_noticia = utf8_decode($_POST['txt_titulo_not_edit']);
$contenido_noticia = utf8_decode($_POST['txt_contenido_noticia_edit']);

$string_ruta_imagen = $_POST['ruta_imagen_noticia_edit'];

if(strpos($string_ruta_imagen, "http://localhost:8080/apl/") == "false"){
    $imagen_noticia = str_replace("http://localhost:8080/apl/", "/", $string_ruta_imagen);
}else if(strpos($string_ruta_imagen, "http://10.200.10.90/apl/") == "false"){
    $imagen_noticia = str_replace("http://10.200.10.90/apl/", "/", $string_ruta_imagen);
}else if(strpos($string_ruta_imagen, "http://pid.cosapidata.pe/") == "false"){
    $imagen_noticia = str_replace("http://pid.cosapidata.pe/", "/", $string_ruta_imagen);
}else{
    $imagen_noticia = $string_ruta_imagen;
}

$tipo_noticia = $_POST['sl_tipo_noticia_edit'];
$fecha_noticia = $_POST['fecha_noticia_edit'];
$fuente_noticia = $_POST['txt_fuente_noticia_edit'];

$object = new update_pid();
if($result = $object->update_noticia_portal($txt_noticia, $contenido_noticia, $imagen_noticia, $tipo_noticia, $fecha_noticia, $fuente_noticia, $id_noticia)){
    echo "true";
}else{
    echo "false";
}