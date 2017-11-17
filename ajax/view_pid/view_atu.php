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
    require_once ('../../data/pid_examen.php');
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
    $id_atu = $row['id_atu'];
    $object_bloqueo = new examen_usuario();
    $result_bloqueo = $object_bloqueo->bloquear_documento($id_atu);
    $row_bloqueo = $result_bloqueo->fetch_assoc();
    $row_access = $result_access->fetch_assoc();
    $row_permisos = $result_permisos->fetch_assoc();
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title"><?= $row['titulo']; ?></h3>
    </div>
    <div class="modal-body">
        <div class="row center-block">
            <section class="col col-12">
            <?php if($row_permisos['crea_cono'] == "true" || $row_permisos['gest_cono'] == "true"){ ?>
            <div id="makeMeDraggable1" style="left: 1034px">
                <button class="print btn btn-info"><i class="fa fa-image"></i></button>
            </div>
            <?php } ?>
            <?php if($row_access['bloqueo_examen'] == 0){
                if($row_bloqueo['id_atu'] == $row['id_atu']){
            ?>
                <div class="panel panel-danger">
                    <div class="panel-heading">
                        <h3 class="panel-title">Documento Bloqueado</h3>
                    </div>
                    <div class="panel-body text-center">
                      Este documento se encuentra bloqueado, porque se encuentra en plena evaluación.
                    </div>
                </div>
            <?php
                }else{
                if($row_permisos['crea_cono'] == "false" || $row_permisos['gest_cono'] == "false"){
                    $result_update = $object_update->update_contador($id);
                    $result_estado = $object_update->update_ingresos_sesion($id_user);
                }
                
                $permisos = $row_permisos['gest_comment'];
                $comentario_nuevo = $row['comentario_nuevo'];
                /*if($row_permisos['gest_comment'] == "true"){
                    if($row['comentario_nuevo'] == "1"){
                        $result_update = $object_update->update_leer_comentarios($id);
                    }
                }*/
            ?>
            <div id="counter" hidden>0</div>
            <div id="id_user" hidden><?= $id_user ?></div>
            <div><?= $row['contenido']; ?></div>
            <hr>
            <div class="contenedor_botones">
                <center>
                <?php if($row_permisos['gest_comment'] == "true"){ ?>
                    <a class="btn btn-success abrir_caja_comentario_kdb_gestor"><i class="fa fa-comments"></i> Abrir Comentarios <t class="contador_en_documento"></t></a>
                    <a class="btn btn-danger cerrar_caja_comentario_kdb_gestor"><i class="fa fa-comments-o"></i> Cerrar Comentarios</a>
                <?php }else{ ?>
                    <a class="btn btn-success abrir_caja_comentario_kdb"><i class="fa fa-comments"></i> Abrir Comentarios <t class="contador_en_documento"></t></a>
                    <a class="btn btn-danger cerrar_caja_comentario_kdb"><i class="fa fa-comments-o"></i> Cerrar Comentarios</a>
                <?php } ?>
                </center>
            </div>
            <br>
            <div class="loading_comentario"><center><img src='assets/images/loading.gif'><b> Cargando...</b></center></div>
            <br>
            <div class="cuerpo_comentario"></div>

            <script>

                $('.contador_en_documento').load("ajax/load_php/comentarios_pid/contador_comentario_documento.php?id_tabla_comment=<?= $id ?>");

                $('.cerrar_caja_comentario_kdb,.cerrar_caja_comentario_kdb_gestor,.loading_comentario').hide();

                $('.abrir_caja_comentario_kdb').click(function() {
                    $('.loading_comentario').show();
                    $('.contenedor_botones').fadeOut(function() {
                        $('.cuerpo_comentario').fadeIn(function (){
                            $('.abrir_caja_comentario_kdb,.loading_comentario').hide();
                            $('.contenedor_botones,.cerrar_caja_comentario_kdb').fadeIn();
                            $('.cuerpo_comentario').load('ajax/load_php/comentarios_pid/comentarios_kdb.php?id=<?= $id ?>&comentario=<?= $row['comentarios'] ?>');
                        });
                    });
                });

                $('.cerrar_caja_comentario_kdb').click(function() {
                    $('.loading_comentario').show();
                    $('.contenedor_botones').fadeOut(function(){
                        $('.cuerpo_comentario').fadeOut(function (){
                            $('.contador_en_documento').load("ajax/load_php/comentarios_pid/contador_comentario_documento.php?id_tabla_comment=<?= $id ?>");
                            $('.contenedor_botones,.abrir_caja_comentario_kdb').fadeIn();
                            $('.cuerpo_comentario,.cerrar_caja_comentario_kdb,.loading_comentario').hide();
                        });
                    });
                });

                $('.abrir_caja_comentario_kdb_gestor').click(function() {
                    $('.loading_comentario').show();
                    $('.contenedor_botones').fadeOut(function() {
                        $('.cuerpo_comentario').fadeIn(function (){
                            $('.abrir_caja_comentario_kdb_gestor,.loading_comentario').hide();
                            $('.contenedor_botones,.cerrar_caja_comentario_kdb_gestor').fadeIn();
                            $('.cuerpo_comentario').load('ajax/load_php/comentarios_pid/comentarios_kdb.php?id=<?= $id ?>&comentario=<?= $row['comentarios'] ?>');
                        });
                    });
                });

                $('.cerrar_caja_comentario_kdb_gestor').click(function() {
                    $.ajax({
                        cache: false,
                        type: 'GET',
                        url: 'ajax/action_class/update/update_comentarios_vistos.php',
                        data: 'id=<?= $id ?>' + '&permisos=' + <?= $permisos ?> + '&comentario_nuevo=' + <?= $comentario_nuevo ?>,
                        success:function(){
                            $('.contador_en_documento').load("ajax/load_php/comentarios_pid/contador_comentario_documento.php?id_tabla_comment=<?= $id ?>");
                            $('.loading_comentario').show();
                            $('.contenedor_botones').fadeOut(function(){
                                $('.cuerpo_comentario').fadeOut(function (){
                                    $('.contenedor_botones,.abrir_caja_comentario_kdb_gestor').fadeIn();
                                    $('.cuerpo_comentario,.cerrar_caja_comentario_kdb_gestor,.loading_comentario').hide();
                                });
                            });
                        }
                    });
                });

            </script>
            <?php }}else{ ?>
            <div class="panel panel-danger">
                <div class="panel-heading">
                    <h3 class="panel-title">Ya has iniciado un examen</h3>
                </div>
                <div class="panel-body text-center">
                  Empezaste tu examen de conocimiento, por el cual el KDB se encontrara bloqueado.
                </div>
            </div>
            <?php } ?>
            </section>
        </div>
    </div>
    <div class="modal-footer">
        <?php if($row_permisos['gest_est_comment'] == "true"){ if($row['comentarios'] == "1"){ ?>
        <a onclick="cambiar_estado_comentario(<?= $id ?>,1)" class="btn btn-warning pull-left"><i class="fa fa-comments-o"></i> Deshabilitar Comentarios</a>
        <?php }else{ ?>
        <a onclick="cambiar_estado_comentario(<?= $id ?>,0)" class="btn btn-success pull-left"><i class="fa fa-comments"></i> Habilitar Comentarios</a>
        <?php }} ?>
        <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
    </div>
</div>
<script>
    
    $(".print").on("click", function(event) {
        html2canvas($('.modal-content'), {
            onrendered: function(canvas) {
                var img = canvas.toDataURL("image/png")
                window.open(img);
            },
            allowTaint: true,
            letterRendering: true,
            taintTest: true,
            useCORS: true
        });
    });
    
    $.curCSS = function (element, attrib, val) {
        $(element).css(attrib, val);
    };
    
    $('#makeMeDraggable1').draggable({cancel:false});
    
    /* Funcion para cambiar estado de comentario */
function cambiar_estado_comentario(id,estado){
    var id_tabla = id;
    var estado_comentario = estado;
    
    if(estado_comentario == "1"){
        var estado_txt = "Deshabilitar";
        var estado_txt_dos = "deshabilito";
    }else{
        var estado_txt = "Habilitar";
        var estado_txt_dos = "habilito";
    }
    
    swal({
        title: 'Deseas ' + estado_txt + ' los comentarios de este documento?',
        text: "",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#1b9cdd',
        cancelButtonColor: '#d33',
        confirmButtonText: '<i class="fa fa-refresh"></i> ' + estado_txt,
        showLoaderOnConfirm: false,
        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
    }).then(function() {
        $.ajax({
            type: "GET",
            url: "ajax/action_class/update/update_estado_comentario.php",
            data: "id="+ id_tabla + "&estado_comentario=" + estado_comentario,
            success: function(data) {
                if(data == "true"){
                    setTimeout(function(){     
                        swal({
                            title: "",
                            text: "Se " + estado_txt_dos + " los comentarios con exito",
                            type: "success",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                        $('#modal_ver_conocimiento').modal('toggle');
                    }, 600);
                }else{
                    swal({
                        title: "",
                        text: "Error al " + estado_txt + " los comentarios, informalo al administrador y/o desarrollador",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }
            }
        });
    }, function(dismiss) {
      if (dismiss === 'cancel') {
        swal({
            title: "",
            text: "No se " + estado_txt_dos + " los comentarios",
            type: "error",
            showCancelButton: false,
            showConfirmButton: true
        });
      }
    })
}
/* Fin Funcion para cambiar estado de comentario */
</script>

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
        var data = "";
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