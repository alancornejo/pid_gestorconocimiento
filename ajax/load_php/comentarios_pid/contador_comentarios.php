<?php
session_start();
require_once ('../../../data/pid_data.php');
require_once ('../../../data/pid_access.php');
$id_user = $_SESSION['id_user_apl'];
$object = new comentarios_pid();
$object_auth = new pid_auth();
$result_auth = $object_auth->user_auth($id_user);
$row_auth = $result_auth->fetch_assoc();
$tipo_usuario = $row_auth['tipo_user'];
$result = $object->contador_comentarios($id_user, $tipo_usuario);
$row = $result->fetch_assoc();
if($row['num_comentario'] == "0" || $row['num_comentario'] == NULL){
    $num_comentario = "0";
}else{
    $num_comentario = $row['num_comentario'];
}

echo $num_comentario;