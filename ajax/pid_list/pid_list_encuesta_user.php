<?php
    session_start();
    require_once ('../../data/pid_encuesta.php');
    $object = new Encuesta();
    $data = $object ->list_encuesta_user();
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>