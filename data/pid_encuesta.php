<?php
require_once ('data_access.php');
Class Encuesta {
    function listar_encuestas(){
        $sql = "SELECT * FROM pid_encuesta WHERE estado_encuesta = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function listar_pre_encuestas(){
        $sql = "SELECT * FROM pid_encuesta_preguntas WHERE tipo_pregunta = '0' AND estado_pregunta = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function list_encuesta_gestor(){
        $sql = "SELECT * FROM pid_encuesta";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            if($reg->habilitar_comentario == 1){
                $comentario = '<li class="label label-success">HABILITADO</li>';
            }else{
                $comentario = '<li class="label label-danger">NO-HABILITADO</li>';
            }

            if($reg->estado_encuesta == 1){
                $estado = '<li class="label label-primary"><i class="fa fa-check"></i> ACTIVO</li>';
            }else{
                $estado = '<li class="label label-info"><i class="fa fa-close"></i> NO-ACTIVO</li>';
            }

            $array = array(
                $reg->id_encuesta,
                $i,
                $reg->titulo_encuesta,
                $comentario,
                $estado,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_encuesta" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_encuesta(".$reg->id_encuesta.")'".'  title="Editar Encuesta"><i class="fa fa-edit" aria-hidden="true"></i></a> '
                .'<a data-toggle="modal" data-target="#modal_grafico_encuesta" onclick='."'ver_grafico_encuesta(".$reg->id_encuesta.")'".' class="btn btn-info" style="padding: 0px 0.5rem;" title="Ver Grafico"><i class="fa fa-bar-chart" aria-hidden="true"></i></a>'
                .'<a class="btn btn-success" style="padding: 0px 0.5rem;" onclick='."'estado_encuesta(".$reg->id_encuesta.",".$reg->estado_encuesta .")'".'  title="Cambiar Estado"><i class="fa fa-check" aria-hidden="true"></i></a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_encuesta_user(){
        $sql = "SELECT * FROM pid_encuesta WHERE estado_encuesta = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;

            $array = array(
                $reg->id_encuesta,
                $i,
                $reg->titulo_encuesta,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_dar_encuesta" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'dar_encuesta(".$reg->id_encuesta.")'".'  title="Realizar Encuesta"><i class="fa fa-edit" aria-hidden="true"></i> Realizar Encuesta</a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_enc_preguntas(){
        $sql = "SELECT p.*,i.titulo_encuesta FROM pid_encuesta_preguntas p INNER JOIN pid_encuesta i ON i.id_encuesta = p.id_encuesta WHERE i.estado_encuesta = 1 ORDER BY p.id_enc_pregunta ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            if($reg->estado_pregunta == 1){
                $estado = '<li class="label label-primary"><i class="fa fa-check"></i> ACTIVO</li>';
            }else{
                $estado = '<li class="label label-info"><i class="fa fa-close"></i> NO-ACTIVO</li>';
            }
            
            if($reg->tipo_pregunta == 0){
                $tipo = '<li class="label label-primary"><i class="fa fa-archive"></i> BOTONES</li>';
            }else{
                $tipo = '<li class="label label-info"><i class="fa fa-comments"></i> COMENTARIO</li>';
            }
            
            $array = array(
                $reg->id_enc_pregunta,
                $i,
                $reg->titulo_pregunta,
                $reg->id_encuesta,
                $tipo,
                $estado,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_enc_pregunta" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_encuesta_pregunta(".$reg->id_enc_pregunta.")'".'  title="Editar Pregunta"><i class="fa fa-edit" aria-hidden="true"></i></a> '
                .'<a class="btn btn-success" style="padding: 0px 0.5rem;" onclick='."'estado_enc_pregunta(".$reg->id_enc_pregunta.",".$reg->estado_pregunta .")'".'  title="Cambiar Estado"><i class="fa fa-check" aria-hidden="true"></i></a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_enc_opciones(){
        $sql = "SELECT p.id_enc_pregunta,p.titulo_pregunta,COUNT(*) AS cantidad FROM pid_encuesta_opciones o INNER JOIN pid_encuesta_preguntas p ON o.id_enc_pregunta = p.id_enc_pregunta GROUP BY p.titulo_pregunta ORDER BY p.id_enc_pregunta ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            $array = array(
                $reg->id_enc_pregunta,
                $i,
                $reg->titulo_pregunta,
                $reg->cantidad,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_enc_opciones" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_encuesta_opciones(".$reg->id_enc_pregunta.")'".'  title="Editar Opción"><i class="fa fa-edit" aria-hidden="true"></i></a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function verificar_encuesta(){
        $sql = "SELECT * FROM pid_encuesta WHERE estado_encuesta = '1' AND habilitar_mini_encuesta = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insert_encuesta($titulo_encuesta,$habilitar_comentario,$habilitar_mini_encuesta,$mensaje_encuesta,$fec_inicio_enc,$fec_termino_enc){
        $sql = "INSERT INTO pid_encuesta (`titulo_encuesta`,`habilitar_comentario`,`habilitar_mini_encuesta`,`mensaje_encuesta`,`fecha_inicio`,`fecha_termino`) VALUES ('$titulo_encuesta','$habilitar_comentario','$habilitar_mini_encuesta','$mensaje_encuesta','$fec_inicio_enc','$fec_termino_enc')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insert_enc_pregunta($txt_pregunta,$tipo_pregunta,$num_opciones,$date_creacion,$creador_pregunta,$estado_pregunta,$id_encuesta){
        $sql = "INSERT INTO pid_encuesta_preguntas (`titulo_pregunta`,`tipo_pregunta`,`cantidad_opciones`,`date_creacion`,`creador_pregunta`,`estado_pregunta`,`id_encuesta`) VALUES ('$txt_pregunta','$tipo_pregunta',$num_opciones,'$date_creacion','$creador_pregunta','$estado_pregunta','$id_encuesta')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insert_enc_pregunta_comentario($txt_pregunta,$tipo_pregunta,$date_creacion,$creador_pregunta,$estado_pregunta,$id_encuesta){
        $sql = "INSERT INTO pid_encuesta_preguntas (`titulo_pregunta`,`tipo_pregunta`,`date_creacion`,`creador_pregunta`,`estado_pregunta`,`id_encuesta`) VALUES ('$txt_pregunta','$tipo_pregunta','$date_creacion','$creador_pregunta','$estado_pregunta','$id_encuesta')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insert_enc_opciones($txt_opciones,$id_enc_pregunta){
        $sql = "INSERT INTO pid_encuesta_opciones (`titulo_enc_opciones`,`estado_enc_opciones`,`id_enc_pregunta`) VALUES ('$txt_opciones','1','$id_enc_pregunta')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function finalizar_encuesta($id_enc_pregunta,$rpta_enc,$ip_resultado,$fecha_resultado){
        $sql = "INSERT INTO pid_encuesta_resultado (`id_enc_opciones`,`id_enc_pregunta`,`ip_resultado`,`fecha_resultado`) VALUES ('$rpta_enc','$id_enc_pregunta','$ip_resultado','$fecha_resultado')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function restringir_mini_encuesta($id_user,$id_encuesta){
        $sql = "INSERT INTO pid_mini_encuesta_bloqueo (`id_user`,`id_encuesta`) VALUES ('$id_user','$id_encuesta')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function finalizar_encuesta_comentario($id_encuesta,$sl_comentario,$txt_comentario,$id_enc_pre_comentario,$ip_comentario,$fecha_comentario){
        $sql = "INSERT INTO pid_encuesta_comentario (`text_comentario`,`sl_comentario`,`id_enc_pre_comentario`,`id_encuesta`,`ip_comentario`,`fecha_comentario`) VALUES ('$txt_comentario','$sl_comentario','$id_enc_pre_comentario','$id_encuesta','$ip_comentario','$fecha_comentario')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function edit_encuesta($titulo_encuesta,$habilitar_comentario,$mensaje_encuesta,$id_encuesta,$fec_inicio_enc,$fec_termino_enc){
        $sql = "UPDATE pid_encuesta SET titulo_encuesta = '$titulo_encuesta', habilitar_comentario = '$habilitar_comentario', mensaje_encuesta = '$mensaje_encuesta', fecha_inicio = '$fec_inicio_enc', fecha_termino = '$fec_termino_enc' WHERE id_encuesta = '".$id_encuesta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function edit_enc_pregunta($txt_pregunta,$tipo_pregunta,$num_opciones,$date_actualizacion,$estado_pregunta,$id_encuesta,$id_enc_pregunta){
        $sql = "UPDATE pid_encuesta_preguntas SET titulo_pregunta = '$txt_pregunta', tipo_pregunta = '$tipo_pregunta', cantidad_opciones = '$num_opciones', estado_pregunta = '$estado_pregunta', id_encuesta = '$id_encuesta', date_actualizacion = '$date_actualizacion' WHERE id_enc_pregunta = '".$id_enc_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function edit_enc_pregunta_comentario($txt_pregunta,$tipo_pregunta,$date_actualizacion,$estado_pregunta,$id_encuesta,$id_enc_pregunta){
        $sql = "UPDATE pid_encuesta_preguntas SET titulo_pregunta = '$txt_pregunta', tipo_pregunta = '$tipo_pregunta', estado_pregunta = '$estado_pregunta', id_encuesta = '$id_encuesta', date_actualizacion = '$date_actualizacion' WHERE id_enc_pregunta = '".$id_enc_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function edit_enc_opciones($txt_opciones,$id_opc){
        $sql = "UPDATE pid_encuesta_opciones SET titulo_enc_opciones = '$txt_opciones' WHERE id_enc_opciones = '".$id_opc."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_encuesta($id_encuesta){
        $sql = "SELECT * FROM pid_encuesta WHERE id_encuesta = '".$id_encuesta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_enc_pregunta($id_enc_pregunta){
        $sql = "SELECT * FROM pid_encuesta_preguntas WHERE id_enc_pregunta = '".$id_enc_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_enc_pregunta_opc($id_enc_pregunta){
        $sql = "SELECT * FROM pid_encuesta_preguntas WHERE id_enc_pregunta = '".$id_enc_pregunta."' AND tipo_pregunta = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_enc_opc($id_enc_pregunta){
        $sql = "SELECT * FROM pid_encuesta_opciones WHERE id_enc_pregunta = '".$id_enc_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_preguntas_encuesta($id_encuesta){
        $sql = "SELECT p.id_enc_pregunta,p.titulo_pregunta FROM pid_encuesta_preguntas p WHERE p.id_encuesta = '".$id_encuesta."' AND p.estado_pregunta = '1' AND p.tipo_pregunta = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_encuesta_comentario($id_encuesta){
        $sql = "SELECT * FROM pid_encuesta_comentario WHERE id_encuesta = '".$id_encuesta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function verificar_cantidad_opciones($id_pregunta,$id_opcion){
        $sql = "SELECT COUNT(*) AS cantidad_opciones FROM pid_encuesta_resultado WHERE id_enc_pregunta = '".$id_pregunta."' AND id_enc_opciones = '".$id_opcion."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_usuarios_conta(){
        $sql = "SELECT COUNT(*) AS cantidad FROM pid_usuario";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_encuestas_conta($id_encuesta){
        $sql = "SELECT COUNT(*) AS cantidad_encuestas FROM pid_encuesta_comentario WHERE id_encuesta = '".$id_encuesta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_estado_enc($estado_encuesta,$id_encuesta){
        $sql = "UPDATE pid_encuesta SET estado_encuesta = '$estado_encuesta' WHERE id_encuesta = '".$id_encuesta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_estado_enc_pre($estado_enc_pregunta,$id_enc_pre){
        $sql = "UPDATE pid_encuesta_preguntas SET estado_pregunta = '$estado_enc_pregunta' WHERE id_enc_pregunta = '".$id_enc_pre."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function delete_enc_opc($id_enc_opcion){
        $sql = "DELETE FROM pid_encuesta_opciones WHERE id_enc_opciones = '".$id_enc_opcion."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function dar_encuesta($id_encuesta){
        $sql = "SELECT * FROM pid_encuesta_preguntas WHERE id_encuesta = '".$id_encuesta."' AND tipo_pregunta = '0' AND estado_pregunta = '1' ORDER BY id_enc_pregunta ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function dar_encuesta_com($id_encuesta){
        $sql = "SELECT * FROM pid_encuesta_preguntas WHERE id_encuesta = '".$id_encuesta."' AND tipo_pregunta = '1' AND estado_pregunta = '1' ORDER BY id_enc_pregunta ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}