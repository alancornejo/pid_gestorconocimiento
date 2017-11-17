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
    $id = $_GET['id'];
?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h3 class="modal-title">Cambiar Contraseña</h3>
            </div>
            <div class="modal-body">
                <form id="edit_password" class="sky-form">
                    <fieldset>
                        <div class="row">
                            <section class="col col-11">
                                <label>Contraseña</label>
                                <div class="input-group">
                                    <input name="txt_password" type="password" class="txt_password form-control" id="inputContraseña" placeholder="Nueva contraseña">
                                    <input name="user_id" type="text" value="<?= $id ?>" hidden>
                                    <span style="cursor:pointer" class="input-group-addon view_password"><i class="fa fa-eye text-primary"></i></span>
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section id="mensaje" class="col col-12" hidden>
                                <div class="alert alert-dismissible alert-warning">
                                    <p><i class="fa fa-warning"></i> Recuerda, guardar tu contraseña!</p>
                                </div>
                            </section>
                        </div>
                        <div class="row modal-footer">
                            <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                            <input class="btn btn-primary" type="submit" value="Cambiar">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
<script>
    $(".txt_password").keyup(function (){
        $("#mensaje").show();
    });
    
    $(".view_password").mousedown(function(){
        $("#inputContraseña").attr('type','text');
    }).mouseup(function(){
        $("#inputContraseña").attr('type','password');
    }).mouseout(function(){
        $("#inputContraseña").attr('type','password');
    });

    $('#edit_password').submit(function( event ) {
        var datos = $(this).serialize();
        swal({
            title: 'Realmente deseas cambiar tu contraseña?',
            text: "Recuerda guardar tu contraseña",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-edit"></i> Cambiar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "POST",
                url: "ajax/action_class/update/update_password.php",
                data: datos,
                success: function(data) {
                    if(data == "true"){
                        swal({
                             title: "",
                             text: "Tu contraseña fue actualizado con exito, porfavor espere un momento...",
                             type: "success",
                             showConfirmButton: false
                         });
                        setTimeout(function (){
                         window.location.href = "logout";
                        },1500);
                    }else{
                        swal({
                            title: "",
                            text: "Error al editar tu contraseña, informalo al administrador y/o desarrollador",
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
                text: "No se cambio tu contraseña",
                type: "error",
                showCancelButton: false,
                showConfirmButton: true
            });
          }
        })
        event.preventDefault();
    });

</script>
<?php } ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>