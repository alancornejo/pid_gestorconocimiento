<?php
    session_start();
    require_once ('../../../data/pid_data.php');
    require_once ('../../../data/pid_access.php');
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $id_comentario = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $id_user_comentario = $_GET['user'];
    if($_GET['estado'] == "0"){
        $estado_comentario = "1";
        $oper_calificado = "+1";
    }else{
        $estado_comentario = "0";
        $oper_calificado = "-1";
    }
    $fec_leido = date('Y-m-d H:i:s');
    $object = new comentarios_pid();
    $object_permisos = new pid_permisos();
    $object_update = new update_pid();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['apro_comment'] == "true"){
        if($result = $object->update_comentario_calificado($id_comentario, $estado_comentario, $fec_leido) && $result_update = $object_update->update_comentarios_calificados($id_user_comentario, $oper_calificado)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }