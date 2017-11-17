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
    $object_update = new update_pid();
    $object_access = new pid_auth();
    $object_permisos = new pid_permisos();
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $result_view = $object->view_contenido($id);
    $result_access = $object_access->user_auth($id_user);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row = $result_view->fetch_assoc();
    $row_access = $result_access->fetch_assoc();
    $row_permisos = $result_permisos->fetch_assoc();
    
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= $row['titulo']; ?></h3>
    </div>
    <div class="modal-body">
        <?php if($row_access['bloqueo_examen'] == 0){
            if($row_permisos['crea_cono'] == "false" || $row_permisos['gest_cono'] == "false"){
                $result_update = $object_update->update_contador($id);
                $result_estado = $object_update->update_ingresos_sesion($id_user);
            }
        ?>
        <div id="counter" hidden>0</div>
        <div id="id_user" hidden><?= $id_user ?></div>
        <div><?= $row['contenido']; ?></div>
        <hr>
        <div class="contenedor_botones">
            <center>
                <a class="btn btn-success abrir_caja_comentario_kdb"><i class="fa fa-comments"></i> Abrir Comentarios <t class="contador_en_documento"></t></a>
                <a class="btn btn-danger cerrar_caja_comentario_kdb"><i class="fa fa-comments-o"></i> Cerrar Comentarios</a>
            </center>
        </div>
        <br>
        <div class="loading_comentario"><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></div>
        <br>
        <div class="cuerpo_comentario"></div>
        
        <script>
            
            $('.contador_en_documento').load("ajax/load_php/comentarios_pid/contador_comentario_documento.php?id_tabla_comment=<?= $id ?>");
            
            $('.cerrar_caja_comentario_kdb,.loading_comentario').hide();
            
            $('.abrir_caja_comentario_kdb').click(function() {
                $('.loading_comentario').show();
                $('.contenedor_botones').fadeOut(function() {
                     $('.cuerpo_comentario').fadeIn(function (){
                         $('.abrir_caja_comentario_kdb,.loading_comentario').hide();
                         $('.contenedor_botones,.cerrar_caja_comentario_kdb').fadeIn();
                         $('.cuerpo_comentario').load('ajax/load_php/comentarios_pid/comentarios_kdb.php?id=<?= $id ?>');
                     });
                 });
            });
            
            $('.cerrar_caja_comentario_kdb').click(function() {
                $.ajax({
                    cache: false,
                    type: 'GET',
                    url: 'ajax/action_class/update/update_comentarios_vistos.php',
                    data: 'id=<?= $id ?>',
                    success:function(){
                        $('.loading_comentario').show();
                        $('.contenedor_botones').fadeOut(function(){
                            $('.cuerpo_comentario').fadeOut(function (){
                                $('.contenedor_botones,.abrir_caja_comentario_kdb').fadeIn();
                                $('.cuerpo_comentario,.cerrar_caja_comentario_kdb,.loading_comentario').hide();
                            });
                        });
                    }
                });
            });
        </script>
            
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
if($row_permisos['gest_cono'] == "false"){
?>
<script>
    $('#counter').timer({
        format: '%t'
    });
    $('#modal_ver_conocimiento').on('hidden.bs.modal', function (e) {
        var tiempo = $('#counter').text();
        var id_us = $('#id_user').text();
        $.ajax({
            cache: false,
            type: 'GET',
            url: 'ajax/action_class/update/update_tiempo_kdb.php',
            data: "id_user="+ id_us + "&tiempo=" + tiempo,
            success:function(data){
               console.log('Data_Contabilizado'+data);
            }
        });
        if (!data) return e.preventDefault();
    });
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>