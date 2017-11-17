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
    $id_asignado = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new examen_usuario();
    $object_permisos = new pid_permisos();
    $result_user = $object->view_user();
    $result_exam = $object->view_id_examen_asig();
    $result_asig = $object->view_asignado($id_asignado);
    $row = $result_asig->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_asig_exam'] != "true"){
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
          <h3 class="modal-title">Editar Examen a Usuario</h3>
        </div>
        <div class="modal-body">
            <form id="edit_asignado" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-7">
                            <label>Usuario</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user-plus"></i></span>
                                <select name="sl_usuario_edit" id="inputUsuarioAsignadoEdit" class="sl_usuario_edit selectpicker_edit form-control" disabled>
                                    <?php while ($row_user = $result_user->fetch_assoc()){ ?>
                                    <option value="<?= $row_user['id_user'] ?>" <?php if($row_user['id_user'] == $row['id_user']){ echo "selected"; } ?>><?= utf8_encode($row_user['nom_user']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </section>
                        <section class="col col-5">
                            <label>Examen</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                <select name="sl_examen_edit" id="inputExamenAsignadoEdit" class="sl_examen_edit selectpicker_edit form-control" disabled>
                                    <?php while ($row_exam = $result_exam->fetch_assoc()){ ?>
                                    <option value="<?= $row_exam['id_examen'] ?>" <?php if($row_exam['id_examen'] == $row['id_examen']){ echo "selected"; } ?>><?= $row_exam['titulo_examen'] ?></option>
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
                                <input name="fec_asi_edit" type="text" class="fec_asi_edit form-control" id="inputFecAsignadoEdit" value="<?= date("Y-m-d H:i:s", strtotime($row['fecha_examen'])) ?>">
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Fecha Término</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_ter_edit" type="text" class="fec_ter_edit form-control" id="inputFecTerminoEdit" value="<?= date("Y-m-d H:i:s", strtotime($row['fecha_termino'])) ?>">
                                <input type="text" name="id_asignado" value="<?= $id_asignado ?>" hidden>
                            </div>
                        </section>
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
        
        $('.fec_asi_edit').daterangepicker({
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

        $('.fec_asi_edit').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_asi_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });
        
        $('.fec_asi_edit').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_asi_edit').val('');
        });
        
        $('.fec_ter_edit').daterangepicker({
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

        $('.fec_ter_edit').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_ter_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });
        
        $('.fec_ter_edit').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_ter_edit').val('');
        });
        
        $('#edit_asignado').submit(function( event ) {
                var datos = $(this).serialize();
                console.log(datos);
                swal({
                    title: 'Deseas editar esta asignacion?',
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
                        url: "ajax/action_class/examen/edit_asignado.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se actualizo al usuario asignado con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_edit_asignado').modal('toggle');
                                }, 600);
                                tabla_examenes_asignados.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al editar el usuario asignado, informalo al administrador y/o desarrollador",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }
                        }
                    });
                }, function(dismiss) {
                  if (dismiss === 'cancel') {
                    swal("PID - CLARO AN", "No se edito ninguna asignacion", "error");
                        swal({
                        title: "",
                        text: "No se edito la asignacion",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                  }
                });
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