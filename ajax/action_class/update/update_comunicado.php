<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Comunicado */
    $titulo_comunicado = addslashes($_POST['txt_titulo_com']);
    $string_ruta_correo = $_POST['ruta_correo'];
    if(strpos($string_ruta_correo, "http://localhost:8080/apl/") == "false"){
        $url_correo = str_replace("http://localhost:8080/apl/", "/", $string_ruta_correo);
    }else if(strpos($string_ruta_correo, "http://10.200.10.90/apl/") == "false"){
        $url_correo = str_replace("http://10.200.10.90/apl/", "/", $string_ruta_correo);
    }else if(strpos($string_ruta_correo, "http://pid.cosapidata.pe/") == "false"){
        $url_correo = str_replace("http://pid.cosapidata.pe/", "/", $string_ruta_correo);
    }else{
        $url_correo = $string_ruta_correo;
    }
    $contenido_comunicado = addslashes($_POST['txt_contenido_com']);
    $user_id_comunicado = $_SESSION['id_user_apl'];
    $id_comunicado = $_POST['id_comunicado'];
    $sl_estado = $_POST['sl_estado_com'];
    
    if($_POST['estado_urg_ori'] == $_POST['sl_estado_urg']){
        $origen = "igual";
        $sl_estado_urg = $_POST['estado_urg_ori'];
    }else{
        if($_POST['sl_estado_urg'] == 1){
            $origen = "desigual";
            $dias = 2;
            $sl_estado_urg = $_POST['sl_estado_urg'];
        }else if($_POST['sl_estado_urg'] == 2){
            $origen = "desigual";
            $dias = 5;
            $sl_estado_urg = $_POST['sl_estado_urg'];
        }else if($_POST['sl_estado_urg'] == 3){
            $origen = "desigual";
            $dias = 1;
            $sl_estado_urg = $_POST['sl_estado_urg'];
        }
    }
    
    if($_POST['fecha_ori'] == $_POST['fecha_actualizacion']){
        $fecha_actualizacion = $_POST['fecha_ori'];
        if($origen == "igual"){
            $fecha_aviso = $_POST['fecha_aviso'];
        }else{
            $aviso = date("Y-m-j",  strtotime($fecha_actualizacion));
            $fecha_aviso = strtotime('+'.$dias.' day', strtotime($aviso));
            $fecha_aviso = date("Y-m-d", $fecha_aviso)." ".date("H:i:s",  strtotime($fecha_actualizacion));
        }
    }else{
        $fecha_actualizacion = $_POST['fecha_actualizacion'];
        if($origen == "desigual"){
            $aviso = date("Y-m-j",  strtotime($fecha_actualizacion));
            $fecha_aviso = strtotime('+'.$dias.' day', strtotime($aviso));
            $fecha_aviso = date("Y-m-d", $fecha_aviso)." ".date("H:i:s",  strtotime($fecha_actualizacion));
        }else{
            if($_POST['estado_urg_ori'] == 1){
                $dias = 2;
            }else if($_POST['estado_urg_ori'] == 2){
                $dias = 5;
            }else if($_POST['estado_urg_ori'] == 3){
                $dias = 1;
            }
            $aviso = date("Y-m-j",  strtotime($fecha_actualizacion));
            $fecha_aviso = strtotime('+'.$dias.' day', strtotime($aviso));
            $fecha_aviso = date("Y-m-d", $fecha_aviso)." ".date("H:i:s",  strtotime($fecha_actualizacion));
        }
    }
    
    /* Fin de Comunicado */
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new update_pid();
    
    if($result = $object->update_comunicado($titulo_comunicado, $fecha_actualizacion, $fecha_aviso, $url_correo, $sl_estado, $sl_estado_urg, $contenido_comunicado, $user_id_comunicado, $id_comunicado)){
        echo "true";
    }else{
        echo "false";
    }
?>