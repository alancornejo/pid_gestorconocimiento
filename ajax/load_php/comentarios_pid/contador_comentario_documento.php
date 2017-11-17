<?php
session_start();
require_once ('../../../data/pid_data.php');
$id_user = $_SESSION['id_user_apl'];
$id_tabla = $_GET['id_tabla_comment'];
$object = new comentarios_pid();
$result = $object->contador_comentario_documento($id_user, $id_tabla);
$row = $result->fetch_assoc();
if($row['num_comentario'] == "0" || $row['num_comentario'] == NULL){
    $num_comentario = "[0]";
}else{
    $num_comentario = "[".$row['num_comentario']."]";
}

echo $num_comentario;