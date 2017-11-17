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
    $_SESSION['filemanager_categoria'] = "pregunta";
    require_once ('../../../data/pid_examen.php');
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $id_pregunta = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new examen_usuario();
    $object_cat = new pid_view();
    $object_permisos = new pid_permisos();
    $object_user = new pid_auth();
    $result = $object->view_id_examen();
    $result_view = $object->view_pregunta($id_pregunta);
    $result_cat = $object_cat->view_category();
    $result_user = $object_user->user_auth($id_user);
    $row_view = $result_view->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    $row_access = $result_user->fetch_assoc();

    if($row_permisos['edit_pre_exam'] != "true"){
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
            <legend class="modal-title">Editar Pregunta</legend>
          </div>
          <div class="modal-body">
            <form id="edit_pregunta" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Titulo de la Pregunta</label>
                            <div class="input-group">
                                <textarea name="nom_pregunta" rows="3" class="nom_pregunta editor_pregunta form-control"><?= $row_view['nombre_pregunta'] ?></textarea>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 1</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_1" type="text" class="respuesta_1 form-control" id="inputRpta1Edit" placeholder="Respuesta 1" value="<?= utf8_decode($row_view['respuesta_1']) ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 2</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_2" type="text" class="respuesta_2 form-control" id="inputRpta2Edit" placeholder="Respuesta 2" value="<?= utf8_decode($row_view['respuesta_2']) ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 3</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_3" type="text" class="respuesta_1 form-control" id="inputRpta3Edit" placeholder="Respuesta 3" value="<?= utf8_decode($row_view['respuesta_3']) ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Respuesta 4</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-stumbleupon-circle"></i></span>
                                <input name="respuesta_4" type="text" class="respuesta_1 form-control" id="inputRpta4Edit" placeholder="Respuesta 4" value="<?= utf8_decode($row_view['respuesta_4']) ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-5">
                            <label>Respuesta Correcta</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-check"></i></span>
                                <select name="sl_respuesta" id="inputRptaCEdit" class="sl_respuesta selectpicker_edit form-control show-tick" data-header="Respuesta Correcta">
                                    <option value="1" <?php if($row_view['respuesta_correcta'] == 1){ echo "selected"; } ?>>Respuesta 1</option>
                                    <option value="2" <?php if($row_view['respuesta_correcta'] == 2){ echo "selected"; } ?>>Respuesta 2</option>
                                    <option value="3" <?php if($row_view['respuesta_correcta'] == 3){ echo "selected"; } ?>>Respuesta 3</option>
                                    <option value="4" <?php if($row_view['respuesta_correcta'] == 4){ echo "selected"; } ?>>Respuesta 4</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-7">
                            <label>Asignar a :</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-bank"></i></span>
                                <select name="sl_asignar[]" id="inputAsignarEdit" class="sl_asignar selectpicker_edit form-control show-tick" data-header="Asignar a Examen" data-live-search="true" data-selected-text-format="count" data-actions-box="true" multiple>
                                    <?php 
                                    $id_examen = explode(',', $row_view['id_examen']);
                                    while ($row = $result->fetch_assoc()){ 
                                    ?>
                                    <option value="<?= $row['id_examen'] ?>" 
                                        <?php if(in_array($row['id_examen'], $id_examen)/*$row['id_examen'] == $row_view['id_examen']*/){ 
                                            echo "selected"; 
                                        } ?>><?= $row['titulo_examen'] ?></option>
                                    <?php } ?>
                                </select>
                                <input type="text" name="id_pregunta" value="<?= $id_pregunta ?>" hidden>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-2">
                            <label>N°ID</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-info"></i></span>
                                <input name="id_atu" type="text" class="id_atu form-control" id="inputIDEdit" value="<?= $row_view['id_atu'] ?>" placeholder="'XXX'" maxlength="3" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8">
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Aplicativo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_aplicativo" id="inputAplicativoExamEdit" class="sl_aplicativo selectpicker_edit form-control show-tick" data-header="Aplicativo" data-live-search="true">
                                    <?php while ($row_cat = $result_cat->fetch_assoc()){ ?>
                                    <option value="<?= $row_cat['id_apli'] ?>" <?php if($row_cat['id_apli'] == $row_view['id_apli']){ echo "selected"; } ?>><?= $row_cat['nom_apli'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Dificultad</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-question"></i></span>
                                <select name="sl_dificultad" id="inputDificultadEdit" class="sl_dificultad selectpicker_edit form-control show-tick" data-header="Dificultad">
                                    <option value="0" <?php if($row_view['dificultad'] == '0' ){ echo "selected"; } ?>>Facil</option>
                                    <option value="1" <?php if($row_view['dificultad'] == '1' ){ echo "selected"; } ?>>Dificil</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row modal-footer">
                        <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                        <?php if($row_access['funcion_user'] == 6 || $row_access['funcion_user'] == 7){ echo ""; }else{ ?>
                        <input class="btn btn-primary" type="submit" value="Editar">
                        <?php } ?>
                    </div>
                </fieldset>
            </form>
          </div>
        </div>
<script>
    
    $('.selectpicker_edit').selectpicker();
    
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

        $('#edit_pregunta').submit(function( event ) {
            var datos = $(this).serialize();
            swal({
                title: 'Deseas editar esta pregunta?',
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
                    url: "ajax/action_class/examen/edit_pregunta.php",
                    data: datos,
                    success: function(data) {
                      if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se actualizo la pregunta con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                            $('#modal_edit_pregunta').modal('toggle');
                        }, 600);
                        tabla_universo_preguntas.ajax.reload( null, false );
                      }else{
                        
                      }
                    }
                });
            }, function(dismiss) {
              if (dismiss === 'cancel') {
                swal({
                    title: "",
                    text: "No se edito la pregunta",
                    type: "success",
                    showCancelButton: false,
                    showConfirmButton: true
                });
              }
            })
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