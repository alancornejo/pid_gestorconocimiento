<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Conocimiento */
    $titulo = addslashes($_POST['txt_titulo_conocimiento_edit']);
    $id_atu = $_POST['id_atu_conocimiento_edit'];
    $id = $_POST['id_tabla_conocimiento_edit'];
    $aplicativo = $_POST['sl_aplicativo_conocimiento_edit'];
    //
    $estado_conocimiento = $_POST['sl_inc_dev_edit'];
    $tipo_flujo = $_POST['sl_flujo_conocimiento_edit'];
    $grupo_conocimiento = $_POST['sl_grupo_conocimiento_edit'];
    $verificar_resolutor = (isset($_GET['sl_resolutor_conocimiento_edit'])) ? "true" : "false";
    if($verificar_resolutor == "false"){
        $usuario_resolutor = "0";
    }else{
        $usuario_resolutor = $_POST['sl_resolutor_conocimiento_edit'];
    }
    //
    $contenido = addslashes($_POST['txt_contenido_conocimiento_edit']);
    $fecha_actualizacion = $_POST['id_fecha_editor_conocimiento_edit'];
    $publicado = $_POST['sl_publicado_conocimiento_edit'];
    $ver_cliente = $_POST['sl_cliente_conocimiento_edit'];
    $tipo_conocimiento = $_POST['sl_tipo_servicio_edit'];
    $publico = $_POST['sl_publico_edit'];
    /* Fin de Conocimiento */
    
    /* Registro */
    $modelo_registro = "1";
    $tipo_registro = "2";
    $id_modelo = $_POST['id_atu_conocimiento_edit'];
    $contenido_registro = addslashes($_POST['txt_contenido_original_conocimiento']);
    $estado_registro = "";
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */
    
    $bitacora_contenido = "";
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new update_pid();
    $object_registro = new insert_pid();
    if($result = $object->update_conocimiento($id_atu, $titulo, $contenido, $aplicativo, $estado_conocimiento, $tipo_flujo, $grupo_conocimiento, $usuario_resolutor, $fecha_actualizacion, $id, $publicado, $ver_cliente, $tipo_conocimiento, $publico)){
        echo "true";
        $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
?>