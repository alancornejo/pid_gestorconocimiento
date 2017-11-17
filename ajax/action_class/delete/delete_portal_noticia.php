<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Noticia */
    $id_noticia = $_GET['id'];
    /* Fin de Noticia */
    
    $id_user = $_SESSION['id_user_apl'];
    
    $object = new delete_pid();
    $object_permisos = new pid_permisos();

    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['dele_port_not'] == "true"){
        if($result = $object->delete_portal_noticia($id_noticia)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }