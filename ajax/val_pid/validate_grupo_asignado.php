<?php
require_once("../../data/pid_val.php");
$nom_grupo = $_POST['nom_grupo'];
$object = new pid_validate();
$result = $object->grupo_asignado_validate($nom_grupo);
$validate = mysqli_num_rows($result);
if($validate == 0){
    echo 0;
}else{
    echo 1;
}
?>
