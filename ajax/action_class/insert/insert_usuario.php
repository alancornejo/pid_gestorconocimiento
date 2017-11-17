<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Usuario */
    $nom_usuario = utf8_decode($_POST['txt_usuario']);
    $claro_usuario = strtoupper($_POST['txt_claro']);
    $pass_usuario = md5(strtoupper($_POST['txt_claro']));
    $rol_user = $_POST['sl_rol'];
    $funcion_user = $_POST['sl_funcion'];
    $sl_servicio = $_POST['sl_servicio'];
    $id_last_user = ($_POST['last_id_user'])+1;
    /* Fin de Usuario */
    
    /* Registro */
    $modelo_registro = "5";
    $tipo_registro = "1";
    $id_modelo = $_POST['txt_claro'];
    $contenido_registro = $_POST['sl_rol'];
    $estado_registro = "";
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */
    
    $bitacora_contenido = "";
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new insert_pid();
    if($result = $object->insertar_usuario($nom_usuario, $claro_usuario, $pass_usuario, $rol_user, $funcion_user, $sl_servicio)){
        echo "true";
        $result_last_id = $object->insertar_permisos_user($id_last_user);
        $result_registro = $object->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
?>