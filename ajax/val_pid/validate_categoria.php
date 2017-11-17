<?php
require_once("../../data/pid_val.php");
$nom_cat = $_POST['nom_cat'];
$object = new pid_validate();
$result = $object->categoria_validate($nom_cat);
$validate = mysqli_num_rows($result);
if($validate == 0){
    echo 0;
}else{
    echo 1;
}
?>
