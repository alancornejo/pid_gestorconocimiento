<?php
    session_start();
    require_once '../../../data/pid_data.php';
    $object = new update_pid();
    $object_vaciar = new vaciar_tabla();
    $object_utf8 = new utf8_fix();
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $fname = $_POST['sel_file_horarios'];
    $chk_ext = explode(".",$fname);
    if(strtolower(end($chk_ext)) == "xls"){
        $filename = $_POST['sel_file_horarios'];;
        $result = $object->update_ruta_horarios($filename);
        echo 1;
    }else{
        echo 0;
    }
?>