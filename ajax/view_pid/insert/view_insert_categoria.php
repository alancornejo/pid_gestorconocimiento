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
    
    if($row_permisos['crea_cat'] != "true"){
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
        <h3 class="modal-title">Insertar Categoria</h3>
    </div>
    <div class="modal-body">
        <form id="insert_categoria" class="sky-form">
            <fieldset>
                <div class="row">
                    <section class="col col-12">
                        <label>Nombre de la Categoria</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="fa fa-database"></i></span>
                            <input name="nom_cat" type="text" class="nom_cat form-control" id="inputCategoria" placeholder="Categoria">
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
    
    $('#insert_categoria').submit(function(event){
    if ($(".nom_cat").val() == '') {
            swal({
                title: "",
                text: "Favor de completar los campos",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
            return false;
        }else{
            var nom_cat = $("#inputCategoria").val().toUpperCase();
            var categoria = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "ajax/val_pid/validate_categoria.php",
                data: "nom_cat="+nom_cat,
                dataType: "html",
                success: function(data){                                                      
                    if(data == 0){
                        swal({
                             title: 'Deseas agregar esta categoria?',
                             text: "Recuerda que esto se mostrara en las categorias del KDB",
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
                                 url: "ajax/action_class/insert/insert_categoria.php",
                                 data: categoria,
                                 success: function(data) {
                                     if(data == "true"){
                                        setTimeout(function(){     
                                            swal({
                                                title: "",
                                                text: "Se agrego la categoria con exito",
                                                type: "success",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            }).then(function() {
                                                setTimeout(function(){
                                                    $(document.body).css('padding-right','');
                                                },200);
                                            });
                                            $('#modal_ins_categoria').modal('toggle');
                                        }, 600);
                                        tabla_categorias.ajax.reload( null, false );
                                    }else{
                                        swal({
                                            title: "",
                                            text: "Error al insertar la categoria, informalo al administrador y/o desarrollador",
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
                                text: "No se agrego ninguna categoria",
                                type: "error",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                           }
                         });
                    }else{
                        swal({
                            title: "",
                            text: "Esta categoria ya esta registrado, intenta con otro",
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