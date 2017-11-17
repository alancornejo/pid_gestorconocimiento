<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    
    $id_user = $_SESSION['id_user_apl'];
    
    $object = new update_pid();
    $object_permisos = new pid_permisos();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['rein_all_est_pregunta'] == "true"){
        if($result = $object->update_estadisticas_preguntas()){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }
?>