<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    $area_resp = utf8_decode($_POST['sl_area_resp']);
    $apl_pla = utf8_decode($_POST['sl_apl_pl_caso']);
    $tipo_cargo = utf8_decode($_POST['sl_cargo']);
    $nom_responsable = utf8_decode($_POST['sl_responsable']);
    $num_anexo = $_POST['txt_anexo'];
    $num_celular = $_POST['txt_telefono'];
    $id_matriz = $_POST['txt_id_matriz'];

    $object = new update_pid();
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    if($result = $object->update_matriz_responsable($area_resp, $apl_pla, $tipo_cargo, $nom_responsable, $num_anexo, $num_celular, $id_matriz)){
        echo "true";
    }else{
        echo "false";
    }