<?php
session_start();
date_default_timezone_set('America/Bogota');
?>
<div class="container content-md">
    <div class="row">
        <div class="tabla_portal_pid">
            <div style="float: left; margin-right: 1px;">
                <div class="btn-group" role="group">
                    <a class="dt-button agregar_noticia"><span class="fa fa-plus"></span> Agregar Noticias</a>
                </div>
            </div>
            <table id="tabla_portal_pid" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                  <thead>
                      <tr>
                        <th>ID Noticias</th>
                        <th>ID</th>
                        <th>Titulo</th>
                        <th>Fecha Publicación</th>
                        <th>Tipo Noticias</th>
                        <th>Acciones</th>
                      </tr>
                  </thead>
            </table>
        </div>
        <script>
            var tabla_portal_pid = $('#tabla_portal_pid').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_noticias_portal.php",
                /*scrollY: "700px",*/
                scrollX: "100%",
                scrollCollapse: true,
                /*paging: false,*/
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                order: [[ 1, "asc"]],
                dom: 'Bfirtp',
                stateSave: true,
                fixedHeader: true,
                buttons: [
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
                    },
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_portal_pid.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: 'date-uk', targets: 3 },
                    { width: '15px', targets: 1 },
                    { width: '680px', targets: 2 },
                    { width: '120px', targets: 3 },
                    { width: '180px', targets: 4 },
                    { width: '150px', targets: 5 },
                    { className: "text-center", "targets": 3},
                ],
                columns: [
                    { visible: false },
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

            $('.clear_input_search').click(function() {
                $('.search_close').val('').keyup();
                setTimeout(function(){
                    $(document.body).css('padding-right','');
                },1000);
            });

            $(document).ready(function () {
                tabla_portal_pid.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_portal_pid_processing").show();
                });
            });
            
            /* Modal Insertar Noticia */
            $('.agregar_noticia').click(function () {
                $("#modal_ins_portal_noticia").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_noticias_portal_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_portal_noticias.php',
                    success:function(data){
                        $('.ins_noticias_portal_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Noticia */

        </script>
    </div>
</div>