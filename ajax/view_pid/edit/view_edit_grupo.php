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
    $result = $object->view_grupo($id);
    $row = $result->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_grupo'] != "true"){
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
            <h3 class="modal-title">Editar Grupo Asignado</h3>
          </div>
          <div class="modal-body">
            <form id="edit_grupo" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Nombre del Grupo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <input name="txt_grupo" type="text" class="txt_grupo form-control" id="inputGrupoAsignado" value="<?= $row['nom_grupo'] ?>" placeholder="Grupo Asignado">
                                <input name="id_grupo" type="text" value="<?= $id ?>" hidden>
                                <input name="txt_grupo_original" type="text" value="<?= $row['nom_grupo'] ?>" hidden>
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
    $('#edit_grupo').submit(function(event){
        var nom_grupo = $("#inputGrupoAsignado").val().toUpperCase();
        var aplicativo = $(this).serialize();
        $.ajax({
            type: "POST",
            url: "ajax/val_pid/validate_grupo_asignado.php",
            data: "nom_grupo="+nom_grupo,
            dataType: "html",
            success: function(data){                                                      
                if(data == 0){
                    swal({
                         title: 'Deseas editar este grupo?',
                         text: "Recuerda que esto se mostrara en los grupos del KDB",
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
                             url: "ajax/action_class/update/update_grupo.php",
                             data: aplicativo,
                             success: function(data) {
                                 if(data == "true"){
                                    setTimeout(function(){     
                                        swal({
                                            title: "",
                                            text: "Se actualizo el grupo con exito",
                                            type: "success",
                                            showCancelButton: false,
                                            showConfirmButton: true
                                        }).then(function() {
                                            setTimeout(function(){
                                                $(document.body).css('padding-right','');
                                            },200);
                                        });
                                        $('#modal_edit_grupo').modal('toggle');
                                    }, 600);
                                    tabla_grupo_asignado.ajax.reload( null, false );
                                }else{
                                    swal({
                                        title: "",
                                        text: "Error al editar el grupo asignado, informalo al administrador y/o desarrollador",
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
                            text: "No se edito el grupo",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                       }
                     })
                }else{
                    swal({
                        title: "",
                        text: "Este grupo ya esta registrado, intenta con otro",
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