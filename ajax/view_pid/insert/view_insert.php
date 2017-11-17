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
    $_SESSION['filemanager_categoria'] = "kdb";
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $result_cat = $object->view_category();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['crea_cono'] != "true"){
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
          <h3 class="modal-title">Insertar Conocimiento</h3>
        </div>
        <div class="modal-body">
            <form id="insert_conocimiento" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-10">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_titulo_conocimiento" type="text" class="txt_titulo_conocimiento form-control" id="inputTituloConocimiento" placeholder="Titulo">
                            </div>
                        </section>
                        <section class="col col-2">
                            <label>N°ID</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="id_atu_conocimiento" type="text" class="id_atu_conocimiento form-control" id="inputIDConocimiento" placeholder="XXX"maxlength="3" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Fecha Creación</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="id_fecha_conocimiento" id="inputFechaCreacionConocimiento" type="text" class="id_fecha_conocimiento form-control" placeholder="<?= date("Y-m-d") ?>">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Nivel 1 (Derivaciones/Incidencias)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_inc_dev" id="inputIncDevConocimiento" class="sl_inc_dev form-control selectpicker show-tick" data-header="Aplicativo" data-live-search="true" data-title="Aplicativo">
                                    <option value="" selected>Selecciona Aqui</option>
                                    <option value="0">Incidencia</option>
                                    <option value="1">Derivaciones</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Nivel 2 (Aplicativo)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_aplicativo_conocimiento" id="inputAplicativoConocimiento" class="sl_aplicativo_conocimiento form-control selectpicker show-tick" data-header="Aplicativo" data-live-search="true" data-title="Aplicativo">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Esperando...</b>" value="" selected>Selecciona Aqui</option>
                                </select>
                            </div>
                        </section>
                        <!-- <section class="col col-2">
                            <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                            <div class="btn-group">
                                <a data-toggle="modal" data-target="#modal_ins_aplicativo" class="agregar_aplicativo btn btn-primary btn-sm" style="color:white" title="Agregar Nuevo Aplicativo"><b><i class="fa fa-plus" aria-hidden="true"></i> Agregar</b></a>
                            </div>
                        </section> -->
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Nivel 3 (Flujo)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_flujo_conocimiento" id="inputFlujoConocimiento" class="sl_flujo_conocimiento form-control selectpicker show-tick" data-header="Nivel 3 (Flujo)" data-live-search="true" data-title="Nivel 3 (Flujo)">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Esperando...</b>" value="" selected>Selecciona Aqui</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Nivel 4 (Grupo Responsable)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_grupo_conocimiento" id="inputGrupoConocimiento" class="sl_grupo_conocimiento form-control selectpicker show-tick" data-header="Nivel 4 (Grupo Responsable)" data-live-search="true" data-title="Nivel 4 (Grupo Responsable)">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Esperando...</b>" value="" selected>Selecciona Aqui</option>
                                </select>                            
                            </div>
                        </section>
                        <section class="col col-4 hide_area_negocio">
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning" style="height: 35px;">
                                <p style="margin-top: -8px;font-size:11px"><i class="fa fa-exclamation-triangle text-warning"></i> Se hablita con Áreas de Negocio.</p>
                            </div>
                        </section>
                        <section class="col col-4 show_area_negocio" hidden>
                            <label>Usuario Resolutor</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <select name="sl_resolutor_conocimiento" id="inputResolutorConocimiento" class="sl_resolutor_conocimiento form-control selectpicker show-tick" data-header="Usuario Resolutor" data-live-search="true" data-title="Usuario Resolutor">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Cargando...</b>" value="" selected>Selecciona Aqui</option>
                                </select> 
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Estado Publicacion</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                <select name="sl_publicado_conocimiento" id="inputPublicadoConocimiento" class="sl_publicado_conocimiento selectpicker form-control show-tick" data-header="Estado Publicacion">
                                    <option value="1" selected>Publicado</option>
                                    <option value="0">No Publicado</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Visualizar Cliente</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-eye"></i></span>
                                <select name="sl_cliente_conocimiento" id="inputClienteConocimiento" class="sl_cliente_conocimiento selectpicker form-control show-tick" data-header="Visualiza Cliente">
                                    <option value="1" selected>Visualizar</option>
                                    <option value="0">No Visualizar</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Dirigido a : </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                                <select name="sl_tipo_servicio" id="inputTipoServicio" class="sl_tipo_servicio selectpicker form-control show-tick" data-header="Dirigido a : ">
                                    <option value="0" selected>Aplicaciones</option>
                                    <option value="1">Biométrico</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="co col-12">
                            <textarea name="txt_contenido_conocimiento" class="txt_contenido_conocimiento editor_conocimiento form-control" rows="3"></textarea>
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
    
    /* Load de aplicativos */
    $(".sl_aplicativo_conocimiento").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php");
    /* Fin de load de aplicativos */
    
    $('.selectpicker').selectpicker();
    
    setTimeout(function(){
        $('.sl_aplicativo_conocimiento').selectpicker('refresh');
    },1000);
    
    $('.sl_aplicativo_conocimiento').change(function(){
        var id_apli = $('#inputAplicativoConocimiento').val();
        $(".sl_flujo_conocimiento").selectpicker('destroy').load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_categorias.php?id_apli="+id_apli);
        $(".sl_grupo_conocimiento").selectpicker('destroy').load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_grupos.php?id_apli="+id_apli);
        setTimeout(function(){
            $('.sl_flujo_conocimiento').selectpicker('refresh');
            $('.sl_grupo_conocimiento').selectpicker('refresh');
        },500);
    });
    
    $('.sl_grupo_conocimiento').change(function(){
        var id_grupo = $('#inputGrupoConocimiento').val();
        if(id_grupo == "4"){
            $('.hide_area_negocio').fadeOut(function(){
                $('.show_area_negocio').fadeIn(function(){
                    $(".sl_resolutor_conocimiento").selectpicker('destroy').load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_resolutor.php");
                    setTimeout(function(){
                        $('.sl_resolutor_conocimiento').selectpicker('refresh');
                    },500);
                });
            });
        
        }else{
            $('.show_area_negocio').fadeOut(function(){
                $('.hide_area_negocio').fadeIn();
            });
        }
    });
    
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
    
    
    $(document).ready(function () {
        $('textarea.editor_conocimiento').tinymce({
            extended_valid_elements: "table[class=table table-bordered table-striped],ul[class=custom-bullet],img[class=img-responsive center-block|!src|border:0|alt|title|width|height|style]",
            theme: "modern",
            height: 300,
            font_formats: "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager smileys"
            ],
            auto_convert_smileys: true,
            toolbar1: "responsivefilemanager undo redo | formatselect styleselect fontsizeselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | image table | print preview media | smileys",
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
            menubar: true,
            fullscreen_new_window : true,
            toolbar_items_size: 'small',
            image_advtab: true,
            fix_list_elements : true,
            external_filemanager_path: "assets/js/tinymce/filemanager/",
            filemanager_title: "Gestor de Archivos - PID - CLARO AN" ,
            external_plugins: { filemanager: "filemanager/plugin.min.js"},
        });
        
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        
        $('.id_fecha_conocimiento').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoUpdateInput: false,
            opens: "right",
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        
        $('.id_fecha_conocimiento').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.id_fecha_conocimiento').val(startDate.format('YYYY-MM-DD'));
        });
        
        $('#insert_conocimiento').submit(function( event ) {
            var id_grupo = $('#inputGrupoConocimiento').val();
            if ($(".txt_titulo_conocimiento").val() == '' || $(".id_atu_conocimiento").val() == '' || $(".id_fecha_conocimiento").val() == '' || $(".txt_contenido_conocimiento").val() == '' || $("select.sl_inc_dev").val() == null || $("select.sl_aplicativo_conocimiento").val() == null || $("select.sl_flujo_conocimiento").val() == null || $("select.sl_grupo_conocimiento").val() == null) {
                if(id_grupo == "4" && $("select.sl_resolutor_conocimiento").val() == null){
                    swal({
                        title: "",
                        text: "Favor de completar los campos",
                        type: "warning",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }else{
                    swal({
                        title: "",
                        text: "Favor de completar los campos",
                        type: "warning",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                }
                return false;
               }else{
                var datos = $(this).serialize();
                swal({
                    title: 'Deseas agregar este conocimiento?',
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
                        url: "ajax/action_class/insert/insert_conocimiento.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se agrego el conocimiento con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_ins_conocimiento').modal('toggle');
                                }, 600);
                                tabla_kdb_gestor.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al insertar el conocimiento, informalo al administrador y/o desarrollador",
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
                        text: "No se agrego ningun conocimiento",
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