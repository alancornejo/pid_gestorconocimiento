<?php
    require_once ('../../data/pid_data.php');
    $object = new pid_list();
    $data = $object ->list_pid_kdb_biometrico_json();
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>