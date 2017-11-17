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
    require_once ('../../data/pid_data.php');
    require_once ('../../data/pid_access.php');
    $object = new pid_view();
    $object_access = new pid_auth();
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $result_view = $object->view_contenido_comunicado($id);
    $result_access = $object_access->user_auth($id_user);
    $row = $result_view->fetch_assoc();
    $row_access = $result_access->fetch_assoc();
    
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= $row['txt_comunicado']; ?></h3>
    </div>
    <div class="modal-body">
        <?php if($row_access['bloqueo_examen'] == 0){
        ?>
        <div id="id_user" hidden><?= $id_user ?></div>
        <div><?= $row['com_contenido']; ?></div>
        <?php }else{ ?>
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Ya has iniciado un examen</h3>
            </div>
            <div class="panel-body text-center">
              Empezaste tu examen de conocimiento, por el cual el KDB se encontrara bloqueado.
            </div>
        </div>
        <?php } ?>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
    </div>
</div>
<?php 
if($row_access['funcion_user'] == 0 || $row_access['funcion_user'] == 1 || $row_access['funcion_user'] == 2 || $row_access['funcion_user'] == 3 || $row_access['funcion_user'] == 6 || $row_access['funcion_user'] == 7 || $row_access['funcion_user'] == 8){
?>
<script>
    
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>