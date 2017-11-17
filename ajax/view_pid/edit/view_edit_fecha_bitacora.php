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
    $_SESSION['filemanager_categoria'] = "bitacora";
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $result_apl = $object->view_category();
    $result_asig = $object->view_grupo_asignado();
    $result_view = $object->view_contenido_bitacora($id);
    $row = $result_view->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_fec_bita'] != "true"){
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
                <h3 class="modal-title">Editar Fecha de Estado - Bitácora</h3>
            </div>
            <div class="modal-body">
                <form id="edit_fecha_bitacora" class="sky-form">
                    <fieldset>
                        <div class="row">
                            <section class="col-md-6">
                                <label>Estado de Bitácora</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-stack-exchange"></i></span>
                                    <select name="sl_estado" id="inputEstado" class="sl_estado_edit selectpicker_edit form-control show-tick" data-header="Estado">
                                            <option value="asignado" <?php if("ASIGNADO" == $row['id_estado']){ echo "selected"; }else{ echo ""; }?>>ASIGNADO</option>
                                            <option value="solucionado" <?php if("SOLUCIONADO" == $row['id_estado']){ echo "selected"; }else{ echo ""; }?>>SOLUCIONADO</option>
                                            <option value="re-asignado" <?php if("RE-ASIGNADO" == $row['id_estado']){ echo "selected"; }else{ echo ""; }?>>RE-ASIGNADO</option>
                                            <option value="cerrado" <?php if("CERRADO" == $row['id_estado']){ echo "selected"; }else{ echo ""; }?>>CERRADO</option>
                                    </select>
                                </div>
                            </section>
                            <section class="col-md-6">
                                <div>
                                    <div id="edit_fec_asignado" class="estado_bitacora_edit asignado" <?php if("ASIGNADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Asignacion</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_apertura" type="text" class="fec_edit_fecha_apertura input_edit_asignado form-control" id="inputFechaApertura" value="<?= $row['fec_apertura'] ?>">
                                        </div>
                                    </div>
                                    <div id="edit_fec_re-asignado" class="estado_bitacora_edit re-asignado" <?php if("RE-ASIGNADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Re-Asignacion</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_re_asignado" type="text" class="fec_edit_fecha_re_asignado input_edit_re-asignado form-control" id="inputFechaReAsignado" value="<?= $row['fec_reasi']; ?>" placeholder="<?= date("Y-m-d H:i") ?>">
                                        </div>
                                    </div>
                                    <div id="edit_fec_solucionado" class="estado_bitacora_edit solucionado" <?php if("SOLUCIONADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Solucion</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_solucionado" type="text" class="fec_edit_fecha_solucionado input_edit_solucionado form-control" id="inputFechaSolucionado" value="<?= $row['fec_solucion']; ?>" placeholder="<?= date("Y-m-d H:i") ?>">                                        
                                        </div>
                                    </div>
                                    <div id="edit_fec_cerrado" class="estado_bitacora_edit cerrado" <?php if("CERRADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Cierre</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_cerrado" type="text" class="fec_edit_fecha_cerrado input_edit_cerrado form-control" id="inputFechaCerrado" value="<?= $row['fec_cierre']; ?>" placeholder="<?= date("Y-m-d H:i") ?>">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <input name="fecha_actual" type="text" value="<?= date("Y-m-d H:i") ?>" hidden>
                            <input name="id_bitacora" type="text" class="id_bitacora" hidden value="<?= $id ?>">
                        </div>
                        <div class="row modal-footer">
                            <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                            <input class="btn btn-primary" type="submit" value="Actualizar">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
<script>
    
    $(document).ready(function() {
        $('.selectpicker_edit').selectpicker();
        
        $('select.sl_estado_edit').on('changed.bs.select', function(){
            $('.estado_bitacora_edit').hide();
            $('#edit_fec_' + $(this).val()).show();
        });
        
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        
        $('.fec_edit_fecha_apertura').daterangepicker({
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

        $('.fec_edit_fecha_apertura').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_fecha_apertura').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_fecha_apertura').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_fecha_apertura').val('');
        });
        
        $('.fec_edit_fecha_re_asignado').daterangepicker({
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

        $('.fec_edit_fecha_re_asignado').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_fecha_re_asignado').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_fecha_re_asignado').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_fecha_re_asignado').val('');
        });
        
        $('.fec_edit_fecha_solucionado').daterangepicker({
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

        $('.fec_edit_fecha_solucionado').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_fecha_solucionado').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_fecha_solucionado').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_fecha_solucionado').val('');
        });
        
        $('.fec_edit_fecha_cerrado').daterangepicker({
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

        $('.fec_edit_fecha_cerrado').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_fecha_cerrado').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_fecha_cerrado').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_fecha_cerrado').val('');
        });
        
    });    
    
    $('#edit_fecha_bitacora').submit(function( event ) {
            var select = $('select.sl_estado_edit').val();
            if($(".fec_edit_"+select).val() == ""){
                swal({
                    title: "",
                    text: "Favor de llenar el campo de fecha "+select,
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
            }else{
                var datos = $(this).serialize();
                swal({
                    title: 'Deseas editar esta bitácora?',
                    text: "Recuerda haber llenado todo correctamente !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1b9cdd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                    showLoaderOnConfirm: false,
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                }).then(function() {
                    $.ajax({
                        type: "POST",
                        url: "ajax/action_class/update/update_fecha_bitacora.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se actualizo la bitácora con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_edit_fecha_bitacora').modal('toggle');
                                }, 600);
                                tabla_bitacora_gestor.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al editar la bitácora, informalo al administrador y/o desarrollador",
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
                        text: "No se edito la bitácora",
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