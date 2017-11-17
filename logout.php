<?php
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
    if(empty($_SESSION['id_user_apl']))
    {
        header('Location: login');
    }
    date_default_timezone_set('America/Bogota');
    require_once("data/pid_data.php");
    session_start();
    $id_user = $_SESSION['id_user_apl'];
    $cierre_sesion = date("Y-m-d H:i:s");
    $object = new update_pid();
    if(!empty($_SESSION['id_user_apl'])){
        $result = $object->update_cierre_sesion($cierre_sesion, $id_user);
        $_SESSION['id_user_apl']='';
    }
    header('Location: login');
?>