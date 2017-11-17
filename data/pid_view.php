<?php
require_once ('data_access.php');
Class pid_view {
    function view_contenido($id){

        $sql = "SELECT * FROM pid_conocimiento WHERE id_tabla = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_contenido_borrador($id){

        $sql = "SELECT * FROM pid_borrador WHERE id_tabla = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_contenido_responsable($id){

        $sql = "SELECT * FROM nas_matriz_responsable WHERE id_matriz = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_contenido_jobs($id){

        $sql = "SELECT * FROM nas_matriz_jobs WHERE id_jobs = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_contenido_comunicado($id){

        $sql = "SELECT * FROM nas_comunicado WHERE id_comunicado = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_category(){

        $sql = "SELECT id_apli,nom_apli FROM pid_aplicativo ORDER BY nom_apli ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_category_assoc($id_apli){

        $sql = "SELECT a.id_apli,a.nom_apli,c.id_cat,c.nom_cat FROM pid_aplicativo a INNER JOIN pid_categoria c ON c.id_cat = a.id_cat WHERE a.id_apli = '".$id_apli."' ORDER BY a.nom_apli ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grupo_asignado(){

        $sql = "SELECT * FROM pid_grupo_asignado order by nom_grupo";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_grupo_assoc($id_apli){

        $sql = "SELECT a.id_apli,a.nom_apli,g.id_grupo,g.nom_grupo FROM pid_aplicativo a INNER JOIN pid_grupo_asignado g ON g.id_grupo = a.id_grupo WHERE a.id_apli = '".$id_apli."' ORDER BY a.nom_apli ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_usuario_resolutor(){

        $sql = "SELECT * FROM pid_resolutor order by nom_res";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_usuario_edit_resolutor($id_res){

        $sql = "SELECT * FROM pid_resolutor WHERE id_res = '".$id_res."' order by nom_res";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_contenido_bitacora($id){

        $sql = "SELECT * FROM pid_bitacora WHERE id_bitacora = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_usuario($id){

        $sql = "SELECT * FROM pid_usuario WHERE id_user = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_aplicativo($id){

        $sql = "SELECT a.*,c.nom_cat,g.nom_grupo FROM pid_aplicativo a INNER JOIN pid_categoria c ON c.id_cat = a.id_cat INNER JOIN pid_grupo_asignado g ON g.id_grupo = a.id_grupo WHERE a.id_apli = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_categoria($id){

        $sql = "SELECT * FROM pid_categoria WHERE id_cat = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grupo($id){

        $sql = "SELECT * FROM pid_grupo_asignado WHERE id_grupo = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_registro($id){

        $sql = "SELECT * FROM pid_registro WHERE id_registro = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_area_resp(){

        $sql = "SELECT DISTINCT(area_resp) FROM nas_matriz_responsable";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_aplicativo_plataforma_caso(){

        $sql = "SELECT DISTINCT(apl_pla) FROM nas_matriz_responsable";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_cargo(){

        $sql = "SELECT DISTINCT(tipo_cargo) FROM nas_matriz_responsable";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_responsable(){

        $sql = "SELECT DISTINCT(nom_responsable) FROM nas_matriz_responsable";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_apl_jobs(){

        $sql = "SELECT DISTINCT(apl_job) FROM nas_matriz_jobs";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_comunicado($id_comunicado){

        $sql = "SELECT * FROM nas_comunicado WHERE id_comunicado = '$id_comunicado'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_ruta_speech(){

        $sql = "SELECT * FROM nas_ruta WHERE nom_ruta = 'Ruta_Speech_Servicio'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_ruta_turnos(){

        $sql = "SELECT * FROM nas_ruta WHERE nom_ruta = 'Ruta_Turnos_Analistas_Claro'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_ruta_horarios(){

        $sql = "SELECT * FROM nas_ruta WHERE nom_ruta = 'Ruta_Horarios_Responsables_Cacs'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_ruta_turnos_analistas_claro(){

        $sql = "SELECT * FROM nas_ruta WHERE nom_ruta = 'Ruta_Turnos_Analistas_Claro'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_ruta_horarios_responsables_cacs(){

        $sql = "SELECT * FROM nas_ruta WHERE nom_ruta = 'Ruta_Horarios_Responsables_Cacs'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_generado_por_seguimiento(){

        $sql = "SELECT DISTINCT(generado_por) AS generado_por FROM nas_base_caso WHERE nom_grupo IN ('SOPORTE APLICACIONES N1','AREAS DE NEGOCIO','PORTABILIDAD','SS TECNOLOGICOS N1','SS TECNOLOGICOS N2','SS HP N1') AND tipo_estado IN('Asignado','Pendiente','En progreso') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_supervisor_seguimiento(){

        $sql = "SELECT DISTINCT(nom_supervisor) AS nom_supervisor FROM nas_base_caso WHERE nom_grupo IN ('SOPORTE APLICACIONES N1','AREAS DE NEGOCIO','PORTABILIDAD','SS TECNOLOGICOS N1','SS TECNOLOGICOS N2','SS HP N1') AND tipo_estado IN('Asignado','Pendiente','En progreso') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grupo_responsable_seguimiento(){

        $sql = "SELECT DISTINCT(nom_grupo) AS nom_grupo FROM nas_base_caso WHERE nom_grupo IN ('SOPORTE APLICACIONES N1','AREAS DE NEGOCIO','PORTABILIDAD','SS TECNOLOGICOS N1','SS TECNOLOGICOS N2','SS HP N1') AND tipo_estado IN('Asignado','Pendiente','En progreso') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_generado_por_seguimiento_solu(){

        $sql = "SELECT DISTINCT(generado_por) AS generado_por FROM nas_base_caso WHERE tipo_estado IN('Solucionado') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_supervisor_seguimiento_solu(){

        $sql = "SELECT DISTINCT(nom_supervisor) AS nom_supervisor FROM nas_base_caso WHERE tipo_estado IN('Solucionado') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function view_grupo_responsable_seguimiento_solu(){

        $sql = "SELECT DISTINCT(nom_grupo) AS nom_grupo FROM nas_base_caso WHERE tipo_estado IN('Solucionado') AND tipo_rol IN ('APLIC','CESADO','PORTA') ORDER BY nom_grupo, nom_responsable ASC";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_usuarios_bloqueados(){

        $sql = "SELECT DISTINCT(b.id_user),u.nom_user,b.claro_user FROM pid_bloqueo b INNER JOIN pid_usuario u ON b.id_user = u.id_user";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function list_categoria(){

        $sql = "SELECT * FROM pid_categoria";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function view_contenido_noticia_portal($id){

        $sql = "SELECT * FROM pid_portal_noticia WHERE id_noticia = '$id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}