<?php
    session_start();
    require_once '../../../data/pid_examen.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Pregunta */
    $id = $_GET['id_pregunta'];
    /* Fin de Pregunta */
    
    $id_user = $_SESSION['id_user_apl'];
    
    $object = new examen_usuario();
    $object_permisos = new pid_permisos();

    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['dele_pre_exam'] == "true"){
        if($result = $object->ocultar_pregunta($id)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }