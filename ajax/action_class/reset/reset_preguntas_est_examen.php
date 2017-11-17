<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    
    $id_user = $_SESSION['id_user_apl'];
    $id_examen = $_GET['id'];
    
    $object = new update_pid();
    $object_permisos = new pid_permisos();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['rein_est_pregunta'] == "true"){
        if($result = $object->update_estadistica_pregunta_examen($id_examen)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }
?>