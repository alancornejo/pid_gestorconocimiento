<?php
    session_start();
    require_once ('../../data/pid_encuesta.php');
    $object = new Encuesta();
    $data = $object ->list_enc_opciones();
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>