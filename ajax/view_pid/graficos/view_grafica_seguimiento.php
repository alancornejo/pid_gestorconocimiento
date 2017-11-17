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
    
    $id_user = $_SESSION['id_user_apl'];
    $object_permisos = new pid_permisos();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    
    if($row_permisos['add_seg_casos'] != "true"){
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
    <h3 class="modal-title">Gestionar Grafico de Casos</h3>
  </div>
  <div class="modal-body">
    <form id="gestionar_grafico_seguimiento" class="col-lg-12">
        <fieldset>
            <div class="row form-group">
                <div class="col-md-5 has-cosapi">
                    <label for="Fecha_Inicio" class="col-md-4 control-label">Fecha Inicial</label>
                    <div class="col-md-4">
                      <input name="fec_inicio" type="text" class="fec_inicio form-control" id="Fecha_Inicio" placeholder="<?= date("Y-m-d") ?>">
                    </div>
                </div>
                <div class="col-md-5 has-cosapi">
                    <label for="Fecha_Final" class="col-md-4 control-label">Fecha Final</label>
                    <div class="col-md-4">
                      <input name="fec_final" type="text" class="fec_final form-control" id="Fecha_Final" placeholder="<?= date("Y-m-d") ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" value="Gestionar">
                </div>
            </div>
        </fieldset>
    </form>
    <br><br><br><br>
    <div class="grafica_seguimiento"></div>
  </div>
  <div class="modal-footer">
    <a data-dismiss="modal" class="formulario_boton btn btn-default">Cerrar</a>
  </div>
</div>
<script type="text/javascript">
    
    $.fn.modal.Constructor.prototype.enforceFocus = function() {};
    
    $('.fec_inicio').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        alwaysShowCalendars: true,
        autoUpdateInput: false,
        opens: "center",
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('.fec_inicio').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_inicio').val(startDate.format('YYYY-MM-DD'));
    });
    
    $('.fec_final').daterangepicker({
        singleDatePicker: true,
        showDropdowns: true,
        alwaysShowCalendars: true,
        autoUpdateInput: false,
        opens: "center",
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    $('.fec_final').on('apply.daterangepicker', function (ev, picker) {
        var startDate = picker.startDate;
        $('.fec_final').val(startDate.format('YYYY-MM-DD'));
    });
    
    $('#gestionar_grafico_seguimiento').submit(function( event ) {
        if ($(".fec_inicio").val() == '' || $(".fec_final").val() == '') {
            swal({
                title: "",
                text: "Favor de completar los campos",
                type: "warning",
                showCancelButton: false,
                showConfirmButton: true
            });
        return false;
       }else{
       var datos = $(this).serialize();
        swal({
            title: '',
            text: "Deseas Generar el Gráfico con los datos ingresados ?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-refresh"></i> Generar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "POST",
                url: "ajax/load_php/base_casos/graficos_casos/grafico_gestionable.php",
                data: datos,
                success: function(data) {
                    $('.grafica_seguimiento').html("<center><img src='assets/images/loading.gif'><b> Cargando...</b></center>");
                    setTimeout(function() {
                        $('.grafica_seguimiento').html(data);
                    },2000);
                    
                    /*if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se agrego el conocimiento con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                            $('#modal_ins_conocimiento').modal('toggle');
                        }, 600);
                        tabla_kdb_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al insertar el conocimiento, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }*/
                }
            });
        }, function(dismiss) {
          if (dismiss === 'cancel') {
            swal({
                title: "",
                text: "No se mostrara ningun gráfico",
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
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>

