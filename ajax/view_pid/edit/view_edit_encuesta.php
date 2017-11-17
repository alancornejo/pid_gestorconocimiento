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
    require_once ('../../../data/pid_access.php');
    require_once ('../../../data/pid_encuesta.php');
    $object_permisos = new pid_permisos();
    $object_encuesta = new Encuesta();
    $id_user = $_SESSION['id_user_apl'];
    $id_encuesta = $_GET['id'];
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result_encuesta = $object_encuesta->view_encuesta($id_encuesta);
    $row_permisos = $result_permisos->fetch_assoc();
    $row_encuesta = $result_encuesta->fetch_assoc();

    if($row_permisos['edit_enc'] != "true"){
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
            <h3 class="modal-title">Editar Encuesta [ID]</h3>
          </div>
          <div class="modal-body">
            <form id="edit_encuesta" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-6">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_titulo" type="text" class="txt_titulo_enc_edit form-control" id="inputIEncuesta" placeholder="Titulo de Encuesta" value="<?= $row_encuesta['titulo_encuesta'] ?>">
                                <input name="id_encuesta" type="text" value="<?= $id_encuesta ?>" hidden>
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Habilitar Comentario</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-comment"></i></span>
                                <select name="sl_comentario" id="inputCEncuesta" class="sl_comentario_enc_edit selectpicker_edit form-control show-tick" data-header="Habilitar Comentario">
                                    <option value="1" <?php if($row_encuesta['habilitar_comentario'] == 1) echo "selected" ?>>Si</option>
                                    <option value="0" <?php if($row_encuesta['habilitar_comentario'] == 0) echo "selected" ?>>No</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Habilitar Mini-Encuesta</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                <select name="sl_mini_encuesta" id="inputMEncuesta" class="sl_mini_encuesta selectpicker_edit form-control show-tick" data-header="Habilitar Mini-Encuesta" disabled>
                                    <option value="1" <?php if($row_encuesta['habilitar_mini_encuesta'] == 1) echo "selected" ?>>Si</option>
                                    <option value="0" <?php if($row_encuesta['habilitar_mini_encuesta'] == 0) echo "selected" ?>>No</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Fecha Inicio</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_inicio_enc_edit" type="text" class="fec_inicio_enc_edit form-control" id="inputInEncuesta" placeholder="<?= date("Y-m-d H:i A") ?>" value="<?= $row_encuesta['fecha_inicio'] ?>">                            
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Fecha Revisión</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_termino_enc_edit" type="text" class="fec_termino_enc_edit form-control" id="inputTEncuesta" placeholder="<?= date("Y-m-d H:i A") ?>" value="<?= $row_encuesta['fecha_termino'] ?>">                            
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Mensaje al terminar</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input name="txt_mensaje" type="text" class="txt_mensaje_enc_edit form-control" id="inputMEncuesta" placeholder="Este mensaje aparece al culminar la encuesta" value="<?= $row_encuesta['mensaje_encuesta'] ?>">
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
    
    $('.fec_inicio_enc_edit').daterangepicker({
        timePicker: true,
        timePicker24Hour: false,
        singleDatePicker: true,
        showDropdowns: true,
        alwaysShowCalendars: true,
        autoUpdateInput: false,
        opens: "right",
        locale: {
            cancelLabel: 'Limpiar',
            applyLabel: 'Aplicar',
            format: 'YYYY-MM-DD'
        }
    });

    $('.fec_inicio_enc_edit').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_inicio_enc_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fec_inicio_enc_edit').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_inicio_enc_edit').val('');
    });
    
    $('.fec_termino_enc_edit').daterangepicker({
        timePicker: true,
        timePicker24Hour: false,
        singleDatePicker: true,
        showDropdowns: true,
        alwaysShowCalendars: true,
        autoUpdateInput: false,
        opens: "right",
        locale: {
            cancelLabel: 'Limpiar',
            applyLabel: 'Aplicar',
            format: 'YYYY-MM-DD h:mm A'
        }
    });

    $('.fec_termino_enc_edit').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_termino_enc_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fec_termino_enc_edit').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_termino_enc_edit').val('');
    });
    
    $('.selectpicker_edit').selectpicker();
    
    $('#edit_encuesta').submit(function( event ) {
        if ($(".txt_titulo_enc_edit").val() == '' || $("select.sl_comentario_enc_edit").val() == null || $('.txt_mensaje_enc_edit').val() == '' || $('.fec_inicio_enc_edit').val() == '' || $('.fec_termino_enc_edit').val() == '') {
            swal({
                title: "",
                text: "Favor de completar los campos",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
            }else{
                var datos = $(this).serialize();
                swal({
                    title: 'Deseas editar esta encuesta ?',
                    text: "Recuerda haber llenado todo correctamente !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1b9cdd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-edit"></i> Editar',
                    showLoaderOnConfirm: false,
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                }).then(function() {
                    $.ajax({
                        type: "POST",
                        url: "ajax/action_class/encuesta/edit_encuesta.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se edito la encuesta con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_edit_encuesta').modal('toggle');
                                }, 600);
                                tabla_encuesta_gestor.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al editar la encuesta, informalo al administrador y/o desarrollador",
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
                        text: "No se edito ninguna encuesta",
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