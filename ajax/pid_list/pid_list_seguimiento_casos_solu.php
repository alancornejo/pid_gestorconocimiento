<?php
    require_once ('../../data/pid_data.php');
    $object = new pid_list();
    $data = $object ->list_pid_seguimiento_casos_solu();
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>