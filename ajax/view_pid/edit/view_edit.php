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
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $result_apl = $object->view_category();
    $result_view = $object->view_contenido($id);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    $row = $result_view->fetch_assoc();
    
    if($row_permisos['edit_cono'] != "true"){
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
          <h3 class="modal-title">Editar Conocimiento</h3>
        </div>
        <div class="modal-body">
            <form id="edit_conocimiento" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-10">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_titulo_conocimiento_edit" type="text" class="txt_titulo_conocimiento_edit form-control" id="inputTituloConocimientoEdit" value="<?= $row['titulo'] ?>">
                            </div>
                        </section>
                        <section class="col col-2">
                            <label>N°ID</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="id_atu_conocimiento_edit" type="text" class="id_atu_conocimiento_edit form-control" id="inputIDConocimientoEdit" maxlength="3" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8" value="<?= $row['id_atu'] ?>">
                                <input name="id_tabla_conocimiento_edit" type="text" class="id_tabla_conocimiento_edit" hidden value="<?= $id ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Fecha Actualización</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="id_fecha_editor_conocimiento_edit" id="inputFechaEditorConocimientoEdit" type="text" class="id_fecha_editor_conocimiento_edit form-control" value="<?= $row['fecha_actualizacion']; ?>">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Nivel 1 (Derivaciones/Incidencias)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_inc_dev_edit" id="inputIncDevConocimientoEdit" class="sl_inc_dev_edit form-control selectpicker_edit show-tick" data-header="Aplicativo" data-live-search="true" data-title="Aplicativo">
                                    <option value="0" <?php if($row['id_tipo'] == "0"){ echo "selected"; } ?>>Incidencia</option>
                                    <option value="1" <?php if($row['id_tipo'] == "1"){ echo "selected"; } ?>>Derivaciones</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Nivel 2 (Aplicativo)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_aplicativo_conocimiento_edit" id="inputAplicativoConocimientoEdit" class="sl_aplicativo_conocimiento_edit selectpicker_edit form-control show-tick" data-header="Aplicativo" data-live-search="true" data-title="Aplicativo">
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
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Nivel 3 (Flujo)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_flujo_conocimiento_edit" id="inputFlujoConocimientoEdit" class="sl_flujo_conocimiento_edit form-control selectpicker_edit show-tick" data-header="Nivel 3 (Flujo)" data-live-search="true" data-title="Nivel 3 (Flujo)">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Esperando...</b>" value="" selected>Selecciona Aqui</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Nivel 4 (Grupo Responsable)</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_grupo_conocimiento_edit" id="inputGrupoConocimientoEdit" class="sl_grupo_conocimiento_edit form-control selectpicker_edit show-tick" data-header="Nivel 4 (Grupo Responsable)" data-live-search="true" data-title="Nivel 4 (Grupo Responsable)">
                                    <option data-content="<img style='width:16px;height:16px' src='assets/images/loading.gif'><b> Esperando...</b>" value="" selected>Selecciona Aqui</option>
                                </select>                            
                            </div>
                        </section>
                        <section class="col col-4 hide_area_negocio" <?php if($row['id_grupo'] == "4"){ echo "hidden"; } ?>>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning" style="height: 35px;">
                                <p style="margin-top: -8px;font-size:11px"><i class="fa fa-exclamation-triangle text-warning"></i> Se hablita con Áreas de Negocio.</p>
                            </div>
                        </section>
                        <section class="col col-4 show_area_negocio" <?php if($row['id_grupo'] != "4"){ echo "hidden"; } ?>>
                            <label>Usuario Resolutor</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <select name="sl_resolutor_conocimiento_edit" id="inputResolutorConocimientoEdit" class="sl_resolutor_conocimiento_edit form-control selectpicker_edit show-tick" data-header="Usuario Resolutor" data-live-search="true" data-title="Usuario Resolutor">
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
                                <select name="sl_publicado_conocimiento_edit" id="inputPublicadoConocimientoEdit" class="sl_publicado_conocimiento_edit selectpicker_edit form-control show-tick" data-header="Estado Publicacion">
                                    <option value="1" <?php if($row['aprobado'] == "1"){ echo "selected"; } ?>>Publicado</option>
                                    <option value="0" <?php if($row['aprobado'] == "0"){ echo "selected"; } ?>>No Publicado</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Visualizar Cliente</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-eye"></i></span>
                                <select name="sl_cliente_conocimiento_edit" id="inputClienteConocimientoEdit" class="sl_cliente_conocimiento_edit selectpicker_edit form-control show-tick" data-header="Visualiza Cliente">
                                    <option value="1" <?php if($row['ver_cliente'] == "1"){ echo "selected"; } ?>>Visualizar</option>
                                    <option value="0" <?php if($row['ver_cliente'] == "0"){ echo "selected"; } ?>>No Visualizar</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Dirigido a : </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                                <select name="sl_tipo_servicio_edit" id="inputTipoServicioEdit" class="sl_tipo_servicio_edit selectpicker_edit form-control show-tick" data-header="Dirigido a : ">
                                    <option value="0" <?php if($row['tipo_conocimiento'] == "0"){ echo "selected"; } ?>>Aplicaciones</option>
                                    <option value="1" <?php if($row['tipo_conocimiento'] == "1"){ echo "selected"; } ?>>Biométrico</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-4">
                            <label>Vista Publica : </label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                                <select name="sl_publico_edit" id="inputPublico" class="sl_publico_edit selectpicker_edit form-control show-tick" data-header="Elija la opción : ">
                                    <option value="0" <?php if($row['publico'] == "0"){ echo "selected"; } ?>>No Público</option>
                                    <option value="1" <?php if($row['publico'] == "1"){ echo "selected"; } ?>>Público</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                       <section class="co col-12">
                            <textarea name="txt_contenido_conocimiento_edit" class="txt_contenido_conocimiento_edit editor_conocimiento form-control" rows="3"><?= $row['contenido']; ?></textarea>
                            <textarea name="txt_contenido_original_conocimiento" hidden><?= $row['contenido']; ?></textarea>
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
    /* Load de aplicativos */
    $(".sl_aplicativo_conocimiento_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php?id_aplicativo=<?=$row['id_apli']?>");
    $(".sl_flujo_conocimiento_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_categorias.php?id_apli=<?=$row['id_apli']?>");
    $(".sl_grupo_conocimiento_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_grupos.php?id_apli=<?=$row['id_apli']?>&edit_kdb=<?=$row['id_apli']?>");
    /* Fin de load de aplicativos */
    
    <?php if($row['id_grupo'] == "4"){ ?>
        $(".sl_resolutor_conocimiento_edit").selectpicker('destroy').load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_resolutor.php?id_res=<?= $row['id_resolutor'] ?>");
    <?php } ?>
    
    $('.selectpicker_edit').selectpicker();
    
    setTimeout(function(){
        $('.sl_aplicativo_conocimiento_edit').selectpicker('refresh');
        $('.sl_flujo_conocimiento_edit').selectpicker('refresh');
        $('.sl_grupo_conocimiento_edit').selectpicker('refresh');
        <?php if($row['id_grupo'] == "4"){ ?>
            $('.sl_resolutor_conocimiento_edit').selectpicker('refresh');
        <?php } ?>
    },1000);
    
    $('.sl_aplicativo_conocimiento_edit').change(function(){
        $('.show_area_negocio').fadeOut(function(){
            $('.hide_area_negocio').fadeIn();
        });
        var id_apli = $('#inputAplicativoConocimientoEdit').val();
        $(".sl_flujo_conocimiento_edit").selectpicker('destroy').load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_categorias.php?id_apli="+id_apli);
        $(".sl_grupo_conocimiento_edit").selectpicker('destroy').load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_grupos.php?id_apli="+id_apli);
        setTimeout(function(){
            $('.sl_flujo_conocimiento_edit').selectpicker('refresh');
            $('.sl_grupo_conocimiento_edit').selectpicker('refresh');
        },500);
    });
    
    $('.sl_grupo_conocimiento_edit').change(function(){
        var id_grupo = $('#inputGrupoConocimientoEdit').val();
        if(id_grupo == "4"){
            $('.hide_area_negocio').fadeOut(function(){
                $('.show_area_negocio').fadeIn(function(){
                    $(".sl_resolutor_conocimiento_edit").selectpicker('destroy').load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_resolutor.php?id_res=<?= $row['id_resolutor'] ?>");
                    setTimeout(function(){
                        $('.sl_resolutor_conocimiento_edit').selectpicker('refresh');
                    },500);
                });
            });
        }else{
            $('.show_area_negocio').fadeOut(function(){
                $('.hide_area_negocio').fadeIn();
            });
        }
    });
    
    $(document).ready(function () {
        $('textarea.editor_conocimiento').tinymce({
            extended_valid_elements: "table[class=table table-bordered table-striped],ul[class=custom-bullet],img[class=img-responsive center-block|!src|border:0|alt|title|width|height|style],iframe[src|width|height|name|align|class=video-container]",
            theme: "modern",
            /*paste_data_images: true,*/
            height: 300,
            font_formats: "Arial=arial,helvetica,sans-serif;Courier New=courier new,courier,monospace;AkrutiKndPadmini=Akpdmi-n",
            fontsize_formats: "8pt 10pt 12pt 14pt 18pt 24pt 36pt",
            plugins: [
                "advlist autolink lists link image charmap print preview hr anchor pagebreak",
                "searchreplace wordcount visualblocks visualchars code fullscreen",
                "insertdatetime media nonbreaking save table contextmenu directionality",
                "emoticons template paste textcolor colorpicker textpattern imagetools responsivefilemanager smileys"
            ],
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
            external_filemanager_path:"assets/js/tinymce/filemanager/",
            filemanager_title:"Gestor de Archivos - PID - CLARO AN" ,
            external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
        });
        
        $(document).ready(function() {
            $("#fec_edit_conocimiento").DateTimePicker({
                secondsInterval: 1,
                language:'es'
            });
            $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        });
        
        $('.id_fecha_editor_conocimiento_edit').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoUpdateInput: false,
            opens: "center",
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
        
        $('.id_fecha_editor_conocimiento_edit').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.id_fecha_editor_conocimiento_edit').val(startDate.format('YYYY-MM-DD'));
        });
        
        /* Modal Insertar Aplicativo */
        $('.agregar_aplicativo').click(function () {
            var id_aplicativo = <?= $row['id_apli'] ?>;
            $.ajax({
                beforeSend: function(){
                    $('.ins_aplicativo_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                },
                type: "GET",
                url: 'ajax/view_pid/insert/view_insert_aplicativo_caja.php',
                data: 'id_aplicativo=' + id_aplicativo,
                success:function(data){
                    $('.ins_aplicativo_body').html(data);
                }
            });
        });
        $('#modal_ins_aplicativo').on('hidden.bs.modal', function () {
            $(document.body).addClass('modal-open');
        });
        /* Fin Modal Insertar Aplicativo */
        
        $('#edit_conocimiento').submit(function( event ) {
            var datos = $(this).serialize();
                swal({
                    title: 'Deseas editar este conocimiento?',
                    text: "Recuerda que esto cambiara el contenido !",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#1b9cdd',
                    cancelButtonColor: '#d33',
                    confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                    cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                }).then(function() {
                    $.ajax({
                        type: "POST",
                        url: "ajax/action_class/update/update_conocimiento.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){
                                    swal({
                                        title: "",
                                        text: "Se actualizo el conocimiento con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true,
                                        closeOnConfirm: false
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_edit_conocimiento').modal('toggle');
                                }, 600);
                                tabla_kdb_gestor.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al editar el conocimiento, informalo al administrador y/o desarrollador",
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
                        text: "No se edito el conocimiento",
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