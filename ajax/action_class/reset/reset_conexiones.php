<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    
    /* Registro */
    $modelo_registro = "5";
    $tipo_registro = "5";
    $id_modelo = "conexion";
    $contenido_registro = NULL;
    $estado_registro = "";
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */
    
    $bitacora_contenido = "";
    
    $object = new update_pid();
    $object_registro = new insert_pid();
    $object_permisos = new pid_permisos();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['rein_cone_usua'] == "true"){
        if($result = $object->update_conexiones_reset()){
            echo "true";
            $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }
?>