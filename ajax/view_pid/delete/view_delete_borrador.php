<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Insertar motivo de eliminación</h3>
    </div>
    <div class="modal-body">
        <form id="insert_motivo_borrador" class="sky-form">
            <fieldset>
                <div class="row">
                    <section class="col col-12">
                        <label>Motivo de la eliminación</label>
                        <div class="input-group">
                            <textarea name="txt_motivo" type="text" class="txt_motivo editor_motivo_borrador form-control" rows="3"></textarea>
                            <input name="id_borrador" value="<?= $_GET['id'] ?>" hidden>
                        </div>
                    </section>
                </div>
                <div class="row modal-footer">
                    <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                    <input class="btn btn-primary" type="submit" value="Insertar">
                </div>
            </fieldset>
        </form>
    </div>
</div>

<script>
    $('textarea.editor_motivo_borrador').tinymce({
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
        toolbar1: "undo redo | formatselect styleselect fontsizeselect | forecolor backcolor | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link unlink anchor | table | print preview | smileys",
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
        external_filemanager_path: "assets/js/tinymce/filemanager/",
        filemanager_title: "Gestor de Archivos - PID - CLARO AN" ,
        external_plugins: { filemanager: "filemanager/plugin.min.js"},
    });

    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    
    $('#insert_motivo_borrador').submit(function(e){
        if($('.txt_motivo').val() == ''){
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
                title: 'Deseas eliminar este borrador?',
                text: "Al eliminarlo solo se cambiara su estado",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1b9cdd',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-trash"></i> Eliminar',
                showLoaderOnConfirm: false,
                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
            }).then(function() {
                $.ajax({
                    type: "GET",
                    url: "ajax/action_class/delete/delete_borrador.php",
                    data: datos,
                    success: function(data) {
                        if(data == "sin_permiso"){
                            swal({
                                title: "",
                                text: "No cuentas con el permiso correspondiente",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }else{
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se elimino el borrador con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_view_elim_borrador').modal('toggle');
                                }, 600);
                                tabla_borrador_gestor.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al eliminar el borrador, informalo al administrador y/o desarrollador",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                            }
                        }
                    }
                });
            }, function(dismiss) {
              if (dismiss === 'cancel') {
                swal({
                    title: "",
                    text: "No se elimino el borrador",
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: true
                });
              }
            });
        }
        e.preventDefault();
    });
    
</script>