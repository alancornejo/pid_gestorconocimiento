<?php
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $titulo = addslashes($_POST['txt_borrador']);
    $id_autor = $_POST['id_autor'];
    $ip_autor = $_POST['ip_autor'];
    $fecha_creacion = $_POST['fec_creacion'];
    $contenido = addslashes($_POST['contenido']);
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new insert_pid();
    
    if($result = $object->insertar_borrador($titulo, $ip_autor, $id_autor, $fecha_creacion, $contenido)){
        echo "true";
    }else{
        echo "false";
    }
    
?>