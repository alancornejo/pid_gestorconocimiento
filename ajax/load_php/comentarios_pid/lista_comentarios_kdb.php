<?php
    session_start();
    require_once ('../../../data/pid_data.php');
    require_once ('../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new comentarios_pid();
    $object_auth = new pid_auth();
    $object_permisos = new pid_permisos();
    $result_auth = $object_auth->user_auth($id_user);
    $row_auth = $result_auth->fetch_assoc();
    $tipo_usuario = $row_auth['tipo_user'];
    $result = $object->lista_comentarios_kdb_nuevos($tipo_usuario);
    $result_historial = $object->lista_comentarios_kdb($tipo_usuario);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    $n = 0;
?>
<style>
    .navbar.navbar-default .navbar-nav .dropdown-menu li.li_comentarios > a {
        color: #797979;
        background-color: white;
    }

    .navbar.navbar-default .navbar-nav .dropdown-menu li.li_comentarios > a:hover {
        color: white;
        background-color: #797979;
    }
    
    .navbar.navbar-default .navbar-nav .dropdown-menu li.li_comentarios_nuevo > a {
        color: white;
        background-color: #1B9CDD;
    }

    .navbar.navbar-default .navbar-nav .dropdown-menu li.li_comentarios_nuevo > a:hover {
        color: white;
        background-color: #68CFFF;
    }
</style>

<div class="slimscroll">
    <?php
        while($row = $result->fetch_assoc()){

        $n++;

        $id_tabla = $row['id_tabla'];

        $result_last_id = $object->last_id_comentario($id_tabla);
        $row_last = $result_last_id->fetch_assoc();

        if($row['cantidad_comentarios'] == "1"){
            $text_comentario = "comentario";
        }else{
            $text_comentario = "comentarios";
        }

        if($tipo_usuario == "0"){
            $servicio = "APL";
        }else{
            $servicio = "BIO";
        }

    ?>

    <li style="<?php if($row_last['id_user'] == $id_user) { echo "display:none"; }else{ echo ""; } ?>" class="li_comentarios_nuevo">
        <a data-toggle="modal" data-target="#modal_ver_conocimiento" onclick="view_atu(<?= $row['id_tabla'] ?>)" style="cursor: pointer;font-size: 12px">
            <i class="fa fa-comment"></i> 
                Hay un nuevo comentario en el <b><?= $servicio ?> <?= $row['id_atu'] ?>
            </b>
        </a>
    </li>

    <?php } ?>

    <?php
        while($row_historial = $result_historial->fetch_assoc()){

        $n++;

        $id_tabla = $row_historial['id_tabla'];

        $result_last_id_historial = $object->last_id_comentario($id_tabla);
        $row_last_historial = $result_last_id_historial->fetch_assoc();

        if($row_historial['cantidad_comentarios'] == "1"){
            $text_comentario = "comentario";
        }else{
            $text_comentario = "comentarios";
        }

        if($tipo_usuario == "0"){
            $servicio = "APL";
        }else{
            $servicio = "BIO";
        }
    ?>

    <li class="li_comentarios">
        <a data-toggle="modal" data-target="#modal_ver_conocimiento" onclick="view_atu(<?= $row_historial['id_tabla'] ?>)" style="cursor: pointer;font-size: 12px">
            <i class="fa fa-comment"></i> 
                Hay <?= $row_historial['cantidad_comentarios']; ?> <?= $text_comentario ?> en el <b><?= $servicio ?> <?= $row_historial['id_atu'] ?>
            </b>
        </a>
    </li>

    <?php } ?>
</div>

<?php if($n == 0){ ?>

<li>
    <a style="cursor: pointer;font-size: 12px">
        <i class="fa fa-comment"></i> <b>No hay Comentarios nuevos</b>
    </a>
</li>

<?php } ?>

<?php if($n > 15){ ?>
<script>
    $('.slimscroll').slimScroll({
        height: '250px'
    });
</script>
<?php } ?>