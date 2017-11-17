<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_access.php');
require_once ('../../../data/pid_view.php');
$id_user = $_SESSION['id_user_apl'];
$object = new pid_auth();
$object_permisos = new pid_permisos();
$object_view = new pid_view();
$result = $object->user_auth($id_user);
$result_permisos = $object_permisos->user_permisos($id_user);
$result_view = $object_view->view_usuarios_bloqueados();
$row_access = $result->fetch_assoc();
$row_permisos = $result_permisos->fetch_assoc();
?>
<?php if($row_permisos['gest_log_reg'] != "true"){ ?>
<div class="container content-md">
    <div class="row">
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
    </div>
</div>
<?php }else{ ?>
<div class="container content-md">
    <div class="row">
        <div class="tabla_pid_bloqueo section">
            <div style="float: right; margin-right: 10px;">
                <select id="dbox_registro_bloqueo" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-width="250px" data-header="Filtrar por usuario">
                    <option data-content="Todos los usuarios" value="" selected>Todos</option>
                    <?php while($row_bloqueo = $result_view->fetch_assoc()){ ?>
                    <option data-content="<?= utf8_encode($row_bloqueo['nom_user']) ?>" value="<?= $row_bloqueo['claro_user'] ?>"><?= utf8_encode($row_bloqueo['nom_user']) ?></option>
                    <?php } ?>
                </select>
                <br>
            </div>
            <table id="tabla_registro_bloqueo" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
              <thead>
                  <tr>
                      <th>ID Tabla</th>
                      <th>ID</th>
                      <th>Usuario</th>
                      <th>U.Claro</th>
                      <th>Fec.Logeo</th>
                      <th>Fec.Bloqueo</th>
                      <th>Fec.Desbloqueo</th>
                      <th>IP</th>
                      <th>Acción</th>
                  </tr>
              </thead>
            </table>
        </div>

        <script>

            var tabla_registro_bloqueo = $('#tabla_registro_bloqueo').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_bloqueo.php",
                /*scrollY: "600px",*/
                scrollX: "100%",
                scrollCollapse: true,
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                stateSave: true,
                order: [[ 1, "asc"]],
                dom: 'Bfirtp',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fa fa-file-pdf-o"></i> PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-file-archive-o"></i> CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    /*{
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
                    },*/
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_registro_bloqueo.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: 'currency', targets: 1 },
                    { type: 'date-uk', targets: 4 },
                    { type: 'date-uk', targets: 5 },
                    { type: 'date-uk', targets: 6 },
                    { className: 'text-center', targets: 3},
                    { className: 'text-center', targets: 4},
                    { className: 'text-center', targets: 5},
                    { className: 'text-center', targets: 6},
                    { className: 'text-center', targets: 7},
                    { className: 'text-center', targets: 8},
                    { width: "10px", targets: 1 },
                    { width: "280px", targets: 2 },
                    { width: "110px", targets: 4 },
                    { width: "110px", targets: 5 },
                    { width: "110px", targets: 6 },
                    { width: "85px", targets: 7 },
                    { width: "85px", targets: 8 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true }
                ],
                language: {
                    sSearch: "Buscar:",
                    searchPlaceholder: 'Buscar aqui...',
                    sZeroRecords: "No se encontraron resultados",
                    sEmptyTable: "Ningun dato disponible en esta tabla",
                    sProcessing: "<img src='assets/images/loading.gif'><b> Cargando...</b>",
                    sInfo: "Mostrando del _START_ hasta _END_ (Total registrados : _TOTAL_)",
                    sInfoEmpty: "Mostrando de 0 hasta 0 (Total registrados : 0)",
                    sInfoFiltered: "(filtrado de _MAX_ registros en total)",
                    sInfoPostFix: "",
                    sInfoThousands: ",",
                    sLoadingRecords: "",
                    lengthMenu: "Mostrar _MENU_ entradas",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );
            
            $('#dbox_registro_bloqueo').selectpicker('show');

            $("select#dbox_registro_bloqueo").change(function() {
                if($("#dbox_registro_bloqueo").val() == "" || $("#dbox_registro_bloqueo").val() == null){
                    choosedFilter = "";
                }else{
                    choosedFilter = "^\\s*"+$("#dbox_registro_bloqueo").val()+"\\s*$";
                }
                tabla_registro_bloqueo
                        .columns(3)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('.clear_input_search').click(function() {
                $('.search_close').val('').keyup();
                setTimeout(function(){
                    $(document.body).css('padding-right','');
                },1000);
            });

            $(document).ready(function () {
                tabla_registro_bloqueo.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_registro_bloqueo_processing").show();
                });
            });

        </script>
    </div>
</div>
<?php } ?>