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
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $result_apl = $object->view_category();
    $result_asig = $object->view_grupo_asignado();
    $result_view = $object->view_contenido_bitacora($id);
    $row = $result_view->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_bita'] != "true"){
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
                <h3 class="modal-title">Editar Bitácora</h3>
            </div>
            <div class="modal-body">
                <form id="edit_bitacora" class="sky-form">
                    <fieldset>
                        <div class="row">
                            <section class="col col-3">
                                <label>Fecha Bitácora</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                    <input name="fec_bitacora" type="text" class="fec_bitacora_edit form-control" id="inputFechaBitacora" value="<?= $row['fec_bitacora'] ?>">
                                    <input name="id_bitacora" type="text" class="id_bitacora" hidden value="<?= $id ?>">
                                </div>
                            </section>
                            <section class="col col-3">
                                <label>Tipo Impacto</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-life-ring"></i></span>
                                    <select name="sl_impacto" id="inputImpacto" class="sl_impacto_edit selectpicker_edit form-control show-tick" data-header="Tipo Impacto">
                                        <option value="IMPACTO MUY ALTO" <?php if("IMPACTO MUY ALTO" == $row['txt_impacto']){ echo "selected"; }?>>IMPACTO MUY ALTO</option>
                                        <option value="IMPACTO ALTO" <?php if("IMPACTO ALTO" == $row['txt_impacto']){ echo "selected"; }?>>IMPACTO ALTO</option>
                                        <option value="IMPACTO MEDIO ALTO" <?php if("IMPACTO MEDIO ALTO" == $row['txt_impacto']){ echo "selected"; }?>>IMPACTO MEDIO ALTO</option>
                                        <option value="IMPACTO MEDIO" <?php if("IMPACTO MEDIO" == $row['txt_impacto']){ echo "selected"; }?>>IMPACTO MEDIO</option>
                                        <option value="IMPACTO BAJO" <?php if("IMPACTO BAJO" == $row['txt_impacto']){ echo "selected"; }?>>IMPACTO BAJO</option>
                                    </select>
                                </div>
                            </section>
                            <section class="col col-3">
                                <label>Usuarios Afectados</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input name="num_afectados" type="text" class="num_afectados_edit form-control" id="inputUafectados" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9" value="<?= $row['user_afectado'] ?>">
                                </div>
                            </section>
                            <section class="col col-3">
                                <label>Cantidad de Correos</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                    <input name="num_correos" type="text" class="num_correos_edit form-control" id="inputNumCorreo" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9" value="<?= $row['num_correo'] ?>"> 
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-6">
                                <label>Aplicativo Afectado</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                    <select name="sl_afectado" id="inputAplAfectado" class="sl_afectado_edit selectpicker_edit form-control" data-header="Aplicativo" data-live-search="true">
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
                                    <select name="sl_asignado" id="inputGruAsignado" class="sl_asignado_edit selectpicker_edit form-control" data-header="Grupo Asignado" data-live-search="true">
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
                                    <input name="txt_bitacora" type="txt" class="txt_bitacora_edit form-control" id="inputTiBitacora" value="<?= $row['txt_bitacora'] ?>">
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-4">
                                <label>Responsable</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-wrench"></i></span>
                                    <input name="txt_responsable" type="txt" class="txt_responsable_edit form-control" id="inputResponsable" value="<?= $row['nom_responsable'] ?>">
                                </div>
                            </section>
                            <section class="col col-4">
                                <label>Número de Caso</label>
                                <div class="input-group">
                                    <span class="input-group-addon">#</span>
                                    <input name="num_caso" type="txt" class="num_caso_edit form-control" id="inputNumCaso" value="<?= $row['num_caso'] ?>">
                                </div>
                            </section>
                            <section class="col-md-4">
                            <div>
                                <label>Fecha Recepción de Correo</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                    <input name="fec_recepcion" type="text" class="fec_recepcion_edit form-control" id="inputFechaRecepcion" placeholder="<?= date("Y-m-d H:i") ?>" value="<?= $row['fec_recepcion'] ?>">
                                </div>
                            </div>
                        </section>
                        </div>
                        <div class="row">
                            <section class="col-md-6">
                                <label>Estado de Bitácora</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-stack-exchange"></i></span>
                                    <select name="sl_estado" id="inputEstado" class="sl_estado_edit selectpicker_edit form-control show-tick" data-header="Estado">
                                        <?php if($row['id_estado'] == "ASIGNADO" || $row['id_estado'] == "RE-ASIGNADO"){ ?>
                                            <?php if($row['id_estado'] == "ASIGNADO"){ ?>
                                                    <option value="asignado" selected>ASIGNADO</option>
                                            <?php }elseif($row['id_estado'] == "RE-ASIGNADO"){ ?>
                                                    <option value="re-asignado" selected>RE-ASIGNADO</option>
                                            <?php } ?>
                                                <option value="solucionado">SOLUCIONADO</option>
                                        <?php } ?>
                                        <?php if($row['id_estado'] == "SOLUCIONADO"){ ?>
                                            <option value="solucionado" selected>SOLUCIONADO</option>
                                            <option value="re-asignado">RE-ASIGNADO</option>
                                            <option value="cerrado">CERRADO</option>
                                        <?php } ?>
                                        <?php if($row['id_estado'] == "CERRADO"){ ?>
                                            <option value="cerrado" selected>CERRADO</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </section>
                            <?php 
                            if($row['id_estado'] == "ASIGNADO"){
                                $id_estado = "ASIGNADO";
                                $fecha_estado = $row['fec_apertura'];
                            }else if($row['id_estado'] == "RE-ASIGNADO"){
                                $id_estado = "RE-ASIGNADO";
                                $fecha_estado = $row['fec_reasi'];
                            }else if($row['id_estado'] == "SOLUCIONADO"){
                                $id_estado = "SOLUCIONADO";
                                $fecha_estado = $row['fec_solucion'];
                            }else if($row['id_estado'] == "CERRADO"){
                                $id_estado = "CERRADO";
                                $fecha_estado = $row['fec_cierre'];
                            }
                            ?>
                            <input name="fecha_bitacora_original" value="<?= $row['fec_bitacora'] ?>" hidden>
                            <input name="impacto_original" value="<?= $row['txt_impacto'] ?>" hidden>
                            <input name="num_afectados_original" value="<?= $row['user_afectado'] ?>" hidden>
                            <input name="num_correo_original" value="<?= $row['num_correo'] ?>" hidden>
                            <input name="sl_aplicativo_original" value="<?= $row['id_apli'] ?>" hidden>
                            <input name="sl_grupo_original" value="<?= $row['id_grupo'] ?>" hidden>
                            <input name="titulo_bitacora_original" value="<?= $row['txt_bitacora'] ?>" hidden>
                            <input name="responsable_original" value="<?= $row['nom_responsable'] ?>" hidden>
                            <input name="num_caso_original" value="<?= $row['num_caso'] ?>" hidden>
                            <input name="estado_original" value="<?= $id_estado ?>" hidden>
                            <input name="fecha_estado_original" value="<?= $fecha_estado ?>" hidden>
                            <section class="col-md-6">
                                <div>
                                    <div id="edit_asignado" class="estado_bitacora_edit asignado" <?php if("ASIGNADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Asignacion</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_apertura" type="text" class="fec_edit_apertura input_edit_asignado form-control" id="inputFechaApertura" value="<?= $row['fec_apertura'] ?>">
                                        </div>
                                    </div>
                                    <div id="edit_re-asignado" class="estado_bitacora_edit re-asignado" <?php if("RE-ASIGNADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Re-Asignacion</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_re_asignado" type="text" class="fec_edit_re_asignado input_edit_re-asignado form-control" id="inputFechaReAsignado" value="<?= $row['fec_reasi']; ?>" placeholder="<?= date("Y-m-d H:i") ?>">
                                        </div>
                                    </div>
                                    <div id="edit_solucionado" class="estado_bitacora_edit solucionado" <?php if("SOLUCIONADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Solucion</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_solucionado" type="text" class="fec_edit_solucionado input_edit_solucionado form-control" id="inputFechaSolucionado" value="<?= $row['fec_solucion']; ?>" placeholder="<?= date("Y-m-d H:i") ?>">                                        
                                        </div>
                                    </div>
                                    <div id="edit_cerrado" class="estado_bitacora_edit cerrado" <?php if("CERRADO" == $row['id_estado']){ echo ""; }else{ echo "hidden"; }?>>
                                        <label>Fecha de Cierre</label>
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-calendar-times-o"></i></span>
                                            <input name="fec_cerrado" type="text" class="fec_edit_cerrado input_edit_cerrado form-control" id="inputFechaCerrado" value="<?= $row['fec_cierre']; ?>" placeholder="<?= date("Y-m-d H:i") ?>">
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-12">
                                <textarea name="contenido" class="editar_bitacora form-control"><?= $row['contenido'] ?></textarea>
                                <textarea name="contenido_original" hidden><?= $row['contenido'] ?></textarea>
                            </section>
                            <input name="fecha_actual" type="text" value="<?= date("Y-m-d H:i") ?>" hidden>
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
    $('textarea.editar_bitacora').tinymce({
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
    $(".sl_afectado_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php?id_aplicativo=<?=$row['id_apli']?>");
    $(".sl_asignado_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_grupos.php?id_grupo=<?=$row['id_grupo']?>");
    /* Fin de load de aplicativos y Grupo Asignado */
    
    setTimeout(function(){
        $('.sl_afectado_edit').selectpicker('refresh');
        $('.sl_asignado_edit').selectpicker('refresh');
    },1000);
    
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
    
    /* Modal Insertar Grupo Asignado */
    $('.agregar_grupo_asignado').click(function () {
        var id_grupo = <?= $row['id_grupo'] ?>;
        $.ajax({
            beforeSend: function(){
                $('.ins_grupo_asignado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
            },
            type: "GET",
            url: 'ajax/view_pid/insert/view_insert_grupo_caja.php',
            data: 'id_grupo=' + id_grupo,
            success:function(data){
                $('.ins_grupo_asignado_body').html(data);
            }
        });
    });
    $('#modal_ins_grupo_asignado').on('hidden.bs.modal', function () {
        $(document.body).addClass('modal-open');
    });
    /* Fin Modal Insertar Grupo Asignado */
    
    $(document).ready(function() {
        $('.selectpicker_edit').selectpicker();
        
        $('select.sl_estado_edit').on('changed.bs.select', function(){
            $('.estado_bitacora_edit').hide();
            $('#edit_' + $(this).val()).show();
        });
        
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
        
        $('.fec_bitacora_edit').daterangepicker({
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

        $('.fec_bitacora_edit').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_bitacora_edit').val(startDate.format('YYYY-MM-DD'));
        });

        $('.fec_bitacora_edit').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_bitacora_edit').val('');
        });
        
        $('.fec_edit_apertura').daterangepicker({
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

        $('.fec_edit_apertura').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_apertura').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_apertura').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_apertura').val('');
        });
        
        $('.fec_edit_re_asignado').daterangepicker({
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

        $('.fec_edit_re_asignado').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_re_asignado').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_re_asignado').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_re_asignado').val('');
        });
        
        $('.fec_edit_solucionado').daterangepicker({
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

        $('.fec_edit_solucionado').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_solucionado').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_solucionado').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_solucionado').val('');
        });
        
        $('.fec_edit_cerrado').daterangepicker({
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

        $('.fec_edit_cerrado').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_edit_cerrado').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_edit_cerrado').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_edit_cerrado').val('');
        });
        
        $('.fec_recepcion_edit').daterangepicker({
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

        $('.fec_recepcion_edit').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_recepcion_edit').val(startDate.format('YYYY-MM-DD HH:mm:ss'));
        });

        $('.fec_recepcion_edit').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_recepcion_edit').val('');
        });
        
    });    
    
    $('#edit_bitacora').submit(function( event ) {
            var select = $('select.sl_estado_edit').val();
            if($(".fec_edit_"+select).val() == ""){
                swal({
                    title: "",
                    text: "Favor de llenar el campo de fecha "+select,
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
            }else if($(".fec_bitacora_edit").val() == '' || $("select.sl_impacto_edit").val() == null || $(".num_afectados_edit").val() == '' || $(".num_correos_edit").val() == '' || $("select.sl_asignado_edit").val() == null || $("select.sl_afectado_edit").val() == null || $(".txt_bitacora_edit").val() == '' || $(".txt_responsable_edit").val() == '' || $(".num_caso_edit").val() == '' || $(".fec_recepcion_edit").val() == '' || $(".editar_bitacora").val() == ''){
                swal({
                    title: "",
                    text: "Favor de completar los campos",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
            }else{
                if($("select.sl_impacto_edit").val() == 'IMPACTO MUY ALTO'){
                    if($(".num_afectados_edit").val() >= 500 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas editar esta bitacora?',
                            text: "Recuerda haber llenado todo correctamente !",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1b9cdd',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                            showLoaderOnConfirm: false,
                            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                        }).then(function() {
                            $.ajax({
                                type: "POST",
                                url: "ajax/action_class/update/update_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se actualizo la bitacora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_edit_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al editar la bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se edito la bitácora",
                                type: "error",
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
                if($("select.sl_impacto_edit").val() == 'IMPACTO ALTO'){
                    if($(".num_afectados_edit").val() >= 100 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas editar esta bitácora?',
                            text: "Recuerda haber llenado todo correctamente !",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1b9cdd',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                            showLoaderOnConfirm: false,
                            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                        }).then(function() {
                            $.ajax({
                                type: "POST",
                                url: "ajax/action_class/update/update_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se actualizo la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_edit_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al editar la bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se edito la bitácora",
                                type: "error",
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
                if($("select.sl_impacto_edit").val() == 'IMPACTO MEDIO ALTO'){
                    if($(".num_afectados_edit").val() <= 100 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas editar esta bitácora?',
                            text: "Recuerda haber llenado todo correctamente !",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1b9cdd',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                            showLoaderOnConfirm: false,
                            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                        }).then(function() {
                            $.ajax({
                                type: "POST",
                                url: "ajax/action_class/update/update_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se actualizo la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_edit_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al editar la bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se edito la bitácora",
                                type: "error",
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
                if($("select.sl_impacto_edit").val() == 'IMPACTO MEDIO'){
                    if($(".num_afectados_edit").val() <= 20 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas editar esta bitácora?',
                            text: "Recuerda haber llenado todo correctamente !",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1b9cdd',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                            showLoaderOnConfirm: false,
                            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                        }).then(function() {
                            $.ajax({
                                type: "POST",
                                url: "ajax/action_class/update/update_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se actualizo la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_edit_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al editar la bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se edito la bitácora",
                                type: "error",
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
                if($("select.sl_impacto_edit").val() == 'IMPACTO BAJO'){
                    if($(".num_afectados_edit").val() == 1 ){
                        var datos = $(this).serialize();
                        swal({
                            title: 'Deseas editar esta bitácora?',
                            text: "Recuerda haber llenado todo correctamente !",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#1b9cdd',
                            cancelButtonColor: '#d33',
                            confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                            showLoaderOnConfirm: false,
                            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                        }).then(function() {
                            $.ajax({
                                type: "POST",
                                url: "ajax/action_class/update/update_bitacora.php",
                                data: datos,
                                success: function(data) {
                                    if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se actualizo la bitácora con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_edit_bitacora').modal('toggle');
                                        }, 600);
                                        tabla_bitacora_gestor.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al editar la bitácora, informalo al administrador y/o desarrollador",
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
                                text: "No se edito la bitácora",
                                type: "error",
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
            /*swal({
                title: 'Deseas editar esta bitácora?',
                text: "Recuerda haber llenado todo correctamente !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#1b9cdd',
                cancelButtonColor: '#d33',
                confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
                showLoaderOnConfirm: false,
                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
            }).then(function() {
                $.ajax({
                    type: "POST",
                    url: "ajax/action_class/update/update_bitacora.php",
                    data: datos,
                    success: function(data) {
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se actualizo la bitácora con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                                $('#modal_edit_bitacora').modal('toggle');
                            }, 600);
                            tabla_bitacora_gestor.ajax.reload( null, false );
                        }else{
                            swal({
                                title: "",
                                text: "Error al editar la bitácora, informalo al administrador y/o desarrollador",
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
                    text: "No se edito la bitácora",
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: true
                });
              }
            });
            }*/
        event.preventDefault();
    });
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>