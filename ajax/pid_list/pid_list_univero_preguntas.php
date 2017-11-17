<?php
    session_start();
    require_once ('../../data/pid_examen.php');
    $object = new examen_usuario();
    $data = $object ->list_univero_preguntas();
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>