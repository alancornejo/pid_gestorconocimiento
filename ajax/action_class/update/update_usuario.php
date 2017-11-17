<?php
    session_start();
    require_once '../../../data/pid_data.php';
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    
    /* Usuario */
    $id = $_POST['id_usuario'];
    $user_id = $_POST['id_usuario'];
    $nom_usuario = utf8_decode($_POST['txt_usuario']);
    $claro_usuario = strtoupper($_POST['txt_claro']);
    $rol_user = $_POST['sl_rol'];
    $funcion_user = $_POST['sl_funcion'];
    $sl_servicio = $_POST['sl_servicio'];
    $gest_cono = (isset($_POST['gest_cono'])) ? "true" : "false";
    $crea_cono = (isset($_POST['crea_cono'])) ? "true" : "false";
    $edit_cono = (isset($_POST['edit_cono'])) ? "true" : "false";
    $apro_cono = (isset($_POST['apro_cono'])) ? "true" : "false";
    $rein_con_cono = (isset($_POST['rein_con_cono'])) ? "true" : "false";
    $gest_comment = (isset($_POST['gest_comment'])) ? "true" : "false";
    $apro_comment = (isset($_POST['apro_comment'])) ? "true" : "false";
    $gest_est_comment = (isset($_POST['gest_est_comment'])) ? "true" : "false";
    $rein_comment = (isset($_POST['rein_comment'])) ? "true" : "false";
    $gest_borra = (isset($_POST['gest_borra'])) ? "true" : "false";
    $edit_borra = (isset($_POST['edit_borra'])) ? "true" : "false";
    $dele_borra = (isset($_POST['dele_borra'])) ? "true" : "false";
    $gest_bita = (isset($_POST['gest_bita'])) ? "true" : "false";
    $crea_bita = (isset($_POST['crea_bita'])) ? "true" : "false";
    $edit_bita = (isset($_POST['edit_bita'])) ? "true" : "false";
    $dele_bita = (isset($_POST['dele_bita'])) ? "true" : "false";
    $gest_cat = (isset($_POST['gest_cat'])) ? "true" : "false";
    $crea_cat = (isset($_POST['crea_cat'])) ? "true" : "false";
    $edit_cat = (isset($_POST['edit_cat'])) ? "true" : "false";
    $dele_cat = (isset($_POST['dele_cat'])) ? "true" : "false";
    $crea_apli = (isset($_POST['crea_apli'])) ? "true" : "false";
    $edit_apli = (isset($_POST['edit_apli'])) ? "true" : "false";
    $dele_apli = (isset($_POST['dele_apli'])) ? "true" : "false";
    $crea_grupo = (isset($_POST['crea_grupo'])) ? "true" : "false";
    $edit_grupo = (isset($_POST['edit_grupo'])) ? "true" : "false";
    $dele_grupo = (isset($_POST['dele_grupo'])) ? "true" : "false";
    $gest_usua = (isset($_POST['gest_usua'])) ? "true" : "false";
    $crea_usua = (isset($_POST['crea_usua'])) ? "true" : "false";
    $edit_usua = (isset($_POST['edit_usua'])) ? "true" : "false";
    $edit_perfil_usua = (isset($_POST['edit_perfil_usua'])) ? "true" : "false";
    $rein_cone_usua = (isset($_POST['rein_cone_usua'])) ? "true" : "false";
    $descs_usua = (isset($_POST['descs_usua'])) ? "true" : "false";
    $desc_usua = (isset($_POST['desc_usua'])) ? "true" : "false";
    $rein_tiem_usua = (isset($_POST['rein_tiem_usua'])) ? "true" : "false";
    $rein_password = (isset($_POST['rein_password'])) ? "true" : "false";
    $rein_comment_cali = (isset($_POST['rein_comment_cali'])) ? "true" : "false";
    $rein_comment_cali_all = (isset($_POST['rein_comment_cali_all'])) ? "true" : "false";
    $dele_usua = (isset($_POST['dele_usua'])) ? "true" : "false";
    $gest_exam = (isset($_POST['gest_exam'])) ? "true" : "false";
    $crea_exam = (isset($_POST['crea_exam'])) ? "true" : "false";
    $edit_exam = (isset($_POST['edit_exam'])) ? "true" : "false";
    $chg_exam = (isset($_POST['chg_exam'])) ? "true" : "false";
    $graf_exam = (isset($_POST['graf_exam'])) ? "true" : "false";
    $crea_pre_exam = (isset($_POST['crea_pre_exam'])) ? "true" : "false";
    $edit_pre_exam = (isset($_POST['edit_pre_exam'])) ? "true" : "false";
    $dele_pre_exam = (isset($_POST['dele_pre_exam'])) ? "true" : "false";
    $graf_pregunta = (isset($_POST['graf_pregunta'])) ? "true" : "false";
    $rein_est_pregunta = (isset($_POST['rein_est_pregunta'])) ? "true" : "false";
    $rein_all_est_pregunta = (isset($_POST['rein_all_est_pregunta'])) ? "true" : "false";
    $asig_exam = (isset($_POST['asig_exam'])) ? "true" : "false";
    $edit_asig_exam = (isset($_POST['edit_asig_exam'])) ? "true" : "false";
    $dele_asig_exam = (isset($_POST['dele_asig_exam'])) ? "true" : "false";
    $graf_exam_usua = (isset($_POST['graf_exam_usua'])) ? "true" : "false";
    $gest_enc = (isset($_POST['gest_enc'])) ? "true" : "false";
    $crea_enc = (isset($_POST['crea_enc'])) ? "true" : "false";
    $edit_enc = (isset($_POST['edit_enc'])) ? "true" : "false";
    $esta_enc = (isset($_POST['esta_enc'])) ? "true" : "false";
    $crea_pre_enc = (isset($_POST['crea_pre_enc'])) ? "true" : "false";
    $edit_pre_enc = (isset($_POST['edit_pre_enc'])) ? "true" : "false";
    $esta_pre_enc = (isset($_POST['esta_pre_enc'])) ? "true" : "false";
    $crea_opc_enc = (isset($_POST['crea_opc_enc'])) ? "true" : "false";
    $edit_opc_enc = (isset($_POST['edit_opc_enc'])) ? "true" : "false";
    $dele_opc_enc = (isset($_POST['dele_opc_enc'])) ? "true" : "false";    
    $gest_log_reg = (isset($_POST['gest_log_reg'])) ? "true" : "false";
    $gest_nas = (isset($_POST['gest_nas'])) ? "true" : "false";
    $add_ma_resp = (isset($_POST['add_ma_resp'])) ? "true" : "false";
    $edit_ma_resp = (isset($_POST['edit_ma_resp'])) ? "true" : "false";
    $gest_seg_casos = (isset($_POST['gest_seg_casos'])) ? "true" : "false";
    $add_seg_casos = (isset($_POST['add_seg_casos'])) ? "true" : "false";
    $add_ma_jobs = (isset($_POST['add_ma_jobs'])) ? "true" : "false";
    $edit_ma_jobs = (isset($_POST['edit_ma_jobs'])) ? "true" : "false";
    $edit_dir_spee = (isset($_POST['edit_dir_spee'])) ? "true" : "false";
    $edit_dir_tur = (isset($_POST['edit_dir_tur'])) ? "true" : "false";
    $edit_dir_cac = (isset($_POST['edit_dir_cac'])) ? "true" : "false";
    $add_com_atc = (isset($_POST['add_com_atc'])) ? "true" : "false";
    $edit_com_atc = (isset($_POST['edit_com_atc'])) ? "true" : "false";
    $gest_port = (isset($_POST['gest_port'])) ? "true" : "false";
    $crea_port_not = (isset($_POST['crea_port_not'])) ? "true" : "false";
    $edit_port_not = (isset($_POST['edit_port_not'])) ? "true" : "false";
    $dele_port_not = (isset($_POST['dele_port_not'])) ? "true" : "false";
    $mod_ges = (isset($_POST['mod_ges'])) ? "true" : "false";
    $mod_kdb = (isset($_POST['mod_kdb'])) ? "true" : "false";
    $mod_bit = (isset($_POST['mod_bit'])) ? "true" : "false";
    $mod_bor = (isset($_POST['mod_bor'])) ? "true" : "false";
    $mod_cat = (isset($_POST['mod_cat'])) ? "true" : "false";
    $mod_usu = (isset($_POST['mod_usu'])) ? "true" : "false";
    $mod_exa = (isset($_POST['mod_exa'])) ? "true" : "false";
    $mod_nas = (isset($_POST['mod_nas'])) ? "true" : "false";
    $mod_port = (isset($_POST['mod_port'])) ? "true" : "false";
    /* Fin de Usuario */
    
    /* Registro */
    $modelo_registro = "5";
    $tipo_registro = "2";
    $id_modelo = $_POST['txt_claro'];
    $contenido_registro = $_POST['sl_funcion'];
    $estado_registro = "";
    $fecha_registro = date("Y-m-d H:i:s");
    $id_user = $_SESSION['id_user_apl'];
    /* Fin de Registro */
    
    $bitacora_contenido = "";
    
    $object_utf8 = new utf8_fix();
    //$result_utf8 = $object_utf8->fix_utf8();();
    
    $object = new update_pid();
    $object_registro = new insert_pid();
    if($result = $object->update_usuario($id,$nom_usuario,$claro_usuario,$rol_user,$funcion_user,$sl_servicio) && $result_permisos = $object->update_permisos_user($gest_cono, $crea_cono, $edit_cono, $apro_cono, $rein_con_cono, $gest_comment, $apro_comment, $gest_est_comment, $rein_comment, $gest_borra, $edit_borra, $dele_borra, $gest_bita, $crea_bita, $edit_bita, $dele_bita, $gest_cat, $crea_cat, $edit_cat, $dele_cat, $crea_apli, $edit_apli, $dele_apli, $crea_grupo, $edit_grupo, $dele_grupo, $gest_usua, $crea_usua, $edit_usua, $edit_perfil_usua, $rein_cone_usua, $descs_usua, $desc_usua, $rein_tiem_usua, $rein_password, $rein_comment_cali, $rein_comment_cali_all, $dele_usua, $gest_exam, $crea_exam, $edit_exam, $chg_exam, $graf_exam, $crea_pre_exam, $edit_pre_exam, $dele_pre_exam, $graf_pregunta, $rein_est_pregunta, $rein_all_est_pregunta, $asig_exam, $edit_asig_exam, $dele_asig_exam, $graf_exam_usua, $gest_enc, $crea_enc, $edit_enc, $esta_enc, $crea_pre_enc, $edit_pre_enc, $esta_pre_enc, $crea_opc_enc, $edit_opc_enc, $dele_opc_enc, $gest_log_reg, $gest_nas, $add_ma_resp, $edit_ma_resp, $gest_seg_casos, $add_seg_casos, $add_ma_jobs, $edit_ma_jobs, $edit_dir_spee, $edit_dir_tur, $edit_dir_cac, $add_com_atc, $edit_com_atc, $gest_port, $crea_port_not, $edit_port_not, $dele_port_not, $mod_ges, $mod_kdb, $mod_bit, $mod_bor, $mod_cat, $mod_usu, $mod_exa, $mod_nas, $mod_port, $user_id)){
        echo "true";
        $result_registro = $object_registro->insertar_registro($modelo_registro, $tipo_registro, $id_modelo, $contenido_registro, $estado_registro, $fecha_registro, $bitacora_contenido, $id_user);
    }else{
        echo "false";
    }
?>