<?php
require_once ('data_access.php');
Class portal_pid {
    function ver_cumpleaños(){
        $sql = "SELECT u.nom_user,u.fecha_nacimiento,u.img_user,MONTH(u.fecha_nacimiento) AS Mes FROM pid_usuario u WHERE MONTH(u.fecha_nacimiento) = MONTH(NOW()) AND u.usuario_eliminado = '0' AND u.estado_user = '0' ORDER BY DAY(u.fecha_nacimiento) ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function analistas_mas_casos(){
        $sql = "SELECT generado_por,COUNT(*) AS total_casos FROM nas_base_caso WHERE nom_grupo IN ('SOPORTE APLICACIONES N1') AND tipo_estado IN('Asignado','Pendiente','En progreso') AND tipo_rol IN ('APLIC') GROUP BY generado_por ORDER BY total_casos DESC LIMIT 3";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function analistas_area_negocios(){
        $sql = "SELECT generado_por,COUNT(*) AS total_casos FROM nas_base_caso WHERE nom_grupo IN ('AREAS DE NEGOCIO') AND tipo_estado IN('Asignado','Pendiente','En progreso') AND tipo_rol IN ('APLIC') GROUP BY generado_por ORDER BY total_casos DESC LIMIT 3";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function ver_noticias(){
        $sql = "SELECT * FROM pid_portal_noticia ORDER BY fecha_noticia DESC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function mini_encuesta(){
        $sql = "SELECT * FROM pid_encuesta WHERE habilitar_mini_encuesta = '1' ORDER BY id_encuesta DESC LIMIT 1";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function mini_encuesta_pregunta($id_encuesta){
        $sql = "SELECT * FROM pid_encuesta_preguntas WHERE id_encuesta = '".$id_encuesta."' AND tipo_pregunta = '0' AND estado_pregunta = '1' ORDER BY id_enc_pregunta ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function mini_encuesta_opciones($id_enc_pregunta){
        $sql = "SELECT * FROM pid_encuesta_opciones WHERE id_enc_pregunta = '".$id_enc_pregunta."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function ver_mini_bloqueo($id_user,$id_encuesta){
        $sql = "SELECT * FROM pid_mini_encuesta_bloqueo WHERE id_user = '$id_user' AND id_encuesta = '$id_encuesta'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function verificar_cantidad_opciones_mini($id_pregunta,$id_opcion){
        $sql = "SELECT COUNT(*) AS cantidad_opciones FROM pid_encuesta_resultado WHERE id_enc_pregunta = '".$id_pregunta."' AND id_enc_opciones = '".$id_opcion."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function verificar_cantidad_usuarios(){
        $sql = "SELECT COUNT(*) AS cantidad FROM pid_usuario";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}