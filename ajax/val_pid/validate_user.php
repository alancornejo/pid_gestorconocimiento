<?php
require_once("../../data/pid_val.php");
$claro_usuario = strtoupper($_POST['claro_usuario']);
$object = new pid_validate();
$result = $object->usuario_validate($claro_usuario);
$validate = mysqli_num_rows($result);
if($validate == 0){
    echo 0;
}else{
    echo 1;
}
?>
