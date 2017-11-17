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
    $_SESSION['filemanager_categoria'] = "comunicado";
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $id_user = $_SESSION['id_user_apl'];
    $id_comunicado = $_GET['id'];
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result = $object->view_comunicado($id_comunicado);
    $row = $result->fetch_assoc();    
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['edit_com_atc'] != "true"){
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
          <h3 class="modal-title">Editar Comunicado</h3>
        </div>
        <div class="modal-body">
            <form id="edit_comunicado" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_titulo_com" type="text" class="txt_titulo_com_edit form-control" id="inputTituloComEdit" placeholder="Titulo Comunicado" value="<?= $row['txt_comunicado'] ?>">
                                <input name="id_comunicado" value="<?= $id_comunicado ?>" hidden>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-8">
                            <label>Adj. Correo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input name="ruta_correo" type="text" class="ruta_correo_edit form-control" id="inputCorreoComEdit" placeholder="Haz Clic Aqui" value="<?= $row['url_correo'] ?>" onclick="javascript:ventana_url('assets/js/tinymce/filemanager/dialog.php?popup=1&amp;field_id=inputCorreoComEdit')">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Fecha de Actualizacion</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input name="fecha_actualizacion" type="text" placeholder="<?= date("Y-m-d H:i:s") ?>" class="fecha_actualizacion_edit form-control" id="inputFecActEdit" value="<?= $row['fec_registro'] ?>">
                                <input name="fecha_ori" type="text" value="<?= $row['fec_registro'] ?>" hidden>
                                <input name="fecha_aviso" type="text" value="<?= $row['fec_aviso'] ?>" hidden>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Estado</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stack-exchange"></i></span>
                                <select name="sl_estado_com" id="inputEstadoEdit" class="sl_estado_com selectpicker form-control show-tick" data-header='Estado'>
                                    <option value="0" <?php if($row['com_estado'] == "0"){ echo "selected"; }else{ echo ""; } ?> >VIGENTE</option>
                                    <option value="1" <?php if($row['com_estado'] == "1"){ echo "selected"; }else{ echo ""; } ?> >NO VIGENTE</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Tipo de Urgencia</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-life-ring"></i></span>
                                <select name="sl_estado_urg" id="inputUrgenciaEdit" class="sl_estado_com selectpicker form-control show-tick" data-header='Tipo Urgencia'>
                                    <option value="1" <?php if($row['tipo_aviso'] == "1"){ echo "selected"; }else{ echo ""; } ?> >ALTA</option>
                                    <option value="2" <?php if($row['tipo_aviso'] == "2"){ echo "selected"; }else{ echo ""; } ?> >MEDIA</option>
                                    <option value="3" <?php if($row['tipo_aviso'] == "3"){ echo "selected"; }else{ echo ""; } ?> >BAJA</option>
                                </select>
                                <input name="estado_urg_ori" value="<?= $row['tipo_aviso'] ?>" hidden>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <textarea name="txt_contenido_com" class="txt_contenido_com contenido_comunicado_edit form-control"><?= $row['com_contenido'] ?></textarea>
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
    $('.fecha_actualizacion_edit').daterangepicker({
        timePicker: true,
        timePicker24Hour: false,
        singleDatePicker: true,
        showDropdowns: true,
        alwaysShowCalendars: true,
        autoUpdateInput: false,
        opens: "right",
        drops: "down",
        locale: {
            cancelLabel: 'Limpiar',
            applyLabel: 'Aplicar',
            format: 'YYYY-MM-DD h:mm A'
        }
    });
    
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};

    $('.fecha_actualizacion_edit').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fecha_actualizacion_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
    });

    $('.fecha_actualizacion_edit').on('cancel.daterangepicker', function (ev, picker) {
        $('.fecha_actualizacion_edit').val('');
    });    
    
    $('.selectpicker').selectpicker();
    
    
    function ventana_url(url){
        var w = 1000;
        var h = 600;
        var l = Math.floor((screen.width-w)/2);
        var t = Math.floor((screen.height-h)/2);
        var win = window.open(url, 'Gestor de Archivos - PID - CLARO AN', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
    }
    
    $(document).ready(function () {
        $('textarea.contenido_comunicado_edit').tinymce({
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
            toolbar1: "responsivefilemanager undo redo | formatselect styleselect fontsizeselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | image table | print preview media | emoticons",
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
            external_plugins: { filemanager: "filemanager/plugin.min.js"}
        });
        
        $('#edit_comunicado').submit(function( event ) {
            var datos = $(this).serialize();
            swal({
                title: 'Deseas editar este comunicado?',
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
                    url: "ajax/action_class/update/update_comunicado.php",
                    data: datos,
                    success: function(data) {
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se edito el comunicado con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    setTimeout(function(){
                                        $(document.body).css('padding-right','');
                                    },200);
                                });
                                $('#modal_edit_comunicado').modal('toggle');
                            }, 600);
                            tabla_comunicados_gestor.ajax.reload( null, false );
                        }else{
                            swal({
                                title: "",
                                text: "Error al editar el comunicado, informalo al administrador y/o desarrollador",
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
                    text: "No se edito ningun comunicado",
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