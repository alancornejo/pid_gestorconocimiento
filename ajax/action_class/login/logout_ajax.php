<?php
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    include("../../../data/pid_data.php");
    session_start();
    $id_user = $_SESSION['id_user_apl'];
    $cierre_sesion = date("Y-m-d H:i:s");
    $object = new update_pid();
    if(!empty($_SESSION['id_user_apl'])){
        $result = $object->update_cierre_sesion($cierre_sesion, $id_user);
        $_SESSION['id_user_apl']='';
    }
?>
