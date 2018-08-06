<?php
require_once ('data_access.php');
Class pid_list {

    function list_pid_kdb_json_gestor(){

        $sql = "SELECT t.id_tabla, t.id_atu, t.titulo, t.contenido, c.nom_apli, t.aprobado, t.ver_cliente, t.fecha_creacion, t.fecha_actualizacion, t.contador, t.comentarios, t.tipo_conocimiento, t.publico FROM pid_conocimiento t inner join pid_aplicativo c on t.id_apli = c.id_apli WHERE t.tipo_conocimiento = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            if($reg->aprobado == 1){
                $estado = '<li class="label label-success">P</li>';
            }else{
                $estado = '<li class="label label-danger">NP</li>';
            }

            if($reg->ver_cliente == 1){
                $ver_cliente = '<li class="label label-primary"><i class="fa fa-check"></i></li>';
            }else{
                $ver_cliente = '<li class="label label-info"><i class="fa fa-close"></i></li>';
            }

            if($reg->publico == 1){
                $publico = '<li class="label label-success"><i class="fa fa-check"></i></li>';
            }else{
                $publico = '<li class="label label-danger"><i class="fa fa-close"></i></li>';
            }
            
            if($reg->tipo_conocimiento == 0){
                $tipo_conocimiento = 'APL';
            }else{
                $tipo_conocimiento = 'BIO';
            }

            $array = array(
                $reg->id_tabla,
                $tipo_conocimiento."".$reg->id_atu,
                $reg->titulo,
                strip_tags($reg->contenido),
                $reg->nom_apli,
                $estado,
                $ver_cliente,
                $publico,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                date("d/m/Y",strtotime($reg->fecha_actualizacion)),
                $reg->contador,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_ver_conocimiento" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_atu(".$reg->id_tabla.")'".'  title="Ver Conocimiento"><i class="fa fa-eye" aria-hidden="true"></i></a> '
                .'<a data-toggle="modal" data-target="#modal_edit_conocimiento" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_atu(".$reg->id_tabla.")'".'  title="Editar Conocimiento"><i class="fa fa-edit" aria-hidden="true"></i></a> '
                .'<a class="btn btn-info" style="padding: 0px 0.5rem;" onclick='."'resetear_comentarios(".$reg->id_tabla.")'".'  title="Desactivar Comentarios"><i class="fa fa-comments" aria-hidden="true"></i></a>'
                .'<a class="btn btn-success" style="padding: 0px 0.5rem;" onclick='."'aprobar_conocimiento(".$reg->id_tabla.",".$reg->aprobado.")'".'  title="Cambiar Estado"><i class="fa fa-check" aria-hidden="true"></i></a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_pid_kdb_bio_json_gestor(){

        $sql = "SELECT t.id_tabla, t.id_atu, t.titulo, t.contenido, c.nom_apli, t.aprobado, t.ver_cliente, t.fecha_creacion, t.fecha_actualizacion, t.contador, t.comentarios, t.tipo_conocimiento FROM pid_conocimiento t inner join pid_aplicativo c on t.id_apli = c.id_apli WHERE t.tipo_conocimiento = '1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            if($reg->aprobado == 1){
                $estado = '<li class="label label-success">PUBLICADO</li>';
            }else{
                $estado = '<li class="label label-danger">NO-PUBLICADO</li>';
            }

            if($reg->ver_cliente == 1){
                $ver_cliente = '<li class="label label-primary"><i class="fa fa-check"></i> SI-VER</li>';
            }else{
                $ver_cliente = '<li class="label label-info"><i class="fa fa-close"></i> NO-VER</li>';
            }
            
            if($reg->tipo_conocimiento == 0){
                $tipo_conocimiento = 'APL';
            }else{
                $tipo_conocimiento = 'BIO';
            }

            $array = array(
                $reg->id_tabla,
                $tipo_conocimiento."".$reg->id_atu,
                $reg->titulo,
                strip_tags($reg->contenido),
                $reg->nom_apli,
                $estado,
                $ver_cliente,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                date("d/m/Y",strtotime($reg->fecha_actualizacion)),
                $reg->contador,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_ver_conocimiento" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_atu(".$reg->id_tabla.")'".'  title="Ver Conocimiento"><i class="fa fa-eye" aria-hidden="true"></i></a> '
                .'<a data-toggle="modal" data-target="#modal_edit_conocimiento" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_atu(".$reg->id_tabla.")'".'  title="Editar Conocimiento"><i class="fa fa-edit" aria-hidden="true"></i></a> '
                .'<a class="btn btn-info" style="padding: 0px 0.5rem;" onclick='."'resetear_comentarios(".$reg->id_tabla.")'".'  title="Desactivar Comentarios"><i class="fa fa-comments" aria-hidden="true"></i></a>'
                .'<a class="btn btn-success" style="padding: 0px 0.5rem;" onclick='."'aprobar_conocimiento(".$reg->id_tabla.",".$reg->aprobado.")'".'  title="Cambiar Estado"><i class="fa fa-check" aria-hidden="true"></i></a></div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_kdb_json_borrador(){

        $sql = "SELECT b.*,u.nom_user,u.claro_user FROM pid_borrador b INNER JOIN pid_usuario u ON u.id_user = b.id_user ";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            if($reg->estado == 0){
                $estado = '<li class="label label-primary">BORRADOR</li>';
                $editar = '<a data-toggle="modal" data-target="#modal_edit_borrador" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_atu_borrador(".$reg->id_tabla.")'".' title="Editar Borrador"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
                $eliminar = '<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_atu_borrador(".$reg->id_tabla.")'".'  title="Eliminar Borrador"><i class="fa fa-close" aria-hidden="true"></i></a>';
            }elseif($reg->estado == 1){
                $estado = '<li class="label label-success">PUBLICADO</li>';
                $editar = '';
                $eliminar = '';
            }elseif($reg->estado == 2){
                $estado = '<li class="label label-danger">ELIMINADO</li>';
                $editar = '';
                $eliminar = '';
            }
            $i = $i + 1;
            $array = array(
                $reg->id_tabla,
                "DOC".$i,
                $reg->claro_user,
                utf8_encode($reg->nom_user),
                $reg->ip_autor,
                $estado,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                '<div class="btn-group"><a data-toggle="modal" data-target="#modal_ver_borrador" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_atu_borrador(".$reg->id_tabla.")'".'  title="Ver Borrador"><i class="fa fa-eye" aria-hidden="true"></i></a> '
                .$editar
                .$eliminar.'</div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_kdb_json_user_borrador($id_user){

        $sql = "SELECT * FROM pid_borrador WHERE id_user = '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            if($reg->estado == 0){
                $estado = '<a class="label label-primary">BORRADOR</a>';
                $editar = '<a data-toggle="modal" data-target="#modal_edit_borrador_user" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_atu_borrador_user(".$reg->id_tabla.")'".' title="Editar Borrador"><i class="fa fa-edit" aria-hidden="true"></i></a> ';
            }elseif($reg->estado == 1){
                $estado = '<a class="label label-success">PUBLICADO</a>';
                $editar = '';
            }elseif($reg->estado == 2){
                $estado = '<a class="label label-danger">ELIMINADO</a>';
                $editar = '';
            }
            $i = $i + 1;
            $array = array(
                $reg->id_tabla,
                "DOC".$i,
                $reg->titulo,
                $estado,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                '<div class="btn-group"><a data-toggle="modal" data-target="#modal_ver_borrador" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_atu_borrador(".$reg->id_tabla.")'".'  title="Ver Borrador"><i class="fa fa-eye" aria-hidden="true"></i></a> '
                .$editar."</div>"
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_json_usuarios(){

        $sql = "SELECT * FROM pid_usuario WHERE funcion_user in (0,1,2,4,6,7,8,9) AND usuario_eliminado = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            if($reg->funcion_user == 0){
                $funcion_user = "Analista";
            }
            if($reg->funcion_user == 2){
                $funcion_user = "G.Conocimiento";
            }
            if($reg->funcion_user == 1){
                $funcion_user = "G.Correo";
            }
            if($reg->funcion_user == 4){
                $funcion_user = "Administrador";
            }
            if($reg->funcion_user == 6){
                $funcion_user = "C.Claro";
            }
            if($reg->funcion_user == 7){
                $funcion_user = "Apo.C.Claro";
            }
            if($reg->funcion_user == 8){
                $funcion_user = "Apoyo PID";
            }
            if($reg->funcion_user == 9){
                $funcion_user = "Analista Escalado";
            }
            if($reg->estado_pid == 0){
                $estado = '<li class="label label-danger" style="font-size:9px">NO CONECTADO</li>';
            }else{
                $estado = '<li class="label label-success" style="font-size:9px">CONECTADO</li>';
            }
            if($reg->estado_user == 0){
                $estado_usuario = '<li class="label label-success">ACTIVO</li>';
            }else{
                $estado_usuario = '<li class="label label-danger">CESADO</li>';
            }
            if($reg->inicio_sesion == NULL){
                if($reg->cierre_sesion == NULL){
                    $ultimo_acceso = "-";
                }else{
                    $ultimo_acceso = date("d/m/Y h:i a",strtotime($reg->cierre_sesion));
                }
            }else{
                if($reg->inicio_sesion == NULL){
                    $ultimo_acceso = "-";
                }else{
                    $ultimo_acceso = date("d/m/Y h:i a",strtotime($reg->inicio_sesion));
                }
            }

            $tiempo = $reg->tiempo_kdb;

            $horas = floor($tiempo / 3600);
            $minutos = floor(($tiempo - ($horas * 3600)) / 60);
            $segundos = $tiempo - ($horas * 3600) - ($minutos * 60);

            $hora_texto = "";

            if ($tiempo == 0 ) {
                $hora_texto .= "0s";
            }
            if ($horas > 0 ) {
                $hora_texto .= $horas . "h ";
            }
            if ($minutos > 0 ) {
                $hora_texto .= $minutos . "m ";
            }
            if ($segundos > 0 ) {
                $hora_texto .= $segundos . "s";
            }

            if($reg->rol_user == "0"){
                $rol_user = "Analista de Soporte 1er Nivel";
            }elseif($reg->rol_user == "1"){
                $rol_user = "Supervisor de Soporte 1er Nivel";
            }elseif($reg->rol_user == "2"){
                $rol_user = "Gestor de Servicio";
            }elseif($reg->rol_user == "3"){
                $rol_user = "Monitor de Calidad";
            }elseif($reg->rol_user == "4"){
                $rol_user = "Practicante de Mesa de Ayuda";
            }elseif($reg->rol_user == "5"){
                $rol_user = "Especialista BES";
            }elseif($reg->rol_user == "6"){
                $rol_user = "Asistente Admnistrativo";
            }elseif($reg->rol_user == "7"){
                $rol_user = "Jefe de Proyecto";
            }elseif($reg->rol_user == "8"){
                $rol_user = "Cliente de Proyecto";
            }elseif($reg->rol_user == "9"){
                $rol_user = "Apoyo de Cliente de Proyecto";
            }

            if($reg->telefono_user == NULL || $reg->telefono_user == ""){
                $telefono_user = "-";
            }else{
                $telefono_user = $reg->telefono_user;
            }

            if($reg->telefono_fijo_user == NULL || $reg->telefono_fijo_user == ""){
                $telefono_fijo_user = "-";
            }else{
                $telefono_fijo_user = $reg->telefono_fijo_user;
            }

            if($reg->telefono_referencia_user == NULL || $reg->telefono_referencia_user == ""){
                $telefono_referencia_user = "-";
            }else{
                $telefono_referencia_user = $reg->telefono_referencia_user;
            }

            if($reg->ref_parentesco == NULL || $reg->ref_parentesco == ""){
                $ref_parentesco = "-";
            }elseif($reg->ref_parentesco == "0"){
                $ref_parentesco = "Mamá";
            }elseif($reg->ref_parentesco == "1"){
                $ref_parentesco = "Papá";
            }elseif($reg->ref_parentesco == "2"){
                $ref_parentesco = "Hermano";
            }elseif($reg->ref_parentesco == "3"){
                $ref_parentesco = "Hermana";
            }elseif($reg->ref_parentesco == "4"){
                $ref_parentesco = "Esposo";
            }elseif($reg->ref_parentesco == "5"){
                $ref_parentesco = "Esposa";
            }elseif($reg->ref_parentesco == "6"){
                $ref_parentesco = "Hijo";
            }elseif($reg->ref_parentesco == "7"){
                $ref_parentesco = "Hija";
            }elseif($reg->ref_parentesco == "8"){
                $ref_parentesco = "Tio";
            }elseif($reg->ref_parentesco == "9"){
                $ref_parentesco = "Tia";
            }elseif($reg->ref_parentesco == "10"){
                $ref_parentesco = "Amiga";
            }elseif($reg->ref_parentesco == "11"){
                $ref_parentesco = "Amiga";
            }

            if($reg->genero_user == NULL || $reg->genero_user == "" ){
                $genero_user = "-";
            }elseif($reg->genero_user == "0"){
                $genero_user = "Hombre";
            }elseif($reg->genero_user == "1"){
                $genero_user = "Mujer";
            }

            if($reg->situacion_familiar == NULL || $reg->situacion_familiar == ""){
                $situacion_familiar = "-";
            }elseif($reg->situacion_familiar == "0"){
                $situacion_familiar = "Sin Hijos";
            }elseif($reg->situacion_familiar == "1"){
                $situacion_familiar = "Con Hijos";
            }

            if($reg->num_hijos == NULL || $reg->num_hijos == ""){
                $num_hijos = "-";
            }else{
                $num_hijos = $reg->num_hijos;
            }

            if($reg->cod_empleado == NULL || $reg->cod_empleado == ""){
                $cod_empleado = "-";
            }else{
                $cod_empleado = $reg->cod_empleado;
            }

            if($reg->situacion_academica == NULL || $reg->situacion_academica == ""){
                $situacion_academica = "-";
            }elseif($reg->situacion_academica == "0"){
                $situacion_academica = "Técnica";
            }elseif($reg->situacion_academica == "1"){
                $situacion_academica = "Universitaria";
            }

            if($reg->estado_academico == NULL || $reg->estado_academico == ""){
                $estado_academico = "-";
            }elseif($reg->estado_academico == "0"){
                $estado_academico = "En Curso";
            }elseif($reg->estado_academico == "1"){
                $estado_academico = "Trunco";
            }elseif($reg->estado_academico == "2"){
                $estado_academico = "Egresado";
            }elseif($reg->estado_academico == "3"){
                $estado_academico = "Titulado";
            }

            if($reg->correo_personal == NULL || $reg->correo_personal == ""){
                $correo_personal = "-";
            }else{
                $correo_personal = $reg->correo_personal;
            }

            if($reg->fecha_nacimiento == NULL || $reg->fecha_nacimiento == ""){
                $fec_nacimiento = "-";
            }else{
                $fec_nacimiento = date("d/m/Y", strtotime($reg->fecha_nacimiento));
            }

            if($reg->fec_ingreso == NULL || $reg->fec_ingreso == ""){
                $fec_ingreso = "-";
            }else{
                $fec_ingreso = date("d/m/Y", strtotime($reg->fec_ingreso));
            }
            
            if($reg->nom_user_perfil == NULL || $reg->nom_user_perfil == ""){
                $nom_user = "-";
            }else{
                $nom_user = utf8_encode($reg->nom_user_perfil);
            }

            $array = array(
                $reg->id_user,
                $reg->claro_user,
                utf8_encode($reg->nom_user),
                $nom_user,
                $reg->dni_user,
                $telefono_user,
                $telefono_fijo_user,
                $telefono_referencia_user,
                $ref_parentesco,
                $genero_user,
                $situacion_familiar,
                $num_hijos,
                $cod_empleado,
                $estado_academico,
                $situacion_academica,
                $fec_nacimiento,
                $fec_ingreso,
                $correo_personal,
                $reg->ip_user,
                $rol_user,
                $funcion_user,
                $estado_usuario,
                $estado,
                $reg->kdb_ingresos,
                $hora_texto,
                $reg->comentarios_calificados,
                $ultimo_acceso,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_usuario" class="btn btn-warning" style="padding: 0px 0.6rem;" onclick='."'edit_usuario(".$reg->id_user.")'".'  title="Editar Usuario"><i class="fa fa-edit" aria-hidden="true"></i></a> '
                .'<a data-toggle="modal" data-target="#modal_edit_perfil" class="btn" style="padding: 0px 0.7rem;background-color:#5972FF;color:white" onclick='."'editar_perfil_usuario(".$reg->id_user.")'".'  title="Editar Perfil de Usuario"><i class="fa fa-user" aria-hidden="true"></i></a> '
                .'<a class="btn btn-success" style="padding: 0px 0.6rem;" onclick='."'desconectar_usuario(".$reg->id_user.")'".'  title="Desconectar Usuario"><i class="fa fa-sign-out" aria-hidden="true"></i></a> '
                .'<a class="btn btn-info" style="padding: 0px 0.7rem;" onclick='."'resetear_password(".$reg->id_user.")'".'  title="Resetear Contraseña"><i class="fa fa-recycle" aria-hidden="true"></i></a> '
                .'<a class="btn btn-primary" style="padding: 0px 0.7rem;" onclick='."'resetear_comment_calificados_usuario(".$reg->id_user.")'".'  title="Resetear Comentarios Calificados"><i class="fa fa-comments" aria-hidden="true"></i></a> '
                .'<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_usuario(".$reg->id_user.")'".'  title="Eliminar Usuario"><i class="fa fa-close" aria-hidden="true"></i></a> </div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_kdb_json(){

        $sql = "SELECT t.id_tabla, t.id_atu, t.titulo, t.contenido, c.nom_apli, t.aprobado, t.fecha_creacion, t.fecha_actualizacion, t.contador FROM pid_conocimiento t inner join pid_aplicativo c on t.id_apli = c.id_apli WHERE t.aprobado='1' AND t.tipo_conocimiento='0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            $array = array(
                $reg->id_tabla,
                "APL".$reg->id_atu,
                $reg->titulo,
                strip_tags($reg->contenido),
                $reg->nom_apli,
                $reg->aprobado,
                $reg->aprobado,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                date("d/m/Y",strtotime($reg->fecha_actualizacion)),
                $reg->contador,
                '<a data-toggle="modal" data-target="#modal_ver_conocimiento" class="btn btn-primary" style="padding: 1px 4rem;" onclick='."'view_atu(".$reg->id_tabla.")'".'  title="Ver Conocimiento"><span class="fa fa-eye" aria-hidden="true"></span></a>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_pid_kdb_biometrico_json(){

        $sql = "SELECT t.id_tabla, t.id_atu, t.titulo, t.contenido, c.nom_apli, t.aprobado, t.fecha_creacion, t.fecha_actualizacion, t.contador FROM pid_conocimiento t inner join pid_aplicativo c on t.id_apli = c.id_apli WHERE t.aprobado='1' AND t.tipo_conocimiento='1'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            $array = array(
                $reg->id_tabla,
                "BIO".$reg->id_atu,
                $reg->titulo,
                strip_tags($reg->contenido),
                $reg->nom_apli,
                $reg->aprobado,
                $reg->aprobado,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                date("d/m/Y",strtotime($reg->fecha_actualizacion)),
                $reg->contador,
                '<a data-toggle="modal" data-target="#modal_ver_conocimiento" class="btn btn-primary" style="padding: 1px 4rem;" onclick='."'view_atu(".$reg->id_tabla.")'".'  title="Ver Conocimiento"><span class="fa fa-eye" aria-hidden="true"></span></a>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_kdb_json_cliente(){

        $sql = "SELECT t.id_tabla, t.id_atu, t.titulo, t.contenido, c.nom_apli, t.aprobado, t.fecha_creacion, t.fecha_actualizacion, t.contador FROM pid_conocimiento t inner join pid_aplicativo c on t.id_apli = c.id_apli WHERE t.aprobado='1' AND t.ver_cliente='1' AND t.tipo_conocimiento='0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            $array = array(
                $reg->id_tabla,
                "APL".$reg->id_atu,
                $reg->titulo,
                strip_tags($reg->contenido),
                $reg->nom_apli,
                $reg->aprobado,
                $reg->aprobado,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                date("d/m/Y",strtotime($reg->fecha_actualizacion)),
                $reg->contador,
                '<a data-toggle="modal" data-target="#modal_ver_conocimiento" class="btn btn-primary" style="padding: 1px 4rem;" onclick='."'view_atu(".$reg->id_tabla.")'".'  title="Ver Conocimiento"><span class="fa fa-eye" aria-hidden="true"></span></a>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_kdb_json_usuario(){

        $sql = "SELECT t.id_tabla, t.id_atu, t.titulo, t.contenido, c.nom_apli, t.aprobado, t.fecha_creacion, t.fecha_actualizacion, t.contador FROM pid_conocimiento t INNER JOIN pid_aplicativo c ON t.id_apli = c.id_apli WHERE t.aprobado='1' AND t.publico='1' AND t.tipo_conocimiento='0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            $array = array(
                $reg->id_tabla,
                $reg->id_atu,
                $reg->titulo,
                strip_tags($reg->contenido),
                $reg->nom_apli,
                $reg->aprobado,
                date("d/m/Y",strtotime($reg->fecha_creacion)),
                date("d/m/Y",strtotime($reg->fecha_actualizacion)),
                $reg->contador
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_bitacora_json_gestor(){

        $sql = "SELECT b.fec_bitacora, b.txt_impacto, b.user_afectado, g.nom_grupo, c.nom_apli, b.txt_bitacora, b.nom_responsable, b.num_caso, b.num_correo, b.id_estado, b.fec_apertura, b.fec_solucion, b.fec_cierre, b.fec_reasi, b.fec_recepcion, b.id_bitacora FROM pid_bitacora b inner join pid_aplicativo c on b.id_apli = c.id_apli inner join pid_grupo_asignado g on b.id_grupo = g.id_grupo";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            if($reg->id_estado == "ASIGNADO"){
                $estado = '<li class="btn btn-warning" style="width: 121px;">ASIGNADO</li>';
                $ecuacion = (strtotime($reg->fec_bitacora)-  strtotime(date('Y-m-d H:i:s')))/86400;
                $dias = "Hace ".floor(abs($ecuacion))." dias";
            }elseif($reg->id_estado == "SOLUCIONADO"){
                $estado = '<li class="btn btn-success" style="width: 121px;">SOLUCIONADO</li>';
                $dias = "-";
            }elseif($reg->id_estado == "RE-ASIGNADO"){
                $estado = '<li class="btn btn-primary" style="width: 121px;">RE-ASIGNADO</li>';
                $ecuacion = (strtotime($reg->fec_bitacora) -  strtotime(date('Y-m-d H:i:s')))/86400;
                $dias = "Hace ".floor(abs($ecuacion))." dias";
            }elseif($reg->id_estado == "CERRADO"){
                $estado = '<li class="btn btn-danger" style="width: 121px;">CERRADO</li>';
                $dias = "-";
            }
            if($reg->fec_apertura == NULL){
                $fec_apertura = "";
            }else{
                $fec_apertura = date("d/m/Y h:i a",strtotime($reg->fec_apertura));
            }
            if($reg->fec_solucion == NULL){
                $fec_solucion = "";
            }else{
                $fec_solucion = date("d/m/Y h:i a",strtotime($reg->fec_solucion));
            }
            if($reg->fec_cierre == NULL){
                $fec_cierre = "";
            }else{
                $fec_cierre = date("d/m/Y h:i a",strtotime($reg->fec_cierre));
            }
            if($reg->fec_reasi == NULL){
                $fec_reasi = "";
            }else{
                $fec_reasi = date("d/m/Y h:i a",strtotime($reg->fec_reasi));
            }
            if($reg->fec_recepcion == NULL){
                $fec_recepcion = "";
            }else{
                $fec_recepcion = date("d/m/Y h:i a",strtotime($reg->fec_recepcion));
            }
            $array = array(
                date("d/m/Y",strtotime($reg->fec_bitacora)),
                $reg->txt_impacto,
                $reg->user_afectado,
                strtoupper($reg->nom_grupo),
                strtoupper($reg->nom_apli),
                utf8_encode(stripslashes($reg->txt_bitacora)),
                $reg->nom_responsable,
                $reg->num_caso,
                $reg->num_correo,
                $estado,
                $fec_apertura,
                $fec_solucion,
                $fec_cierre,
                $fec_reasi,
                $fec_recepcion,
                $dias,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_ver_bitacora" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_bitacora(".$reg->id_bitacora.")'".' title="Ver Caso SDM"><span class="fa fa-eye" aria-hidden="true"></span></a> '
                .'<a data-toggle="modal" data-target="#modal_edit_bitacora" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_bitacora(".$reg->id_bitacora.")'".'  title="Editar Bitacora"><span class="fa fa-edit" aria-hidden="true"></span></a> '
                .'<a data-toggle="modal" data-target="#modal_edit_fecha_bitacora" class="btn btn-info" style="padding: 0px 0.5rem;" onclick='."'edit_fecha_bitacora(".$reg->id_bitacora.")'".'  title="Editar Fecha Bitacora"><span class="fa fa-calendar" aria-hidden="true"></span></a> '
                .'<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_bitacora(".$reg->id_bitacora.")'".'  title="Eliminar Bitacora"><i class="fa fa-close" aria-hidden="true"></i></a> </div>'

                );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_bitacora_json_cliente(){

        $sql = "SELECT b.fec_bitacora, b.txt_impacto, b.user_afectado, g.nom_grupo, c.nom_apli, b.txt_bitacora, b.nom_responsable, b.num_caso, b.num_correo, b.id_estado, b.fec_apertura, b.fec_solucion, b.fec_cierre, b.fec_reasi, b.fec_recepcion, b.id_bitacora FROM pid_bitacora b inner join pid_aplicativo c on b.id_apli = c.id_apli inner join pid_grupo_asignado g on b.id_grupo = g.id_grupo";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            if($reg->id_estado == "ASIGNADO"){
                $estado = '<li class="btn btn-warning" style="width: 121px;">ASIGNADO</li></li>';
                $ecuacion = (strtotime($reg->fec_bitacora)-  strtotime(date('Y-m-d H:i:s')))/86400;
                $dias = "Hace ".floor(abs($ecuacion))." dias";
            }elseif($reg->id_estado == "SOLUCIONADO"){
                $estado = '<li class="btn btn-success" style="width: 121px;">SOLUCIONADO</li></li>';
                $dias = "-";
            }elseif($reg->id_estado == "RE-ASIGNADO"){
                $estado = '<li class="btn btn-primary" style="width: 121px;">RE-ASIGNADO</li></li>';
                $ecuacion = (strtotime($reg->fec_bitacora)-  strtotime(date('Y-m-d H:i:s')))/86400;
                $dias = "Hace ".floor(abs($ecuacion))." dias";
            }elseif($reg->id_estado == "CERRADO"){
                $estado = '<li class="btn btn-danger" style="width: 121px;">CERRADO</li></li>';
                $dias = "-";
            }
            if($reg->fec_apertura == NULL){
                $fec_apertura = "";
            }else{
                $fec_apertura = date("d/m/Y h:i a",strtotime($reg->fec_apertura));
            }
            if($reg->fec_solucion == NULL){
                $fec_solucion = "";
            }else{
                $fec_solucion = date("d/m/Y h:i a",strtotime($reg->fec_solucion));
            }
            if($reg->fec_cierre == NULL){
                $fec_cierre = "";
            }else{
                $fec_cierre = date("d/m/Y h:i a",strtotime($reg->fec_cierre));
            }
            if($reg->fec_reasi == NULL){
                $fec_reasi = "";
            }else{
                $fec_reasi = date("d/m/Y h:i a",strtotime($reg->fec_reasi));
            }
            if($reg->fec_recepcion == NULL){
                $fec_recepcion = "";
            }else{
                $fec_recepcion = date("d/m/Y h:i a",strtotime($reg->fec_recepcion));
            }
            $array = array(
                $reg->id_bitacora,
                date("d/m/Y",strtotime($reg->fec_bitacora)),
                $reg->txt_impacto,
                $reg->user_afectado,
                strtoupper($reg->nom_grupo),
                strtoupper($reg->nom_apli),
                utf8_encode(stripslashes($reg->txt_bitacora)),
                $reg->nom_responsable,
                $reg->num_caso,
                $reg->num_correo,
                $estado,
                $fec_apertura,
                $fec_solucion,
                $fec_cierre,
                $fec_reasi,
                $fec_recepcion,
                $dias
                );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_bitacora_json(){

        $sql = "SELECT b.fec_bitacora, g.nom_grupo, c.nom_apli, b.txt_bitacora, b.nom_responsable, b.num_caso, b.id_estado, b.fec_apertura, b.id_bitacora FROM pid_bitacora b inner join pid_aplicativo c on b.id_apli = c.id_apli inner join pid_grupo_asignado g on b.id_grupo = g.id_grupo WHERE b.id_estado in ('ASIGNADO','SOLUCIONADO','RE-ASIGNADO')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            if($reg->id_estado == "ASIGNADO"){
                $estado = '<li class="btn btn-warning" style="width: 121px;">ASIGNADO</li>';
                $ecuacion = (strtotime($reg->fec_bitacora)-  strtotime(date('Y-m-d H:i:s')))/86400;
                $dias = "Hace ".floor(abs($ecuacion))." dias";
            }elseif($reg->id_estado == "SOLUCIONADO"){
                $estado = '<li class="btn btn-success" style="width: 121px;">SOLUCIONADO</li>';
                $dias = "-";
            }elseif($reg->id_estado == "RE-ASIGNADO"){
                $estado = '<li class="btn btn-primary" style="width: 121px;">RE-ASIGNADO</li>';
                $ecuacion = (strtotime($reg->fec_bitacora)-  strtotime(date('Y-m-d H:i:s')))/86400;
                $dias = "Hace ".floor(abs($ecuacion))." dias";
            }
            $array = array(
                $reg->id_bitacora,
                $reg->num_caso,
                utf8_encode(stripslashes($reg->txt_bitacora)),
                strtoupper($reg->nom_apli),
                strtoupper($reg->nom_grupo),
                $reg->nom_responsable,
                $estado,
                date("d/m/Y",strtotime($reg->fec_bitacora)),
                $dias
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_json_categorias(){

        $sql = "SELECT * FROM pid_categoria ORDER BY nom_cat ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            $array = array(
                $reg->id_cat,
                "CAT".$i,
                $reg->nom_cat,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_categoria" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_categoria(".$reg->id_cat.")'".'  title="Editar Categoria"><i class="fa fa-edit" aria-hidden="true"></i> EDITAR</a> '
                .'<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_categoria(".$reg->id_cat.")'".'  title="Eliminar Categoria"><i class="fa fa-close" aria-hidden="true"></i> ELIMINAR</a> </div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_pid_json_aplicativos(){

        $sql = "SELECT a.*,c.nom_cat,g.nom_grupo FROM pid_aplicativo a LEFT JOIN pid_categoria c ON c.id_cat = a.id_cat LEFT JOIN pid_grupo_asignado g ON g.id_grupo = a.id_grupo ORDER BY a.nom_apli ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            if($reg->nom_cat == NULL || $reg->nom_cat == ""){
                $nom_cat = "-";
            }else{
                $nom_cat = $reg->nom_cat;
            }
            if($reg->nom_grupo == NULL || $reg->nom_grupo == ""){
                $nom_grupo = "-";
            }else{
                $nom_grupo = $reg->nom_grupo;
            }
            $i = $i + 1;
            $array = array(
                $reg->id_apli,
                "APLI".$i,
                $reg->nom_apli,
                $nom_cat,
                $nom_grupo,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_aplicativo" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_aplicativo(".$reg->id_apli.")'".'  title="Editar Aplicativo"><i class="fa fa-edit" aria-hidden="true"></i> EDITAR</a> '
                .'<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_aplicativo(".$reg->id_apli.")'".'  title="Eliminar Aplicativo"><i class="fa fa-close" aria-hidden="true"></i> ELIMINAR</a> </div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_json_grupo(){

        $sql = "SELECT * FROM pid_grupo_asignado ORDER BY nom_grupo ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            $array = array(
                $reg->id_grupo,
                "GRU".$i,
                $reg->nom_grupo,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_grupo" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_grupo(".$reg->id_grupo.")'".'  title="Editar Aplicativo"><i class="fa fa-edit" aria-hidden="true"></i> EDITAR</a> '
                .'<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_grupo(".$reg->id_grupo.")'".'  title="Eliminar Aplicativo"><i class="fa fa-close" aria-hidden="true"></i> ELIMINAR</a> </div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_pid_json_resolutor(){

        $sql = "SELECT * FROM pid_resolutor ORDER BY nom_res ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            $array = array(
                $reg->id_res,
                "RES".$i,
                $reg->nom_res,
                $reg->area_res,
                $reg->jefe_res,
                $reg->cargo_res,
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_edit_resolutor" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_resolutor(".$reg->id_res.")'".'  title="Editar Usuario Resolutor"><i class="fa fa-edit" aria-hidden="true"></i> EDITAR</a> </div>'
                //.'<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_resolutor(".$reg->id_res.")'".'  title="Eliminar Usuario Resolutor"><i class="fa fa-close" aria-hidden="true"></i> ELIMINAR</a> </div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_json_registro(){

        $sql = "SELECT r.*, u.nom_user FROM pid_registro r INNER JOIN pid_usuario u ON u.id_user = r.user_id ORDER BY id_registro ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            if($reg->tipo_registro == 1){
                $tipo = '<li class="label label-success">CREACIÓN</li>';
            }
            if($reg->tipo_registro == 2){
                $tipo = '<li class="label label-warning">ACTUALIZACION</li>';
            }
            if($reg->tipo_registro == 3){
                $tipo = '<li class="label label-info">ACTUALIZACION-ESTADO</li>';
            }
            if($reg->tipo_registro == 4){
                $tipo = '<li class="label label-danger">ELIMINACION</li>';
            }
            if($reg->tipo_registro == 5){
                $tipo = '<li class="label label-primary">RESETEO</li>';
            }

            if($reg->modelo_registro == 1){
                $modelo = '<li class="label label-default">CONOCIMIENTO</li>';
                $identificador = "APL".$reg->id_modelo;
                if($reg->tipo_registro == 3){
                    if($reg->contenido_registro == 0){
                        $visualizar = '<li class="label label-danger">NO-PUBLICADO</li>';
                    }else{
                        $visualizar = '<li class="label label-success">PUBLICADO</li>';
                    }
                }elseif($reg->tipo_registro == 5){
                    $identificador = "RESET DE CONTADORES";
                    $visualizar = '<li class="label label-primary">RESET DE CONTADORES</li>';
                }else{
                    $visualizar = '<a data-toggle="modal" data-target="#modal_ver_registro" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_registro(".$reg->id_registro.")'".' title="Ver Contenido Registro"><span class="fa fa-eye" aria-hidden="true"></span> Ver Registro</a> ';
                }
            }
            if($reg->modelo_registro == 2){
                $modelo = '<li class="label label-default">BITACORA</li>';
                if($reg->tipo_registro == 4){
                    $identificador = "N° ID: ".$reg->id_modelo." / N° Caso: ".$reg->estado_registro;
                }else{
                    $identificador = "N° Caso: ".$reg->id_modelo;
                }
                $visualizar = '<a data-toggle="modal" data-target="#modal_ver_registro" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_registro(".$reg->id_registro.")'".' title="Ver Contenido Registro"><span class="fa fa-eye" aria-hidden="true"></span> Ver Registro</a> ';
            }
            if($reg->modelo_registro == 3){
                $modelo = '<li class="label label-default">APLICATIVO</li>';
                if($reg->tipo_registro == 2){
                    $identificador = $reg->id_modelo;
                    $visualizar = '<li class="label label-warning">'.$reg->contenido_registro.'</li>';
                }elseif($reg->tipo_registro == 4){
                    $identificador = $reg->contenido_registro;
                    $visualizar = '<li class="label label-danger">ID ELIMINADO: '.$reg->id_modelo.'</li>';
                }else{
                    $identificador = $reg->id_modelo;
                    $visualizar = '<li class="label label-primary">APLICACION NUEVA</li>';
                }
            }
            if($reg->modelo_registro == 4){
                $modelo = '<li class="label label-default">GRUPO-ASIGNADO</li>';
                if($reg->tipo_registro == 2){
                    $identificador = $reg->id_modelo;
                    $visualizar = '<li class="label label-warning">'.$reg->contenido_registro.'</li>';
                }elseif($reg->tipo_registro == 4){
                    $identificador = $reg->contenido_registro;
                    $visualizar = '<li class="label label-danger">ID ELIMINADO: '.$reg->id_modelo.'</li>';
                }else{
                    $identificador = $reg->id_modelo;
                    $visualizar = '<li class="label label-primary">GRUPO ASIGNADO NUEVO</li>';
                }
            }
            if($reg->modelo_registro == 5){
                $modelo = '<li class="label label-default">USUARIO</li>';
                if($reg->tipo_registro == 2){
                    $identificador = $reg->id_modelo;
                    if($reg->contenido_registro == 0){
                        $permiso = "Analista";
                    }elseif($reg->contenido_registro == 1){
                        $permiso = "G.Conocimieno";
                    }elseif($reg->contenido_registro == 2){
                        $permiso = "G.Bitácoras";
                    }elseif($reg->contenido_registro == 4){
                        $permiso = "Administrador";
                    }elseif($reg->contenido_registro == 6){
                        $permiso = "C.Claro";
                    }elseif($reg->contenido_registro == 7){
                        $permiso = "Apo.C.Claro";
                    }elseif($reg->contenido_registro == 8){
                        $permiso = "Apoyo PID";
                    }elseif($reg->contenido_registro == 9){
                        $permiso = "Analista Escalado";
                    }elseif($reg->contenido_registro == 5){
                        $permiso = "Desarrollador";
                    }elseif($reg->contenido_registro == 3){
                        $permiso = "Supervisor";
                    }
                    $visualizar = '<li class="label label-warning">'.$permiso.'</li>';
                }elseif($reg->tipo_registro == 5){
                    if($reg->id_modelo == "desconexion"){
                        $identificador = "DESCONEXION USUARIOS";
                        $visualizar = '<li class="label label-primary">DESCONEXION TOTAL</li>';
                    }elseif($reg->id_modelo == "conexion"){
                        $identificador = "RESET DE CONEXIONES";
                        $visualizar = '<li class="label label-primary">RESET DE CONEXIONES</li>';
                    }
                }elseif($reg->tipo_registro == 4){
                    $identificador = $reg->contenido_registro;
                    $visualizar = '<li class="label label-danger">ID ELIMINADO: '.$reg->id_modelo.'</li>';
                }elseif($reg->tipo_registro == 3){
                    $identificador = $reg->contenido_registro;
                    $visualizar = '<li class="label label-info">USUARIO DESCONECTADO</li>';
                }else{
                    $identificador = $reg->id_modelo;
                    $visualizar = '<li class="label label-primary">USUARIO NUEVO</li>';
                }
            }
            $fecha_registro = date("d/m/Y h:i a",strtotime($reg->fecha_registro));
            $array = array(
                $reg->id_registro,
                "".$i,
                $tipo,
                $modelo,
                $identificador,
                $fecha_registro,
                utf8_encode($reg->nom_user),
                $visualizar
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_pid_json_bloqueo(){

        $sql = "SELECT b.id_bloqueo,b.claro_user,u.nom_user,b.fec_login,b.fec_bloqueo,b.fec_desbloqueo,b.ip_login FROM pid_bloqueo b INNER JOIN pid_usuario u ON b.id_user = u.id_user ORDER BY id_bloqueo ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;
            
            $fecha_login = date("d/m/Y h:i a",strtotime($reg->fec_login));
            $fecha_bloqueo = date("d/m/Y h:i a",strtotime($reg->fec_bloqueo));
            $fecha_desbloqueo = date("d/m/Y h:i a",strtotime($reg->fec_desbloqueo));
            
            if(strtotime($reg->fec_desbloqueo) > strtotime(date("Y-m-d H:i:s"))){
                $boton = '<a class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'desbloquear_usuario(".$reg->id_bloqueo.")'".'  title="Desbloquear"><i class="fa fa-dashcube" aria-hidden="true"></i></a>';
            }else{
                $boton = '-';
            }
            
            $array = array(
                $reg->id_bloqueo,
                "".$i,
                utf8_encode($reg->nom_user),
                $reg->claro_user,
                $fecha_login,
                $fecha_bloqueo,
                $fecha_desbloqueo,
                $reg->ip_login,
                $boton
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_responsable_gestor(){

        $sql = "SELECT * FROM nas_matriz_responsable";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            $array = array(
                'id_matriz' => $reg->id_matriz,
                'area_resp' => utf8_encode($reg->area_resp),
                'apl_pla' => utf8_encode($reg->apl_pla),
                'tipo_cargo' => utf8_encode($reg->tipo_cargo),
                'nom_responsable' => utf8_encode($reg->nom_responsable),
                'num_anexo' => $reg->num_anexo,
                'num_celular' => $reg->num_celular,
                'boton' => '<a data-toggle="modal" data-target="#modal_edit_responsable" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_responsable(".$reg->id_matriz.")'".'  title="Editar Fila"><i class="fa fa-edit" aria-hidden="true"></i></a> '
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_jobs_gestor(){

        $sql = "SELECT * FROM nas_matriz_jobs";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        while ($reg = $result->fetch_object()) {
            if($reg->nom_job == NULL){
                $nom_job = "-";
            }else{
                $nom_job = utf8_encode($reg->nom_job);
            }
            if($reg->apl_job == NULL){
                $apl_job = "-";
            }else{
                $apl_job = utf8_encode($reg->apl_job);
            }
            if($reg->group_job == NULL){
                $group_job = "-";
            }else{
                $group_job = utf8_encode($reg->group_job);
            }
            if($reg->cyclic_job == NULL){
                $cyclic_job = "-";
            }else{
                $cyclic_job = utf8_encode($reg->cyclic_job);
            }
            if($reg->nom_analista_job == NULL){
                $nom_analista_job = "-";
            }else{
                $nom_analista_job = utf8_encode($reg->nom_analista_job);
            }
            if($reg->desc_job == NULL){
                $desc_job = "-";
            }else{
                $desc_job = utf8_encode($reg->desc_job);
            }
            if($reg->obs_job == NULL){
                $obs_job = "-";
            }else{
                $obs_job = utf8_encode($reg->obs_job);
            }
            $array = array(
                'id_jobs' => $reg->id_jobs,
                'nom_job' => $nom_job,
                'apl_job' => $apl_job,
                'group_job' => $group_job,
                'cyclic_job' => $cyclic_job,
                'nom_analista_job' => $nom_analista_job,
                'desc_job' => $desc_job,
                'obs_job' => $obs_job,
                'boton' => '<a data-toggle="modal" data-target="#modal_edit_jobs" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'edit_jobs(".$reg->id_jobs.")'".'  title="Editar Fila"><i class="fa fa-edit" aria-hidden="true"></i> Editar Fila</a> '
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_comunicados_atc_gestor(){

        $sql = "SELECT c.*,u.nom_user FROM nas_comunicado c INNER JOIN pid_usuario u ON u.id_user = c.id_user WHERE c.tipo_aviso IN(1,2,3) AND IF(c.tipo_aviso = 3,IF(c.fec_aviso < NOW(),0,1),1) = 1 ORDER BY c.fec_registro DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;

            /*if($reg->com_estado == 0){
                $estado = '<li style="padding: 0px 0.5rem;" class="btn btn-success"><i class="fa fa-clock-o"></i> VIGENTE</li>';
            }else{
                $estado = '<li style="padding: 0px 0.5rem;" class="btn btn-danger"><i class="fa fa-ban"></i> NO-VIGENTE</li>';
            }*/

            /*$fec_registro = date('Y-m-d', strtotime($reg->fec_registro));
            $ecuacion = (strtotime($fec_registro) -  strtotime(date('Y-m-d H:i:s')))/86400;
            $dias = floor(abs($ecuacion));*/

            $fec_registro = date('Y-m-d', strtotime($reg->fec_registro));

            if($reg->tipo_aviso == 1){
                if(strtotime(date('Y-m-d H:i:s')) >= strtotime($reg->fec_aviso)){
                    $aviso = "culminado";
                }else{
                    $aviso = "falta";
                }
            }else if($reg->tipo_aviso == 2){
                if(strtotime(date('Y-m-d H:i:s')) >= strtotime($reg->fec_aviso)){
                    $aviso = "culminado";
                }else{
                    $aviso = "falta";
                }
            }else if($reg->tipo_aviso == 3){
                $aviso = "falta";
            }else{
                $aviso = "falta";
            }

            if($reg->fec_actualizacion == NULL){
                $actualizacion = "-";
            }else{
                $actualizacion = date("d/m/Y h:i a",strtotime($reg->fec_actualizacion));
            }

            $ruta_correo = "http://".$_SERVER['SERVER_NAME'].$reg->url_correo;

            $array = array(
                $reg->id_comunicado,
                "COM".$i,
                $reg->txt_comunicado,
                utf8_encode($reg->nom_user),
                date("d/m/Y h:i a",strtotime($reg->fec_registro)),
                $actualizacion,
                $reg->tipo_aviso,
                $aviso,
                '<a class="btn btn-primary" style="padding: 0px 0.5rem;" target="_blank" href="'.$ruta_correo.'"  title="Descargar Correo"><i class="fa fa-envelope" aria-hidden="true"></i> Correo</a>',
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_ver_comunicado" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'view_comunicado(".$reg->id_comunicado.")'".'  title="Ver Comunicado"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Ver</a> '
                .'<a data-toggle="modal" data-target="#modal_edit_comunicado" class="btn btn-info" style="padding: 0px 0.5rem;" onclick='."'editar_comunicado(".$reg->id_comunicado.")'".'  title="Editar Comunicado"><i class="fa fa-edit" aria-hidden="true"></i> Editar</a></div>',
                strip_tags($reg->com_contenido)
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_comunicados_atc(){

        $sql = "SELECT * FROM nas_comunicado WHERE tipo_aviso IN(1,2,3) AND com_estado IN(0) AND IF(tipo_aviso = 3,IF(fec_aviso < CURDATE(),0,1),1) = 1";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;

            $fec_registro = date('Y-m-d', strtotime($reg->fec_registro));

            if($reg->fec_actualizacion == NULL){
                $actualizacion = "-";
            }else{
                $actualizacion = date("d/m/Y h:i a",strtotime($reg->fec_actualizacion));
            }

            $array = array(
                $reg->id_comunicado,
                "COM".$i,
                $reg->txt_comunicado,
                date("d/m/Y h:i a",strtotime($reg->fec_registro)),
                $actualizacion,
                '<a class="btn btn-primary" style="padding: 0px 0.5rem;" target="_blank" href="'.$reg->url_correo.'"  title="Descargar Correo"><i class="fa fa-envelope" aria-hidden="true"></i> Correo</a>',
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_ver_comunicado" class="btn btn-warning" style="padding: 0px 0.5rem;" onclick='."'view_comunicado(".$reg->id_comunicado.")'".'  title="Ver Comunicado"><i class="fa fa-newspaper-o" aria-hidden="true"></i> Ver</a></div>',
                strip_tags($reg->com_contenido)
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_seguimiento_casos(){

        $sql = "SELECT * FROM nas_base_caso WHERE nom_grupo IN ('SOPORTE APLICACIONES N1','AREAS DE NEGOCIO','PORTABILIDAD','SS TECNOLOGICOS N1','SS TECNOLOGICOS N2','SS HP N1') AND tipo_estado IN('Asignado','Pendiente','En progreso') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;

            if($reg->tipo_estado == "Asignado"){
                $estado = '<li class="label label-warning">ASIGNADO</li>';
            }else if($reg->tipo_estado == "Pendiente"){
                $estado = '<li class="label label-primary">PENDIENTE</li>';
            }else if($reg->tipo_estado == "En progreso"){
                $estado = '<li class="label label-info">EN-PROGRESO</li>';
            }

            $array = array(
                $reg->id_base,
                $i."",
                $reg->num_caso,
                utf8_encode($reg->generado_por),
                utf8_encode($reg->nom_supervisor),
                utf8_encode($reg->nom_grupo),
                $estado,
                $reg->dias_pendientes
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_pid_seguimiento_casos_solu(){

        $sql = "SELECT * FROM nas_base_caso WHERE tipo_estado IN('Solucionado') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $i = $i + 1;

            if($reg->tipo_estado == "Solucionado"){
                $estado = '<li class="label label-success">Solucionado</li>';
            }

            $array = array(
                $reg->id_base,
                $i."",
                $reg->num_caso,
                utf8_encode($reg->generado_por),
                utf8_encode($reg->nom_supervisor),
                utf8_encode($reg->nom_grupo),
                $estado,
                $reg->dias_solucionados
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

    function list_pid_casos_gestor(){

        $sql = "SELECT id_tabla,mes_subida,ano_subida FROM nas_base_caso_asignado GROUP BY mes_subida ORDER BY ano_subida DESC , mes_subida DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        while ($reg = $result->fetch_object()) {
            $mes_subida = $reg->mes_subida;
            if($mes_subida == "Enero"){
                $id_mes = "1";
            }elseif($mes_subida == "Febrero"){
                $id_mes = "2";
            }elseif($mes_subida == "Marzo"){
                $id_mes = "3";
            }elseif($mes_subida == "Abril"){
                $id_mes = "4";
            }elseif($mes_subida == "Mayo"){
                $id_mes = "5";
            }elseif($mes_subida == "Junio"){
                $id_mes = "6";
            }elseif($mes_subida == "Julio"){
                $id_mes = "7";
            }elseif($mes_subida == "Agosto"){
                $id_mes = "8";
            }elseif($mes_subida == "Setiembre" || $mes_subida == "Septiembre"){
                $id_mes = "9";
            }elseif($mes_subida == "Octubre"){
                $id_mes = "10";
            }elseif($mes_subida == "Noviembre"){
                $id_mes = "11";
            }elseif($mes_subida == "Diciembre"){
                $id_mes = "12";
            }
            $i = $i + 1;
            $array = array(
                $reg->id_tabla,
                "SEG".$i,
                addslashes($reg->mes_subida),
                addslashes($reg->ano_subida),
                '<a data-toggle="modal" data-target="#modal_ver_grafico_casos" class="btn btn-primary" style="padding: 0px 0.5rem;" onclick='."'view_grafico_casos(".$id_mes.",".$reg->ano_subida.")'".'  title="Ver Grafico"><i class="fa fa-bar-chart" aria-hidden="true"></i> Visualizar Grafico</a> '
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }
    
    function list_pid_noticias_portal(){

        $sql = "SELECT * FROM pid_portal_noticia ORDER BY fecha_noticia DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        $res = '';
        $super_array = [];
        $i = 0;
        
        while ($reg = $result->fetch_object()) { 
            $i = $i+1;
        
            if($reg->tipo_noticia = '0'){
                $tipo = "Nuevo";
            }
            
            $array = array(
                $reg->id_noticia,
                "".$i,
                utf8_encode($reg->txt_noticia),
                date("d/m/Y",strtotime($reg->fecha_noticia)),
                "",
                '<div class="btn-group" role="group"><a data-toggle="modal" data-target="#modal_ver_noticia_portal" class="btn btn-primary" style="padding: 0px 0.7rem;" onclick='."'view_noticia_portal(".$reg->id_noticia.")'".'  title="Ver Noticia"><span class="fa fa-eye" aria-hidden="true"></span></a>'
                .'<a data-toggle="modal" data-target="#modal_edit_portal_noticia" class="btn btn-warning" style="padding: 0px 0.7rem;" onclick='."'editar_noticia_portal(".$reg->id_noticia.")'".'  title="Editar Noticia"><i class="fa fa-edit" aria-hidden="true"></i></a>'
                .'<a class="btn btn-danger" style="padding: 0px 0.7rem;" onclick='."'eliminar_noticia_portal(".$reg->id_noticia.")'".'  title="Eliminar Noticia"><i class="fa fa-close" aria-hidden="true"></i></a> </div>'
            );
            array_push($super_array, $array);
        }            
        $ar = array('data' => $super_array);
        return ($result) ? json_encode($ar) : false ;
    }

}

Class insert_pid {

    function insertar_conocimiento($id_atu,$titulo,$contenido,$aplicativo,$estado_conocimiento,$tipo_flujo,$grupo_conocimiento,$usuario_resolutor,$fecha_creacion,$fecha_actualizacion,$publicado,$ver_cliente,$tipo_conocimiento, $publico){

        $sql = "INSERT INTO pid_conocimiento (`id_atu`, `titulo`, `contenido`, `id_apli`, `id_tipo`, `id_flujo`, `id_grupo`, `id_resolutor`, `fecha_creacion`, `fecha_actualizacion`, `aprobado`, `ver_cliente`, `tipo_conocimiento`, `publico`) VALUES ('$id_atu', '$titulo','$contenido','$aplicativo','$estado_conocimiento','$tipo_flujo','$grupo_conocimiento','$usuario_resolutor','$fecha_creacion','$fecha_actualizacion','$publicado','$ver_cliente','$tipo_conocimiento', '$publico')";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_borrador($titulo,$ip_autor,$id_autor,$fecha_creacion,$contenido){

        $sql = "INSERT INTO pid_borrador (`titulo`, `ip_autor`, `id_user`, `fecha_creacion`, `contenido`, `estado`) VALUES ('$titulo','$ip_autor','$id_autor','$fecha_creacion','$contenido','0')";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_usuario($nom_usuario,$claro_usuario,$pass_usuario,$rol_user,$funcion_user,$sl_servicio){

        $sql = "INSERT INTO pid_usuario (`nom_user`, `claro_user`, `pass_user`, `funcion_user`, `rol_user`, `tipo_user`) VALUES ('$nom_usuario','$claro_usuario','$pass_usuario','$funcion_user','$rol_user','$sl_servicio')";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_aplicativo($txt_apli, $sl_flujo, $sl_grupo){

        $sql = "INSERT INTO pid_aplicativo (`nom_apli`, `id_cat`, `id_grupo`) VALUES (UPPER('$txt_apli'), '$sl_flujo', '$sl_grupo')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insertar_categoria($txt_cat){

        $sql = "INSERT INTO pid_categoria (`nom_cat`) VALUES ('$txt_cat')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insertar_noticia($txt_noticia,$contenido_noticia,$imagen_noticia,$tipo_noticia,$fecha_noticia,$fuente_noticia){

        $sql = "INSERT INTO pid_portal_noticia (`txt_noticia`,`contenido_noticia`,`imagen_noticia`,`tipo_noticia`,`fecha_noticia`,`fuente_noticia`) VALUES ('$txt_noticia','$contenido_noticia','$imagen_noticia','$tipo_noticia','$fecha_noticia','$fuente_noticia')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_grupo($txt_grupo){

        $sql = "INSERT INTO pid_grupo_asignado (`nom_grupo`) VALUES ('$txt_grupo')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insertar_resolutor($txt_res,$area_res,$jefe_res,$cargo_res){

        $sql = "INSERT INTO pid_resolutor (`nom_res`,`area_res`,`jefe_res`,`cargo_res`) VALUES ('$txt_res','$area_res','$jefe_res','$cargo_res')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_bitacora($fec_bitacora,$sl_impacto,$num_afectados,$num_correos,$sl_asignado,$sl_afectado,$txt_bitacora,$txt_responsable,$num_caso,$sl_estado,$fec_apertura,$fec_recepcion,$contenido){

        $sql = "INSERT INTO pid_bitacora (`fec_bitacora`,`txt_impacto`,`user_afectado`,`num_correo`,`id_grupo`,`id_apli`,`txt_bitacora`,`nom_responsable`,`num_caso`,`id_estado`,`fec_apertura`,`fec_recepcion`,`contenido`) VALUES ('$fec_bitacora','$sl_impacto','$num_afectados','$num_correos','$sl_asignado','$sl_afectado','$txt_bitacora','$txt_responsable','$num_caso','$sl_estado','$fec_apertura','$fec_recepcion','$contenido')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_registro($modelo_registro,$tipo_registro,$id_modelo,$contenido_registro,$estado_registro,$fecha_registro,$bitacora_contenido,$id_user){

        $sql = "INSERT INTO pid_registro (`modelo_registro`,`tipo_registro`,`id_modelo`,`contenido_registro`,`estado_registro`,`fecha_registro`,`bitacora_contenido`,`user_id`) VALUES ('$modelo_registro','$tipo_registro','$id_modelo','$contenido_registro','$estado_registro','$fecha_registro','$bitacora_contenido','$id_user')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_permisos_user($id_last_user){

        $sql = "INSERT INTO pid_permiso (`id_user`) VALUES ('$id_last_user')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_matriz_responsable($area_resp,$apl_pla,$tipo_cargo,$nom_responsable,$num_anexo,$num_celular){

        $sql = "INSERT INTO nas_matriz_responsable (`area_resp`,`apl_pla`,`tipo_cargo`,`nom_responsable`,`num_anexo`,`num_celular`) VALUES ('$area_resp','$apl_pla','$tipo_cargo','$nom_responsable','$num_anexo','$num_celular')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_base_casos($num_caso,$txt_usuario,$txt_aplicativo,$nom_responsable,$nom_grupo,$fec_apertura,$tipo_estado,$generado_por,$fec_solucion,$fec_solucion_2,$nom_supervisor,$asig_atu,$est_solu,$tipo_rol,$dia_seg,$fec,$asig_caso_seg,$solu_caso_seg,$cant_casos,$fec_actual,$dias_pendientes,$dias_solucionados,$mes_actual,$ano_actual,$claro_user){

        $sql = "INSERT INTO nas_base_caso (`num_caso`,`txt_usuario`,`txt_aplicativo`,`nom_responsable`,`nom_grupo`,`fec_apertura`,`tipo_estado`,`generado_por`,`fec_solucion`,`fec_solucion_2`,`nom_supervisor`,`asig_atu`,`est_solu`,`tipo_rol`,`dia`,`fec`,`asig_caso_seg`,`solu_caso_seg`,`cant_casos`,`fec_actual`,`dias_pendientes`,`dias_solucionados`,`mes_subida`,`ano_subida`,`claro_user`) VALUES ('$num_caso','$txt_usuario','$txt_aplicativo','$nom_responsable','$nom_grupo','$fec_apertura','$tipo_estado','$generado_por','$fec_solucion','$fec_solucion_2','$nom_supervisor','$asig_atu','$est_solu','$tipo_rol','$dia_seg','$fec','$asig_caso_seg','$solu_caso_seg','$cant_casos','$fec_actual','$dias_pendientes','$dias_solucionados','$mes_actual','$ano_actual','$claro_user')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function base_tabla_casos(){

        $sql = 'SELECT 
                (
                    SELECT MAX(id_base) FROM nas_base_caso
                ) AS ultimo_id,
                (
                    SELECT fec_actual FROM nas_base_caso WHERE id_base = ultimo_id
                ) AS asignados,
                (
                    SELECT COUNT(*) FROM nas_base_caso WHERE tipo_estado IN ("Asignado","Pendiente","En progreso") AND fec_actual = asignados AND nom_grupo IN ("SOPORTE APLICACIONES N1","SS TECNOLOGICOS N1") AND tipo_rol IN("APLIC","CESADO")
                ) AS cantidad,
                (
                    SELECT MAX(CONVERT(SUBSTRING_INDEX(dias_pendientes,"-",-1),UNSIGNED INTEGER)) FROM nas_base_caso WHERE tipo_estado IN ("Asignado","Pendiente","En progreso") AND fec_actual = asignados AND nom_grupo IN ("SOPORTE APLICACIONES N1","SS TECNOLOGICOS N1") AND tipo_rol IN("APLIC","CESADO")
                ) AS caso_mas_antiguo,
                (
                    SELECT ROUND(AVG(dias_pendientes)) FROM nas_base_caso WHERE tipo_estado IN ("Asignado","Pendiente","En progreso") AND fec_actual = asignados AND nom_grupo IN ("SOPORTE APLICACIONES N1","SS TECNOLOGICOS N1") AND tipo_rol IN("APLIC","CESADO")
                ) AS prom_antiguedad,
                (
                    SELECT mes_subida FROM nas_base_caso WHERE id_base = ultimo_id
                ) AS mes_subida,
                (
                    SELECT ano_subida FROM nas_base_caso WHERE id_base = ultimo_id
                ) AS ano_subida';
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function base_tabla_casos_solucionados(){

        $sql = 'SELECT
                (
                    SELECT MAX(id_base) FROM nas_base_caso   
                ) AS ultimo_id,
                (
                    SELECT fec_actual FROM nas_base_caso WHERE id_base = ultimo_id
                ) AS asignados,
                (
                    SELECT COUNT(*) FROM nas_base_caso WHERE tipo_estado IN ("Solucionado") AND fec_actual = asignados AND solu_caso_seg IN ("SI","NO") AND tipo_rol IN ("APLIC","CESADO","HW & SW")
                ) AS cantidad,
                (
                    SELECT MAX(dias_solucionados) FROM nas_base_caso WHERE tipo_estado IN ("Solucionado") AND fec_actual = asignados
                ) AS caso_mas_antiguo,
                (
                    SELECT ROUND(AVG(dias_solucionados)) FROM nas_base_caso WHERE tipo_estado IN ("Solucionado") AND fec_actual = asignados AND IF(dias_solucionados < cantidad,1,0)
                ) AS prom_antiguedad,
                (
                    SELECT mes_subida FROM nas_base_caso WHERE id_base = ultimo_id
                ) AS mes_subida,
                (
                    SELECT ano_subida FROM nas_base_caso WHERE id_base = ultimo_id
                ) AS ano_subida';
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function validar_base_casos(){
        $sql = "SELECT * FROM nas_base_caso";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function validar_consulta_asignado($fec_asignados){
        $sql = "SELECT * FROM nas_base_caso_asignado WHERE fec_asignados = '$fec_asignados'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function validar_consulta_solucionado($fec_asignados_s){
        $sql = "SELECT * FROM nas_base_caso_solucionado WHERE fec_asignados = '$fec_asignados_s'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_tabla_base($fec_asignados,$num_cantidad,$prom_antiguedad,$caso_mas_antiguo,$mes_subida,$ano_subida){

        $sql = "INSERT INTO nas_base_caso_asignado (`fec_asignados`,`num_cantidad`,`prom_antiguedad`,`caso_mas_antiguo`,`mes_subida`,`ano_subida`) VALUES ('$fec_asignados','$num_cantidad','$prom_antiguedad','$caso_mas_antiguo','$mes_subida','$ano_subida')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_tabla_base_solucionados($fec_asignados_s,$num_cantidad_s,$prom_antiguedad_s,$caso_mas_antiguo_s,$mes_subida_s,$ano_subida_s){

        $sql = "INSERT INTO nas_base_caso_solucionado (`fec_asignados`,`num_cantidad`,`prom_antiguedad`,`caso_mas_antiguo`,`mes_subida`,`ano_subida`) VALUES ('$fec_asignados_s','$num_cantidad_s','$prom_antiguedad_s','$caso_mas_antiguo_s','$mes_subida_s','$ano_subida_s')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_matriz_jobs($nom_job,$apl_job,$group_job,$cyclic_job,$nom_analista_job,$desc_job,$obs_job){

        $sql = "INSERT INTO nas_matriz_jobs (`nom_job`,`apl_job`,`group_job`,`cyclic_job`,`nom_analista_job`,`desc_job`,`obs_job`) VALUES ('$nom_job','$apl_job','$group_job','$cyclic_job','$nom_analista_job','$desc_job','$obs_job')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function insertar_comunicado($titulo_comunicado,$fecha_creacion,$fecha_aviso,$url_correo,$sl_estado,$sl_estado_urg,$contenido_comunicado,$user_id_comunicado){

        $sql = "INSERT INTO nas_comunicado (`txt_comunicado`, `fec_registro`, `fec_aviso`, `tipo_aviso`, `url_correo`, `com_estado`, `com_contenido`, `id_user`) VALUES ('$titulo_comunicado','$fecha_creacion','$fecha_aviso','$sl_estado_urg','$url_correo','$sl_estado','$contenido_comunicado','$user_id_comunicado')";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function insertar_bloqueo_user($id_user,$claro_user,$fec_login,$ip_login,$fec_bloqueo,$ip_bloqueo,$fec_desbloqueo){

        $sql = "INSERT INTO pid_bloqueo (`claro_user`,`id_user`,`fec_login`,`ip_login`,`fec_bloqueo`,`ip_bloqueo`,`fec_desbloqueo`) VALUES ('$claro_user','$id_user','$fec_login','$ip_login','$fec_bloqueo','$ip_bloqueo','$fec_desbloqueo')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}

Class update_pid {

    function update_conocimiento($id_atu,$titulo,$contenido,$aplicativo,$estado_conocimiento,$tipo_flujo,$grupo_conocimiento,$usuario_resolutor,$fecha_actualizacion,$id,$publicado,$ver_cliente, $tipo_conocimiento, $publico){

        $sql = "UPDATE pid_conocimiento SET id_atu='".$id_atu."',titulo='".$titulo."',contenido='".$contenido."',id_apli='".$aplicativo."',id_tipo='".$estado_conocimiento."',id_flujo='".$tipo_flujo."',id_grupo='".$grupo_conocimiento."',id_resolutor='".$usuario_resolutor."',fecha_actualizacion='".$fecha_actualizacion."',aprobado='".$publicado."',ver_cliente='".$ver_cliente."',tipo_conocimiento='".$tipo_conocimiento."',publico='".$publico."' WHERE id_tabla='".$id."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_bitacora($id,$fec_bitacora,$sl_impacto,$num_afectados,$num_correos,$sl_asignado,$sl_afectado,$txt_bitacora,$txt_responsable,$num_caso,$sl_estado,$fec_apertura,$fec_reasi,$fec_solucionado,$fec_cerrado,$fec_recepcion,$contenido){

        $sql = "UPDATE pid_bitacora SET fec_bitacora='".$fec_bitacora."',txt_impacto='".$sl_impacto."',user_afectado='".$num_afectados."',num_correo='".$num_correos."',id_grupo='".$sl_asignado."',id_apli='".$sl_afectado."',txt_bitacora='".$txt_bitacora."',nom_responsable='".$txt_responsable."',num_caso='".$num_caso."',id_estado='".$sl_estado."',fec_apertura='".$fec_apertura."',fec_reasi='".$fec_reasi."',fec_solucion='".$fec_solucionado."',fec_cierre='".$fec_cerrado."',fec_recepcion='".$fec_recepcion."',contenido='".$contenido."' WHERE id_bitacora='".$id."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_fecha_bitacora($id_bitacora,$fec_apertura,$fec_reasi,$fec_solucionado,$fec_cerrado){

        $sql = "UPDATE pid_bitacora SET fec_apertura='".$fec_apertura."',fec_reasi='".$fec_reasi."',fec_solucion='".$fec_solucionado."',fec_cierre='".$fec_cerrado."' WHERE id_bitacora='".$id_bitacora."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_contador($id){

        $sql = "UPDATE pid_conocimiento SET contador=contador+1 WHERE id_tabla='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_tiempo_kdb($id_user,$tiempo){

        $sql = "UPDATE pid_usuario SET tiempo_kdb=tiempo_kdb+".$tiempo." WHERE id_user='".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_contadores_reset(){

        $sql = "UPDATE pid_conocimiento SET contador='0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estado_conocimiento($id,$estado){

        $sql = "UPDATE pid_conocimiento SET aprobado='".$estado."' WHERE id_tabla='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_comentarios_nuevos($id_tabla){

        $sql = "UPDATE pid_conocimiento SET comentario_nuevo='1' WHERE id_tabla='".$id_tabla."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_quitar_comentarios_nuevos($id){

        $sql = "UPDATE pid_conocimiento SET comentario_nuevo='0' WHERE id_tabla='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_borrador($txt_borrador,$id_tabla,$contenido){

        $sql = "UPDATE pid_borrador SET titulo='".$txt_borrador."',contenido='".$contenido."' WHERE id_tabla='".$id_tabla."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estado_borrador($id_tabla){

        $sql = "UPDATE pid_borrador SET estado='1' WHERE id_tabla='".$id_tabla."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_usuario($id,$nom_usuario,$claro_usuario,$rol_user,$funcion_user,$sl_servicio){

        $sql = "UPDATE pid_usuario SET nom_user='".$nom_usuario."', claro_user='".$claro_usuario."', rol_user='".$rol_user."', funcion_user='".$funcion_user."', tipo_user='".$sl_servicio."' WHERE id_user='".$id."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_inicio_sesion($inicio_sesion,$id_user,$ip_user){

        $sql = "UPDATE pid_usuario SET inicio_sesion='".$inicio_sesion."', ip_user='".$ip_user."', cierre_sesion=NULL WHERE id_user='".$id_user."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_ingreso($id_user){

        $sql = "UPDATE pid_usuario SET estado_pid='1' WHERE id_user='".$id_user."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_ingresos_sesion($id_user){

        $sql = "UPDATE pid_usuario SET kdb_ingresos=kdb_ingresos+1, estado_pid='1' WHERE id_user='".$id_user."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_cierre_sesion($cierre_sesion,$id_user){

        $sql = "UPDATE pid_usuario SET cierre_sesion='".$cierre_sesion."', inicio_sesion=NULL, ip_user=NULL, estado_pid='0' WHERE id_user='".$id_user."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_password($user_id,$password){

        $sql = "UPDATE pid_usuario SET pass_user='".$password."' WHERE id_user='".$user_id."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_conexiones_reset(){

        $sql = "UPDATE pid_usuario SET kdb_ingresos='0' WHERE funcion_user in(0,1,2,4,6,7,8,9)";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_tiempo_conexion_reset(){

        $sql = "UPDATE pid_usuario SET tiempo_kdb='0' WHERE funcion_user in(0,1,2,4,6,7,8,9)";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estadistica_pregunta($id_pregunta){

        $sql = "UPDATE pid_exam_pregunta SET correctas='0', incorrectas='0', sin_respuesta='0' WHERE id_pregunta = '".$id_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estadistica_pregunta_examen($id_examen){

        $sql = "UPDATE pid_exam_pregunta SET correctas='0', incorrectas='0', sin_respuesta='0' WHERE id_examen RLIKE '[[:<:]]".$id_examen."[[:>:]]'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estadisticas_preguntas(){

        $sql = "UPDATE pid_exam_pregunta SET correctas='0', incorrectas='0', sin_respuesta='0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_aplicativo($txt_apli, $id_apli, $sl_flujo, $sl_grupo){

        $sql = "UPDATE pid_aplicativo SET nom_apli=UPPER('".$txt_apli."'), id_cat='".$sl_flujo."', id_grupo='".$sl_grupo."' WHERE id_apli = '".$id_apli."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_categoria($txt_cat, $id_cat){

        $sql = "UPDATE pid_categoria SET nom_cat='".$txt_cat."' WHERE id_cat = '".$id_cat."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_grupo($txt_grupo, $id_grupo){

        $sql = "UPDATE pid_grupo_asignado SET nom_grupo='".$txt_grupo."' WHERE id_grupo = '".$id_grupo."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estado_pid(){

        $sql = "UPDATE pid_usuario SET estado_pid='0' WHERE funcion_user in(0,1,2,4,6,7,8,9)";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estado_usuario($user_id){

        $sql = "UPDATE pid_usuario SET estado_pid='0', inicio_sesion=NULL WHERE id_user = '".$user_id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_desbloqueo_usuario($fecha_desbloqueo, $id_bloqueo){

        $sql = "UPDATE pid_bloqueo SET fec_desbloqueo='".$fecha_desbloqueo."' WHERE id_bloqueo = '".$id_bloqueo."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_permisos_user($gest_cono,$crea_cono,$edit_cono,$apro_cono,$rein_con_cono,$gest_comment,$apro_comment,$gest_est_comment,$rein_comment,$gest_borra,$edit_borra,$dele_borra,$gest_bita,$crea_bita,$edit_bita,$dele_bita,$gest_cat,$crea_cat,$edit_cat,$dele_cat,$crea_apli,$edit_apli,$dele_apli,$crea_grupo,$edit_grupo,$dele_grupo,$gest_usua,$crea_usua,$edit_usua,$edit_perfil_usua,$rein_cone_usua,$descs_usua,$desc_usua,$rein_tiem_usua,$rein_password,$rein_comment_cali,$rein_comment_cali_all,$dele_usua,$gest_exam,$crea_exam,$edit_exam,$chg_exam,$graf_exam,$crea_pre_exam,$edit_pre_exam,$dele_pre_exam,$graf_pregunta,$rein_est_pregunta,$rein_all_est_pregunta,$asig_exam,$edit_asig_exam,$dele_asig_exam,$graf_exam_usua,$gest_enc,$crea_enc,$edit_enc,$esta_enc,$crea_pre_enc,$edit_pre_enc,$esta_pre_enc,$crea_opc_enc,$edit_opc_enc,$dele_opc_enc,$gest_log_reg,$gest_nas,$add_ma_resp,$edit_ma_resp,$gest_seg_casos,$add_seg_casos,$add_ma_jobs,$edit_ma_jobs,$edit_dir_spee,$edit_dir_tur,$edit_dir_cac,$add_com_atc,$edit_com_atc,$gest_port,$crea_port_not,$edit_port_not,$dele_port_not,$mod_ges,$mod_kdb,$mod_bit,$mod_bor,$mod_cat,$mod_usu,$mod_exa,$mod_nas,$mod_port,$user_id){

        $sql = "UPDATE pid_permiso SET gest_cono='".$gest_cono."', crea_cono='".$crea_cono."', edit_cono='".$edit_cono."', apro_cono='".$apro_cono."', rein_con_cono='".$rein_con_cono."', gest_comment='".$gest_comment."', apro_comment='".$apro_comment."', gest_est_comment='".$gest_est_comment."', rein_comment='".$rein_comment."', gest_borra='".$gest_borra."', edit_borra='".$edit_borra."', dele_borra='".$dele_borra."', gest_bita='".$gest_bita."', crea_bita='".$crea_bita."', edit_bita='".$edit_bita."', dele_bita='".$dele_bita."', gest_cat='".$gest_cat."', crea_cat='".$crea_cat."',  edit_cat='".$edit_cat."', dele_cat='".$dele_cat."', crea_apli='".$crea_apli."',  edit_apli='".$edit_apli."', dele_apli='".$dele_apli."', crea_grupo='".$crea_grupo."', edit_grupo='".$edit_grupo."', dele_grupo='".$dele_grupo."', gest_usua='".$gest_usua."', crea_usua='".$crea_usua."', edit_usua='".$edit_usua."', edit_perfil_usua='".$edit_perfil_usua."', rein_cone_usua='".$rein_cone_usua."', descs_usua='".$descs_usua."', desc_usua='".$desc_usua."', rein_tiem_usua='".$rein_tiem_usua."', rein_password='".$rein_password."', rein_comment_cali='".$rein_comment_cali."', rein_comment_cali_all='".$rein_comment_cali_all."', dele_usua='".$dele_usua."', gest_exam='".$gest_exam."', crea_exam='".$crea_exam."', edit_exam='".$edit_exam."', chg_exam='".$chg_exam."' ,graf_exam='".$graf_exam."', crea_pre_exam='".$crea_pre_exam."', edit_pre_exam='".$edit_pre_exam."', dele_pre_exam='".$dele_pre_exam."', graf_pregunta='".$graf_pregunta."', rein_est_pregunta='".$rein_est_pregunta."', rein_all_est_pregunta='".$rein_all_est_pregunta."', asig_exam='".$asig_exam."', edit_asig_exam='".$edit_asig_exam."', dele_asig_exam='".$dele_asig_exam."', graf_exam_usua='".$graf_exam_usua."', gest_enc = '".$gest_enc."', crea_enc = '".$crea_enc."', edit_enc = '".$edit_enc."', esta_enc = '".$esta_enc."', crea_pre_enc = '".$crea_pre_enc."', edit_pre_enc = '".$edit_pre_enc."', esta_pre_enc = '".$esta_pre_enc."', crea_opc_enc = '".$crea_opc_enc."', edit_opc_enc = '".$edit_opc_enc."', dele_opc_enc = '".$dele_opc_enc."', gest_log_reg='".$gest_log_reg."', gest_nas='".$gest_nas."', add_ma_resp='".$add_ma_resp."', edit_ma_resp='".$edit_ma_resp."', gest_seg_casos='".$gest_seg_casos."', add_seg_casos='".$add_seg_casos."', add_ma_jobs='".$add_ma_jobs."', edit_ma_jobs='".$edit_ma_jobs."', edit_dir_spee='".$edit_dir_spee."', edit_dir_tur='".$edit_dir_tur."', edit_dir_cac='".$edit_dir_cac."', add_com_atc='".$add_com_atc."', edit_com_atc='".$edit_com_atc."', gest_port='".$gest_port."', crea_port_not='".$crea_port_not."', edit_port_not='".$edit_port_not."', dele_port_not='".$dele_port_not."' ,mod_ges='".$mod_ges."', mod_kdb='".$mod_kdb."', mod_bit='".$mod_bit."', mod_bor='".$mod_bor."', mod_cat='".$mod_cat."', mod_usu='".$mod_usu."', mod_exa='".$mod_exa."', mod_nas='".$mod_nas."', mod_port='".$mod_port."' WHERE id_user = '".$user_id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_matriz_responsable($area_resp,$apl_pla,$tipo_cargo,$nom_responsable,$num_anexo,$num_celular,$id_matriz){

        $sql = "UPDATE nas_matriz_responsable SET area_resp='".$area_resp."',apl_pla='".$apl_pla."',tipo_cargo='".$tipo_cargo."',nom_responsable='".$nom_responsable."',num_anexo='".$num_anexo."',num_celular='".$num_celular."' WHERE id_matriz = '".$id_matriz."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_matriz_jobs($nom_job,$id_jobs,$apl_job,$group_job,$cyclic_job,$nom_analista_job,$obs_job,$desc_job){

        $sql = "UPDATE nas_matriz_jobs SET nom_job='".$nom_job."',apl_job='".$apl_job."',group_job='".$group_job."',cyclic_job='".$cyclic_job."',nom_analista_job='".$nom_analista_job."',obs_job='".$obs_job."',desc_job='".$desc_job."' WHERE id_jobs = '".$id_jobs."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_comunicado($titulo_comunicado,$fecha_actualizacion,$fecha_aviso,$url_correo,$sl_estado,$sl_estado_urg,$contenido_comunicado,$user_id_comunicado,$id_comunicado){

        $sql = "UPDATE nas_comunicado SET txt_comunicado='".$titulo_comunicado."',fec_actualizacion='".$fecha_actualizacion."',fec_aviso='".$fecha_aviso."',url_correo='".$url_correo."',com_estado='".$sl_estado."',tipo_aviso='"."$sl_estado_urg"."',com_contenido='".$contenido_comunicado."',id_user='".$user_id_comunicado."' WHERE id_comunicado = '".$id_comunicado."'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_ruta_speech($filename){

        $sql = "UPDATE nas_ruta SET src_ruta='".$filename."' WHERE nom_ruta = 'Ruta_Speech_Servicio'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_ruta_turnos($filename){

        $sql = "UPDATE nas_ruta SET src_ruta='".$filename."' WHERE nom_ruta = 'Ruta_Turnos_Analistas_Claro'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_ruta_horarios($filename){

        $sql = "UPDATE nas_ruta SET src_ruta='".$filename."' WHERE nom_ruta = 'Ruta_Horarios_Responsables_Cacs'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_comentarios_calificados($id_user_comentario,$oper_calificado){

        $sql = "UPDATE pid_usuario SET comentarios_calificados=comentarios_calificados".$oper_calificado." WHERE id_user='".$id_user_comentario."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_leer_comentarios($id){

        $sql = "UPDATE pid_conocimiento SET comentario_nuevo='0' WHERE id_tabla='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_perfil_user($id_user,$txt_nombre,$num_dni,$num_celular,$num_fijo,$num_referencia,$sl_parentesco,$sl_genero,$sl_familiar,$num_hijos,$cod_empleado,$sl_est_academico,$sl_academica,$fec_nac,$txt_email,$fec_ingreso,$dni_editado,$rut_avatar){

        $sql = "UPDATE pid_usuario SET nom_user_perfil='".$txt_nombre."',dni_user='".$num_dni."',telefono_user='".$num_celular."',telefono_fijo_user='".$num_fijo."',telefono_referencia_user='".$num_referencia."',ref_parentesco='".$sl_parentesco."',cod_empleado='".$cod_empleado."',genero_user='".$sl_genero."',situacion_familiar='".$sl_familiar."',num_hijos='".$num_hijos."',situacion_academica='".$sl_academica."',estado_academico='".$sl_est_academico."',fecha_nacimiento='".$fec_nac."',correo_personal='".$txt_email."',fec_ingreso='".$fec_ingreso."', dni_editado='".$dni_editado."', img_user='".$rut_avatar."' WHERE id_user='".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_resolutor($txt_res,$area_res,$jefe_res,$cargo_res,$id_res){

        $sql = "UPDATE pid_resolutor SET nom_res='".$txt_res."', area_res='".$area_res."', jefe_res='".$jefe_res."', cargo_res='".$cargo_res."' WHERE id_res = '".$id_res."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function update_noticia_portal($txt_noticia,$contenido_noticia,$imagen_noticia,$tipo_noticia,$fecha_noticia,$fuente_noticia,$id_noticia){

        $sql = "UPDATE pid_portal_noticia SET txt_noticia='$txt_noticia', contenido_noticia='$contenido_noticia', imagen_noticia='$imagen_noticia', tipo_noticia='$tipo_noticia', fecha_noticia='$fecha_noticia', fuente_noticia='$fuente_noticia' WHERE id_noticia = '$id_noticia'";  
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}

Class delete_pid{

    function delete_conocimiento($id){

        $sql = "DELETE FROM pid_conocimiento WHERE id_tabla='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function delete_bitacora($id){

        $sql = "DELETE FROM pid_bitacora WHERE id_bitacora='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function delete_borrador($id,$txt_motivo){

        $sql = "UPDATE pid_borrador SET estado='2', comentario_eliminado='".$txt_motivo."' WHERE id_tabla='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function delete_usuario($id){
        
        $sql = "UPDATE pid_usuario SET estado_user='1' WHERE id_user='".$id."'";
        //$sql = "UPDATE pid_usuario SET usuario_eliminado='1' WHERE id_user='".$id."'";
        //$sql = "DELETE FROM pid_usuario WHERE id_user='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function delete_aplicativo($id){

        $sql = "DELETE FROM pid_aplicativo WHERE id_apli='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function delete_categoria($id){

        $sql = "DELETE FROM pid_categoria WHERE id_cat='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function delete_grupo($id){

        $sql = "DELETE FROM pid_grupo_asignado WHERE id_grupo='".$id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function delete_portal_noticia($id_noticia){

        $sql = "DELETE FROM pid_portal_noticia WHERE id_noticia='".$id_noticia."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}

Class vaciar_tabla{
    function vaciar_matriz_responsables(){

        $sql = "TRUNCATE TABLE nas_matriz_responsable";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function vaciar_matriz_jobs(){

        $sql = "TRUNCATE TABLE nas_matriz_jobs";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function vaciar_base_casos(){

        $sql = "TRUNCATE TABLE nas_base_caso";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}

Class last_id{
    function last_id_user(){

        $sql = "SELECT MAX(id_user) as id_last_user FROM pid_usuario";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}

Class utf8_fix{
    function fix_utf8(){

        $sql = "SET NAMES 'utf8'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}

Class seguimiento_casos{
    function grafico_asigpen_solu($mes,$ano){

        $sql = "SELECT t.num_cantidad AS Cantidad_AsigPen, t.prom_antiguedad AS Promedio_AsigPen, t.caso_mas_antiguo AS Caso_AsigPen, t.fec_asignados AS Fecha_AsigPen, s.num_cantidad AS Cantidad_Solu, s.prom_antiguedad AS Promedio_Solu, s.caso_mas_antiguo AS Caso_Solu, s.fec_asignados AS Fecha_Solu FROM nas_base_caso_asignado t INNER JOIN nas_base_caso_solucionado s ON t.id_tabla = s.id_tabla WHERE t.mes_subida = '".$mes."' AND s.mes_subida = '".$mes."' AND t.ano_subida = '".$ano."' AND s.ano_subida = '".$ano."' ORDER BY t.id_tabla";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function mini_tabla_asigpen($mes,$ano){

        $sql = "SELECT
                (
                    SELECT MAX(id_tabla) FROM nas_base_caso_asignado WHERE mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS id_AsigPen_mini,
                (
                    SELECT fec_asignados FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS fec_AsigPen_mini,
                (
                    SELECT num_cantidad FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS cantidad_AsigPen_mini,
                (
                    SELECT prom_antiguedad FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS promedio_AsigPen_mini,
                (
                    SELECT caso_mas_antiguo FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS caso_antiguo_AsigPen_mini";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function mini_tabla_solu($mes,$ano){

        $sql = "SELECT
                (
                    SELECT MAX(id_tabla) FROM nas_base_caso_solucionado WHERE mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS id_Solu_mini,
                (
                    SELECT fec_asignados FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS fec_Solu_mini,
                (
                    SELECT num_cantidad FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS cantidad_Solu_mini,
                (
                    SELECT prom_antiguedad FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS promedio_Solu_mini,
                (
                    SELECT caso_mas_antiguo FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND mes_subida = '".$mes."' AND ano_subida = '".$ano."'
                ) AS caso_antiguo_Solu_mini";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function tabla_asigpen($mes,$ano){

        $sql = "SELECT * FROM nas_base_caso_asignado WHERE mes_subida = '".$mes."' AND ano_subida = '".$ano."' ORDER BY id_tabla ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function tabla_solu($mes,$ano){

        $sql = "SELECT * FROM nas_base_caso_solucionado WHERE mes_subida = '".$mes."' AND ano_subida = '".$ano."' ORDER BY id_tabla ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function grafico_asigpen_solu_gestionable($fecha_inicio,$fecha_final){

        $sql = "SELECT t.num_cantidad AS Cantidad_AsigPen, t.prom_antiguedad AS Promedio_AsigPen, t.caso_mas_antiguo AS Caso_AsigPen, t.fec_asignados AS Fecha_AsigPen, s.num_cantidad AS Cantidad_Solu, s.prom_antiguedad AS Promedio_Solu, s.caso_mas_antiguo AS Caso_Solu, s.fec_asignados AS Fecha_Solu FROM nas_base_caso_asignado t INNER JOIN nas_base_caso_solucionado s ON t.id_tabla = s.id_tabla WHERE t.fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final' ORDER BY t.mes_subida,t.id_tabla ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function mini_tabla_gestionable_asigpen($fecha_inicio,$fecha_final){

        $sql = "SELECT
                (
                    SELECT MAX(id_tabla) FROM nas_base_caso_asignado WHERE fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS id_AsigPen_mini,
                (
                    SELECT fec_asignados FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS fec_AsigPen_mini,
                (
                    SELECT num_cantidad FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS cantidad_AsigPen_mini,
                (
                    SELECT prom_antiguedad FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS promedio_AsigPen_mini,
                (
                    SELECT caso_mas_antiguo FROM nas_base_caso_asignado WHERE id_tabla = id_AsigPen_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS caso_antiguo_AsigPen_mini";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function mini_tabla_gestionable_solu($fecha_inicio,$fecha_final){

        $sql = "SELECT
                (
                    SELECT MAX(id_tabla) FROM nas_base_caso_solucionado WHERE fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS id_Solu_mini,
                (
                    SELECT fec_asignados FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS fec_Solu_mini,
                (
                    SELECT num_cantidad FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS cantidad_Solu_mini,
                (
                    SELECT prom_antiguedad FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS promedio_Solu_mini,
                (
                    SELECT caso_mas_antiguo FROM nas_base_caso_solucionado WHERE id_tabla = id_Solu_mini AND fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final'
                ) AS caso_antiguo_Solu_mini";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function tabla_gestionable_asigpen($fecha_inicio,$fecha_final){

        $sql = "SELECT * FROM nas_base_caso_asignado WHERE fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final' ORDER BY mes_subida,id_tabla ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function tabla_gestionable_solu($fecha_inicio,$fecha_final){

        $sql = "SELECT * FROM nas_base_caso_solucionado WHERE fec_asignados BETWEEN '$fecha_inicio' AND '$fecha_final' ORDER BY mes_subida,id_tabla ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}

Class comentarios_pid{
    function contador_comentarios($id_user,$tipo_usuario){

        $sql = "SELECT COUNT(DISTINCT(t.id_tabla)) AS num_comentario FROM pid_conocimiento t INNER JOIN pid_comentario c ON c.id_tabla = t.id_tabla WHERE t.comentario_nuevo = '1' AND t.id_tabla = c.id_tabla AND t.tipo_conocimiento = '".$tipo_usuario."' AND IF(c.fec_comentario < (SELECT MAX(c.fec_comentario) FROM pid_comentario c WHERE c.id_tabla = t.id_tabla),0,1) = 1 AND c.id_user != '".$id_user."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function contador_comentario_documento($id_user,$id_tabla){

        //$sql = "SELECT COUNT(DISTINCT(t.id_tabla)) AS num_comentario FROM pid_comentario c INNER JOIN pid_conocimiento t ON c.id_tabla = t.id_tabla WHERE t.comentario_nuevo = '".$id_user."' AND c.id_user != '1' AND c.id_tabla = '".$id_tabla."'";
        $sql = "SELECT COUNT(DISTINCT(t.id_tabla)) AS num_comentario FROM pid_conocimiento t INNER JOIN pid_comentario c ON c.id_tabla = t.id_tabla WHERE c.nuevo_comentario = '1' AND t.id_tabla = c.id_tabla AND IF(c.fec_comentario < (SELECT MAX(c.fec_comentario) FROM pid_comentario c WHERE c.id_tabla = t.id_tabla),0,1) = 1 AND c.id_user != '".$id_user."' AND c.id_tabla = '".$id_tabla."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function comentarios_kdb($id_tabla){

        $sql = "SELECT c.id_comentario,u.id_user,u.claro_user,u.nom_user,u.funcion_user,u.img_user,c.contenido,c.tipo_comentario,c.fec_comentario,c.nuevo_comentario,c.id_tabla,c.comentario_calificado,c.fec_leido FROM pid_comentario c INNER JOIN pid_usuario u ON u.id_user = c.id_user WHERE c.id_tabla = '".$id_tabla."' ORDER BY c.fec_comentario ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function lista_comentarios_kdb_nuevos($tipo_usuario){

        $sql = "SELECT t.id_tabla,t.id_atu,t.comentario_nuevo,c.fec_comentario,COUNT(t.id_tabla) AS cantidad_comentarios FROM pid_comentario c INNER JOIN pid_conocimiento t ON t.id_tabla = c.id_tabla WHERE t.comentario_nuevo = '1' AND t.tipo_conocimiento = '".$tipo_usuario."' GROUP BY t.id_tabla ORDER BY c.fec_comentario DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function lista_comentarios_kdb($tipo_usuario){

        $sql = "SELECT t.id_tabla,t.id_atu,t.comentario_nuevo,c.fec_comentario,COUNT(t.id_tabla) AS cantidad_comentarios FROM pid_comentario c INNER JOIN pid_conocimiento t ON t.id_tabla = c.id_tabla WHERE t.tipo_conocimiento = '".$tipo_usuario."' GROUP BY t.id_tabla ORDER BY c.fec_comentario DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    /*function lista_comentarios_kdb(){

        $sql = "SELECT t.id_tabla,t.id_atu,t.comentario_nuevo,c.fec_comentario,COUNT(t.id_tabla) AS cantidad_comentarios FROM pid_comentario c INNER JOIN pid_conocimiento t ON t.id_tabla = c.id_tabla GROUP BY t.id_tabla ORDER BY IF(t.comentario_nuevo = 1, t.comentario_nuevo,'') DESC, IF(t.comentario_nuevo = 0, c.fec_comentario,'') DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }*/

    function insertar_comentario($id_tabla,$contenido,$id_user,$fec_comentario){

        $sql = "INSERT INTO pid_comentario (`id_tabla`, `contenido`, `id_user`, `fec_comentario`) VALUES ('$id_tabla','$contenido','$id_user','$fec_comentario')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_comentarios_vistos($id_tabla,$fec_leido){

        $sql = "UPDATE pid_comentario SET nuevo_comentario = '0', fec_leido = '".$fec_leido."' WHERE id_tabla = '".$id_tabla."' AND comentario_calificado = '0' AND fec_leido = 'NULL'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_comentario_calificado($id_comentario,$estado_comentario,$fec_leido){

        $sql = "UPDATE pid_comentario SET comentario_calificado = '".$estado_comentario."', nuevo_comentario = '0', fec_leido = '".$fec_leido."' WHERE id_comentario = '".$id_comentario."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_comentario_leido($id_comentario,$fec_leido){

        $sql = "UPDATE pid_comentario SET nuevo_comentario = '0', fec_leido = '".$fec_leido."' WHERE id_comentario = '".$id_comentario."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function update_estado_comentarios($id_tabla,$estado_comentario){

        $sql = "UPDATE pid_conocimiento SET comentarios = '".$estado_comentario."' WHERE id_tabla = '".$id_tabla."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function delete_comentarios_documento($id_tabla){

        $sql = "DELETE FROM pid_comentario WHERE id_tabla='".$id_tabla."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function resetear_comentarios_calificados_usuario($user_id){

        $sql = "UPDATE pid_usuario SET comentarios_calificados = '0' WHERE id_user = '".$user_id."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function resetear_comentarios_calificados(){

        $sql = "UPDATE pid_usuario SET comentarios_calificados = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function last_id_comentario($id_tabla){

        $sql = "SELECT
                (
                        SELECT MAX(id_comentario) FROM pid_comentario WHERE id_tabla = '".$id_tabla."'
                ) AS id_last,
                (
                        SELECT id_user FROM pid_comentario WHERE id_comentario = id_last
                ) AS id_user";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}