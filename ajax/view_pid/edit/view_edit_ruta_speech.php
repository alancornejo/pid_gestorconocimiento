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
    $_SESSION['filemanager_categoria'] = "ruta_speech";
    require_once ('../../../data/pid_access.php');
    require_once ('../../../data/pid_view.php');
    $object_permisos = new pid_permisos();
    $object_view = new pid_view();
    $id_user = $_SESSION['id_user_apl'];
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result_view = $object_view->view_ruta_speech();
    $row_permisos = $result_permisos->fetch_assoc();
    $row_view = $result_view->fetch_assoc();
    
    if($row_permisos['edit_dir_spee'] != "true"){
?> 
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Acceso Bloqueado</h3>
    </div>
    <div class="modal-body">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Sin permisos para el acceso al módulo</h3>
            </div>
            <div class="panel-body text-center">
              No cuentas con los permisos correspondientes para el acceso a este módulo, contacte con el desarrolador y/o administrador.
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
    </div>
</div>
<?php }else{ ?>
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h3 class="modal-title">Editar Ruta Speech</h3>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" id="edit_ruta_speech" class="sky-form">
                    <fieldset>
                        <div class="row">
                            <section class="col col-10">
                                <label>Ubicacion de la ruta del Speech (.pdf)</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-file-excel-o"></i></span>
                                    <input name="sel_file_speech" type="text" class="sel_file_speech form-control" id="inputSpeech" placeholder="Ruta del archivo a Subir" value="<?= $row_view['src_ruta'] ?>">
                                </div>
                            </section>
                            <section class="col col-2">
                                <label>&nbsp;</label>
                                <div class="input-group">
                                    <a class="btn btn-info" style="color:white" onclick="javascript:ventana_url('assets/js/tinymce/filemanager/dialog.php?popup=1&amp;field_id=inputSpeech')"><i class="fa fa-upload"></i> Examinar</a>
                                </div>
                            </section>
                        </div>
                        <div class="row modal-footer">
                            <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                            <input class="btn btn-primary" type="submit" value="Editar">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
<script>
    
    function abrir_loading(){
        swal({
            title: "",
            text: "Cargando la ruta de Speech.....",
            type: "info",
            showCancelButton: false,
            showConfirmButton: false
        });
    }
    
    function cerrar_loading(){
        swal.close();
    }
    
    function ventana_url(url){
        var w = 1000;
        var h = 600;
        var l = Math.floor((screen.width-w)/2);
        var t = Math.floor((screen.height-h)/2);
        var win = window.open(url, 'Gestor de Archivos - PID - CLARO AN', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
    }
    
    $('#edit_ruta_speech').submit(function( event ) {
        if ($(".sel_file_speech").val() == '') {
            swal("PID - CLARO AN", "Favor de completar los campos", "warning");
            return false;
            }else{
                var formData = $(this).serialize();
                swal({
                    title: 'Deseas Editar la ruta del Speech ?',
                    text: "Recuerda que se editara la redireccion",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1b9cdd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-edit"></i> Editar',
                    showLoaderOnConfirm: false,
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                }).then(function() {
                    abrir_loading();
                    $.ajax({
                        type: "POST",
                        url: "ajax/action_class/update/update_ruta_speech.php",
                        data: formData,
                        success: function(data) {
                            console.log(data);
                            if(data == 0){
                                cerrar_loading();
                                swal({
                                    title: "",
                                    text: "Extension de archivo incorrecto, solo formato pdf",
                                    type: "warning",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }else if(data == 1){
                                cerrar_loading();
                                setTimeout(function(){
                                    swal({
                                        title: "",
                                        text: "Se edito la ruta del speech con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    });
                                    $('#modal_edit_ruta_speech').modal('toggle');
                                }, 1000);
                            }
                        }
                    });
                }, function(dismiss) {
                  if (dismiss === 'cancel') {
                    swal({
                        title: "",
                        text: "No se edito la ruta",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                  }
                });
            }
        event.preventDefault();
    });
    
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>