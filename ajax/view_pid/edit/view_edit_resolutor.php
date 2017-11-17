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
    $object_permisos = new pid_permisos();
    $object_edit = new pid_view();
    $id_user = $_SESSION['id_user_apl'];
    $id_res = $_GET['id'];
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result_edit = $object_edit->view_usuario_edit_resolutor($id_res);
    $row_permisos = $result_permisos->fetch_assoc();
    $row_res = $result_edit->fetch_assoc();

    if($row_permisos['crea_grupo'] != "true"){
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
            <h3 class="modal-title">Editar U.Resolutor</h3>
          </div>
          <div class="modal-body">
            <form id="edit_resolutor" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Nombre del U.Resolutor</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input name="txt_res_edit" type="text" class="txt_res_edit form-control" id="inputResEdit" placeholder="Usuario Resolutor" value="<?= $row_res['nom_res'] ?>">
                                <input name="id_res" type="text" value="<?= $id_res ?>" hidden>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Área</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <input name="txt_area_edit" type="text" class="txt_area_edit form-control" id="inputAreaEdit" placeholder="Área" value="<?= $row_res['area_res'] ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Jefe</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-star"></i></span>
                                <input name="txt_jefe_edit" type="text" class="txt_jefe_edit form-control" id="inputJefeEdit" placeholder="Jefe" value="<?= $row_res['jefe_res'] ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Cargo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-adn"></i></span>
                                <input name="txt_cargo_edit" type="text" class="txt_cargo_edit form-control" id="inputCargoEdit" placeholder="Cargo" value="<?= $row_res['cargo_res'] ?>">
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
    $('#edit_resolutor').submit(function(event){
    if ($(".txt_res_edit").val() == '' || $(".txt_area_edit").val() == '' || $(".txt_jefe_edit").val() == '' || $(".txt_cargo_edit").val() == '') {
        swal({
            title: "",
            text: "Favor de completar los campos",
            type: "warning",
            showCancelButton: false,
            showConfirmButton: true
        });
        return false;
        }else{
            var nom_res = $("#inputResEdit").val().toUpperCase();
            var area_res = $("#inputAreaEdit").val().toUpperCase();
            var jefe_res = $("#inputJefeEdit").val().toUpperCase();
            var cargo_res = $("#inputCargoEdit").val().toUpperCase();
            var resolutor = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "ajax/val_pid/validate_usuario_resolutor.php",
                data: "nom_res="+nom_res+"&area_res="+area_res+"&jefe_res="+jefe_res+"&cargo_res="+cargo_res,
                dataType: "html",
                success: function(data){                                                      
                    if(data == 0){
                        swal({
                             title: 'Deseas editar este grupo?',
                             text: "Recuerda que esto se asociara con el grupo Área de Negocios",
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
                                 url: "ajax/action_class/update/update_resolutor.php",
                                 data: resolutor,
                                 success: function(data) {
                                     if(data == "true"){
                                        setTimeout(function(){
                                            swal({
                                                title: "",
                                                text: "Se edito el usuario resolutor con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_edit_resolutor').modal('toggle');
                                        }, 600);
                                        tabla_usuario_resolutor.ajax.reload( null, false );
                                     }else{
                                         swal({
                                            title: "",
                                            text: "Error al editar al usuario resolutor, informalo al administrador y/o desarrollador",
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
                                text: "No se edito ningun usuario resolutor",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                           }
                         });
                    }else{
                        swal({
                            title: "",
                            text: "Este usuario resolutor ya esta registrado, intenta con otro",
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