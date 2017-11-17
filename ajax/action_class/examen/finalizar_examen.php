<?php
require_once ("../../../data/pid_examen.php");
date_default_timezone_set('America/Bogota');
setlocale (LC_TIME, "es_ES");
header('Content-type: text/html; charset=UTF-8');
session_start();
$id_user = $_SESSION['id_user_apl'];
$id_user_asig = $_SESSION['id_user_apl'];
$tipo_servicio = $_SESSION['tipo_servicio'];
$conjunto = array_keys($_POST);
$id_examen = join(",",$conjunto);
//print_r($conjunto);
$object = new examen_usuario();
$correcto = 0;
$nada = 0;
$incorrecto = 0;
$id_examen_tomado = $_SESSION['id_examen_usuario'];
$result = $object->validar_preguntas($id_examen,$tipo_servicio);
while ($reg = $result->fetch_array()) {
    if($reg['respuesta_correcta'] == $_POST[$reg['id_pregunta']]){
        $id_pregunta = $reg['id_pregunta'];
        $result_pregunta_resultado = $object->update_pregunta_correcta($id_pregunta);
        $campo_tabla = "correctas";
        $result_pregunta_grafico = $object->insert_pregunta_resultado($id_pregunta, $id_examen_tomado, $campo_tabla);
        $correcto++;
    }else if($_POST[$reg['id_pregunta']] == "nada"){
        $id_pregunta = $reg['id_pregunta'];
        $result_pregunta_resultado = $object->update_pregunta_sin_respuesta($id_pregunta);
        $campo_tabla = "sin_respuesta";
        $result_pregunta_grafico = $object->insert_pregunta_resultado($id_pregunta, $id_examen_tomado, $campo_tabla);
        $nada++;
    }else{
        $id_pregunta = $reg['id_pregunta'];
        $result_pregunta_resultado = $object->update_pregunta_incorrecta($id_pregunta);
        $campo_tabla = "incorrectas";
        $result_pregunta_grafico = $object->insert_pregunta_resultado($id_pregunta, $id_examen_tomado, $campo_tabla);
        $incorrecto++;
    }
}

$cantidad_preguntas = count($_POST);

$correctas = $correcto;
$incorrectas = $incorrecto;
$sin_respuesta = $nada;
$nota_final = round(($correctas*20)/$cantidad_preguntas);
$preguntas = $id_examen;

$id_identificador = $_SESSION['id_identificador'];

$respuestas = implode(',', $_POST);

/*echo $correctas."\n";
echo $incorrectas."\n";
echo $sin_respuesta."\n";
echo $nota_final."\n";*/

$result_insertar_resultado = $object->insert_respuesta($id_user, $id_examen_tomado, $correctas, $incorrectas, $sin_respuesta, $preguntas, $respuestas, $id_identificador);
$result_desbloqueo = $object->desbloquear_pid($id_user_asig);
$result_nota_final = $object->update_nota_examen($id_user, $id_examen_tomado, $nota_final, $id_identificador);