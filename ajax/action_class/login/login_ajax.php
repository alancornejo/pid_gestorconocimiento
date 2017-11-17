<?php
require_once ('../../../data/pid_access.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
$object = new pid_login();
$object_bloqueo = new pid_auth();
session_start();
if(isset($_POST['username']) && isset($_POST['password'])){
    $username =  strtoupper($_POST['username']); 
    $password = md5($_POST['password']);
    $result = $object->pid_autentificador($username, $password);
    $result_bloqueo = $object_bloqueo->verificar_bloqueo($username);
    $count = $result->num_rows;
    $count_bloqueo = $result_bloqueo->num_rows;
    $row = $result->fetch_array();
    $row_bloqueo = $result_bloqueo->fetch_assoc();
    if($count==1){
        if($count_bloqueo == 1){
            if(strtotime($row_bloqueo['fec_desbloqueo']) < strtotime(date("Y-m-d H:i:s"))){
                $_SESSION['id_user_apl'] = $row['id_user'];
                $_SESSION['nom_user'] = $row['nom_user'];
                $_SESSION['claro_user'] = $row['claro_user'];
                $_SESSION['ip_user'] = $row['ip_user'];
                $_SESSION['funcion_user'] = $row['funcion_user'];
                $_SESSION['tipo_servicio'] = $row['tipo_user'];
                echo "conectado";
            }else{
                echo date("d/m", strtotime($row_bloqueo['fec_desbloqueo']))." a las ".date("H:i a", strtotime($row_bloqueo['fec_desbloqueo']));
            }
        }else{
            $_SESSION['id_user_apl'] = $row['id_user'];
            $_SESSION['nom_user'] = $row['nom_user'];
            $_SESSION['claro_user'] = $row['claro_user'];
            $_SESSION['ip_user'] = $row['ip_user'];
            $_SESSION['funcion_user'] = $row['funcion_user'];
            $_SESSION['tipo_servicio'] = $row['tipo_user'];
            echo "conectado";
        }
    }else{
        echo "incorrecto";
    }
}