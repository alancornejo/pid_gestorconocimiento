<?php
require_once ('data_access.php');
Class pid_validate{
    function aplicativo_validate($nom_apli, $id_cat, $id_grupo){

        $sql = "SELECT nom_apli FROM pid_aplicativo WHERE nom_apli = UPPER('".$nom_apli."') AND id_cat = '".$id_cat."' AND id_grupo = '".$id_grupo."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function categoria_validate($nom_cat){

        $sql = "SELECT nom_cat FROM pid_categoria WHERE nom_cat = '".$nom_cat."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
    
    function resolutor_validate($nom_res,$area_res,$jefe_res,$cargo_res){

        $sql = "SELECT nom_res FROM pid_resolutor WHERE nom_res = UPPER('".$nom_res."') AND area_res = UPPER('".$area_res."') AND jefe_res = UPPER('".$jefe_res."') AND cargo_res = UPPER('".$cargo_res."')";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function grupo_asignado_validate($nom_grupo){

        $sql = "SELECT nom_grupo FROM pid_grupo_asignado WHERE nom_grupo = '".$nom_grupo."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function usuario_validate($claro_usuario){

        $sql = "SELECT claro_user FROM pid_usuario WHERE claro_user = '".$claro_usuario."'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}