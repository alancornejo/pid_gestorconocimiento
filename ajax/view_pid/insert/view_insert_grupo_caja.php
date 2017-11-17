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
    
    $id_grupo = (isset($_GET['id_grupo'])) ? "true" : "false";

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
            <h3 class="modal-title">Insertar G. Asignado</h3>
          </div>
          <div class="modal-body">
            <form id="insert_grupo" class="sky-form">
                <fieldset>
                    <div class="row">
                        <section class="col col-12">
                            <label>Nombre del Grupo</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                <input name="txt_grupo" type="text" class="txt_grupo form-control" id="inputGrupoAsignado" placeholder="Grupo Asignado">
                                <?php if($id_grupo == "true") { ?>
                                <input name="id_grupo" type="text" value="<?= $_GET['id_grupo'] ?>" hidden>
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
    $('#insert_grupo').submit(function(event){
    if ($(".txt_grupo").val() == '') {
        swal({
            title: "",
            text: "Favor de completar los campos",
            type: "warning",
            showCancelButton: false,
            showConfirmButton: true
        });
        return false;
        }else{
            var nom_grupo = $("#inputGrupoAsignado").val().toUpperCase();
            var grupo = $(this).serialize();
            var id_grupo = $("input[name=id_grupo]").val();
            $.ajax({
                type: "POST",
                url: "ajax/val_pid/validate_grupo_asignado.php",
                data: "nom_grupo="+nom_grupo,
                dataType: "html",
                success: function(data){                                                      
                    if(data == 0){
                        swal({
                             title: 'Deseas agregar este grupo?',
                             text: "Recuerda que esto se mostrara en los Grupos Asignados del KDB",
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
                                 url: "ajax/action_class/insert/insert_grupo.php",
                                 data: grupo,
                                 success: function(data) {
                                     if(data == "true"){
                                        $('.sl_asignado').selectpicker("destroy");
                                        $('.sl_asignado_edit').selectpicker("destroy");
                                        $(".sl_asignado").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_grupos.php");
                                        $(".sl_asignado_edit").load("ajax/load_php/aplicativo-grupo/select_aplicativos_grupos/cuerpo_grupos.php?id_grupo="+id_grupo);
                                        setTimeout(function(){
                                            swal({
                                                title: "",
                                                text: "Se agrego el grupo asignado con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('.sl_asignado').selectpicker('show');
                                            $('.sl_asignado_edit').selectpicker('show');
                                            $('#modal_ins_grupo_asignado').modal('toggle');
                                        }, 600);
                                     }else{
                                         swal({
                                            title: "",
                                            text: "Error al insertar al grupo asignado, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ningun grupo",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                           }
                         });
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