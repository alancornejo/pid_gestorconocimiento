<?php
    session_start();
    require_once '../../../data/pid_data.php';
    $object = new insert_pid();
    $object_vaciar = new vaciar_tabla();
    $object_utf8 = new utf8_fix();
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $fname = $_POST['sel_file_jobs'];
    $chk_ext = explode(".",$fname);
    if(strtolower(end($chk_ext)) == "txt"){
        $filename = $_POST['sel_file_jobs'];;
        $handle = fopen($filename, "r");
        $result_vaciar = $object_vaciar->vaciar_matriz_jobs();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            $nom_job = addslashes($data[0]);
            $apl_job = addslashes($data[1]);
            $group_job = addslashes($data[2]);
            $cyclic_job = addslashes($data[3]);
            $nom_analista_job = addslashes($data[4]);
            $desc_job = addslashes($data[5]);
            $obs_job = addslashes($data[6]);
            //$result_utf8 = $object_utf8->fix_utf8();();
            $result = $object->insertar_matriz_jobs($nom_job, $apl_job, $group_job, $cyclic_job, $nom_analista_job, $desc_job, $obs_job);
        }
        fclose($handle);
        echo 1;
    }else{
        echo 0;
    }
?>