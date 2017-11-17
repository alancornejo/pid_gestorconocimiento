<?php
require_once ('../../../data/pid_data.php');
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
$object = new update_pid();
$id_user = $_POST['id_user'];
$txt_nombre = utf8_decode($_POST['txt_nombre']);
$num_dni = $_POST['num_dni'];
if($num_dni == NULL || $num_dni == ""){
    $dni_editado = "0";
}else{
    $dni_editado = "1";
}
$num_celular = $_POST['num_celular'];
$num_fijo = $_POST['num_fijo'];
$num_referencia = $_POST['num_referencia'];
$sl_genero = $_POST['sl_genero'];
$sl_familiar = $_POST['sl_familiar'];
$num_hijos = $_POST['num_hijos'];
$sl_est_academico = $_POST['sl_est_academico'];
$sl_academica = $_POST['sl_academica'];
$fec_nac = $_POST['fec_nac'];
$txt_email = $_POST['txt_email'];
$fec_ingreso = $_POST['fec_ingreso'];
$sl_parentesco = $_POST['sl_parentesco'];
$cod_empleado = $_POST['cod_empleado'];

$string_ruta_avatar = $_POST['rut_avatar'];

if(strpos($string_ruta_avatar, "http://localhost:8080/apl/") == "false"){
    $rut_avatar = str_replace("http://localhost:8080/apl/", "/", $string_ruta_avatar);
}else if(strpos($string_ruta_avatar, "http://10.200.10.90/apl/") == "false"){
    $rut_avatar = str_replace("http://10.200.10.90/apl/", "/", $string_ruta_avatar);
}else if(strpos($string_ruta_avatar, "http://pid.cosapidata.pe/") == "false"){
    $rut_avatar = str_replace("http://pid.cosapidata.pe/", "/", $string_ruta_avatar);
}else{
    $rut_avatar = $string_ruta_avatar;
}

if($result = $object->update_perfil_user($id_user, $txt_nombre, $num_dni, $num_celular, $num_fijo, $num_referencia, $sl_parentesco, $sl_genero, $sl_familiar, $num_hijos, $cod_empleado, $sl_est_academico, $sl_academica, $fec_nac, $txt_email, $fec_ingreso, $dni_editado, $rut_avatar)){
    echo "true";
}else{
    echo "false";
}

