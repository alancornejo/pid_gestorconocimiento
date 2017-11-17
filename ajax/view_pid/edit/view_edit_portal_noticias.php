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
    $_SESSION['filemanager_categoria'] = "portal_noticias";
    require_once ('../../../data/pid_access.php');
    require_once ('../../../data/pid_view.php');
    $object_permisos = new pid_permisos();
    $object = new pid_view();
    $id_user = $_SESSION['id_user_apl'];
    $id = $_GET['id'];
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result_view = $object->view_contenido_noticia_portal($id);
    $row_permisos = $result_permisos->fetch_assoc();
    $row_noticia = $result_view->fetch_assoc();

    if($row_permisos['edit_port_not'] != "true"){
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
            <h3 class="modal-title">Editar Noticias [<?= utf8_encode($row_noticia['txt_noticia']) ?>]</h3>
          </div>
          <div class="modal-body">
            <form id="edit_noticia_portal" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Titulo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="txt_titulo_not_edit" type="text" class="txt_titulo_not_edit form-control" id="inputPTituloEdit" placeholder="Titulo de la Noticia" value="<?= utf8_encode($row_noticia['txt_noticia']) ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Imagen de la Noticia</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-image"></i></span>
                                <input name="ruta_imagen_noticia_edit" type="text" class="ruta_imagen_noticia_edit form-control" id="inputPImagenEdit" placeholder="Haz Clic Aqui" onclick="javascript:ventana_url('assets/js/tinymce/filemanager/dialog.php?popup=1&amp;field_id=inputPImagenEdit')" value="<?= $row_noticia['imagen_noticia'] ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Tipo de Noticia</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stack-exchange"></i></span>
                                <select name="sl_tipo_noticia_edit" id="inputPTipoEdit" class="sl_tipo_noticia_edit selectpicker form-control show-tick" data-header='Tipo de Noticia'>
                                    <option value="0" <?php if($row_noticia['tipo_noticia'] == "0"){ echo "selected"; } ?>>Externo</option>
                                    <!-- <option value="1">Interno</option> -->
                                </select>
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Fuente de la Noticia</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-globe"></i></span>
                                <input name="txt_fuente_noticia_edit" type="text" class="txt_fuente_noticia_edit form-control" id="inputPFuenteEdit" placeholder="www.xxx.xxx" value="<?= $row_noticia['fuente_noticia'] ?>">
                                <input name="fecha_noticia_edit" type="text" value="<?= $row_noticia['fecha_noticia'] ?>" hidden>
                                <input name="id_noticia_edit" type="text" value="<?= $id ?>" hidden>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <textarea name="txt_contenido_noticia_edit" class="txt_contenido_noticia_edit contenido_noticia_portal_edit form-control" rows="3"><?= $row_noticia['contenido_noticia'] ?></textarea>
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
    
    $('.selectpicker').selectpicker();
    
    function ventana_url(url){
        var w = 1000;
        var h = 600;
        var l = Math.floor((screen.width-w)/2);
        var t = Math.floor((screen.height-h)/2);
        var win = window.open(url, 'Gestor de Archivos - PID - CLARO AN', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
    }
    
    $('textarea.contenido_noticia_portal_edit').tinymce({
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
    
    $('#edit_noticia_portal').submit(function( event ) {
        if ($(".txt_titulo_not_edit").val() == '' || $(".ruta_imagen_noticia_edit").val() == '' || $("select.sl_tipo_noticia_edit").val() == null || $('.txt_fuente_noticia_edit').val() == "" || $('.txt_contenido_noticia_edit').val() == "") {
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
                    title: 'Deseas editar esta noticia ?',
                    //text: "Recuerda haber llenado todo correctamente !",
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
                        url: "ajax/action_class/update/update_noticia.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se edito la noticia con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_edit_portal_noticia').modal('toggle');
                                }, 600);
                                tabla_portal_pid.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al editar la noticia, informalo al administrador y/o desarrollador",
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
                        text: "No se edito ninguna noticia",
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