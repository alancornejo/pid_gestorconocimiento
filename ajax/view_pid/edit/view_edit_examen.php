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
    require_once ('../../../data/pid_examen.php');
    require_once ('../../../data/pid_access.php');
    $id_examen = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new examen_usuario();
    $object_permisos = new pid_permisos();
    $result = $object->view_examen($id_examen);
    $row = $result->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_exam'] != "true"){
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
            <h3 class="modal-title">Editar Examen [ID]</h3>
        </div>
        <div class="modal-body">
            <form id="edit_examen" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-7">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_titulo" type="text" class="txt_titulo form-control" id="inputIExamen" placeholder="Titulo de Examen" value="<?= $row['titulo_examen'] ?>">
                                <input name="id_examen" type="text" value="<?= $id_examen ?>" hidden>
                            </div>
                        </section>
                        <section class="col col-5">
                            <label>Tiempo de Duracion</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input name="num_duracion" type="text" class="num_duracion form-control" id="inputTExamen" placeholder="minutos" value="<?= ($row['tiempo_examen'])/60 ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">                                
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Fecha Inicio</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_inicio" type="text" class="fec_inicio_edit form-control" id="inputInExamen" placeholder="<?= date("Y-m-d H:i:s") ?>" value="<?= $row['fecha_inicio'] ?>">                            
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Fecha Revisión</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_rev" type="text" class="fec_rev_edit form-control" id="inputFExamen" placeholder="<?= date("Y-m-d H:i:s") ?>" value="<?= $row['fecha_revision'] ?>">                            
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Habilitar en Portal</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <select name="sl_portal" id="inputPortal" class="sl_portal_edit selectpicker_edit form-control show-tick" data-header="Habilitar en Portal">
                                    <option value="1" <?php if($row['ver_portal'] == "1"){ echo "selected"; } ?>>Si</option>
                                    <option value="0" <?php if($row['ver_portal'] == "0"){ echo "selected"; } ?>>No</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Cantidad Preguntas</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_pregunta" type="text" class="num_pregunta_edit form-control" id="inputCPregunta" value="<?= $row['num_preguntas'] ?>" placeholder="# Preguntas" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Cantidad Faciles</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_facil" type="text" class="num_facil_edit form-control" id="inputCFacil" value="<?= $row['num_facil'] ?>" placeholder="# Faciles" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Cantidad Dificiles</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_dificil" type="text" class="num_dificil_edit form-control" id="inputCDificil" value="<?= $row['num_dificil'] ?>" placeholder="# Dificiles" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                    </div>
                    <div class="row modal-footer">
                        <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                        <input class="btn btn-primary" type="submit" value="Agregar">
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
<script>
    
    $(document).ready(function() {
        $('.selectpicker_edit').selectpicker();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });
    
    $('.fec_inicio_edit').daterangepicker({
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

    $('.fec_inicio_edit').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_inicio_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fec_inicio_edit').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_inicio_edit').val('');
    });
    
    $('.fec_rev_edit').daterangepicker({
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

    $('.fec_rev_edit').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_rev_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fec_rev_edit').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_rev_edit').val('');
    });
    
    $('#edit_examen').submit(function( event ) {
        var num_pregunta_edit = parseFloat($('input.num_pregunta_edit').val());
        var num_facil_edit = parseFloat($('input.num_facil_edit').val());
        var num_dificil_edit = parseFloat($('input.num_dificil_edit').val());
        if ($('input.num_pregunta_edit').val() == '' || $('input.num_facil_edit').val() == '' || $('input.num_dificil_edit').val() == '' || $('.fec_inicio_edit').val() == '' || $('.fec_rev_edit').val() == '' || $('select.sl_portal_edit').val() == null) {
            swal({
                title: "",
                text: "Favor de completar los campos",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
            }else if(num_facil_edit + num_dificil_edit != num_pregunta_edit){
            swal({
                title: "",
                text: "Ingresa bien el número de faciles o dificiles",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
        }else{
        var datos = $(this).serialize();
            swal({
                title: 'Deseas editar este examen',
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
                    url: "ajax/action_class/examen/edit_examen.php",
                    data: datos,
                    success: function(data) {
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se actualizo el examen con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    setTimeout(function(){
                                        $(document.body).css('padding-right','');
                                    },200);
                                });
                                $('#modal_edit_examen').modal('toggle');
                            }, 600);
                            tabla_examen_gestor.ajax.reload( null, false );
                        }else{
                            swal({
                                title: "",
                                text: "Error al editar el examen, informalo al administrador y/o desarrollador",
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
                    text: "No se edito el examen",
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