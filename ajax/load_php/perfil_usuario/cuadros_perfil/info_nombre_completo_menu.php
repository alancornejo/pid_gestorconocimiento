<?php
    session_start();
    date_default_timezone_set('America/Bogota');
    header('Content-type: text/html; charset=UTF-8');
    require_once ('../../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_auth();
    $result = $object->user_auth($id_user);
    $row_profile = $result->fetch_assoc();    
?>
<?= utf8_encode($row_profile['nom_user']) ?>