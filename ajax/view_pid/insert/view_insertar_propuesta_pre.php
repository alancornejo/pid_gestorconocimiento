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
    $_SESSION['filemanager_categoria'] = "pregunta_propuesta";
    require_once ('../../../data/pid_examen.php');
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $object = new examen_usuario();
    $object_view = new pid_view();
    $object_permisos = new pid_permisos();
    $id_user = $_SESSION['id_user_apl'];
    $result = $object->view_id_examen_asig();
    $result_cat = $object_view->view_category();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Insertar Pregunta [Propuesta]</h3>
        </div>
        <div class="modal-body">
            <form id="insert_pregunta" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Titulo de la Pregunta [Propuesta]</label>
                            <div class="input-group">
                                <textarea name="nom_pregunta" rows="3" class="nom_pregunta editor_pregunta form-control"></textarea>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 1</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_1" type="text" class="respuesta_1 form-control" id="inputRpta1" placeholder="Respuesta 1">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 2</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_2" type="text" class="respuesta_2 form-control" id="inputRpta2" placeholder="Respuesta 2">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 3</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_3" type="text" class="respuesta_1 form-control" id="inputRpta3" placeholder="Respuesta 3">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 4</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_4" type="text" class="respuesta_1 form-control" id="inputRpta4" placeholder="Respuesta 4">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-5">
                            <label>Respuesta Correcta</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                <select name="sl_respuesta" id="inputRptaC" class="sl_respuesta selectpicker form-control show-tick" data-header="Respuesta Correcta">
                                  <option value="" disabled selected>Selecciona Aqui</option>
                                  <option value="1">Respuesta 1</option>
                                  <option value="2">Respuesta 2</option>
                                  <option value="3">Respuesta 3</option>
                                  <option value="4">Respuesta 4</option>
                                </select>
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
    
    $('.selectpicker').selectpicker();
    
    $(document).ready(function () {
        $('textarea.editor_pregunta').tinymce({
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
            menubar: true,
            fullscreen_new_window : true,
            toolbar_items_size: 'small',
            image_advtab: true,
            fix_list_elements : true,
            external_filemanager_path:"assets/js/tinymce/filemanager/",
            filemanager_title:"Gestor de Archivos - PID - CLARO AN" ,
            external_plugins: { "filemanager" : "filemanager/plugin.min.js"}
        });

        $('#insert_pregunta').submit(function( event ) {
            if ($(".respuesta_1").val() == "" || $(".respuesta_2").val() == "" || $(".respuesta_3").val() == "" || $(".respuesta_4").val() == "" || $(".nom_pregunta").val() == "" || $("select.sl_respuesta").val() == null) {
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
                        title: 'Deseas agregar esta pregunta?',
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
                            url: "ajax/action_class/examen/insert_pregunta_propuesta.php",
                            data: datos,
                            success: function(data) {
                                if(data == "true"){
                                    setTimeout(function(){     
                                        swal({
                                            title: "",
                                            text: "Se agrego la pregunta con exito",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: true
                                        });
                                        $("input[type=text],textarea").val("");
                                        $(".selectpicker").selectpicker('val','');
                                        $('#modal_ins_pregunta').modal('toggle');
                                    }, 600);
                                    tabla_universo_preguntas.ajax.reload( null, false );
                                }else{
                                    swal({
                                        title: "",
                                        text: "Error al insertar la pregunta, informalo al administrador y/o desarrollador",
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
<?php } ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>