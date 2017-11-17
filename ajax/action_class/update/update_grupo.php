<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Grupo Asignado */
    $txt_grupo = addslashes(strtoupper($_POST['txt_grupo']));
    $id_grupo = $_POST['id_grupo'];
    /* Fin de Grupo Asignado */
    
    /* Registro */
    $modelo_registro = "4";
    $tipo_registro = "2";
    $id_modelo = addslashes(strtoupper($_POST['txt_grupo_original']));
    $contenido_registro = addslashes(strtoupper($_POST['txt_grupo']));
    $estado_registro = "";
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */    
    
    $bitacora_contenido = "";
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new update_pid();
    $object_registro = new insert_pid();
    if($result = $object->update_grupo($txt_grupo, $id_grupo)){
        echo "true";
        $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
