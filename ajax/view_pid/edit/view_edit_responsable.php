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
    $result_area = $object->view_area_resp();
    $result_apl_pl = $object->view_aplicativo_plataforma_caso();
    $result_cargo = $object->view_cargo();
    $result_responsable = $object->view_responsable();
    $result_view = $object->view_contenido_responsable($id);
    $row = $result_view->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['edit_ma_resp'] != "true"){
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
          <h3 class="modal-title">Editar Fila de Matriz de Responsables</h3>
        </div>
        <div class="modal-body">
            <form id="edit_responsable" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-5">
                            <label>Área Responsable</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_area_resp" id="inputARespons" class="sl_area_resp selectpicker show-tick show-menu-arrow form-control" data-header="Área Responsable" data-live-search="true">
                                <?php while ($row_area = $result_area->fetch_assoc()){ ?>
                                    <option value="<?= utf8_encode($row_area['area_resp']) ?>" 
                                        <?php if(utf8_encode($row_area['area_resp']) == utf8_encode($row['area_resp'])){
                                                echo "selected";
                                            } 
                                    ?>><?= utf8_encode($row_area['area_resp']) ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </section>
                        <section class="col col-7">
                            <label>Aplicativo/Plataforma/Caso</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-android"></i></span>
                                <select name="sl_apl_pl_caso" id="inputAPlatCaso" class="sl_apl_pl_caso selectpicker show-tick show-menu-arrow form-control" data-header="Aplicativo/Plataforma/Caso" data-live-search="true">
                                <?php while ($row_apl_pl = $result_apl_pl->fetch_assoc()){ ?>
                                    <option value="<?= utf8_encode($row_apl_pl['apl_pla']) ?>" 
                                        <?php if(utf8_encode($row_apl_pl['apl_pla']) == utf8_encode($row['apl_pla'])){
                                                echo "selected";
                                            } 
                                    ?>><?= substr(utf8_encode($row_apl_pl['apl_pla']),0,72) ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-3">
                            <label>Tipo Cargo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-key"></i></span>
                                <select name="sl_cargo" id="inputCargo" class="sl_cargo selectpicker show-tick show-menu-arrow form-control" data-header="Cargo" data-live-search="true">>
                                    <?php while ($row_cargo = $result_cargo->fetch_assoc()){ ?>
                                        <option value="<?= utf8_encode($row_cargo['tipo_cargo']) ?>" 
                                            <?php if(utf8_encode($row_cargo['tipo_cargo']) == utf8_encode($row['tipo_cargo'])){
                                                    echo "selected";
                                                } 
                                        ?>><?= utf8_encode($row_cargo['tipo_cargo']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Responsable</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <select name="sl_responsable" id="inputResponsable" class="sl_responsable selectpicker show-tick show-menu-arrow form-control" data-header="Nombre de Responsable" data-live-search="true">>
                                    <?php while ($row_responsable = $result_responsable->fetch_assoc()){ ?>
                                        <option value="<?= utf8_encode($row_responsable['nom_responsable']) ?>" 
                                            <?php if(utf8_encode($row_responsable['nom_responsable']) == utf8_encode($row['nom_responsable'])){
                                                    echo "selected";
                                                } 
                                        ?>><?= utf8_encode($row_responsable['nom_responsable']) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Anexo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input name="txt_anexo" type="text" class="txt_anexo form-control" id="inputAnexo" value="<?= $row['num_anexo'] ?>">
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Celular</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input name="txt_telefono" type="text" class="txt_telefono form-control" id="inputTelefono" value="<?= $row['num_celular'] ?>">
                                <input name="txt_id_matriz" type="text" value="<?= $id ?>" hidden>
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
    
    $('#edit_responsable').submit(function( event ) {
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
                    url: "ajax/action_class/update/update_responsable.php",
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
                                $('#modal_edit_responsable').modal('toggle');
                            }, 600);
                            tabla_responsable_gestor.ajax.reload( null, false );
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