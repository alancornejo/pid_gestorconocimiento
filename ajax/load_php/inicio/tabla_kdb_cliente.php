<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_access.php');
require_once ('../../../data/pid_view.php');
$object_permisos = new pid_permisos();
$object_list = new pid_view();
$result_list = $object_list->view_category();
?>
<div class="container content-md">
    <div class="row">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="tabla_apl">
                <br>
                <div class="tabla_kdb_pid">
                    <table id="tabla_kdb_usuario" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                      <thead>
                          <tr>
                              <th>ID Tabla</th>
                              <th>ID</th>
                              <th>Titulo</th>
                              <th>Contenido</th>
                              <th>Aplicativo</th>
                              <th>Aprobado</th>
                              <th>Fec.Crea.</th>
                              <th>Fec.Actu.</th>
                              <th>Aprobado</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                    </table>
                </div>
            </div>
        </div>
        <script>
            
            $('.selectpicker').selectpicker();
            
            /*$('#tabla_kdb_gestor tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );*/

            var tabla_kdb_usuario = $('#tabla_kdb_usuario').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_usuario.php",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                responsive: false,
                processing: true,
                pagingType: 'full_numbers_no_ellipses',
                select: {
                    style: 'single'
                },
                order: [[ 1, "asc"]],
                dom: 'B<"table-select-fix"l>frtip',
                /*"fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td', nRow).addClass('td-cursor');
                },*/
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { type: 'date-uk', targets: 7 },
                    { type: 'date-uk', targets: 8 },
                    { width: "750px", targets: 2 },
                    { orderable: false, targets: 4 },
                    { width: "120px", targets: 4 },
                    { width: "88px", targets: 8 }
                ],
                buttons: [
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_kdb_usuario.ajax.reload( null, false );
                        }
                    }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: true },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
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
                    },
                    select: {
                        rows: {
                            _: "Haz seleccionado %d filas",
                            0: "Selecciona una fila",
                            1: "Seleccionaste una fila"
                        }
                    }
                }
            } );

            /* Modal Ver Datatable */
            $('#tabla_kdb_usuario tbody').on('click', 'tr', function () {
                var id_documento = tabla_kdb_usuario.row(this).data();
                $("#modal_ver_conocimiento").modal("show");
                $.ajax({
                    beforeSend: function(){
                       $('.view_conocimiento_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                    },
                    cache: false,
                    type: 'GET',
                    url: 'ajax/view_pid/view_atu.php',
                    data: 'id=' + id_documento[0],
                    success:function(data){
                       $('.view_conocimiento_body').html(data);
                    }
                });
            } );

            $('.clear_input_search').click(function() {
                $('.search_close').val('').keyup();
                setTimeout(function(){
                    $(document.body).css('padding-right','');
                },1000);
            });
            
            $(document).ready(function () {
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({ visible:true, api:true }).columns.adjust();
                });
            });

            $(document).ready(function () {
                tabla_kdb_usuario.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_kdb_usuario_processing").show();
                });
            });

        </script>
    </div>
</div>