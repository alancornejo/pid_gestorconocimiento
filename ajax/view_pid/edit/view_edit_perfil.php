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
    $_SESSION['filemanager_categoria'] = "perfil_usuario";
    require_once ('../../../data/pid_access.php');
    $object = new pid_auth();
    $object_permisos = new pid_permisos();
    $id_user = $_SESSION['id_user_apl'];
    $user_id = $_GET['id'];
    $result = $object->user_perfil_auth($user_id);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result_user = $object->user_auth($id_user);
    $row = $result->fetch_assoc(); 
    $row_permisos = $result_permisos->fetch_assoc();
    $row_user = $result_user->fetch_assoc();

    if($row_permisos['edit_perfil_usua'] == "false"){
        if($id_user != $user_id){
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
            <h3 class="modal-title">Editar Perfil</h3>
        </div>
        <div class="modal-body">
            <form id="edit_perfil" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-9">
                            <label>Nombre Completo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="id_user" type="text" value="<?= $user_id ?>" hidden>
                                <input name="txt_nombre" type="text" class="txt_nombre form-control" id="inputNombre" placeholder="Nombre Completo" value="<?php if($row['nom_user_perfil'] == NULL || $row['nom_user_perfil'] == ""){ echo utf8_encode($row['nom_user']);  }else{ echo utf8_encode($row['nom_user_perfil']); }?>" onkeypress="return event.charCode >= 1 && event.charCode <= 1 || event.keyCode == 9" style="cursor: no-drop">
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>N° DNI</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_dni" type="text" class="num_dni form-control" id="inputDNI" placeholder="N° DNI" value="<?= $row['dni_user'] ?>" <?php if($row_user['dni_editado'] == "1"){ ?> style="cursor: no-drop" onkeypress="return event.charCode >= 1 && event.charCode <= 1 || event.keyCode == 9" <?php }else{ ?> onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9" <?php } ?>>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-3">
                            <label>Número Celular</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input name="num_celular" type="text" class="num_celular form-control" id="inputCelular" placeholder="N° Celular" value="<?= $row['telefono_user'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Número Fijo/Domicilio</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input name="num_fijo" type="text" class="num_fijo form-control" id="inputFijo" placeholder="N° Fijo" value="<?= $row['telefono_fijo_user'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-info" style="height: 35px;">
                                <p style="margin-top: -8px;"><i class="fa fa-exclamation-triangle text-info"></i> Recuerda que estos datos seran para RRHH</p>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-5">
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning" style="height: 35px;">
                                <p style="margin-top: -8px;"><i class="fa fa-exclamation-triangle text-warning"></i> Llenar con datos reales</p>
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Número de Referencia</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input name="num_referencia" type="text" class="num_referencia form-control" id="inputReferencia" placeholder="N° Referencia" value="<?= $row['telefono_referencia_user'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Parentesco</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_parentesco" class="sl_parentesco selectpicker_edit show-tick show-menu-arrow form-control" data-header="Parentesco">
                                    <option value="" <?php if($row['ref_parentesco'] == NULL || $row['ref_parentesco'] == ""){ echo "selected"; } ?>>Selecciona Aqui</option>
                                    <option value="0" <?php if($row['ref_parentesco'] == "0"){ echo "selected"; } ?>>Mamá</option>
                                    <option value="1" <?php if($row['ref_parentesco'] == "1"){ echo "selected"; } ?>>Papá</option>
                                    <option value="2" <?php if($row['ref_parentesco'] == "2"){ echo "selected"; } ?>>Hermano</option>
                                    <option value="3" <?php if($row['ref_parentesco'] == "3"){ echo "selected"; } ?>>Hermana</option>
                                    <option value="4" <?php if($row['ref_parentesco'] == "4"){ echo "selected"; } ?>>Esposo</option>
                                    <option value="5" <?php if($row['ref_parentesco'] == "5"){ echo "selected"; } ?>>Esposa</option>
                                    <option value="6" <?php if($row['ref_parentesco'] == "6"){ echo "selected"; } ?>>Hijo</option>
                                    <option value="7" <?php if($row['ref_parentesco'] == "7"){ echo "selected"; } ?>>Hija</option>
                                    <option value="8" <?php if($row['ref_parentesco'] == "8"){ echo "selected"; } ?>>Tio</option>
                                    <option value="9" <?php if($row['ref_parentesco'] == "9"){ echo "selected"; } ?>>Tia</option>
                                    <option value="10" <?php if($row['ref_parentesco'] == "10"){ echo "selected"; } ?>>Amigo</option>
                                    <option value="11" <?php if($row['ref_parentesco'] == "11"){ echo "selected"; } ?>>Amiga</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <style>
                        .input-group .form-control{
                            float:none;
                        }
                    </style>
                    <div class="row">
                        <section class="col col-4">
                            <label>Género</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mars"></i></span>
                                <select name="sl_genero" id="inputGenero" class="sl_genero selectpicker_edit show-tick show-menu-arrow form-control" >
                                    <option value="" <?php if($row['genero_user'] == NULL || $row['genero_user'] == ""){ echo "selected"; }else{ echo "disabled"; } ?>>Selecciona Aqui</option>
                                    <option data-content="<i class='fa fa-male' style='color:green'></i> Masculino" value="0" <?php if($row['genero_user'] == "0"){ echo "selected"; } ?>>Masculino</option>
                                    <option data-content="<i class='fa fa-female' style='color:pink'></i> Femenino" value="1" <?php if($row['genero_user'] == "1"){ echo "selected"; } ?>>Femenino</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Situación Familiar</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <select name="sl_familiar" id="inputFamiliar" class="sl_familiar selectpicker_edit show-tick show-menu-arrow form-control" data-header="Situación Familiar">
                                    <option value="" <?php if($row['situacion_familiar'] == NULL || $row['situacion_familiar'] == ""){ echo "selected"; }else{ echo "disabled"; } ?>>Selecciona Aqui</option>
                                    <option data-content="<i class='fa fa-close' style='color:red'></i> Sin Hijos" value="0" <?php if($row['situacion_familiar'] == "0"){ echo "selected"; } ?>>Sin Hijos</option>
                                    <option data-content="<i class='fa fa-check' style='color:green'></i> Con Hijos" value="1" <?php if($row['situacion_familiar'] == "1"){ echo "selected"; } ?>>Con Hijos</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4 num_hijos_div" id="edit_con_hijos_1" <?php if($row['situacion_familiar'] == "1"){ echo ""; }else{ echo "hidden"; } ?>>
                            <label>N° Hijos</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-child"></i></span>
                                <input name="num_hijos" type="text" class="num_hijos form-control" id="inputHijos" placeholder="N° Hijos" value="<?= $row['num_hijos'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Fecha de Nacimiento</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="inputFecNac" type="text" name="fec_nac" class="fec_nac form-control" value="<?= $row['fecha_nacimiento'] ?>" onkeypress="return event.charCode >= 1 && event.charCode <= 1 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Fecha de Ingreso</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="inputFecIngreso" type="text" name="fec_ingreso" class="fec_ingreso form-control" value="<?= $row['fec_ingreso'] ?>" onkeypress="return event.charCode >= 1 && event.charCode <= 1 || event.keyCode == 9">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Estado Académico</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                                <select name="sl_est_academico" id="inputAcademico" class="sl_est_academico selectpicker_edit show-tick show-menu-arrow form-control" data-width="160px" data-header="Estado Académico">
                                    <option value="" <?php if($row['estado_academico'] == NULL || $row['genero_user'] == ""){ echo "selected"; } ?>>Selecciona Aqui</option>
                                    <option value="0" <?php if($row['estado_academico'] == "0"){ echo "selected"; } ?>>Técnica</option>
                                    <option value="1" <?php if($row['estado_academico'] == "1"){ echo "selected"; } ?>>Universitaria</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Situación Académica</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <select name="sl_academica" id="inputAcademica" class="sl_academica selectpicker_edit show-tick show-menu-arrow form-control" data-width="152px" data-header="Situacion Académica">
                                    <option value="" <?php if($row['situacion_academica'] == NULL || $row['genero_user'] == ""){ echo "selected"; } ?>>Selecciona Aqui</option>
                                    <option value="0" <?php if($row['situacion_academica'] == "0"){ echo "selected"; } ?>>En Curso</option>
                                    <option value="1" <?php if($row['situacion_academica'] == "1"){ echo "selected"; } ?>>Trunco</option>
                                    <option value="2" <?php if($row['situacion_academica'] == "2"){ echo "selected"; } ?>>Egresado</option>
                                    <option value="3" <?php if($row['situacion_academica'] == "3"){ echo "selected"; } ?>>Titulado</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-8">
                            <label>Correo Personal</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input name="txt_email" type="text" class="txt_email form-control" id="inputCorreo" placeholder="xxxxx@xxxxx.xxx" value="<?= $row['correo_personal'] ?>">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Código Empleado</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input id="inputCodigoEmpleado" type="text" name="cod_empleado" class="cod_empleado form-control" value="<?= $row['cod_empleado'] ?>" style="width: 100px" placeholder="C: XXXXX">
                                <input type="text" name="rut_avatar" value="<?= $row['img_user'] ?>" hidden>
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

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        $('.fec_nac').daterangepicker({
            timePicker: false,
            timePicker24Hour: false,
            singleDatePicker: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoUpdateInput: false,
            opens: "right",
            locale: {
                cancelLabel: 'Limpiar',
                applyLabel: 'Aplicar',
                format: 'YYYY-MM-DD'
            }
        });

        $('.fec_nac').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_nac').val(startDate.format('YYYY-MM-DD'));
        });

        $('.fec_nac').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_nac').val('');
        });

        $('.fec_ingreso').daterangepicker({
            timePicker: false,
            timePicker24Hour: false,
            singleDatePicker: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoUpdateInput: false,
            opens: "left",
            locale: {
                cancelLabel: 'Limpiar',
                applyLabel: 'Aplicar',
                format: 'YYYY-MM-DD'
            }
        });

        $('.fec_ingreso').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_ingreso').val(startDate.format('YYYY-MM-DD'));
        });

        $('.fec_ingreso').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_ingreso').val('');
        });
    
        $('.selectpicker_edit').selectpicker();

        $('select.sl_familiar').on('changed.bs.select', function(){
            $('.num_hijos_div').fadeOut("blind");
            $('#edit_con_hijos_' + $(this).val()).fadeIn("blind");
        });

        $('#edit_perfil').submit(function( event ) {
            if($('.txt_nombre').val() == "" || $('.num_celular').val() == "" || $('.num_referencia').val() == "" || $('select.sl_parentesco').val() == null || $('select.sl_genero').val() == null || $('select.sl_familiar').val() == null || $('select.sl_familiar').val() == null || $('select.sl_est_academico').val() == null || $('select.sl_academica').val() == null || $('.fec_nac').val() == "" || $('.txt_email').val() == "" || $('.cod_empleado').val() == ""){
                swal({
                    title: "",
                    text: "Favor de llenar todos los campos",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
                return false;
            }else{
                var datos = $(this).serialize();
                swal({
                    title: 'Deseas cambiar tu perfil ?',
                    text: "Recuerda haber editado todo correctamente",
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
                        url: "ajax/action_class/update/update_perfil_usuario.php",
                        data: datos,
                        success: function(data) {
                            //console.log(data);
                            if(data == "true"){
                                swal({
                                    title: "",
                                    text: "Tu Perfil ha sido actualizado con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    setTimeout(function(){
                                        $(document.body).css('padding-right','');
                                    },200);
                                });
                                $('#modal_edit_perfil').modal('toggle');
                                setTimeout(function (){
                                    $('.cuerpo_avatar').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_avatar.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_avatar_menu').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_avatar_menu.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_nombre_completo').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_nombre_completo.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_nombre_completo_menu').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_nombre_completo_menu.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_info_personal').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_personal.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_info_contacto').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_contacto.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_colaboracion').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_colaboracion.php",function(){}).hide().fadeIn("blind");
                                },1000);
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al editar tu perfil, informalo al administrador y/o desarrollador",
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
                        text: "No se cambio tu perfil",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                  }
                });
            }
            event.preventDefault();
        });

    </script>
