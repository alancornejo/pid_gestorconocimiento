<?php
session_start();
require_once '../../../data/pid_data.php';
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');

/* Bitacora */
$id = $_POST['id_bitacora'];
$fec_bitacora = $_POST['fec_bitacora'];
$sl_impacto = $_POST['sl_impacto'];
$num_afectados = $_POST['num_afectados'];
$num_correos = $_POST['num_correos'];
$sl_asignado = $_POST['sl_asignado'];
$sl_afectado = strtoupper($_POST['sl_afectado']);
$txt_bitacora = strtoupper(addslashes($_POST['txt_bitacora']));
$txt_responsable = strtoupper(addslashes($_POST['txt_responsable']));
$num_caso = $_POST['num_caso'];
$sl_estado = strtoupper($_POST['sl_estado']);
if($sl_estado == "RE-ASIGNADO"){
    $fec_solucionado = NULL;
}else {
    $fec_solucionado = $_POST['fec_solucionado'];
}
$fec_apertura = $_POST['fec_apertura'];
$fec_reasi = $_POST['fec_re_asignado'];
$fec_cerrado = $_POST['fec_cerrado'];
$fec_recepcion = $_POST['fec_recepcion'];

$contenido = addslashes($_POST['contenido']);
/* Fin de Bitacora */

/* Registro */
$modelo_registro = "2";
$tipo_registro = "2";
$id_modelo = $_POST['num_caso'];
$contenido_registro = addslashes($_POST['contenido_original']);
$estado_registro = $sl_estado;
$fecha_registro = date("Y-m-d H:i:s");
$id_user = $_SESSION['id_user_apl'];
$bitacora_contenido = $_POST['fecha_bitacora_original']."#".$_POST['impacto_original']."#".$_POST['num_afectados_original']."#".$_POST['num_correo_original']."#".$_POST['sl_aplicativo_original']."#".$_POST['sl_grupo_original']."#".$_POST['titulo_bitacora_original']."#".$_POST['responsable_original']."#".$_POST['num_caso_original']."#".$_POST['estado_original']."#".$_POST['fecha_estado_original'];
/* Fin de Registro */

$object_utf8 = new utf8_fix();
//$result_utf8 = $object_utf8->fix_utf8();();

$object = new update_pid();
$object_registro = new insert_pid();

if($result = $object->update_bitacora($id, $fec_bitacora, $sl_impacto, $num_afectados, $num_correos, $sl_asignado, $sl_afectado, $txt_bitacora, $txt_responsable, $num_caso, $sl_estado, $fec_apertura, $fec_reasi, $fec_solucionado, $fec_cerrado, $fec_recepcion, $contenido)){
    echo "true";
    $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
}else{
    echo "false";
}
?>
