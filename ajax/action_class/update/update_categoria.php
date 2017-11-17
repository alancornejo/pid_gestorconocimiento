<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Aplicativo */
    $txt_cat = addslashes(strtoupper($_POST['nom_cat_edit']));
    $id_cat = $_POST['id_cat'];
    /* Fin de Aplicativo */
    
    /* Registro */
    $modelo_registro = "3";
    $tipo_registro = "2";
    $id_modelo = addslashes(strtoupper($_POST['nom_cat_original']));
    $contenido_registro = addslashes(strtoupper($_POST['nom_cat_edit']));
    $estado_registro = "";
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */
    
    $bitacora_contenido = "";
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new update_pid();
    $object_registro = new insert_pid();
    if($result = $object->update_categoria($txt_cat, $id_cat)){
        echo "true";
        $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