<?php }}else{ ?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Editar Perfil</h3>
        </div>
        <div class="modal-body">
            <form id="edit_perfil_gest" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-9">
                            <label>Nombre Completo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-tint"></i></span>
                                <input name="id_user" type="text" value="<?= $user_id ?>" hidden>
                                <input name="txt_nombre" type="text" class="txt_nombre_gest form-control" id="inputNombre" placeholder="Nombre Completo" value="<?php if($row['nom_user_perfil'] == NULL || $row['nom_user_perfil'] == ""){ echo utf8_encode($row['nom_user']);  }else{ echo utf8_encode($row['nom_user_perfil']); }?>">
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>N° DNI</label>
                            <div class="input-group">
                                <span class="input-group-addon">#</span>
                                <input name="num_dni" type="text" class="num_dni_gest form-control" id="inputDNI" placeholder="N° DNI" value="<?= $row['dni_user'] ?>">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-3">
                            <label>Número Celular</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mobile"></i></span>
                                <input name="num_celular" type="text" class="num_celular_gest form-control" id="inputCelular" placeholder="N° Celular" value="<?= $row['telefono_user'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Número Fijo/Domicilio</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input name="num_fijo" type="text" class="num_fijo_gest form-control" id="inputFijo" placeholder="N° Fijo" value="<?= $row['telefono_fijo_user'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-info" style="height: 35px;">
                                <p style="margin-top: -8px;"><i class="fa fa-exclamation-triangle text-info"></i> Recuerda que estos datos seran para RRHH</p>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-5">
                            <label>&nbsp;</label>
                            <div class="alert alert-dismissible alert-warning" style="height: 35px;">
                                <p style="margin-top: -8px;"><i class="fa fa-exclamation-triangle text-warning"></i> Llenar con datos reales</p>
                            </div>
                        </section>
                        <section class="col col-3">
                            <label>Número de Referencia</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-phone"></i></span>
                                <input name="num_referencia" type="text" class="num_referencia_gest form-control" id="inputReferencia" placeholder="N° Referencia" value="<?= $row['telefono_referencia_user'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Parentesco</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <select name="sl_parentesco" class="sl_parentesco_gest selectpicker_edit show-tick show-menu-arrow form-control" data-header="Parentesco">
                                    <option value="" <?php if($row['ref_parentesco'] == NULL || $row['ref_parentesco'] == ""){ echo "selected"; } ?>>Selecciona Aqui</option>
                                    <option value="0" <?php if($row['ref_parentesco'] == "0"){ echo "selected"; } ?>>Mamá</option>
                                    <option value="1" <?php if($row['ref_parentesco'] == "1"){ echo "selected"; } ?>>Papá</option>
                                    <option value="2" <?php if($row['ref_parentesco'] == "2"){ echo "selected"; } ?>>Hermano</option>
                                    <option value="3" <?php if($row['ref_parentesco'] == "3"){ echo "selected"; } ?>>Hermana</option>
                                    <option value="4" <?php if($row['ref_parentesco'] == "4"){ echo "selected"; } ?>>Esposo</option>
                                    <option value="5" <?php if($row['ref_parentesco'] == "5"){ echo "selected"; } ?>>Esposa</option>
                                    <option value="6" <?php if($row['ref_parentesco'] == "6"){ echo "selected"; } ?>>Hijo</option>
                                    <option value="7" <?php if($row['ref_parentesco'] == "7"){ echo "selected"; } ?>>Hija</option>
                                    <option value="8" <?php if($row['ref_parentesco'] == "8"){ echo "selected"; } ?>>Tio</option>
                                    <option value="9" <?php if($row['ref_parentesco'] == "9"){ echo "selected"; } ?>>Tia</option>
                                    <option value="10" <?php if($row['ref_parentesco'] == "10"){ echo "selected"; } ?>>Amigo</option>
                                    <option value="11" <?php if($row['ref_parentesco'] == "11"){ echo "selected"; } ?>>Amiga</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <style>
                        .input-group .form-control{
                            float:none;
                        }
                    </style>
                    <div class="row">
                        <section class="col col-4">
                            <label>Género</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-mars"></i></span>
                                <select name="sl_genero" id="inputGenero" class="sl_genero_gest selectpicker_edit show-tick show-menu-arrow form-control" >
                                    <option value="" <?php if($row['genero_user'] == NULL || $row['genero_user'] == ""){ echo "selected"; }else{ echo "disabled"; } ?>>Selecciona Aqui</option>
                                    <option data-content="<i class='fa fa-male' style='color:green'></i> Masculino" value="0" <?php if($row['genero_user'] == "0"){ echo "selected"; } ?>>Masculino</option>
                                    <option data-content="<i class='fa fa-female' style='color:pink'></i> Femenino" value="1" <?php if($row['genero_user'] == "1"){ echo "selected"; } ?>>Femenino</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Situacion Familiar</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-home"></i></span>
                                <select name="sl_familiar" id="inputFamiliar" class="sl_familiar_gest selectpicker_edit show-tick show-menu-arrow form-control" data-header="Situación Familiar">
                                    <option value="" <?php if($row['situacion_familiar'] == NULL || $row['situacion_familiar'] == ""){ echo "selected"; }else{ echo "disabled"; } ?>>Selecciona Aqui</option>
                                    <option data-content="<i class='fa fa-close' style='color:red'></i> Sin Hijos" value="0" <?php if($row['situacion_familiar'] == "0"){ echo "selected"; } ?>>Sin Hijos</option>
                                    <option data-content="<i class='fa fa-check' style='color:green'></i> Con Hijos" value="1" <?php if($row['situacion_familiar'] == "1"){ echo "selected"; } ?>>Con Hijos</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-4 num_hijos_div_gest" id="edit_con_hijos_gest_1" <?php if($row['situacion_familiar'] == "1"){ echo ""; }else{ echo "hidden"; } ?>>
                            <label>N° Hijos</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-child"></i></span>
                                <input name="num_hijos" type="text" class="num_hijos_gest form-control" id="inputHijos" placeholder="N° Hijos" value="<?= $row['num_hijos'] ?>" onkeypress="return event.charCode >= 48 && event.charCode <= 57 || event.keyCode == 8 || event.keyCode == 9">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Fecha de Nacimiento</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="inputFecNac" type="text" name="fec_nac" class="fec_nac_gest form-control" value="<?= $row['fecha_nacimiento'] ?>" onkeypress="return event.charCode >= 1 && event.charCode <= 1 || event.keyCode == 9">
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Fecha de Ingreso</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input id="inputFecIngreso" type="text" name="fec_ingreso" class="fec_ingreso_gest form-control" value="<?= $row['fec_ingreso'] ?>" onkeypress="return event.charCode >= 1 && event.charCode <= 1 || event.keyCode == 9">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-6">
                            <label>Estado Académico</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-graduation-cap"></i></span>
                                <select name="sl_est_academico" id="inputAcademico" class="sl_est_academico_gest selectpicker_edit show-tick show-menu-arrow form-control" data-header="Estado Académico">
                                    <option value="" <?php if($row['estado_academico'] == NULL || $row['genero_user'] == ""){ echo "selected"; } ?>>Selecciona Aqui</option>
                                    <option value="0" <?php if($row['estado_academico'] == "0"){ echo "selected"; } ?>>Técnica</option>
                                    <option value="1" <?php if($row['estado_academico'] == "1"){ echo "selected"; } ?>>Universitaria</option>
                                </select>
                            </div>
                        </section>
                        <section class="col col-6">
                            <label>Situación Académica</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-university"></i></span>
                                <select name="sl_academica" id="inputAcademica" class="sl_academica_gest selectpicker_edit show-tick show-menu-arrow form-control" data-header="Situación Académica">
                                    <option value="" <?php if($row['situacion_academica'] == NULL || $row['genero_user'] == ""){ echo "selected"; } ?>>Selecciona Aqui</option>
                                    <option value="0" <?php if($row['situacion_academica'] == "0"){ echo "selected"; } ?>>En Curso</option>
                                    <option value="1" <?php if($row['situacion_academica'] == "1"){ echo "selected"; } ?>>Trunco</option>
                                    <option value="2" <?php if($row['situacion_academica'] == "2"){ echo "selected"; } ?>>Egresado</option>
                                    <option value="3" <?php if($row['situacion_academica'] == "3"){ echo "selected"; } ?>>Titulado</option>
                                </select>
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-8">
                            <label>Correo Personal</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                                <input name="txt_email" type="text" class="txt_email_gest form-control" id="inputCorreo" placeholder="xxxxx@xxxxx.xxx" value="<?= $row['correo_personal'] ?>">
                            </div>
                        </section>
                        <section class="col col-4">
                            <label>Código Empleado</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input id="inputCodigoEmpleado" type="text" name="cod_empleado" class="cod_empleado_gest form-control" value="<?= $row['cod_empleado'] ?>" style="width: 100px" placeholder="C: XXXXX">
                            </div>
                        </section>
                    </div>
                    <div class="row">
                        <section class="col col-10">
                            <label>Imagen Usuario</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-image"></i></span>
                                <input name="rut_avatar" type="text" class="rut_avatar form-control" id="inputAvatar" value="<?= $row['img_user'] ?>" placeholder="Ruta de Imagen Perfil">
                            </div>
                        </section>
                        <section class="col col-2">
                            <label>&nbsp;</label>
                            <div class="input-group">
                                <a class="btn btn-info" style="color:white" onclick="javascript:ventana_url('assets/js/tinymce/filemanager/dialog.php?popup=1&amp;field_id=inputAvatar')"><i class="fa fa-upload"></i> Examinar</a>
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
        
        function ventana_url(url){
            var w = 1000;
            var h = 600;
            var l = Math.floor((screen.width-w)/2);
            var t = Math.floor((screen.height-h)/2);
            var win = window.open(url, 'Gestor de Archivos - PID - CLARO AN', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
        }

        $.fn.modal.Constructor.prototype.enforceFocus = function() {};

        $('.fec_nac_gest').daterangepicker({
            timePicker: false,
            timePicker24Hour: false,
            singleDatePicker: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoUpdateInput: false,
            opens: "right",
            locale: {
                cancelLabel: 'Limpiar',
                applyLabel: 'Aplicar',
                format: 'YYYY-MM-DD'
            }
        });

        $('.fec_nac_gest').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_nac_gest').val(startDate.format('YYYY-MM-DD'));
        });

        $('.fec_nac_gest').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_nac_gest').val('');
        });

        $('.fec_ingreso_gest').daterangepicker({
            timePicker: false,
            timePicker24Hour: false,
            singleDatePicker: true,
            showDropdowns: true,
            alwaysShowCalendars: true,
            autoUpdateInput: false,
            opens: "left",
            locale: {
                cancelLabel: 'Limpiar',
                applyLabel: 'Aplicar',
                format: 'YYYY-MM-DD'
            }
        });

        $('.fec_ingreso_gest').on('apply.daterangepicker', function (ev, picker) {
            var startDate = picker.startDate;
            $('.fec_ingreso_gest').val(startDate.format('YYYY-MM-DD'));
        });

        $('.fec_ingreso_gest').on('cancel.daterangepicker', function (ev, picker) {
            $('.fec_ingreso_gest').val('');
        });
        
        $('.selectpicker_edit').selectpicker();

        $('select.sl_familiar_gest').on('changed.bs.select', function(){
            $('.num_hijos_div_gest').fadeOut("blind");
            $('#edit_con_hijos_gest_' + $(this).val()).fadeIn("blind");
        });

        $('#edit_perfil_gest').submit(function( event ) {
            /*if($('.txt_nombre_gest').val() == "" || $('.num_celular_gest').val() == "" || $('.num_referencia_gest').val() == "" || $('select.sl_genero_gest').val() == null || $('select.sl_familiar_gest').val() == null || $('select.sl_familiar_gest').val() == null || $('select.sl_est_academico_gest').val() == null || $('select.sl_academica_gest').val() == null || $('.fec_nac_gest').val() == "" || $('.txt_email_gest').val() == "" || $('.cod_empleado_gest').val() == "" || $('.rut_avatar').val() == ""){
                swal({
                    title: "",
                    text: "Favor de llenar todos los campos",
                    type: "warning",
                    showCancelButton: false,
                    showConfirmButton: true
                });
                return false;
            }else{*/
                var datos = $(this).serialize();
                swal({
                    title: 'Deseas cambiar tu perfil ?',
                    text: "Recuerda haber editado todo correctamente",
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
                        url: "ajax/action_class/update/update_perfil_usuario.php",
                        data: datos,
                        success: function(data) {
                            //console.log(data);
                            if(data == "true"){
                                swal({
                                    title: "",
                                    text: "Tu Perfil ha sido actualizado con exito",
                                    type: "success",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                }).then(function() {
                                    setTimeout(function(){
                                        $(document.body).css('padding-right','');
                                    },200);
                                });
                                $('#modal_edit_perfil').modal('toggle');
                                setTimeout(function (){
                                    $('.cuerpo_avatar').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_avatar.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_avatar_menu').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_avatar_menu.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_nombre_completo').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_nombre_completo.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_info_personal').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_personal.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_info_contacto').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_contacto.php",function(){}).hide().fadeIn("blind");
                                    $('.cuerpo_colaboracion').load("ajax/load_php/perfil_usuario/cuadros_perfil/info_colaboracion.php",function(){}).hide().fadeIn("blind");
                                },1000);
                            }else{
                                swal({
                                    title: "",
                                    text: "Error al editar tu perfil, informalo al administrador y/o desarrollador",
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
                        text: "No se cambio tu perfil",
                        type: "error",
                        showCancelButton: false,
                        showConfirmButton: true
                    });
                  }
                });
            /*}*/
            event.preventDefault();
        });

    </script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>