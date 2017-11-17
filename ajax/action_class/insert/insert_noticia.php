<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

$txt_noticia = utf8_decode($_POST['txt_titulo_not']);
$contenido_noticia = utf8_decode($_POST['txt_contenido_noticia']);

$string_ruta_imagen = $_POST['ruta_imagen_noticia'];


$imagen_noticia = $string_ruta_imagen;

$tipo_noticia = $_POST['sl_tipo_noticia'];
$fecha_noticia = $_POST['fecha_noticia'];
$fuente_noticia = $_POST['txt_fuente_noticia'];

$object = new insert_pid();
if($result = $object->insertar_noticia($txt_noticia,$contenido_noticia,$imagen_noticia,$tipo_noticia,$fecha_noticia,$fuente_noticia)){
    echo "true";
}else{
    echo "false";
}