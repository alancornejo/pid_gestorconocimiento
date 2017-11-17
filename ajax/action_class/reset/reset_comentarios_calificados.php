<?php
    session_start();
    require_once ('../../../data/pid_data.php');
    require_once '../../../data/pid_access.php';
    
    $id_user = $_SESSION['id_user_apl'];
    
    $object = new comentarios_pid();
    $object_permisos = new pid_permisos();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['rein_comment_cali_all'] == "true"){
        if($result = $object->resetear_comentarios_calificados()){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }