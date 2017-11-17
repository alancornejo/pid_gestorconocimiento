<?php
    session_start();
    $seconds = 0;
    sleep($seconds);
    if(empty($_SESSION['id_user_apl'])){
?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Su sesión ha culminado</h3>
        </div>
        <div class="modal-body">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">No te encuentras logeado</h3>
                </div>
                <div class="panel-body text-center">
                  La sesión ya ha culminado por el cual no podras visualizar nada en la plataforma, 
                  favor de actualizar la web para poder ingresar nuevamente o darle click al siguiente boton : <a data-dismiss="modal" class="btn btn-warning cierre_modal">Actualizar</a>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <a data-dismiss="modal" class="btn btn-default cierre_modal">Cerrar</a>
        </div>
    </div>
<?php
    }else{
    require_once ('../../data/pid_view.php');
    $object = new pid_view();
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $result_view = $object->view_contenido_noticia_portal($id);
    $row = $result_view->fetch_assoc();
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= utf8_encode($row['txt_noticia']); ?></h3>
    </div>
    <div class="modal-body">
        <div class="row center-block">
            <section class="col col-12">                
            <div id="id_user" hidden><?= $id_user ?></div>
            <div><?= $row['contenido_noticia']; ?></div>
            </section>
        </div>
    </div>
    <div class="modal-footer">
        <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
    </div>
</div>
<?php } ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>