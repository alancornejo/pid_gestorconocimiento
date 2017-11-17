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
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $id = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $result_view = $object->view_contenido_jobs($id);
    $result_apl = $object->view_apl_jobs();
    $row = $result_view->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_ma_jobs'] != "true"){
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
              <h3 class="modal-title">Editar Fila de Matriz de Jobs</h3>
            </div>
            <div class="modal-body">
                <form id="edit_jobs" class="sky-form">
                    <fieldset>
                        <div class="row">
                            <section class="col col-3">
                                <label>Nombre de JOB</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                    <input name="nom_job" type="text" id="inputNomJob" class="nom_job form-control" value="<?= $row['nom_job'] ?>">
                                    <input name="id_jobs" type="text" value="<?= $id ?>" hidden>
                                </div>
                            </section>
                            <section class="col col-6">
                                <label>Aplicacion</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                    <select name="apl_job" type="text" id="inputAplJob" class="apl_job selectpicker form-control" data-header="Aplicativo" data-live-search="true" data-title="Aplicativo">
                                        <?php while ($row_apl = $result_apl->fetch_assoc()){ ?>
                                          <option value="<?= utf8_encode($row_apl['apl_job']) ?>" 
                                              <?php if(utf8_encode($row_apl['apl_job']) == utf8_encode($row['apl_job'])){
                                                      echo "selected";
                                                  } 
                                          ?>><?= utf8_encode($row_apl['apl_job']) ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </section>
                            <section class="col-md-3">
                                <label>Grupo de JOB</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                    <input name="group_job" type="text" id="inputGroJob" class="group_job form-control" value="<?= utf8_encode($row['group_job']) ?>" style="width: 150px;">
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-2">
                                <label>Ciclico</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-circle-o"></i></span>
                                    <select name="cyclic_job" id="inputCycJob" class="cyclic_job selectpicker form-control">
                                        <option value="Yes" <?php if($row['cyclic_job'] == "Yes"){ echo "selected"; }else{ echo ""; } ?>>Yes</option>
                                        <option value="No" <?php if($row['cyclic_job'] == "No"){ echo "selected"; }else{ echo ""; } ?>>No</option>
                                    </select>
                                </div>
                            </section>
                            <section class="col col-5">
                                <label>Nombre de Analista</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input name="nom_analista_job" type="text" id="inputAnaNom" class="nom_analista_job form-control" value="<?= utf8_encode($row['nom_analista_job']) ?>">
                                </div>
                            </section>
                            <section class="col col-5">
                                <label>Observacion</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-object-group"></i></span>
                                    <input name="obs_job" type="text" id="inputObs" class="obs_job form-control" value="<?= utf8_encode($row['obs_job']) ?>">
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-12">
                                <label>Descripcion</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-tag"></i></span>
                                    <input name="desc_job" type="text" class="desc_job form-control" id="inputDescripcion" value="<?= utf8_encode($row['desc_job']) ?>">
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
    
    $('.selectpicker').selectpicker();
    
    $('#edit_jobs').submit(function( event ) {
        var datos = $(this).serialize();
            swal({
                title: 'Deseas editar esta fila de la matriz?',
                text: "Recuerda que esto cambiara el contenido !",
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
                    url: "ajax/action_class/update/update_jobs.php",
                    data: datos,
                    success: function(data) {
                        if(data == "true"){
                            setTimeout(function(){     
                                swal({
                                    title: "",
                                    text: "Se actualizo una fila de la matriz con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    setTimeout(function(){
                                        $(document.body).css('padding-right','');
                                    },200);
                                });
                                $('#modal_edit_jobs').modal('toggle');
                            }, 600);
                            tabla_jobs_gestor.ajax.reload( null, false );
                        }else{
                            swal({
                                title: "",
                                text: "Error al editar la fila de la matriz, informalo al administrador y/o desarrollador",
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
                    text: "No se edito la fila de la matriz",
                    type: "error",
                    showCancelButton: false,
                    showConfirmButton: true
                });
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