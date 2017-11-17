<?php
require_once("../../data/pid_val.php");
$nom_apli = $_POST['nom_apl'];
$id_cat = $_POST['id_cat'];
$id_grupo = $_POST['id_grupo'];
$object = new pid_validate();
$result = $object->aplicativo_validate($nom_apli, $id_cat, $id_grupo);
$validate = mysqli_num_rows($result);
if($validate == 0){
    echo 0;
}else{
    echo 1;
}
?>
