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
    require_once ('../../../data/pid_encuesta.php');
    require_once ('../../../data/pid_access.php');
    $object_permisos = new pid_permisos();
    $object_encuesta = new Encuesta();
    $id_user = $_SESSION['id_user_apl'];
    $id_enc_pregunta = $_GET['id'];
    $result_encuesta = $object_encuesta->listar_encuestas();
    $result_enc_pregunta = $object_encuesta->view_enc_pregunta($id_enc_pregunta);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    $row_encuesta = $result_enc_pregunta->fetch_assoc();

    if($row_permisos['edit_pre_enc'] != "true"){
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
          <h3 class="modal-title">Editar Pregunta</h3>
        </div>
        <div class="modal-body">
            <form id="edit_enc_pregunta" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-8">
                                <label>Titulo de la pregunta</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                    <input name="txt_pregunta" type="text" class="txt_pregunta form-control" id="inputTPregunta" placeholder="Titulo de la pregunta" value="<?= $row_encuesta['titulo_pregunta'] ?>">
                                    <input name="id_enc_pregunta" type="text" value="<?= $id_enc_pregunta ?>" hidden>
                                </div>
                        </section>
                        <section class="col col-4">
                          <label>Tipo de opciones</label>
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_opciones" id="inputRol" class="sl_opciones selectpicker_edit form-control" data-header="Tipo de Opciones">
                                      <option value="0" <?php if($row_encuesta['tipo_pregunta'] == "0") echo "selected";  ?>>Botones</option>
                                      <option value="1" <?php if($row_encuesta['tipo_pregunta'] == "1") echo "selected";  ?>>Comentario</option>
                                </select>
                          </div>
                        </section>
                    </div>
                    <div class="row">
                      <section class="col col-5">
                          <label>Estado de la pregunta</label>
                          <div class="input-group">
                              <span class="input-group-addon"><i class="fa fa-archive"></i></span>
                                <select name="sl_estado" id="inputRol" class="sl_estado selectpicker_edit form-control" data-header="Estado de la pregunta">
                                      <option value="1" <?php if($row_encuesta['estado_pregunta'] == "1") echo "selected";  ?>>Habilitado</option>
                                      <option value="0" <?php if($row_encuesta['estado_pregunta'] == "0") echo "selected";  ?>>Deshabilitado</option>
                                </select>
                          </div>
                       </section>
                       <section class="col col-3">
                          <label>Cantidad de opciones</label>
                          <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_opciones" type="text" class="num_opciones form-control" id="inputNOpciones" placeholder="N° Opciones" value="<?= $row_encuesta['cantidad_opciones'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                          </div>
                       </section>
                       <section class="col col-4">
                          <label>Asignar a :</label>
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_asignar" id="inputAsignar" class="sl_asignar selectpicker_edit form-control show-tick" data-header="Asignar a Examen" data-live-search="true" data-actions-box="true">
                                    <?php while ($row_sl_encuesta = $result_encuesta->fetch_assoc()){ ?>
                                    <option value="<?= $row_sl_encuesta['id_encuesta'] ?>" <?php if($row_encuesta['id_encuesta'] == $row_sl_encuesta['id_encuesta']) echo "selected"; ?>><?= $row_sl_encuesta['titulo_encuesta'] ?></option>
                                    <?php } ?>
                                </select>
                          </div>
                       </section>
                    </div>
                    <div class="row">
                        <section id="0" class="contenido_opciones col col-12" <?php if($row_encuesta['tipo_pregunta'] == "1") echo "hidden";  ?>>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                                <h4>Botones</h4>
                                <p>1° ¿Prueba de botones?</p>
                                <div id="scntDiv">
                                </div>
                            </div>
                        </section>
                        <section id="1" class="contenido_opciones col col-12" <?php if($row_encuesta['tipo_pregunta'] == "0") echo "hidden";  ?>>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Comentario</h4>
                              <p>1° ¿Comentario de Prueba?</p>
                              <p>
                                  Dirigido a : 
                                  <select class="selectpicker_edit">
                                      <option>Prueba</option>
                                  </select>
                              </p>
                              <p>
                                <textarea style="width: 412px; height: 50px;">
                                    Este es la caja de los comentarios
                                </textarea>
                              </p>
                            </div>
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
    
    $('.selectpicker_edit').selectpicker();
    
    $(document).ready(function() {
        $('select.sl_opciones').on('changed.bs.select', function(){
            $('.contenido_opciones').hide();
            $('#' + $(this).val()).fadeIn("blind");
            if($(this).val() == 0){
                $('.num_opciones').val("0");
            }else{
                $('.num_opciones').val("");
            }
        });
        
        var int = $(".num_opciones").val();
        var scntDiv2 = $('#scntDiv');
        for (var i=0; i<int; i++) {
            var i2 = i + 1;
            if(i==0){
                checked = "checked";
            }else{
                checked = "";
            }
            $('<p><input type="radio" value="'+i+'" name="1" id="radio_'+i+'" '+checked+'> Prueba Opcion '+i2+'</p>').appendTo(scntDiv2);
            scntDiv2.fadeIn(500);
        }
        
    });
       
    $('.num_opciones').keyup(function(){
        var int = $(this).val();
        var scntDiv = $('#scntDiv');
        scntDiv.fadeOut(0);
        scntDiv.html("");
        for (var i=0; i<int; i++) {
            var i2 = i + 1;
            if(i==0){
                checked = "checked";
            }else{
                checked = "";
            }
            $('<p><input type="radio" value="'+i+'" name="1" id="radio_'+i+'" '+checked+'> Prueba Opcion '+i2+'</p>').appendTo(scntDiv);
            scntDiv.fadeIn(500);
        }
    });
        
    $('#edit_enc_pregunta').submit(function( event ) {
        if($("select.sl_opciones").val() == 0 && $(".num_opciones").val() == 0){
            swal({
                title: "",
                text: "Favor de no dejar el número de opciones en 0",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
        }else if($("select.sl_opciones").val() == 1 && $(".num_opciones").val() != ''){
            swal({
                title: "",
                text: "Si es un comentario, favor de dejar en vacio el campo : Cantidad de Opciones",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
        }else{
            var datos = $(this).serialize();
            swal({
                title: 'Deseas editar esta pregunta',
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
                    url: "ajax/action_class/encuesta/edit_enc_pregunta.php",
                    data: datos,
                    success: function(data) {
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se edito la pregunta con exito, ahora favor de agregar las opciones",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    setTimeout(function(){
                                        $(document.body).css('padding-right','');
                                    },200);
                                });
                                $('#modal_edit_enc_pregunta').modal('toggle');
                            }, 600);
                            tabla_preguntas_encuesta.ajax.reload( null, false );
                        }else if(data == "comentario_deshabilitado"){
                            swal({
                                title: "",
                                text: "La encuesta con la que se desea asignar no permite comentarios",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                        }else{
                            swal({
                                title: "",
                                text: "Error al editar la pregunta, informalo al administrador y/o desarrollador",
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
                    text: "No se edito ninguna pregunta",
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