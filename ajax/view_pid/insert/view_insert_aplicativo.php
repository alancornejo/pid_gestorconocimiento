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
    require_once ('../../../data/pid_access.php');
    require_once ('../../../data/pid_view.php');
    $id_user = $_SESSION['id_user_apl'];
    $object_permisos = new pid_permisos();
    $object_view = new pid_view();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result_view = $object_view->list_categoria();
    $result_view_g = $object_view->view_grupo_asignado();
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['crea_apli'] != "true"){
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
            <h3 class="modal-title">Insertar Aplicativo</h3>
          </div>
          <div class="modal-body">
            <form id="insert_aplicativo" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Nombre del Aplicativo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-wrench"></i></span>
                                <input name="nom_apli" type="text" class="nom_apli form-control" id="inputAplicativo" placeholder="Aplicativo">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Tipo de Flujo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                <select name="sl_flujo" id="inputFlujo" class="sl_flujo selectpicker form-control show-tick" data-header="Tipo de Flujo" data-live-search="true">
                                    <option data-content="Selecciona Aqui" value="" selected>Selecciona Aqui</option>
                                    <?php while($row = $result_view->fetch_assoc()){ ?>
                                    <option value="<?= $row['id_cat'] ?>"><?= $row['nom_cat'] ?></option>
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
                                <select name="sl_grupo" id="inputGrupo" class="sl_grupo selectpicker form-control show-tick" data-header="Grupo Responsable" data-live-search="true">
                                    <option data-content="Selecciona Aqui" value="" selected>Selecciona Aqui</option>
                                    <?php while($row_g = $result_view_g->fetch_assoc()){ ?>
                                    <option value="<?= $row_g['id_grupo'] ?>"><?= $row_g['nom_grupo'] ?></option>
                                    <?php } ?>
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
    
    $(document).ready(function() {
        $('.selectpicker').selectpicker();
        $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    });
    
    $('#insert_aplicativo').submit(function(event){
    if ($(".nom_apli").val() == '' || $('select.sl_flujo').val() == null || $('select.sl_grupo').val() == null) {
            swal({
                title: "",
                text: "Favor de completar los campos",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
        }else{
            var nom_apl = $("#inputAplicativo").val().toUpperCase();
            var id_cat = $("#inputFlujo").val();
            var id_grupo = $("#inputGrupo").val();
            var aplicativo = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "ajax/val_pid/validate_aplicativo.php",
                data: "nom_apl="+nom_apl+"&id_cat="+id_cat+"&id_grupo="+id_grupo,
                dataType: "html",
                success: function(data){                                                      
                    if(data == 0){
                        swal({
                             title: 'Deseas agregar este aplicativo?',
                             text: "Recuerda que esto se mostrara en los aplicativos del KDB",
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
                                 url: "ajax/action_class/insert/insert_aplicativo.php",
                                 data: aplicativo,
                                 success: function(data) {
                                     if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se agrego el aplicativo con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_aplicativo').modal('toggle');
                                        }, 600);
                                        tabla_aplicativos.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al insertar el aplicativo, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ningun aplicativo",
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
                            type: "warning",
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