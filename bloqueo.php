<?php
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
    if(empty($_SESSION['id_user_apl']))
    {
        header('Location: login');
    }
    date_default_timezone_set('America/Bogota');
    require_once("data/pid_data.php");
    require_once("data/pid_access.php");
    session_start();
    $id_user = $_SESSION['id_user_apl'];
    $claro_user = $_SESSION['claro_user'];
    $cierre_sesion = date("Y-m-d H:i:s");
    $object = new update_pid();
    $object_insert = new insert_pid();
    $object_usuario = new pid_auth();
    $result_usuario = $object_usuario->user_auth($id_user);
    $row_usuario = $result_usuario->fetch_assoc();
    $fec_login = $row_usuario['inicio_sesion'];
    $ip_login = $row_usuario['ip_user'];
    $fec_bloqueo = date("Y-m-d H:i:s");
    $ip_bloqueo = $_SERVER['REMOTE_ADDR'];
    $hora_desbloqueo = strtotime('+3 minutes');
    $fec_desbloqueo = date("Y-m-d")." ".date("H:i", $hora_desbloqueo).":00";
    
    $result_insertar = $object_insert->insertar_bloqueo_user($id_user, $claro_user, $fec_login, $ip_login, $fec_bloqueo, $ip_bloqueo, $fec_desbloqueo);
    if(!empty($_SESSION['id_user_apl'])){
        $result = $object->update_cierre_sesion($cierre_sesion, $id_user);
        $_SESSION['id_user_apl']='';
    }
    header('Location: login');
?>