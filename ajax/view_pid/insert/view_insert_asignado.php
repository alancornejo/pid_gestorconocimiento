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
    require_once ("../../../data/pid_examen.php");
    require_once ('../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new examen_usuario();
    $object_permisos = new pid_permisos();
    $result_user = $object->view_user_examen();
    $result_exam = $object->view_id_examen_asig();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['asig_exam'] != "true"){
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
              <h3 class="modal-title">Asignar Examen a Usuario</h3>
            </div>
            <div class="modal-body">
                <form id="insert_asignado" class="sky-form">
                    <fieldset>
                        <div class="row">
                            <section class="col col-7">
                                <label>Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                    <select name="sl_usuario[]" id="inputUsuarioAsignado" class="sl_usuario selectpicker form-control" data-width="350px" data-live-search="true" data-selected-text-format="count" data-actions-box="true" data-header="Usuarios" multiple>
                                        <?php while ($row_user = $result_user->fetch_assoc()){ ?>
                                        <option data-icon="fa fa-user" value="<?= $row_user['id_user'] ?>"><?= utf8_encode($row_user['nom_user']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </section>
                            <section class="col col-5">
                                <label>Examen</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                    <select name="sl_examen" id="inputExamenAsignado" class="sl_examen selectpicker form-control" data-header="Examen">
                                        <option value="" disabled selected>Selecciona Aqui</option>
                                        <?php while ($row_exam = $result_exam->fetch_assoc()){ ?>
                                        <option value="<?= $row_exam['id_examen'] ?>"><?= $row_exam['titulo_examen'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-6">
                                <label>Fecha Asignada</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="fec_asi" type="text" class="fec_asi form-control" id="inputFecAsignado" placeholder="<?= date("d/m/Y H:i:s") ?>">
                                </div>
                            </section>
                            <section class="col col-6">
                                <label>Fecha Término</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="fec_ter" type="text" class="fec_ter form-control" id="inputFecTermino" placeholder="<?= date("d/m/Y H:i:s") ?>">
                                </div>
                            </section>
                        </div>
                        <div class="row modal-footer">
                            <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                            <input class="btn btn-primary" type="submit" value="Asignar">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
<script>
    $(document).ready(function() {
        
        $('.selectpicker').selectpicker();
        
        $('.fec_asi').daterangepicker({
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

        $('.fec_asi').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_asi').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });
        
        $('.fec_asi').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_asi').val('');
        });
        
        $('.fec_ter').daterangepicker({
            timePicker: true,
            timePicker24Hour: false,
            singleDatePicker: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoUpdateInput: false,
            opens: "left",
            locale: {
                cancelLabel: 'Limpiar',
                applyLabel: 'Aplicar',
                format: 'YYYY-MM-DD h:mm A'
            }
        });

        $('.fec_ter').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_ter').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });
        
        $('.fec_ter').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_ter').val('');
        });
            
        $('#insert_asignado').submit(function( event ) {
            if ($("select.sl_usuario").val() == null || $("select.sl_examen").val() == null || $(".fec_asi").val() == "" || $(".fec_ter").val() == "") {
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
                        title: 'Deseas asignar este examen al usuario?',
                        text: "Recuerda haber llenado todo correctamente !",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#1b9cdd',
                        cancelButtonColor: '#d33',
                        confirmButtonText: '<i class="fa fa-plus"></i> Asignar',
                        showLoaderOnConfirm: false,
                        cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                    }).then(function() {
                        $.ajax({
                            type: "POST",
                            url: "ajax/action_class/examen/insert_asignado.php",
                            data: datos,
                            success: function(data) {
                                if(data == "true"){
                                    setTimeout(function(){     
                                        swal({
                                            title: "",
                                            text: "Se asigno el examen con exito",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: true
                                        }).then(function() {
                                            setTimeout(function(){
                                                $(document.body).css('padding-right','');
                                            },200);
                                        });
                                        $('#modal_ins_asignado').modal('toggle');
                                    }, 600);
                                    tabla_examenes_asignados.ajax.reload( null, false );
                                }else{
                                    swal({
                                        title: "",
                                        text: "Error al asignar a usuario, informalo al administrador y/o desarrollador",
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
                            text: "No se agrego ninguna pregunta",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                      }
                    });
                }
            event.preventDefault();
        });    
            
    });
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>