<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_view.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    
    $id = $_GET['id_user'];
    $user_id = $_GET['id_user'];
    
    $id_user = $_SESSION['id_user_apl'];
    
    $object_view = new pid_view();
    $result_view = $object_view->view_usuario($id);
    $row = $result_view->fetch_assoc();
    
    $password = MD5($row['claro_user']);
    
    $object = new update_pid();
    $object_permisos = new pid_permisos();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['rein_password'] == "true"){
        if($result = $object->update_password($user_id, $password)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }
    
?>