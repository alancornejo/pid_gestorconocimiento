<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_view.php';
    require_once '../../../data/pid_access.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Categoria */
    $id = $_GET['id'];
    /* Fin de Categoria */
    
    /* Validar Categoria */
    $object_view = new pid_view();
    $result_view = $object_view->view_categoria($id);
    $row = $result_view->fetch_assoc();
    /* Fin de Validar Categoria */
    
    /* Registro */
    $modelo_registro = "3";
    $tipo_registro = "4";
    $id_modelo = $_GET['id'];
    $contenido_registro = $row['nom_cat'];
    $estado_registro = "";
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */
    
    $bitacora_contenido = "";
    
    $object = new delete_pid();
    $object_registro = new insert_pid();
    $object_permisos = new pid_permisos();
    
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['dele_cat'] == "true"){
        if($result = $object->delete_categoria($id)){
            echo "true";
            $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
        }else{
            echo "false";
        }
    }else{
        echo "sin_permiso";
    }