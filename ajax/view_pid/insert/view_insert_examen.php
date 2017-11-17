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
    $object_permisos = new pid_permisos();
    $id_user = $_SESSION['id_user_apl'];
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['crea_exam'] != "true"){
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
            <h3 class="modal-title">Insertar Examen [ID]</h3>
          </div>
          <div class="modal-body">
            <form id="insert_examen" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-7">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_titulo" type="text" class="txt_titulo form-control" id="inputIExamen" placeholder="Titulo de Examen">
                            </div>
                        </section>
                        <section class="col col-5">
                            <label>Tiempo de Duración</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-clock-o"></i></span>
                                <input name="num_duracion" type="text" class="num_duracion form-control" id="inputTExamen" placeholder="minutos" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Fecha Inicio</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_inicio" type="text" class="fec_inicio form-control" id="inputInExamen" placeholder="<?= date("Y-m-d  H:i:s") ?>" value="<?= date("Y-m-d H:i").":00" ?>">                            
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Fecha Revisión</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_rev" type="text" class="fec_rev form-control" id="inputFExamen" placeholder="<?= date("Y-m-d H:i:s") ?>">                            
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Habilitar en Portal</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-book"></i></span>
                                <select name="sl_portal" id="inputPortal" class="sl_portal selectpicker form-control show-tick" data-header="Habilitar en Portal">
                                    <option data-content="Selecciona Aqui" value="" selected>Selecciona Aqui</option>
                                    <option value="1">Si</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Cantidad Preguntas</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_pregunta" type="text" class="num_pregunta form-control" id="inputCPregunta" placeholder="# Preguntas" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Cantidad Faciles</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_facil" type="text" class="num_facil form-control" id="inputCFacil" placeholder="# Faciles" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Cantidad Dificiles</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_dificil" type="text" class="num_dificil form-control" id="inputCDificil" placeholder="# Dificiles" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
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
        $('.selectpicker').selectpicker();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });
    
    $('.fec_inicio').daterangepicker({
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

    $('.fec_inicio').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_inicio').val(startDate.format('YYYY-MM-DD'));
    });

    $('.fec_inicio').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_inicio').val('');
    });
    
    $('.fec_rev').daterangepicker({
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

    $('.fec_rev').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_rev').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fec_rev').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_rev').val('');
    });
    
    $('#insert_examen').submit(function( event ) {
        var num_pregunta = parseFloat($('input.num_pregunta').val());
        var num_facil = parseFloat($('input.num_facil').val());
        var num_dificil = parseFloat($('input.num_dificil').val());
        if ($(".txt_titulo").val() == '' || $(".num_duracion").val() == '' || $('input.num_pregunta').val() == '' || $('input.num_facil').val() == '' || $('input.num_dificil').val() == '' || $('.fec_inicio').val() == '' || $('.fec_rev').val() == '' || $('select.sl_portal').val() == null) {
            swal({
                title: "",
                text: "Favor de completar los campos",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
            }else if(num_facil + num_dificil != num_pregunta){
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
                    title: 'Deseas agregar este examen',
                    text: "Recuerda haber llenado todo correctamente !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1b9cdd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-plus"></i> Agregar',
                    showLoaderOnConfirm: false,
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                }).then(function() {
                    $.ajax({
                        type: "POST",
                        url: "ajax/action_class/examen/insert_examen.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se agrego el examen con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_ins_examen').modal('toggle');
                                }, 600);
                                tabla_examen_gestor.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al insertar el examen, informalo al administrador y/o desarrollador",
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
                        text: "No se agrego ningun examen",
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