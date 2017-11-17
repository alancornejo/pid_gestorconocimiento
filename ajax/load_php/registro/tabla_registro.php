<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_access.php');
$id_user = $_SESSION['id_user_apl'];
$object = new pid_auth();
$object_permisos = new pid_permisos();
$result = $object->user_auth($id_user);
$result_permisos = $object_permisos->user_permisos($id_user);
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
        <div class="tabla_pid_registro section">
            <div style="float: right; margin-right: 10px;">
                <select id="dbox_registro" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-width="160px" data-header="Estado de Documento">
                    <option data-content="<span class='label label-primary'>Todos los estados</span>" value="" selected>Todos</option>
                    <option data-content="<span class='label label-default'>Bitacora</span>" value="BITACORA">Bitacora</option>
                    <option data-content="<span class='label label-default'>Conocimiento</span>" value="CONOCIMIENTO">Conocimiento</option>
                    <option data-content="<span class='label label-default'>Usuario</span>" value="USUARIO">Usuario</option>
                </select>
                <br>
            </div>
            <table id="tabla_registro_log" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
              <thead>
                  <tr>
                      <th>ID Tabla</th>
                      <th>ID</th>
                      <th>Tipo</th>
                      <th>Modulo</th>
                      <th>Identificador</th>
                      <th>Fecha Registro</th>
                      <th>Usuario de Registro</th>
                      <th>Acción Registro</th>
                  </tr>
              </thead>
            </table>
        </div>

        <!-- Modal Ver Registro -->
        <div id="modal_ver_registro" class="modal fade" tabindex="-1" role="dialog">
          <div class="modal-dialog modal-lg">
            <div class="ins_verregistro_body">
            </div>
          </div>
        </div>

        <script>

            var tabla_registro = $('#tabla_registro_log').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_registro.php",
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
                            tabla_registro.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: 'currency', targets: 1 },
                    { type: 'date-uk', targets: 5 },
                    { className: 'text-center', targets: 3},
                    { className: 'text-center', targets: 4},
                    { className: 'text-center', targets: 5},
                    { className: 'text-center', targets: 6},
                    { className: 'text-center', targets: 7},
                    { width: "200px", targets: 4 }
                ],
                columns: [
                    { visible: false },
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
            
            $('#dbox_registro').selectpicker('show');

            $("select#dbox_registro").change(function() {
                if($("#dbox_registro").val() == "" || $("#dbox_registro").val() == null){
                    choosedFilter = "";
                }else{
                    choosedFilter = "^\\s*"+$("#dbox_registro").val()+"\\s*$";
                }
                tabla_registro
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
                tabla_registro.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_registro_log_processing").show();
                });
            });

            /* Funcion ver registro */
            function view_registro(id){
                var atu = id;
                $.ajax({
                    beforeSend: function(){
                       $('.ins_verregistro_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                    },
                    cache: false,
                    type: 'GET',
                    url: 'ajax/view_pid/view_registro.php',
                    data: 'id=' + atu,
                    success:function(data){
                       $('.ins_verregistro_body').html(data);
                    }
                });
            }
            /* Fin Funcion ver registro */

        </script>
    </div>
</div>
<?php } ?>