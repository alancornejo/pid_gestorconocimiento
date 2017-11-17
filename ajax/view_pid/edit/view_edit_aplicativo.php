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
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $result = $object->view_aplicativo($id);
    $result_view = $object->list_categoria();
    $result_view_g = $object->view_grupo_asignado();
    $row = $result->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_apli'] != "true"){
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
            <h3 class="modal-title">Editar Aplicativo</h3>
          </div>
          <div class="modal-body">
            <form id="edit_aplicativo" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Nombre del Aplicativo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <input name="nom_apli_edit" type="text" class="nom_apli_edit form-control" id="inputAplicativoEdit" value="<?= $row['nom_apli'] ?>" placeholder="Aplicativo">
                                <input name="id_apli" type="text" value="<?= $id ?>" hidden>
                                <input name="nom_apli_original" type="text" value="<?= $row['nom_apli'] ?>" hidden>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Tipo de Flujo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                <select name="sl_flujo_edit" id="inputFlujoEdit" class="sl_flujo_edit selectpicker_edit form-control show-tick" data-header="Tipo de Flujo" data-live-search="true">
                                    <?php while($row_c = $result_view->fetch_assoc()){ ?>
                                    <option value="<?= $row_c['id_cat'] ?>" <?php if($row_c['id_cat'] == $row['id_cat']){ echo "selected"; } ?>><?= $row_c['nom_cat'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Grupo Responsable</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                <select name="sl_grupo_edit" id="inputGrupoEdit" class="sl_grupo_edit selectpicker_edit form-control show-tick" data-header="Grupo Responsable" data-live-search="true">
                                    <?php while($row_g = $result_view_g->fetch_assoc()){ ?>
                                    <option value="<?= $row_g['id_grupo'] ?>" <?php if($row_g['id_grupo'] == $row['id_grupo']){ echo "selected"; } ?>><?= $row_g['nom_grupo'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
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
    
    $(document).ready(function() {
        $('.selectpicker_edit').selectpicker();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });
    
    $('#edit_aplicativo').submit(function(event){
        var nom_apl = $("#inputAplicativoEdit").val().toUpperCase();
        var id_cat = $("#inputFlujoEdit").val();
        var id_grupo = $("#inputGrupoEdit").val();
        var aplicativo = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "ajax/val_pid/validate_aplicativo.php",
            data: "nom_apl="+nom_apl+"&id_cat="+id_cat+"&id_grupo="+id_grupo,
            dataType: "html",
            success: function(data){                                                      
                if(data == 0){
                    swal({
                         title: 'Deseas editar este aplicativo?',
                         text: "Recuerda que esto se mostrara en los aplicativos del KDB",
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
                             url: "ajax/action_class/update/update_aplicativo.php",
                             data: aplicativo,
                             success: function(data) {
                                 if(data == "true"){
                                    setTimeout(function(){     
                                        swal("PID - CLARO AN", "Se modifico el aplicativo.", "success");
                                        swal({
                                            title: "",
                                            text: "Se actualizo el aplicativo con exito",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: true
                                        }).then(function() {
                                            setTimeout(function(){
                                                $(document.body).css('padding-right','');
                                            },200);
                                        });
                                        $('#modal_edit_aplicativo').modal('toggle');
                                    }, 600);
                                    tabla_aplicativos.ajax.reload( null, false );
                                 }else{
                                    swal({
                                        title: "",
                                        text: "Error al editar el aplicativo, informalo al administrador y/o desarrollador",
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
                            text: "No se edito el aplicativo",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                       }
                     });
                }else{
                    swal({
                        title: "",
                        text: "Este aplicativo ya esta registrado, intenta con otro",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    }).then(function() {
                        setTimeout(function(){
                            $(document.body).css('padding-right','');
                        },200);
                    });
                }
            }
        });
        event.preventDefault();
    }); 
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>