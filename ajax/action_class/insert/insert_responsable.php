<?php
    session_start();
    require_once '../../../data/pid_data.php';
    $object = new insert_pid();
    $object_vaciar = new vaciar_tabla();
    $object_utf8 = new utf8_fix();
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $fname = $_POST['sel_file_responsable'];
    $chk_ext = explode(".",$fname);
    if(strtolower(end($chk_ext)) == "txt"){
        $filename = $_POST['sel_file_responsable'];;
        $handle = fopen($filename, "r");
        $result_vaciar = $object_vaciar->vaciar_matriz_responsables();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            $area_resp = addslashes($data[0]);
            $apl_pla = addslashes($data[1]);
            $tipo_cargo = addslashes($data[2]);
            $nom_responsable = addslashes($data[3]);
            $num_anexo = $data[4];
            $num_celular = $data[5];
            //$result_utf8 = $object_utf8->fix_utf8();();
            $result = $object->insertar_matriz_responsable($area_resp, $apl_pla, $tipo_cargo, $nom_responsable, $num_anexo, $num_celular);
        }
        fclose($handle);
        echo 1;
    }else{
        echo 0;
    }
?>