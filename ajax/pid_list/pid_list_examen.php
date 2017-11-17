<?php
    session_start();
    require_once ('../../data/pid_examen.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new examen_usuario();
    $data = $object ->list_examen($id_user);
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>