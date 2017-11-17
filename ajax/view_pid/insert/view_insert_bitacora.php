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
    require_once ('../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object_permisos = new pid_permisos();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['crea_bita'] != "true"){
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
            <h3 class="modal-title">Insertar Bitácora</h3>
        </div>
        <div class="modal-body">
            <form id="insert_bitacora" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-3">
                            <label>Fecha Bitácora</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fec_bitacora" type="text" class="fec_bitacora form-control" id="inputFechaBitacora" placeholder="1999-01-01">
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Tipo Impacto</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-life-ring"></i></span>
                                <select name="sl_impacto" id="inputImpacto" class="sl_impacto selectpicker form-control show-tick" data-header="Tipo Impacto">
                                    <option value="" disabled selected>Selecciona Aqui</option>
                                    <option value="IMPACTO MUY ALTO">IMPACTO MUY ALTO</option>
                                    <option value="IMPACTO ALTO">IMPACTO ALTO</option>
                                    <option value="IMPACTO MEDIO ALTO">IMPACTO MEDIO ALTO</option>
                                    <option value="IMPACTO MEDIO">IMPACTO MEDIO</option>
                                    <option value="IMPACTO BAJO">IMPACTO BAJO</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Usuarios Afectados</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input name="num_afectados" type="text" class="num_afectados form-control" id="inputUafectados" placeholder="XXX" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Cantidad de Correos</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input name="num_correos" type="text" class="num_correos form-control" id="inputNumCorreo" placeholder="XXX" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Aplicativo Afectado</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_afectado" id="inputAplAfectado" class="sl_afectado selectpicker form-control show-tick" data-header="Aplicativo" data-live-search="true">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Cargando...</b>" value="" selected>Selecciona Aqui</option>
                                </select>
                            </div>
                        </section>
                        <!-- <section class="col col-2">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <div class="btn-group">
                                <a data-toggle="modal" data-target="#modal_ins_aplicativo" class="agregar_aplicativo btn btn-primary btn-sm" style="color:white" title="Agregar Nuevo Aplicativo"><b><i class="fa fa-plus" aria-hidden="true"></i> Agregar</b></a>
                            </div>
                        </section> -->
                        <section class="col col-6">
                            <label>Grupo Asignado</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_asignado" id="inputGruAsignado" class="sl_asignado selectpicker form-control show-tick" data-header="Grupo Asignado" data-live-search="true">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Cargando...</b>" value="" selected>Selecciona Aqui</option>
                                </select>
                            </div>
                        </section>
                        <!-- <section class="col col-2">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <div class="btn-group">
                                <a data-toggle="modal" data-target="#modal_ins_grupo_asignado" class="agregar_grupo_asignado btn btn-warning btn-sm" style="color:white" title="Agregar Nuevo Grupo Asignado"><b><i class="fa fa-plus" aria-hidden="true"></i> Agregar</b></a>
                            </div>
                        </section> -->
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Titulo Bitácora</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_bitacora" type="text" class="txt_bitacora form-control" id="inputTiBitacora" placeholder="Titulo de la bitacora">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Responsable</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-wrench"></i></span>
                                <input name="txt_responsable" type="text" class="txt_responsable form-control" id="inputResponsable" placeholder="Responsable del Masivo">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Número de Caso</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_caso" type="text" class="num_caso form-control" id="inputNumCaso" placeholder="INCXXXXXXXXXXX">
                            </div>
                        </section>
                        <section class="col-md-4">
                            <div>
                                <label>Fecha Recepción de Correo</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                    <input name="fec_recepcion" type="text" class="fec_recepcion form-control" id="inputFechaRecepcion" placeholder="<?= date("Y-m-d H:i") ?>">
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col-md-6">
                            <label>Estado de Bitácora</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stack-exchange"></i></span>
                                <select name="sl_estado" id="inputEstado" class="sl_estado selectpicker form-control show-tick" data-header="Estado">
                                    <option value="asignado" selected>ASIGNADO</option>
                                </select>
                            </div>
                        </section>
                        <section class="col-md-6">
                            <div>
                                <label>Fecha de Asignacion</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                    <input name="fec_apertura" type="text" class="fec_apertura input_asignado form-control" id="inputFechaApertura" placeholder="<?= date("Y-m-d H:i") ?>">
                                </div>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <textarea name="contenido" class="insertar_bitacora form-control"></textarea>
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
    $('textarea.insertar_bitacora').tinymce({
        extended_valid_elements: "table[class=table table-bordered table-striped],ul[class=custom-bullet],img[class=img-responsive center-block|!src|border:0|alt|title|width|height|style]",
        theme: "modern",
        height: 300,
        font_formats: "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
        fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
        plugins: [
            "advlist autolink lists link image charmap print preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime media nonbreaking save table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager"
        ],
        toolbar1: "responsivefilemanager undo redo | formatselect styleselect fontsizeselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | image table | print preview media | emoticons ",
        style_formats: [
            {title: 'Open Sans', inline: 'span', styles: { 'font-family':'Open Sans'}},
            {title: 'Arial', inline: 'span', styles: { 'font-family':'arial'}},
            {title: 'Book Antiqua', inline: 'span', styles: { 'font-family':'book antiqua'}},
            {title: 'Comic Sans MS', inline: 'span', styles: { 'font-family':'comic sans ms,sans-serif'}},
            {title: 'Courier New', inline: 'span', styles: { 'font-family':'courier new,courier'}},
            {title: 'Georgia', inline: 'span', styles: { 'font-family':'georgia,palatino'}},
            {title: 'Helvetica', inline: 'span', styles: { 'font-family':'helvetica'}},
            {title: 'Impact', inline: 'span', styles: { 'font-family':'impact,chicago'}},
            {title: 'Symbol', inline: 'span', styles: { 'font-family':'symbol'}},
            {title: 'Tahoma', inline: 'span', styles: { 'font-family':'tahoma'}},
            {title: 'Terminal', inline: 'span', styles: { 'font-family':'terminal,monaco'}},
            {title: 'Times New Roman', inline: 'span', styles: { 'font-family':'times new roman,times'}},
            {title: 'Verdana', inline: 'span', styles: { 'font-family':'Verdana'}}
        ],
        menubar: false,
        fullscreen_new_window : true,
        toolbar_items_size: 'small',
        image_advtab: true,
        fix_list_elements : true,
        external_filemanager_path:"assets/js/tinymce/filemanager/",
        filemanager_title:"Gestor de Archivos - PID - CLARO AN" ,
        external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
    });
    
    /* Load de aplicativos y Grupo Asignado */
    $(".sl_afectado").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php");
    $(".sl_asignado").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_grupos.php");
    /* Fin de load de aplicativos y Grupo Asignado */
    
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });
    
    setTimeout(function(){
        $('.sl_afectado').selectpicker('refresh');
        $('.sl_asignado').selectpicker('refresh');
    },1000);
    
    /* Modal Insertar Aplicativo */
    $('.agregar_aplicativo').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_aplicativo_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
            },
            url: 'ajax/view_pid/insert/view_insert_aplicativo_caja.php',
            success:function(data){
                $('.ins_aplicativo_body').html(data);
            }
        });
    });
    $('#modal_ins_aplicativo').on('hidden.bs.modal', function () {
        $(document.body).addClass('modal-open');
    });
    /* Fin Modal Insertar Aplicativo */
    
    /* Modal Insertar Grupo Asignado */
    $('.agregar_grupo_asignado').click(function () {
        $.ajax({
            beforeSend: function(){
                $('.ins_grupo_asignado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
            },
            url: 'ajax/view_pid/insert/view_insert_grupo_caja.php',
            success:function(data){
                $('.ins_grupo_asignado_body').html(data);
            }
        });
    });
    $('#modal_ins_grupo_asignado').on('hidden.bs.modal', function () {
        $(document.body).addClass('modal-open');
    });
    /* Fin Modal Insertar Grupo Asignado */
        
    $('.fec_bitacora').daterangepicker({
        timePicker: false,
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

    $('.fec_bitacora').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_bitacora').val(startDate.format('YYYY-MM-DD'));
    });

    $('.fec_bitacora').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_bitacora').val('');
    });
    
    $('.fec_recepcion').daterangepicker({
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

    $('.fec_recepcion').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_recepcion').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fec_recepcion').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_recepcion').val('');
    });
    
    $('.fec_apertura').daterangepicker({
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

    $('.fec_apertura').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_apertura').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fec_apertura').on('cancel.daterangepicker', function (ev, picker) {
        $('.fec_apertura').val('');
    });
    
    $('#insert_bitacora').submit(function( event ) {
        if ($(".fec_bitacora").val() == '' || $("select.sl_impacto").val() == null || $(".num_afectados").val() == '' || $(".num_correos").val() == '' || $("select.sl_asignado").val() == null || $("select.sl_afectado").val() == null || $(".txt_bitacora").val() == '' || $(".txt_responsable").val() == '' || $(".num_caso").val() == '' || $(".fec_recepcion").val() == '' || $("select.sl_estado").val() == null || $(".input_asignado").val() == '' || $(".insertar_bitacora").val() == '') {
                swal({
                    title: "",
                    text: "Favor de completar los campos",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
                return false;
                }else{
                  if($("select.sl_impacto").val() == 'IMPACTO MUY ALTO'){
                    if($(".num_afectados").val() >= 500 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas agregar esta bitácora?',
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
                                url: "ajax/action_class/insert/insert_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se agrego la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al insertar bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ninguna bitácora",
                                type: "warning",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                          }
                        });
                      }else{
                        swal({
                            title: "",
                            text: "Favor de agregar correctamente los usuarios afectados",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                      }
                  }
                  if($("select.sl_impacto").val() == 'IMPACTO ALTO'){
                    if($(".num_afectados").val() >= 100 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas agregar esta bitácora?',
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
                                url: "ajax/action_class/insert/insert_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se agrego la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al insertar bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ninguna bitácora",
                                type: "warning",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                          }
                        });
                      }else{
                        swal({
                            title: "",
                            text: "Favor de agregar correctamente los usuarios afectados",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                      }
                  }
                  if($("select.sl_impacto").val() == 'IMPACTO MEDIO ALTO'){
                    if($(".num_afectados").val() <= 100 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas agregar esta bitácora?',
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
                                url: "ajax/action_class/insert/insert_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se agrego la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al insertar bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ninguna bitácora",
                                type: "warning",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                          }
                        });
                      }else{
                        swal({
                            title: "",
                            text: "Favor de agregar correctamente los usuarios afectados",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                      }
                  }
                  if($("select.sl_impacto").val() == 'IMPACTO MEDIO'){
                    if($(".num_afectados").val() <= 20 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas agregar esta bitácora?',
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
                                url: "ajax/action_class/insert/insert_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se agrego la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al insertar bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ninguna bitácora",
                                type: "warning",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                          }
                        });
                      }else{
                        swal({
                            title: "",
                            text: "Favor de agregar correctamente los usuarios afectados",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                      }
                  }
                  if($("select.sl_impacto").val() == 'IMPACTO BAJO'){
                    if($(".num_afectados").val() == 1 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas agregar esta bitácora?',
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
                                url: "ajax/action_class/insert/insert_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se agrego la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al insertar bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ninguna bitácora",
                                type: "warning",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                          }
                        });
                      }else{
                        swal({
                            title: "",
                            text: "Favor de agregar correctamente los usuarios afectados",
                            type: "warning",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                      }
                  }
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