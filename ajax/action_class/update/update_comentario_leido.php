<?php
    session_start();
    require_once ('../../../data/pid_data.php');
    require_once ('../../../data/pid_access.php');
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $id_comentario = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new comentarios_pid();
    $object_permisos = new pid_permisos();
    
    $fec_leido = date("Y-m-d H:i:s");
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['apro_comment'] == "true"){
        if($result = $object->update_comentario_leido($id_comentario, $fec_leido)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }