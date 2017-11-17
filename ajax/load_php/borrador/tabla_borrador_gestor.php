<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_access.php');
$id_user = $_SESSION['id_user_apl'];
$object = new pid_auth();
$result = $object->user_auth($id_user);
$row_access = $result->fetch_assoc();
?>
<div class="container content-md">
    <div class="row">
        <div class="tabla_pid_borrador_gestor">
            <div style="float: right">
                <input type="text" class="daterange" placeholder="Filtrar por fecha" style="width: 215px;">
            </div>
            <div style="float: right; margin-right: 10px;">
                <select id="dbox_borrador" name="categoria_borrador" class="selectpicker show-tick">
                    <option data-content="<span class='label label-default'>Todo</span>" value="" selected>TODO</option>
                    <option data-content="<span class='label label-primary'>Borrador</span>" value="BORRADOR">BORRADOR</option>
                    <option data-content="<span class='label label-success'>Publicado</span>" value="PUBLICADO">PUBLICADO</option>
                    <option data-content="<span class='label label-danger'>Eliminado</span>" value="ELIMINADO">ELIMINADO</option>
                </select>
                <br>
            </div>
            <table id="tabla_borrador_gestor" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
              <thead>
                  <tr>
                      <th>ID Tabla</th>
                      <th>ID</th>
                      <th>C.Claro</th>
                      <th>Usuario</th>
                      <th>IP Usuario</th>
                      <th>Estado</th>
                      <th>Fecha de creación</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
            </table>
        </div>
        <script>
            
            var tabla_borrador_gestor = $('#tabla_borrador_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_kdb_list_borrador.php",
                /*scrollY: "600px",*/
                scrollX: "100%",
                scrollCollapse: true,
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                dom: 'Bfirtp',
                order: [[ 1, "asc"]],
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
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
                    },
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_borrador_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { type: "date-uk", targets: 6 },
                    { width: "20px", targets: 1 },
                    { width: "480px", targets: 3 }
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

            $('.daterange').daterangepicker({
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Hace una semana': [moment().subtract(6, 'days'), moment()],
                    'Hace 30 dias': [moment().subtract(29, 'days'), moment()],
                    'Este Mes': [moment().startOf('month'), moment().endOf('month')],
                    'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                },
                autoUpdateInput: false,
                opens:"left",
                locale: {
                    cancelLabel: 'Limpiar',
                    applyLabel: 'Aplicar',
                    customRangeLabel: 'Por Rango',
                    format: 'DD-MM-YYYY'
                }
            });

            $(document).ready(function (){
                var startDate;
                var endDate;
                var DateFilterFunction = (function (settings, data, iDataIndex) {
                    var filterstart = startDate;
                    var filterend = endDate; 
                    var iStartDateCol = 6;
                    var iEndDateCol = 6;

                    var tabledatestart = data[iStartDateCol] !== "" ? moment(data[iStartDateCol], "DD-MM-YYYY") : data[iStartDateCol];
                    var tabledateend = data[iEndDateCol] !== "" ? moment(data[iEndDateCol], "DD-MM-YYYY") : data[iEndDateCol];

                    if (filterstart === "" && filterend === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD-MM-YYYY").isSame(tabledatestart) || moment(filterstart, "DD-MM-YYYY").isBefore(tabledatestart)) && filterend === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD-MM-YYYY").isSame(tabledatestart) || moment(filterstart, "DD-MM-YYYY").isAfter(tabledatestart)) && filterstart === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD-MM-YYYY").isSame(tabledatestart) || moment(filterstart, "DD-MM-YYYY").isBefore(tabledatestart)) && (moment(filterend, "DD-MM-YYYY").isSame(tabledateend) || moment(filterend, "DD-MM-YYYY").isAfter(tabledateend))) {
                        return true;
                    }
                    return false;
                });

               $(".daterange", this).on('apply.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val(picker.startDate.format('DD-MM-YYYY') + ' hasta ' + picker.endDate.format('DD-MM-YYYY'));
                   startDate = picker.startDate.format('DD-MM-YYYY');
                   endDate = picker.endDate.format('DD-MM-YYYY');
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_borrador_gestor.draw();
               });

               $(".daterange", this).on('cancel.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val('');
                   startDate = '';
                   endDate = '';
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_borrador_gestor.draw();
               });
            });
            
            $('#dbox_borrador').selectpicker('show');
            
            $("select#dbox_borrador").change(function() {
                var choosedFilter = $("#dbox_borrador").val();
                tabla_borrador_gestor
                        .columns(5)
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
                tabla_borrador_gestor.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_pid_borrador_gestor_processing").show();
                });
            });


        </script>
    </div>
</div>