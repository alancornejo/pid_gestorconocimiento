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
    $result_encuesta = $object_encuesta->listar_pre_encuestas();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['crea_opc_enc'] != "true"){
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
          <h3 class="modal-title">Agregar Opciones</h3>
        </div>
        <div class="modal-body">
            <form id="insert_enc_opciones" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Seleccione la pregunta a agregar</label>
                            <select name="sl_pregunta" id="inputPregunta" class="sl_pregunta selectpicker show-tick form-control" data-live-search="true" data-actions-box="true" data-header="Elegir la pregunta">
                                <option disabled selected>Seleccione la pregunta</option>
                                <?php while ($row_pre_enc = $result_encuesta->fetch_assoc()){ ?>
                                    <option value="<?= $row_pre_enc['id_enc_pregunta'] ?>"><?= $row_pre_enc['titulo_pregunta'] ?></option>
                                <?php } ?>
                            </select>
                        </section>
                    </div>
                    <div class="contenido_opciones">
                        
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
    
    $(document).ready(function() {
        $('select.sl_pregunta').on('changed.bs.select', function(){
            $('.contenido_opciones').hide();
            var datos = $(this).val();
            $.ajax({
                    type: "POST",
                    url: "ajax/load_php/encuesta/opciones_enc.php",
                    data: "id="+datos,
                    success: function(data) {
                        $('.contenido_opciones').fadeIn(500).html(data);
                    }
            });
        });
    });
    
    $("#insert_enc_opciones").validate({
        rules: {
            'txt_opcion[]': {
                required: true,
                minlength: 1
            },
            'sl_pregunta': {
                required: true
            }
        },
        messages: {
            'txt_opcion[]': "Porfavor llenar este campo",
            'sl_pregunta': "Porfavor llenar este campo"
        },
        invalidHandler: function () {
            setTimeout(function(){
                swal.close();
            },1);
        },
        submitHandler : function() {
            $('#insert_enc_opciones').submit(function( event ) {
                var datos = $(this).serialize();
                swal({
                    title: 'Deseas agregar estas opciones ?',
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
                        url: "ajax/action_class/encuesta/insert_enc_opciones.php",
                        data: datos,
                        success: function(data) {
                            if(data == "true"){
                                setTimeout(function(){     
                                    swal({
                                        title: "",
                                        text: "Se agregaron las opciones con exito",
                                        type: "success",
                                        showCancelButton: false,
                                        showConfirmButton: true
                                    }).then(function() {
                                        setTimeout(function(){
                                            $(document.body).css('padding-right','');
                                        },200);
                                    });
                                    $('#modal_ins_enc_opciones').modal('toggle');
                                }, 600);
                                tabla_opciones_encuesta.ajax.reload( null, false );
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al insertar las opciones, informalo al administrador y/o desarrollador",
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
                        text: "No se agrego ninguna opción",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                  }
                });
                event.preventDefault();
            });
        }
    });
    
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>