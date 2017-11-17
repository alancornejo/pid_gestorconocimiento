<?php
    session_start();
    set_time_limit(0);
    require_once '../../../data/pid_data.php';
    $object = new insert_pid();
    $object_vaciar = new vaciar_tabla();
    $object_utf8 = new utf8_fix();
    date_default_timezone_set('America/Bogota');
    setlocale (LC_TIME, "es_ES");
    header('Content-type: text/html; charset=UTF-8');
    $fname = $_POST['sel_file_seguimiento'];
    $chk_ext = explode(".",$fname);
    if(strtolower(end($chk_ext)) == "txt"){
        $filename = $_POST['sel_file_seguimiento'];
        $handle = fopen($filename, "r");
        $result_vaciar = $object_vaciar->vaciar_base_casos();
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            if($data[0] == NULL || $data[0] == ""){
                $num_caso = NULL;
            }else{
                $num_caso = $data[0];
            }
            
            if($data[1] == NULL || $data[1] == ""){
                $txt_usuario = NULL;
            }else{
                $txt_usuario = addslashes($data[1]);
            }
            
            if($data[2] == NULL || $data[2] == ""){
                $txt_aplicativo = NULL;
            }else{
                $txt_aplicativo = addslashes($data[2]);
            }
            
            if($data[3] == NULL || $data[3] == ""){
                $nom_responsable = NULL;
            }else{
                $nom_responsable = addslashes($data[3]);
            }
            
            if($data[4] == NULL || $data[4] == ""){
                $nom_grupo = NULL;
            }else{
                $nom_grupo = addslashes($data[4]);
            }
            if($data[5] == NULL || $data[5] == ""){
                $fec_apertura = NULL;
            }else{
                $dia = substr($data[5], 0, 2);
                $mes = substr($data[5], 3, 2);
                $ano = substr($data[5], 6, 4);
                $hora = substr($data[5], 11, 2);
                $minutos = substr($data[5], 14, 2);
                $fec_apertura = $ano."-".$mes."-".$dia." ".$hora.":".$minutos.":00";
            }
            
            if($data[6] == NULL || $data[6] == ""){
                $tipo_estado = NULL;
            }else{
                $tipo_estado = addslashes($data[6]);
            }
            
            if($data[7] == NULL || $data[7] == ""){
                $generado_por = NULL;
            }else{
                $generado_por = addslashes($data[7]);
            }            
            
            if($data[8] == NULL || $data[8] == ""){
                $fec_solucion = NULL;
            }else{
                $dia = substr($data[8], 0, 2);
                $mes = substr($data[8], 3, 2);
                $ano = substr($data[8], 6, 4);
                $hora = substr($data[8], 11, 2);
                $minutos = substr($data[8], 14, 2);
                $fec_solucion = $ano."-".$mes."-".$dia." ".$hora.":".$minutos.":00";
            }
            if($data[9] == NULL || $data[9] == ""){
                $fec_solucion_2 = NULL;
            }else{
                $dia = substr($data[9], 0, 2);
                $mes = substr($data[9], 3, 2);
                $ano = substr($data[9], 6, 4);
                $fec_solucion_2 = $ano."-".$mes."-".$dia;
            }
            
            if($data[10] == NULL || $data[10] == ""){
                $nom_supervisor = NULL;
            }else{
                $nom_supervisor = addslashes($data[10]);
            }
            
            if($data[11] == NULL || $data[11] == ""){
                $asig_atu = NULL;
            }else{
                $asig_atu = $data[11];
            }
            
            if($data[12] == NULL || $data[12] == ""){
                $est_solu = NULL;
            }else{
                $est_solu = $data[12];
            }
            
            if($data[13] == NULL || $data[13] == ""){
                $tipo_rol = NULL;
            }else{
                $tipo_rol = addslashes($data[13]);
            }
            
            if($data[14] == NULL || $data[14] == ""){
                $dia_seg = NULL;
            }else{
                $dia_seg = $data[14];
            }
            
            if($data[15] == NULL || $data[15] == ""){
                $fec = NULL;
            }else{
                $dia = substr($data[15], 0, 2);
                $mes = substr($data[15], 3, 2);
                $ano = substr($data[15], 6, 4);
                $fec = $ano."-".$mes."-".$dia;
            }
            
            if($data[16] == NULL || $data[16] == ""){
                $asig_caso_seg = NULL;
            }else{
                $asig_caso_seg = $data[16];
            }
            
            if($data[17] == NULL || $data[17] == ""){
                $solu_caso_seg = NULL;
            }else{
                $solu_caso_seg = $data[17];
            }
            
            if($data[18] == NULL || $data[18] == ""){
                $cant_casos = NULL;
            }else{
                $cant_casos = $data[18];
            }
            
            if($data[19] == NULL || $data[19] == ""){
                $fec_actual = NULL;
                $ano_actual = NULL;
            }else{
                $dia = substr($data[19], 0, 2);
                $mes = substr($data[19], 3, 2);
                $ano = substr($data[19], 6, 4);
                $hora = substr($data[19], 11, 2);
                $minutos = substr($data[19], 14, 2);
                $fec_actual = $ano."-".$mes."-".$dia." ".$hora.":".$minutos.":00";
                if($mes == "01"){ $mes_actual = "Enero"; }elseif($mes == "02") { $mes_actual = "Febrero"; }
                elseif($mes == "03"){ $mes_actual = "Marzo"; }elseif($mes == "04"){ $mes_actual = "Abril"; }
                elseif($mes == "05"){ $mes_actual = "Mayo"; }elseif($mes == "06"){ $mes_actual = "Junio"; }
                elseif($mes == "07"){ $mes_actual = "Julio"; }elseif($mes == "08"){ $mes_actual = "Agosto"; }
                elseif($mes == "09"){ $mes_actual = "Setiembre"; }elseif($mes == "10"){ $mes_actual = "Octubre"; }
                elseif($mes == "11"){ $mes_actual = "Noviembre"; }elseif($mes == "12"){ $mes_actual = "Diciembre"; }
                $ano_actual = $ano;
            }
            
            if($data[20] == NULL || $data[20] == ""){
                $dias_pendientes = NULL;
            }else{
                $dias_pendientes = $data[20];
            }
            
            if($data[21] == NULL || $data[21] == ""){
                $dias_solucionados = NULL;
            }else{
                $dias_solucionados = $data[21];
            }
            
            if($data[22] == NULL || $data[22] == "" || $data[22] == "-"){
                $claro_user = NULL;
            }else{
                $claro_user = $data[22];
            }
            
            //print_r($data);
            //echo $fec_actual."\n";
            //$result_utf8 = $object_utf8->fix_utf8();();
            //echo $num_caso." ".$txt_usuario." ".$txt_aplicativo." ".$nom_responsable." ".$nom_grupo." ".$fec_apertura." ".$tipo_estado." ".$generado_por." ".$fec_solucion." ".$fec_solucion_2." ".$nom_supervisor." ".$asig_atu." ".$est_solu." ".$tipo_rol." ".$dia_seg." ".$fec." ".$asig_caso_seg." ".$solu_caso_seg." ".$cant_casos." ".$fec_actual." ".$dias_pendientes." ".$dias_solucionados."\n";
            $result = $object->insertar_base_casos($num_caso,$txt_usuario,$txt_aplicativo,$nom_responsable,$nom_grupo,$fec_apertura,$tipo_estado,$generado_por,$fec_solucion,$fec_solucion_2,$nom_supervisor,$asig_atu,$est_solu,$tipo_rol,$dia_seg,$fec,$asig_caso_seg,$solu_caso_seg,$cant_casos,$fec_actual,$dias_pendientes,$dias_solucionados,$mes_actual,$ano_actual,$claro_user);
        }
        fclose($handle);
        /*$result_tabla = $object->base_tabla_casos();
        $row = $result_tabla->fetch_row();
        $fec_asignados = $row['asignados'];
        $num_cantidad = $row['cantidad'];
        $prom_antiguedad = $row['prom_antiguedad'];
        $caso_mas_antiguo = $row['caso_mas_antiguo'];
        $mes_subida = $row['mes_subida'];
        $ano_subida = $row['ano_subida'];
        $result_insertar_tabla_base = $object->insertar_tabla_base($fec_asignados, $num_cantidad, $prom_antiguedad, $caso_mas_antiguo, $mes_subida, $ano_subida);
        $result_tabla_solucionados = $object->base_tabla_casos_solucionados();
        $row_solucionados = $result_tabla_solucionados->fetch_row();
        $fec_asignados_s = $row_solucionados['asignados'];
        $num_cantidad_s = $row_solucionados['cantidad'];
        $prom_antiguedad_s = $row_solucionados['prom_antiguedad'];
        $caso_mas_antiguo_s = $row_solucionados['caso_mas_antiguo'];
        $mes_subida_s = $row_solucionados['mes_subida'];
        $ano_subida_s = $row_solucionados['ano_subida'];
        $result_insertar_tabla_base_solucionados = $object->insertar_tabla_base_solucionados($fec_asignados_s, $num_cantidad_s, $prom_antiguedad_s, $caso_mas_antiguo_s, $mes_subida_s, $ano_subida_s);*/
        echo 1;
    }else{
        echo 0;
    }
?>