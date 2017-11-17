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
    $object_permisos = new pid_permisos();
    $id_user = $_SESSION['id_user_apl'];
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

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
            <h3 class="modal-title">Insertar U.Resolutor</h3>
          </div>
          <div class="modal-body">
            <form id="insert_resolutor" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Nombre del U.Resolutor</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                <input name="txt_res" type="text" class="txt_res form-control" id="inputRes" placeholder="Usuario Resolutor">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Área</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <input name="txt_area" type="text" class="txt_area form-control" id="inputArea" placeholder="Área">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Jefe</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-star"></i></span>
                                <input name="txt_jefe" type="text" class="txt_jefe form-control" id="inputJefe" placeholder="Jefe">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-12">
                            <label>Cargo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-adn"></i></span>
                                <input name="txt_cargo" type="text" class="txt_cargo form-control" id="inputCargo" placeholder="Cargo">
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
    $('#insert_resolutor').submit(function(event){
    if ($(".txt_res").val() == '' || $(".txt_area").val() == '' || $(".txt_jefe").val() == '' || $(".txt_cargo").val() == '') {
        swal({
            title: "",
            text: "Favor de completar los campos",
            type: "warning",
            showCancelButton: false,
            showConfirmButton: true
        });
        return false;
        }else{
            var nom_res = $("#inputRes").val().toUpperCase();
            var area_res = $("#inputArea").val().toUpperCase();
            var jefe_res = $("#inputJefe").val().toUpperCase();
            var cargo_res = $("#inputCargo").val().toUpperCase();
            var resolutor = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "ajax/val_pid/validate_usuario_resolutor.php",
                data: "nom_res="+nom_res+"&area_res="+area_res+"&jefe_res="+jefe_res+"&cargo_res="+cargo_res,
                dataType: "html",
                success: function(data){                                                      
                    if(data == 0){
                        swal({
                             title: 'Deseas agregar este grupo?',
                             text: "Recuerda que esto se asociara con el grupo Área de Negocios",
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
                                 url: "ajax/action_class/insert/insert_resolutor.php",
                                 data: resolutor,
                                 success: function(data) {
                                     if(data == "true"){
                                        setTimeout(function(){
                                            swal({
                                                title: "",
                                                text: "Se agrego el usuario resolutor con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_resolutor').modal('toggle');
                                        }, 600);
                                        tabla_usuario_resolutor.ajax.reload( null, false );
                                     }else{
                                         swal({
                                            title: "",
                                            text: "Error al insertar al usuario resolutor, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ningun usuario resolutor",
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