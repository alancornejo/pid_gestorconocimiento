<?php
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $id_user = $_GET['id_user'];
    $tiempo = $_GET['tiempo'];
    $object = new update_pid();
    $result = $object->update_tiempo_kdb($id_user, $tiempo);
    echo "tiempo";
?>