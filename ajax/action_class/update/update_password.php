<?php
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $id_user = $_POST['user_id'];
    $password = md5($_POST['txt_password']);
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new update_pid();
    if($result = $object->update_password($id_user, $password)){
        echo "true";
    }else{
        echo "false";
    }    
?>