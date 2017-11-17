<?php
require_once("../../data/pid_val.php");
$nom_res = $_POST['nom_res'];
$area_res = $_POST['area_res'];
$jefe_res = $_POST['jefe_res'];
$cargo_res = $_POST['cargo_res'];
$object = new pid_validate();
$result = $object->resolutor_validate($nom_res, $area_res, $jefe_res, $cargo_res);
$validate = mysqli_num_rows($result);
if($validate == 0){
    echo 0;
}else{
    echo 1;
}
?>
