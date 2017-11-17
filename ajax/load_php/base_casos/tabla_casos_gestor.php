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
        <div class="tabla_gestor_casos">
            <!-- <div style="float: right">
                <input type="text" class="daterange" placeholder="Filtrar por fecha" style="width: 215px;">
            </div> -->
            <table id="tabla_gestor_casos" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
              <thead>
                  <tr>
                      <th>ID Tabla</th>
                      <th>ID</th>
                      <th>Mes de Subida</th>
                      <th>Año de Subida</th>
                      <th>Gráfico</th>
                  </tr>
              </thead>
            </table>
        </div>
        <script>
            function abrir_loading_consulta(){
                swal({
                    title: "",
                    text: "Ejecutando consulta, un momento.....",
                    type: "info",
                    showCancelButton: false,
                    showConfirmButton: false
                });
            }

            function cerrar_loading_consulta(){
                swal.close();
            }
            
            
            var tabla_casos_gestor = $('#tabla_gestor_casos').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_kdb_list_casos.php",
                /*scrollY: "400px",*/
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
                        text: '<i class="fa fa-user"></i> Agregar Base de Casos',
                        className: 'modal_casos'
                    },
                    {
                        text: '<i class="fa fa-cog"></i> Ejecutar Consulta para Seguimiento',
                        action: function () {
                            swal({
                                title: 'Deseas ejecutar la consulta?',
                                text: "Recuerda que con esto se llenara la tabla de seguimiento de casos!",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#1b9cdd',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<i class="fa fa-plus"></i> Ejecutar',
                                showLoaderOnConfirm: false,
                                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                            }).then(function() {
                                abrir_loading_consulta();
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/action_class/insert/insert_consulta_seguimiento.php",
                                    success: function(data) {
                                        //console.log(data);
                                        if(data == "base_vacia"){
                                            cerrar_loading_consulta();
                                            swal({
                                                title: "",
                                                text: "No hay ninguna data en la base de seguimiento, favor de cargar una base",
                                                type: "error",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            });
                                        }else{
                                            if(data == "asignado_ingresado"){
                                                cerrar_loading_consulta();
                                                swal({
                                                    title: "",
                                                    text: "La fecha del corte ya se encuentra registrado",
                                                    type: "error",
                                                    showCancelButton: false,
                                                    showConfirmButton: true
                                                });
                                            }else{
                                                if(data == "asignado_ingresado"){
                                                    cerrar_loading_consulta();
                                                    swal({
                                                        title: "",
                                                        text: "La fecha del corte ya se encuentra registrado",
                                                        type: "error",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }else{
                                                    if(data == "true"){
                                                        cerrar_loading_consulta();
                                                        setTimeout(function(){     
                                                            swal({
                                                                title: "",
                                                                text: "Se ejecuto la consulta con exito",
                                                                type: "success",
                                                                showCancelButton: false,
                                                                showConfirmButton: true
                                                            });
                                                            tabla_casos_gestor.ajax.reload( null, false );
                                                        }, 600);
                                                    }else{
                                                        cerrar_loading_consulta();
                                                        swal({
                                                            title: "",
                                                            text: "Error al ejecutar la consulta, informalo al administrador y/o desarrollador",
                                                            type: "error",
                                                            showCancelButton: false,
                                                            showConfirmButton: true
                                                        });
                                                    }
                                                }
                                            }
                                        }
                                    }
                                });
                            }, function(dismiss) {
                              if (dismiss === 'cancel') {
                                swal({
                                    title: "",
                                    text: "No se reinicio el tiempo de conexion",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                              }
                            })
                        }
                    },
                    {
                        text: '<i class="fa fa-bar-chart"></i> Gestionar Grafico de Seguimiento',
                        className: 'modal_grafico_seguimiento'
                    },
                    /*{
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
                    },*/
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_casos_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: true,
                columnDefs: [
                    { type: "currency", targets: 1 }/*,
                    { type: "date-uk", targets: 6 },
                    { width: "20px", targets: 1 },
                    { width: "480px", targets: 3 }*/
                ],
                columns: [
                    { visible: false },
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
                    var iStartDateCol = 2;
                    var iEndDateCol = 2;

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
                   tabla_casos_gestor.draw();
               });

               $(".daterange", this).on('cancel.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val('');
                   startDate = '';
                   endDate = '';
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_casos_gestor.draw();
               });
            });

            $('.clear_input_search').click(function() {
                $('.search_close').val('').keyup();
                setTimeout(function(){
                    $(document.body).css('padding-right','');
                },1000);
            });

            /* Modal Insertar Base de Casos */
            $('.modal_casos').click(function () {
                $("#modal_ins_seguimiento").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_seguimiento_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_seguimiento.php',
                    success:function(data){
                        $('.ins_seguimiento_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Base de Casos */

            /* Modal Gestionar Seguimiento de Casos */
            $('.modal_grafico_seguimiento').click(function () {
                $("#modal_grafico_seguimiento").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.view_grafico_seguimiento').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                    },
                    url: 'ajax/view_pid/graficos/view_grafica_seguimiento.php',
                    success:function(data){
                        $('.view_grafico_seguimiento').html(data);
                    }
                });
            });
            /* Fin Modal Gestionar Seguimiento de Casos */

            $(document).ready(function () {
                tabla_casos_gestor.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_pid_borrador_gestor_processing").show();
                });
            });


        </script>
    </div>
</div>