<?php 

    require_once ('../../../data/pid_data.php');
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    $id_tabla = $_GET['id'];
    if($_GET['estado_comentario'] == "1"){
        $estado_comentario = "0";
    }else{
        $estado_comentario = "1";
    }
    $object = new comentarios_pid();

    if($result = $object->update_estado_comentarios($id_tabla, $estado_comentario)){
        echo "true";
    }else{
        echo "false";
    }