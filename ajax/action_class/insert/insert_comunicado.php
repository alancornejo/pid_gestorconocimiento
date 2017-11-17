<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Comunicado */
    $titulo_comunicado = addslashes($_POST['txt_titulo_com']);
    $fecha_creacion = $_POST['fecha_comunicado'];
    $sl_estado_urg = $_POST['sl_estado_urg'];
    if($sl_estado_urg == 1){
        $dias = 2;
    }else if($sl_estado_urg == 2){
        $dias = 5;
    }else{
        $dias = 1;
    }
    
    $aviso = date("Y-m-j",  strtotime($fecha_creacion));
    $fecha_aviso = strtotime('+'.$dias.' day', strtotime($aviso));
    $fecha_aviso = date("Y-m-d", $fecha_aviso)." ".date("H:i:s", strtotime($fecha_creacion));

    $string_ruta_correo = $_POST['ruta_correo'];

    $url_correo = $string_ruta_correo;

    $sl_estado = $_POST['sl_estado_com'];
    $contenido_comunicado = addslashes($_POST['txt_contenido_com']);
    $user_id_comunicado = $_SESSION['id_user_apl'];
    /* Fin de Comunicado */
    
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new insert_pid();
        
    if($result = $object->insertar_comunicado($titulo_comunicado, $fecha_creacion, $fecha_aviso, $url_correo, $sl_estado, $sl_estado_urg, $contenido_comunicado, $user_id_comunicado)){
        echo "true";
    }else{
        echo "false";
    }
?>