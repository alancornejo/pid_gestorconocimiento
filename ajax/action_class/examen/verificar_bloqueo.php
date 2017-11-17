<?php
    session_start();
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    include("../../../data/pid_examen.php");
    $id_user = $_SESSION['id_user_apl'];
    $object = new examen_usuario();
    $result = $object->validar_usuario($id_user);
    $row = $result->fetch_assoc();
    echo $row['bloqueo_examen'];