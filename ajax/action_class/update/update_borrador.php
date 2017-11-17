<?php
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $txt_borrador = addslashes($_POST['txt_borrador']);
    $id_tabla = $_POST['id_tabla'];
    $contenido = addslashes($_POST['txt_contenido']);
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new update_pid();
    if($result = $object->update_borrador($txt_borrador, $id_tabla, $contenido)){
        echo "true";
    }else{
        echo "false";
    }
