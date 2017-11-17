<?php
    session_start();
    require_once '../../../data/pid_data.php';
    require_once '../../../data/pid_view.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Conocimiento */
    $id = $_GET['id'];
    /* Fin de Conocimiento */
    
    /* Validar Conocimiento */
    $object_view = new pid_view();
    $result_view = $object_view->view_contenido($id);
    $row = $result_view->fetch_assoc();
    /* Fin de Validar Conocimiento */
    
    /* Registro */
    $modelo_registro = "2";
    $tipo_registro = "4";
    $id_modelo = $_GET['id'];
    $contenido_registro = $row['contenido'];
    $estado_registro = $row['id_atu'];
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */
    
    $bitacora_contenido = "";
    
    $object = new delete_pid();
    $object_registro = new insert_pid();
    
    if($result = $object->delete_conocimiento($id)){
        echo "true";
        $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }