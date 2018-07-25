<?php
    require_once ('../../data/pid_data.php');
    $object = new pid_list();
    $data = $object ->list_pid_kdb_json_usuario();
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>