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
    require_once ('../../../data/pid_data.php');
    require_once ('../../../data/pid_access.php');
    $object = new last_id();
    $object_permisos = new pid_permisos();
    $id_user = $_SESSION['id_user_apl'];
    $result = $object->last_id_user();
    $row = $result->fetch_assoc();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['crea_usua'] != "true"){
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
          <h3 class="modal-title">Agregar Usuario</h3>
        </div>
        <div class="modal-body">
            <form id="insert_usuario" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-9">
                                <label>Nombre de Usuario</label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                    <input name="txt_usuario" type="text" class="txt_usuario form-control" id="inputUsuario" placeholder="Nombre de Usuario">
                                </div>
                        </section>
                        <section class="col col-3">
                            <label>Claro Usuario</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input name="txt_claro" type="text" class="txt_claro form-control" id="inputClaroUsuario" placeholder="EXXXXXX">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                      <section class="col col-4">
                          <label>Rol de Usuario</label>
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_rol" id="inputRol" class="sl_rol selectpicker form-control" data-header="Rol de Usuario">
                                      <option value="" disabled selected>Selecciona Aqui</option>
                                      <option value="0">Analista de Soporte 1er Nivel</option>
                                      <option value="1">Supervisor de Soporte 1er Nivel</option>
                                      <option value="2">Gestor de Servicio</option>
                                      <option value="3">Monitor de Calidad</option>
                                      <option value="4">Practicante de Mesa de Ayuda</option>
                                      <option value="5">Especialista BES</option>
                                      <option value="6">Asistente Administrativo</option>
                                      <option value="7">Jefe de Proyecto</option>
                                      <option value="8">Cliente de Proyecto</option>
                                      <option value="9">Apoyo de Cliente de Proyecto</option>
                                </select>
                          </div>
                      </section>
                      <section class="col col-4">
                          <label>Funcion del Usuario</label>
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_funcion" id="inputRol" class="sl_funcion selectpicker form-control" data-header="Funcion del Usuario">
                                      <option value="" disabled selected>Selecciona Aqui</option>
                                      <option value="0">Analista de Mesa de Ayuda</option>
                                      <option value="9">Analista Escalado</option>
                                      <option value="2">Gestor de Conocimiento</option>
                                      <option value="1">Gestor de Correo</option>
                                      <option value="8">Apoyo PID</option>
                                      <?php if($_SESSION['funcion_user'] == 4 || $_SESSION['funcion_user'] == 5){ ?>
                                      <option value="4">Administrador</option>
                                      <?php } ?>
                                      <?php if($_SESSION['funcion_user'] == 2 || $_SESSION['funcion_user'] == 4 || $_SESSION['funcion_user'] == 5){ ?>
                                      <option value="6">Cliente de Proyecto</option>
                                      <option value="7">Apoyo Cliente de Proyecto</option>
                                      <?php } ?>
                                </select>
                          </div>
                      </section>
                      <section class="col col-4">
                          <label>Tipo de Servicio</label>
                          <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                                <select name="sl_servicio" id="inputServicio" class="sl_servicio selectpicker form-control" data-header="Tipo de Servicio">
                                      <option value="0" selected>Aplicaciones</option>
                                      <option value="1">Biométrico</option>
                                </select>
                          </div>
                      </section>
                      <input name="last_id_user" value="<?= $row['id_last_user'] ?>" hidden>
                    </div>
                    <div class="row">
                        <section id="0" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Analista de Mesa de Ayuda</h4>
                              <p>Podra interactuar de manera dinamica, las vistas de la plataforma.</p>
                            </div>
                        </section>
                        <section id="2" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Gestor de conocimiento y/o Apoyo</h4>
                              <p>Podra agregar, modificar y/o aprobar documentos del módulo KDB, como tambien poder eliminarlos, reiniciar los contadores de los documentos del KDB, como tambien exportar la data de esta misma.</p>
                            </div>
                        </section>
                        <section id="1" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Gestor de Correo y/o Apoyo</h4>
                              <p>Podra agregar y modificar las bitácoras en la plataforma, como tambien exportar la data de esta misma.</p>                      
                            </div>
                        </section>
                        <section id="4" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Administrador</h4>
                              <p>Este rol tendra el acceso a todas las funciones de la plataforma.</p>
                            </div>
                        </section>
                        <section id="6" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Cliente de Proyecto</h4>
                              <p>Este rol solo podra tener acceso al módulo visual del KDB y de la Bitácora.</p>
                            </div>
                        </section>
                        <section id="7" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Apoyo de Cli.Proyecto</h4>
                              <p>Cuenta con las mismas caracteristicas que el Cliente de Proyecto.</p>
                            </div>
                        </section>
                        <section id="8" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Apoyo PID</h4>
                              <p>Este rol, define a los usuarios que tendran permisos y estaran de apoyo en la plataforma para distintas tareas.</p>
                            </div>
                        </section>
                        <section id="9" class="funcion_estado col col-12" hidden>
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning">
                              <h4>Analista Escalado</h4>
                              <p>Este rol, podra gestionar la pestaña de comunicados ATC.</p>
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
    
    $('.selectpicker').selectpicker();
    
    $(document).ready(function() {
        $('select.sl_funcion').on('changed.bs.select', function(){
            $('.funcion_estado').hide();
            $('#' + $(this).val()).fadeIn("blind");
        });
    });
        
    $('#insert_usuario').submit(function( event ) {
        if ($(".txt_usuario").val() == '' || $(".txt_claro").val() == '' || $("select.sl_rol").val() == null || $("select.sl_funcion").val() == null) {
            swal({
                title: "",
                text: "Favor de completar los campos",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
            }else{
                var claro_user = $("#inputClaroUsuario").val().toUpperCase();
                console.log(claro_user);
                var datos = $(this).serialize();
                $.ajax({
                type: "POST",
                url: "ajax/val_pid/validate_user.php",
                data: "claro_usuario="+claro_user,
                dataType: "html",
                    success: function(data){
                        console.log(data);
                        if(data == 0){
                            swal({
                                title: 'Deseas agregar a este usuario',
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
                                    url: "ajax/action_class/insert/insert_usuario.php",
                                    data: datos,
                                    success: function(data) {
                                        if(data == "true"){
                                            setTimeout(function(){     
                                                swal({
                                                    title: "",
                                                    text: "Se agrego al usuario con exito",
                                                    type: "success",
                                                    showCancelButton: false,
                                                    showConfirmButton: true
                                                }).then(function() {
                                                    setTimeout(function(){
                                                        $(document.body).css('padding-right','');
                                                    },200);
                                                });
                                                $('#modal_ins_usuario').modal('toggle');
                                            }, 600);
                                            tabla_usuarios_gestor.ajax.reload( null, false );
                                        }else{
                                            swal({
                                                title: "",
                                                text: "Error al insertar el usuario, informalo al administrador y/o desarrollador",
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
                                    text: "No se agrego ningun usuario",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                              }
                            });
                        }else{
                            swal({
                                title: "",
                                text: "Este usuario ya esta registrado, intenta con otro",
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