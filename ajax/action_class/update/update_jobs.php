<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    $nom_job = utf8_decode($_POST['nom_job']);
    $apl_job = utf8_decode($_POST['apl_job']);
    $group_job = utf8_decode($_POST['group_job']);
    $cyclic_job = utf8_decode($_POST['cyclic_job']);
    $nom_analista_job = utf8_decode($_POST['nom_analista_job']);
    $obs_job = utf8_decode($_POST['obs_job']);
    $desc_job = utf8_decode($_POST['desc_job']);
    $id_jobs = $_POST['id_jobs'];

    $object = new update_pid();
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    if($result = $object->update_matriz_jobs($nom_job, $id_jobs, $apl_job, $group_job, $cyclic_job, $nom_analista_job, $obs_job, $desc_job)){
        echo "true";
    }else{
        echo "false";
    }