<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $id = $_GET['id_borrador'];
    $txt_motivo = $_GET['txt_motivo'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new delete_pid();
    $object_permisos = new pid_permisos();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['dele_borra'] == "true"){
        if($result = $object->delete_borrador($id, $txt_motivo)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }
    