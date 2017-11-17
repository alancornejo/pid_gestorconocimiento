<?php
    session_start();
    require_once ('../../data/pid_data.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_list();
    $data = $object ->list_pid_kdb_json_user_borrador($id_user);
    if ($data != false) {
        echo $data;
    } else {
        echo false;
    }
?>