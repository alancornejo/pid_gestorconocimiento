<?php
require_once ('data_access.php');
Class pid_login {
    function pid_autentificador($username,$password){
        $sql = "SELECT * FROM pid_usuario WHERE claro_user='$username' AND pass_user='$password' AND usuario_eliminado = '0'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}

Class pid_auth {
    function user_auth($id_user){

        $sql = "SELECT * FROM pid_usuario WHERE id_user = '$id_user'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function user_perfil_auth($user_id){

        $sql = "SELECT * FROM pid_usuario WHERE id_user = '$user_id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function verificar_bloqueo($username){

        $sql = "SELECT * FROM pid_bloqueo WHERE claro_user = '$username' ORDER BY fec_desbloqueo DESC LIMIT 1";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}

Class pid_permisos {
    function user_permisos($id_user){

        $sql = "SELECT * FROM pid_permiso WHERE id_user = '$id_user'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

    function user_permisos_modulo($user_id){

        $sql = "SELECT * FROM pid_permiso WHERE id_user = '$user_id'";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }

}

Class pid_perfil_usuario {
    function colaboracion_plataforma($id_user){

        $sql = "SELECT (
                    SELECT COUNT(*) FROM pid_borrador WHERE id_user = '$id_user' AND estado = '1'
                ) AS cantidad_borradores,
                (
                    SELECT COUNT(*) FROM pid_comentario WHERE id_user = '$id_user' AND comentario_calificado = '1'
                ) AS cantidad_comentarios";
        $conn = new Connection();
        $result = $conn->consult($sql);
        return $result;
    }
}