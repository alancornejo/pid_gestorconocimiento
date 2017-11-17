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
    $id_user = $_SESSION['id_user_apl'];
    $object_permisos = new pid_permisos();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    $id_aplicativo = (isset($_GET['id_aplicativo'])) ? "true" : "false";
    
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
                                <?php if($id_aplicativo == "true") { ?>
                                <input name="id_aplicativo" type="text" value="<?= $_GET['id_aplicativo'] ?>" hidden>
                                <?php } ?>
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
    
    $('#insert_aplicativo').submit(function(event){
    if ($(".nom_apli").val() == '') {
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
            var aplicativo = $(this).serialize();
            var id_aplicativo = $("input[name=id_aplicativo]").val();
            $.ajax({
                type: "POST",
                url: "ajax/val_pid/validate_aplicativo.php",
                data: "nom_apl="+nom_apl,
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
                                        $('.sl_afectado').selectpicker("destroy");
                                        $('.sl_afectado_edit').selectpicker("destroy");
                                        $('.sl_aplicativo').selectpicker("destroy");
                                        $('.sl_aplicativo_conocimiento').selectpicker("destroy");
                                        $('.sl_aplicativo_conocimiento_edit').selectpicker("destroy");
                                        $(".sl_afectado").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php");
                                        $(".sl_afectado_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php?id_aplicativo="+id_aplicativo);
                                        $(".sl_aplicativo").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php");
                                        $(".sl_aplicativo_conocimiento").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php");
                                        $(".sl_aplicativo_conocimiento_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_aplicativos.php?id_aplicativo="+id_aplicativo);
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
                                            $('.sl_afectado').selectpicker('show');
                                            $('.sl_afectado_edit').selectpicker('show');
                                            $('.sl_aplicativo').selectpicker('show');
                                            $('.sl_aplicativo_conocimiento').selectpicker('show');
                                            $('.sl_aplicativo_conocimiento_edit').selectpicker('show');
                                            $('#modal_ins_aplicativo').modal('toggle');
                                        }, 600);
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