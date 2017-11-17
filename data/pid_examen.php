<?php
require_once ("data_access.php");
Class examen_usuario {

    function validar_usuario($id_user){

        $sql = "SELECT * FROM pid_usuario WHERE id_user = '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function list_examen($id_user){

        $sql = "SELECT a.id_asignado, a.nota_final, e.titulo_examen, e.id_examen, e.num_facil, e.num_dificil, a.examen_tomado, a.fecha_examen, a.fecha_termino, a.id_user, a.id_identificador FROM pid_exam_asignado a INNER JOIN pid_examen e ON a.id_examen = e.id_examen WHERE a.id_user = '".$id_user."' AND e.habilitado = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            $fecha_actual = strtotime(date("Y-m-d H:i:s"));
            $fecha_termino = strtotime($reg->fecha_termino);

            if($reg->nota_final == NULL){
                $nota = "Sin Nota";
            }else{
                $nota = $reg->nota_final;
            }

            if($reg->examen_tomado == 1 || $reg->examen_tomado == 2){
                if($nota > 10){
                    $nota = "<strong class='text-success'>".$reg->nota_final."</strong>";
                }else{
                    if($reg->nota_final == NULL){
                        $nota_expirado = 0;
                    }else{
                        $nota_expirado = $reg->nota_final;
                    }
                    $nota = "<strong class='text-danger'>0".$nota_expirado."</strong>";
                }
                if($reg->nota_final == 10 || $reg->nota_final == 11 || $reg->nota_final == 12 || $reg->nota_final == 13){
                    $nota = "<strong class='text-danger'>".$reg->nota_final."</strong>";
                }
            }

            if($reg->examen_tomado == 0 || $reg->examen_tomado == 3){
                $accion = '<a data-toggle="modal" data-target="#modal_view_examen" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick="tomar_examen('.$reg->id_examen.','.$reg->num_facil.','.$reg->num_dificil.',\''.$reg->id_identificador.'\')"  title="Dar Examen"> Tomar Examen <i class="fa fa-check" aria-hidden="true"></i> </a> ';
            }elseif($reg->examen_tomado == 2){
                $accion = '<a class="label label-danger">EXPIRADO</a>';
            }elseif($reg->examen_tomado == 4){
                $accion = '<a class="label label-info" style="background-color:#AE8E11">OBSERVADO</a> '
                        .'<a data-toggle="modal" data-target="#modal_view_grafica" onclick="ver_grafica('.$reg->id_user.',\''.$reg->id_identificador.'\')" class="label label-info">VER GRAFICA</a>';
            }else{
                $accion = '<a class="label label-success">FINALIZADO</a> '
                        .'<a data-toggle="modal" data-target="#modal_view_grafica" onclick="ver_grafica('.$reg->id_user.',\''.$reg->id_identificador.'\')" class="label label-info">VER GRAFICA</a>';
            }

            if($reg->examen_tomado == 0 || $reg->examen_tomado == 3){
                if($fecha_termino < $fecha_actual){
                    $nota = "<strong class='text-danger'>00</strong>";
                    $accion = '<a class="label label-danger">EXPIRADO</a>';
                }
            }
            
            if($reg->examen_tomado == 4){
                $nota = "<strong class='text-danger'>00</strong>";
            }

            $array = array(
                "EXAM".$i,
                $reg->titulo_examen,
                date("d/m/Y h:i a", strtotime($reg->fecha_examen)),
                date("d/m/Y h:i a", strtotime($reg->fecha_termino)),
                $nota,
                $accion
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_examen_gestor(){

        $sql = "SELECT * FROM pid_examen";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            $tiempo = ($reg->tiempo_examen)/60 ." minutos";

            if($reg->habilitado == 0){
                $habilitado = '<a class="label label-danger"><i class="fa fa-ban"></i> NO-HABILITADO</a> <div hidden>1</div>';
            }else{
                $habilitado = '<a class="label label-success"><i class="fa fa-check"></i> HABILITADO</a> <div hidden>0</div>';
            }

            $array = array(
                $reg->id_examen,
                "".$i,
                $reg->titulo_examen,
                date("d/m/Y",  strtotime($reg->fecha_inicio)),
                $tiempo,
                $habilitado,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_examen" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'editar_examen(".$reg->id_examen.")'".'  title="Editar Examen"> Editar <i class="fa fa-edit" aria-hidden="true"></i> </a> '
                .'<a class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'cambiar_estado_examen(".$reg->id_examen.",".$reg->habilitado.")'".'  title="Cambiar Estado"> Estado <i class="fa fa-refresh" aria-hidden="true"></i> </a>'
                .'<a class="btn btn-warning" style="padding: 0px 0.5rem;background-color:#184" onclick='."'borrar_estadistica(".$reg->id_examen.")'".'  title="Resetear estadisticas de las preguntas"> R.Estadis <i class="fa fa-recycle" aria-hidden="true"></i> </a>'
                .'<a data-toggle="modal" data-target="#modal_view_grafica_gestor" class="btn btn-info" style="padding: 0px 0.5rem;" onclick='."'ver_grafico_gestor(".$reg->id_examen.")'".'  title="Ver Grafico por Examen"> Grafico E.<i class="fa fa-bar-chart" aria-hidden="true"></i> </a>'
                .'<a data-toggle="modal" data-target="#modal_view_grafica_pregunta_gestor" class="btn btn-success" style="padding: 0px 0.5rem;background-color: yellowgreen" onclick='."'ver_grafico_pregunta_gestor(".$reg->id_examen.")'".'  title="Ver Grafico General de Preguntas"> Grafico P.<i class="fa fa-bar-chart" aria-hidden="true"></i> </a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_univero_preguntas(){

        $sql = "SELECT p.id_pregunta,p.nombre_pregunta,p.id_atu,p.dificultad,c.nom_apli,p.id_examen FROM pid_exam_pregunta p INNER JOIN pid_aplicativo c ON p.id_apli = c.id_apli WHERE p.pregunta_oculta = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            if($reg->dificultad == 0){
                $dificultad = "Facil";
                $text_color = "text-success";
            }else{
                $dificultad = "Dificil";
                $text_color = "text-danger";
            }
            $i = $i + 1;
            $array = array(
                "[P".$reg->id_pregunta."]",
                "".$i,
                strip_tags(utf8_encode($reg->nombre_pregunta)),
                $reg->id_examen,
                "<b class='".$text_color."'>APL".$reg->id_atu."</b>",
                $reg->nom_apli,
                $dificultad,
                '<div class="btn-group"><a data-toggle="modal" data-target="#modal_edit_pregunta" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'editar_pregunta(".$reg->id_pregunta.")'".'  title="Editar Pregunta"><i class="fa fa-edit" aria-hidden="true"></i> </a> '
                .'<a data-toggle="modal" data-target="#modal_grafico_preguntas" class="btn btn-info" style="padding: 0px 0.5rem;" onclick='."'view_grafico_pregunta(".$reg->id_pregunta.")'".'  title="Visualizar Estadisticas"><i class="fa fa-pie-chart" aria-hidden="true"></i> </a>'
                .'<a class="btn btn-danger" style="padding: 0px 0.5rem;" onclick='."'reiniciar_estadistica_pregunta(".$reg->id_pregunta.")'".'  title="Eliminar Estadisticas"><i class="fa fa-recycle" aria-hidden="true"></i> </a>'
                .'<a class="btn btn-primary" style="padding: 0px 0.5rem;background-color:orange" onclick='."'ocultar_pregunta(".$reg->id_pregunta.")'".'  title="Ocultar Preguntas"><i class="fa fa-close" aria-hidden="true"></i> </a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_univero_preguntas_propuestas(){

        $sql = "SELECT p.id_pregunta_pro,p.nombre_pregunta_pro,u.nom_user,p.fec_propuesta,p.estado_propuesta FROM pid_exam_pregunta_propuesta p INNER JOIN pid_usuario u ON u.id_user = p.usuario_propuesta";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            if($reg->estado_propuesta == 0){
                $estado = '<a class="label label-primary"><i class="fa fa-ban"></i> SIN-ASOCIAR</a>';
            }else if($reg->estado_propuesta == 1){
                $estado = '<a class="label label-success"><i class="fa fa-check"></i> ASOCIADO</a>';
            }else if($reg->estado_propuesta == 2){
                $estado = '<a class="label label-danger"><i class="fa fa-close"></i> ELIMINADO</a>';
            }
            $fec_propuesta = date("d/m/Y H:i a", strtotime($reg->fec_propuesta));
            $array = array(
                "[P".$reg->id_pregunta_pro."]",
                "".$i,
                strip_tags(utf8_encode($reg->nombre_pregunta_pro)),
                utf8_encode($reg->nom_user),
                $fec_propuesta,
                $estado,
                '<div class="btn-group"><a data-toggle="modal" data-target="#modal_edit_pregunta" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'editar_pregunta_propuesta(".$reg->id_pregunta_pro.")'".'  title="Editar Pregunta"><i class="fa fa-edit" aria-hidden="true"></i> </a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_examen_asignados(){

        $sql = "SELECT a.id_asignado, a.nota_final, e.titulo_examen, e.id_examen, a.examen_tomado, a.fecha_examen, a.fecha_termino, u.nom_user, u.claro_user, a.id_user, a.id_identificador FROM pid_exam_asignado a INNER JOIN pid_examen e ON a.id_examen = e.id_examen INNER JOIN pid_usuario u ON a.id_user = u.id_user WHERE e.habilitado = '1' AND u.usuario_eliminado = '0' ORDER BY a.fecha_examen DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            $fecha_actual = strtotime(date("Y-m-d H:i:s"));
            $fecha_termino = strtotime($reg->fecha_termino);

            if($reg->examen_tomado == 0){
                $estado = '<a class="label label-primary">PENDIENTE</a>';
                $boton = '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_asignado" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'editar_asignado(".$reg->id_asignado.")'".'  title="Editar Asignado"> <i class="fa fa-edit" aria-hidden="true"></i> </a> '
                        .'<a class="btn btn-danger" style="padding: 0px 0.6rem;" onclick='."'eliminar_asignado(".$reg->id_asignado.",".$reg->id_user.")'".'  title="Eliminar Asignado"> <i class="fa fa-close" aria-hidden="true"></i> </a></div>';
            }elseif($reg->examen_tomado == 2){
                $estado = '<a class="label label-danger">EXPIRADO</a>';
                $boton = '<a class="btn btn-danger" style="padding: 0px 0.6rem;" onclick='."'eliminar_asignado(".$reg->id_asignado.",".$reg->id_user.")'".'  title="Eliminar Asignado"> <i class="fa fa-close" aria-hidden="true"></i> </a>';
            }elseif($reg->examen_tomado == 3){
                $estado = '<a class="label label-warning">EN-PROCESO</a>';
                $boton = '<a class="btn btn-danger" style="padding: 0px 0.6rem;" onclick='."'eliminar_asignado(".$reg->id_asignado.",".$reg->id_user.")'".'  title="Eliminar Asignado"> <i class="fa fa-close" aria-hidden="true"></i> </a>';
            }elseif($reg->examen_tomado == 4){
                $estado = '<a class="label label-info" style="background-color:#AE8E11">OBSERVADO</a>';
                $boton = '<div class="btn-group" role="group"><a class="btn btn-danger" style="padding: 0px 0.6rem;" onclick='."'eliminar_asignado(".$reg->id_asignado.",".$reg->id_user.")'".'  title="Eliminar Asignado"> <i class="fa fa-close" aria-hidden="true"></i> </a> '
                        .'<a data-toggle="modal" data-target="#modal_view_grafica" onclick='."'ver_grafica(".$reg->id_user.",\"$reg->id_identificador\")'".' class="btn btn-info" style="padding: 0px 0.5rem;"> <i class="fa fa-pie-chart" aria-hidden="true"></i> </a> '
                        .'<a data-toggle="modal" data-target="#modal_edit_asignado" onclick='."'editar_asignado(".$reg->id_asignado.")'".' class="btn btn-warning" style="padding: 0px 0.5rem;background-color:#AAC35B;"> <i class="fa fa-medkit" aria-hidden="true"></i> </a></div>';
            }else{
                $estado = '<a class="label label-success">RESUELTO</a>';
                $boton = '<div class="btn-group" role="group"><a class="btn btn-danger" style="padding: 0px 0.6rem;" onclick='."'eliminar_asignado(".$reg->id_asignado.",".$reg->id_user.")'".'  title="Eliminar Asignado"> <i class="fa fa-close" aria-hidden="true"></i> </a> '
                        .'<a data-toggle="modal" data-target="#modal_view_grafica" onclick='."'ver_grafica(".$reg->id_user.",\"$reg->id_identificador\")'".' class="btn btn-info" style="padding: 0px 0.5rem;"> <i class="fa fa-pie-chart" aria-hidden="true"></i> </a> '
                        .'<a data-toggle="modal" data-target="#modal_view_observacion" onclick='."'insertar_observacion(".$reg->id_user.",\"$reg->id_identificador\")'".' class="btn btn-info" style="padding: 0px 0.5rem;background-color:#AE8E11;color: #FFFFFF"> <i class="fa fa-warning" aria-hidden="true"></i> </a></div>';
            }

            if($reg->nota_final == NULL){
                $nota = "Sin Nota";
            }else{
                $nota = $reg->nota_final;
            }

            if($reg->examen_tomado == 1 || $reg->examen_tomado == 2){
                if($nota > 10){
                    $nota = "<strong class='text-success'>".$reg->nota_final."</strong>";
                }else{
                    if($reg->nota_final == NULL){
                        $nota_expirado = 0;
                    }else{
                        $nota_expirado = $reg->nota_final;
                    }
                    $nota = "<strong class='text-danger'>0".$nota_expirado."</strong>";
                }
                if($reg->nota_final == 10 || $reg->nota_final == 11 || $reg->nota_final == 12 || $reg->nota_final == 13){
                    $nota = "<strong class='text-danger'>".$reg->nota_final."</strong>";
                }
            }

            if($reg->examen_tomado == 0 || $reg->examen_tomado == 3){
                if($fecha_termino < $fecha_actual){
                    $nota = "<strong class='text-danger'>00</strong>";
                    $estado = '<a class="label label-danger">EXPIRADO</a>';
                    $boton = '<div class="btn-group" role="group"><a class="btn btn-danger" style="padding: 0px 0.5rem;" onclick='."'eliminar_asignado(".$reg->id_asignado.",".$reg->id_user.")'".'  title="Eliminar Asignado"> <i class="fa fa-close" aria-hidden="true"></i> </a>'
                    .$boton = '<a class="btn btn-success" style="padding: 0px 0.5rem;" onclick='."'correguir_usuario(".$reg->id_asignado.",".$reg->id_user.")'".'  title="Corregir Usuario"> <i class="fa fa-wrench" aria-hidden="true"></i> </a></div>';
                }
            }
            
            if($reg->examen_tomado == 4){
                $nota = "<strong class='text-danger'>00</strong>";
            }
            
            $array = array(
                $reg->id_asignado,
                "".$i,
                $reg->claro_user,
                utf8_encode($reg->nom_user),
                $reg->titulo_examen,
                date("d/m/Y h:i a",  strtotime($reg->fecha_examen)),
                date("d/m/Y h:i a", strtotime($reg->fecha_termino)),
                $estado,
                $nota,
                $boton
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function bloquear_pid($id_user){

        $sql = "UPDATE pid_usuario SET bloqueo_examen = '1' WHERE id_user = '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function bloquear_documento($id_atu){

        $sql = "SELECT DISTINCT(p.id_atu) FROM pid_exam_pregunta p INNER JOIN pid_exam_asignado e ON e.id_examen = p.id_examen WHERE p.id_atu = '".$id_atu."' AND e.examen_tomado IN (3,0) AND e.fecha_examen <= NOW() AND e.fecha_termino >= NOW()";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen($id_examen){

        $sql = "SELECT * FROM pid_examen WHERE id_examen = '".$id_examen."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen_asignado($id_examen,$id_user){

        $sql = "SELECT * FROM pid_exam_asignado WHERE id_examen = '".$id_examen."' AND id_user = '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen_user_num($id_examen_tomado){

        $sql = "SELECT * FROM pid_examen WHERE id_examen = '".$id_examen_tomado."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_id_examen(){

        $sql = "SELECT id_examen,titulo_examen FROM pid_examen";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_id_examen_asig(){

        $sql = "SELECT id_examen,titulo_examen FROM pid_examen WHERE habilitado = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_pregunta($id_pregunta){

        $sql = "SELECT * FROM pid_exam_pregunta where id_pregunta = '".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_pregunta_propuesta($id_pregunta){

        $sql = "SELECT * FROM pid_exam_pregunta_propuesta where id_pregunta_pro = '".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen_user($id_examen,$num_facil,$num_dificil){

        //$sql = "SELECT p.id_pregunta,p.nombre_pregunta,p.respuesta_1,p.respuesta_2,p.respuesta_3,p.respuesta_4,p.respuesta_correcta,e.titulo_examen,e.tiempo_examen,a.fecha_examen,a.fecha_termino,a.examen_tomado FROM pid_exam_pregunta p INNER JOIN pid_examen e ON e.id_examen = p.id_examen INNER JOIN pid_exam_asignado a ON a.id_examen = p.id_examen WHERE p.id_examen = '".$id_examen."' AND a.id_user = '".$id_user."' ORDER BY rand() LIMIT 6";
        //$sql = "(SELECT p.id_pregunta,p.nombre_pregunta,p.respuesta_1,p.respuesta_2,p.respuesta_3,p.respuesta_4,p.respuesta_correcta,p.dificultad,e.titulo_examen,e.tiempo_examen,a.fecha_examen,a.fecha_termino,a.examen_tomado FROM pid_exam_pregunta p INNER JOIN pid_examen e ON e.id_examen = p.id_examen INNER JOIN pid_exam_asignado a ON a.id_examen = p.id_examen WHERE p.id_examen = '".$id_examen."' AND a.id_user = '".$id_user."' AND p.dificultad = '0' AND a.id_identificador = '".$id_identificador."' ORDER BY rand() LIMIT $num_facil) UNION (SELECT p.id_pregunta,p.nombre_pregunta,p.respuesta_1,p.respuesta_2,p.respuesta_3,p.respuesta_4,p.respuesta_correcta,p.dificultad,e.titulo_examen,e.tiempo_examen,a.fecha_examen,a.fecha_termino,a.examen_tomado FROM pid_exam_pregunta p INNER JOIN pid_examen e ON e.id_examen = p.id_examen INNER JOIN pid_exam_asignado a ON a.id_examen = p.id_examen WHERE p.id_examen = '".$id_examen."' AND a.id_user = '".$id_user."' AND p.dificultad = '1' AND a.id_identificador = '".$id_identificador."' ORDER BY rand() LIMIT $num_dificil)";
        $sql = "(SELECT p.id_pregunta,p.nombre_pregunta,p.respuesta_1,p.respuesta_2,p.respuesta_3,p.respuesta_4,p.respuesta_correcta,p.dificultad,e.titulo_examen,e.tiempo_examen FROM pid_exam_pregunta p INNER JOIN pid_examen e ON e.id_examen = p.id_examen WHERE p.id_examen RLIKE '[[:<:]]".$id_examen."[[:>:]]' AND p.dificultad = '0' AND p.pregunta_oculta = '0' ORDER BY rand() LIMIT ".$num_facil.") UNION (SELECT p.id_pregunta,p.nombre_pregunta,p.respuesta_1,p.respuesta_2,p.respuesta_3,p.respuesta_4,p.respuesta_correcta,p.dificultad,e.titulo_examen,e.tiempo_examen FROM pid_exam_pregunta p INNER JOIN pid_examen e ON e.id_examen = p.id_examen WHERE p.id_examen RLIKE '[[:<:]]".$id_examen."[[:>:]]' AND p.dificultad = '1' AND p.pregunta_oculta = '0' ORDER BY rand() LIMIT ".$num_dificil.")";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_examen_espc_user($id_examen){

        $sql = "SELECT * FROM pid_examen WHERE id_examen = '".$id_examen."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen_identificado_user($id_identificador,$id_user){

        $sql = "SELECT * FROM pid_exam_asignado WHERE id_identificador = '".$id_identificador."' AND id_user = '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_user(){

        $sql = "SELECT * FROM pid_usuario ORDER BY nom_user ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_user_examen(){

        $sql = "SELECT * FROM pid_usuario WHERE val_examen = '0' AND usuario_eliminado = '0' AND estado_user = '0' ORDER BY nom_user ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_asignado($id_asignado){

        $sql = "SELECT * FROM pid_exam_asignado WHERE id_asignado = '".$id_asignado."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grafico($id_user_exam,$id_identificador){

        $sql = "SELECT e.titulo_examen,e.fecha_revision,u.nom_user,r.correctas,r.incorrectas,r.sin_respuesta,r.preguntas,r.respuestas FROM pid_exam_resultado r INNER JOIN pid_examen e ON r.id_examen = e.id_examen INNER JOIN pid_usuario u ON r.id_user = u.id_user WHERE r.id_user = '".$id_user_exam."' AND r.id_identificador = '".$id_identificador."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grafico_gestor($id_examen){

        $sql = "SELECT DISTINCT u.nom_user,e.nota_final,e.examen_tomado,e.fecha_termino FROM pid_exam_resultado r INNER JOIN pid_exam_asignado e ON e.id_examen = r.id_examen INNER JOIN pid_usuario u ON u.id_user = e.id_user WHERE r.id_examen = '".$id_examen."' ORDER BY LENGTH(e.nota_final),e.nota_final ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_grafico_gestor_portal($id_examen){

        $sql = "SELECT DISTINCT u.nom_user,e.nota_final,e.examen_tomado,e.fecha_termino FROM pid_exam_resultado r INNER JOIN pid_exam_asignado e ON e.id_examen = r.id_examen INNER JOIN pid_usuario u ON u.id_user = e.id_user WHERE r.id_examen = '".$id_examen."' ORDER BY LENGTH(e.nota_final),e.nota_final ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grafico_pregunta_gestor($id_examen){

        $sql = "SELECT id_pregunta FROM pid_exam_pregunta_resultado WHERE id_examen = '$id_examen'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_count_grafico_pregunta_gestor($id_examen,$id_pregunta, $campo){
        $sql = "SELECT $campo FROM pid_exam_pregunta_resultado WHERE id_examen = '$id_examen' AND id_pregunta = '$id_pregunta' AND IF($campo > 0, 1, 0)";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grafico_pregunta($id_pregunta){

        $sql = "SELECT * FROM pid_exam_pregunta WHERE id_pregunta='".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen_grafico($id_examen){

        $sql = "SELECT * FROM pid_examen WHERE id_examen = '".$id_examen."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen_title(){

        $sql = "SELECT * FROM pid_examen";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_examen_asig(){

        $sql = "SELECT titulo_examen FROM pid_examen WHERE habilitado = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function validar_preguntas($id_examen,$tipo_servicio){

        //$sql = "SELECT id_pregunta,nombre_pregunta,respuesta_1,respuesta_2,respuesta_3,respuesta_4,respuesta_correcta,id_examen,id_atu FROM pid_exam_pregunta WHERE id_pregunta IN(".$id_examen.") ORDER BY FIELD(id_pregunta,".$id_examen.")";
        $sql = "SELECT t.id_tabla,p.id_pregunta,p.nombre_pregunta,p.respuesta_1,p.respuesta_2,p.respuesta_3,p.respuesta_4,p.respuesta_correcta,p.id_examen,p.id_atu FROM pid_exam_pregunta p INNER JOIN pid_conocimiento t ON t.id_atu = p.id_atu WHERE p.id_pregunta IN (".$id_examen.") AND t.tipo_conocimiento = '$tipo_servicio' ORDER BY FIELD(p.id_pregunta,".$id_examen.")";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function desbloquear_pid($id_user_asig){

        $sql = "UPDATE pid_usuario SET bloqueo_examen = '0', val_examen = '0' WHERE id_user = '".$id_user_asig."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insert_respuesta($id_user,$id_examen_tomado,$correctas,$incorrectas,$sin_respuesta,$preguntas,$respuestas,$id_identificador){

        $sql = "INSERT INTO pid_exam_resultado (`id_user`,`id_examen`,`correctas`,`incorrectas`,`sin_respuesta`,`preguntas`,`respuestas`,`id_identificador`) VALUES ('$id_user','$id_examen_tomado','$correctas','$incorrectas','$sin_respuesta','$preguntas','$respuestas','$id_identificador')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insert_examen($titulo_examen,$fecha_examen,$fecha_revision,$tiempo_examen,$num_preguntas,$num_facil,$num_dificil,$ver_portal){

        $sql = "INSERT INTO pid_examen (`titulo_examen`,`fecha_inicio`,`fecha_revision`,`tiempo_examen`,`num_preguntas`,`num_facil`,`num_dificil`, `ver_portal`) VALUES ('$titulo_examen','$fecha_examen','$fecha_revision','$tiempo_examen','$num_preguntas','$num_facil','$num_dificil','$ver_portal')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insert_pregunta($nom_pregunta,$respuesta_1,$respuesta_2,$respuesta_3,$respuesta_4,$respuesta_correcta,$id_atu,$id_apli,$id_examen,$dificultad){

        $sql = "INSERT INTO pid_exam_pregunta (`nombre_pregunta`,`respuesta_1`,`respuesta_2`,`respuesta_3`,`respuesta_4`,`respuesta_correcta`,`id_atu`,`id_apli`,`id_examen`,`dificultad`) VALUES ('$nom_pregunta','$respuesta_1','$respuesta_2','$respuesta_3','$respuesta_4','$respuesta_correcta','$id_atu','$id_apli','$id_examen','$dificultad')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insert_pregunta_propuesta($nom_pregunta,$respuesta_1,$respuesta_2,$respuesta_3,$respuesta_4,$respuesta_correcta,$usuario_propuesta,$fec_propuesta){

        $sql = "INSERT INTO pid_exam_pregunta_propuesta (`nombre_pregunta_pro`,`respuesta_1`,`respuesta_2`,`respuesta_3`,`respuesta_4`,`respuesta_correcta`,`usuario_propuesta`,`fec_propuesta`) VALUES ('$nom_pregunta','$respuesta_1','$respuesta_2','$respuesta_3','$respuesta_4','$respuesta_correcta','$usuario_propuesta','$fec_propuesta')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insert_asignado($id_examen,$id_user,$fecha_examen,$fecha_termino,$id_identificador){

        $sql = "INSERT INTO pid_exam_asignado (`id_examen`,`id_user`,`fecha_examen`,`fecha_termino`,`id_identificador`) VALUES ('$id_examen','$id_user','$fecha_examen','$fecha_termino','$id_identificador')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_examen($id_examen,$titulo_examen,$fecha_examen,$fecha_revision,$tiempo_examen,$num_preguntas,$num_facil,$num_dificil,$ver_portal){

        $sql = "UPDATE pid_examen SET titulo_examen = '$titulo_examen', fecha_inicio = '$fecha_examen', fecha_revision = '$fecha_revision', tiempo_examen = '$tiempo_examen', num_preguntas = '$num_preguntas', num_facil = '$num_facil', num_dificil = '$num_dificil', ver_portal = '$ver_portal' WHERE id_examen = '".$id_examen."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_pregunta($nom_pregunta,$respuesta_1,$respuesta_2,$respuesta_3,$respuesta_4,$respuesta_correcta,$id_atu,$id_apli,$id_examen,$dificultad,$id_pregunta){

        $sql = "UPDATE pid_exam_pregunta SET nombre_pregunta = '$nom_pregunta', respuesta_1 = '$respuesta_1', respuesta_2 = '$respuesta_2', respuesta_3 = '$respuesta_3', respuesta_4 = '$respuesta_4', respuesta_correcta = '$respuesta_correcta', id_atu = '$id_atu', id_apli = '$id_apli', id_examen = '$id_examen', dificultad = '$dificultad' WHERE id_pregunta = '".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_usuario_examen($id_user){

        $sql = "UPDATE pid_usuario SET val_examen = '1' WHERE id_user = '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_asignado($fecha_examen,$fecha_termino,$id_asignado){

        $sql = "UPDATE pid_exam_asignado SET fecha_examen = '$fecha_examen', fecha_termino = '$fecha_termino', examen_tomado = '0', nota_final = NULL, nota_observado = NULL WHERE id_asignado = '".$id_asignado."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_nota_examen($id_user,$id_examen_tomado,$nota_final,$id_identificador){

        $sql = "UPDATE pid_exam_asignado SET nota_final = '$nota_final',examen_tomado = '1' WHERE id_user = '".$id_user."' AND id_identificador='".$id_identificador."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_tomando_examen($id_user,$id_identificador){

        $sql = "UPDATE pid_exam_asignado SET examen_tomado = '3' WHERE id_user = '".$id_user."' AND id_identificador='".$id_identificador."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_termino_examen($id_user,$id_identificador,$nota_final){

        $sql = "UPDATE pid_exam_asignado SET nota_final = '$nota_final',examen_tomado = '2' WHERE id_user = '".$id_user."' AND id_identificador='".$id_identificador."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estado_examen($id,$estado){
        
        $sql = "UPDATE pid_examen SET habilitado='".$estado."' WHERE id_examen='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_correguir_usuario($id_user_asig){
        
        $sql = "UPDATE pid_usuario SET val_examen='0' WHERE id_user='".$id_user_asig."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_correguir_expiracion($id,$id_user_asig){
        
        $sql = "UPDATE pid_exam_asignado SET examen_tomado='2' WHERE id_asignado='".$id."' AND id_user='".$id_user_asig."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function delete_asignado($id){
        
        $sql = "DELETE FROM pid_exam_asignado WHERE id_asignado='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_pregunta_correcta($id_pregunta){
        
        $sql = "UPDATE pid_exam_pregunta SET correctas=correctas+1 WHERE id_pregunta='".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_pregunta_incorrecta($id_pregunta){
        
        $sql = "UPDATE pid_exam_pregunta SET incorrectas=incorrectas+1 WHERE id_pregunta='".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_pregunta_sin_respuesta($id_pregunta){
        
        $sql = "UPDATE pid_exam_pregunta SET sin_respuesta=sin_respuesta+1 WHERE id_pregunta='".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insert_pregunta_resultado($id_pregunta,$id_examen_tomado,$campo_tabla){
        $sql = "INSERT INTO pid_exam_pregunta_resultado (`id_pregunta`,`id_examen`,`$campo_tabla`) VALUES ('$id_pregunta','$id_examen_tomado','1')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_exam_portal(){

        $sql = "UPDATE pid_examen SET ver_portal = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function ocultar_pregunta($id){
        
        $sql = "UPDATE pid_exam_pregunta SET pregunta_oculta = '1' WHERE id_pregunta = '".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insert_observacion($txt_motivo,$nota_observado,$id_identificador,$id_user){

        $sql = "UPDATE pid_exam_asignado SET comentario_observado = '".$txt_motivo."', nota_final = '0', nota_observado = '".$nota_observado."', examen_tomado = '4'  WHERE id_identificador = '".$id_identificador."' AND id_user = '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_nota_actual($id_identificador,$id_user_exam){
        $sql = "SELECT * FROM pid_exam_asignado WHERE id_identificador = '".$id_identificador."' AND id_user = '".$id_user_exam."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_exam_portal(){
        $sql = "SELECT * FROM pid_examen WHERE ver_portal = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}
