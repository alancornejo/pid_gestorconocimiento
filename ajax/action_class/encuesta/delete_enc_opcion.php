<?php
    session_start();
    require_once '../../../data/pid_encuesta.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Opcion */
    $id_enc_opcion = $_GET['id'];
    /* Fin de Opcion */
    
    $id_user = $_SESSION['id_user_apl'];
    
    $object = new Encuesta();
    $object_permisos = new pid_permisos();

    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['dele_opc_enc'] == "true"){
        if($result = $object->delete_enc_opc($id_enc_opcion)){
            echo "true";
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }