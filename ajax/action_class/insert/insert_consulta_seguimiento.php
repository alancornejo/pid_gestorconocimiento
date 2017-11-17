<?php
require_once ('../../../data/pid_data.php');
$object = new insert_pid();
$result_tabla = $object->base_tabla_casos();
$row = $result_tabla->fetch_assoc();
$fec_asignados = $row['asignados'];
$num_cantidad = $row['cantidad'];
$prom_antiguedad = $row['prom_antiguedad'];
$caso_mas_antiguo = $row['caso_mas_antiguo'];
$mes_subida = $row['mes_subida'];
$ano_subida = $row['ano_subida'];
$result_tabla_solucionados = $object->base_tabla_casos_solucionados();
$row_solucionados = $result_tabla_solucionados->fetch_assoc();
$fec_asignados_s = $row_solucionados['asignados'];
$num_cantidad_s = $row_solucionados['cantidad'];
$prom_antiguedad_s = $row_solucionados['prom_antiguedad'];
$caso_mas_antiguo_s = $row_solucionados['caso_mas_antiguo'];
$mes_subida_s = $row_solucionados['mes_subida'];
$ano_subida_s = $row_solucionados['ano_subida'];
$result_validar_base = $object->validar_base_casos();
$validar_base = $result_validar_base->num_rows;
$result_validar = $object->validar_consulta_asignado($fec_asignados);
$validar_asignado = $result_validar->num_rows;
$result_validar_s = $object->validar_consulta_solucionado($fec_asignados_s);
$validar_solucionado = $result_validar_s->num_rows;

if($validar_base != 0){
    if($validar_asignado == 1){
        echo "asignado_ingresado";
    }else{
        if($validar_solucionado == 1){
            echo "solucionado_ingresado";
        }else{
            if($object->insertar_tabla_base($fec_asignados, $num_cantidad, $prom_antiguedad, $caso_mas_antiguo, $mes_subida, $ano_subida) && $object->insertar_tabla_base_solucionados($fec_asignados_s, $num_cantidad_s, $prom_antiguedad_s, $caso_mas_antiguo_s, $mes_subida_s, $ano_subida_s)){
                echo "true";
            }else{
                echo "false";
            }
        }
    }
}else{
    echo "base_vacia";
}