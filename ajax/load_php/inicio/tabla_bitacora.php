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
<div class="container content-md">
    <div class="row">
        <div class="tabla_bitacora">
            <?php if($row_permisos['gest_bita'] == "true"){ ?>
            <div style="float: right">
                <input type="text" class="daterange" placeholder="Filtrar por fecha" style="width: 215px;">
            </div>
            <div style="float: right; margin-right: 10px;">
                <select id="dbox" name="categories" multiple>
                    <option data-content="<span class='label label-default'>Todo</span>" value="" selected>TODO</option>
                    <option data-content="<span class='label label-warning'>Asignado</span>" value="ASIGNADO">ASIGNADO</option>
                    <option data-content="<span class='label label-primary'>Re-Asignado</span>" value="RE-ASIGNADO">RE-ASIGNADO</option>
                    <option data-content="<span class='label label-success'>Solucionado</span>" value="SOLUCIONADO">SOLUCIONADO</option>
                    <option data-content="<span class='label label-danger'>Cerrado</span>" value="CERRADO">CERRADO</option>
                </select>
                <br>
            </div>
            <table id="tabla_bitacora_gestor" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                  <thead>
                      <tr>
                        <th>Fec.Bitácora</th>
                        <th>Impacto</th>
                        <th>U.Afectados</th>
                        <th>G.Asignado</th>
                        <th>Aplicativo</th>
                        <th>N.Bitácora</th>
                        <th>Responsable</th>
                        <th>#Caso</th>
                        <th>#Correos</th>
                        <th>Estado</th>
                        <th>Fec.Apertura</th>
                        <th>Fec.Solucion</th>
                        <th>Fec.Cierre</th>
                        <th>Fec.Reasignacion</th>
                        <th>Fec.Recepcion</th>
                        <th>D.Pendientes</th>
                        <th>Acciones</th>
                      </tr>
                  </thead>
            </table>
            <?php }elseif($row_access['funcion_user'] == "6" || $row_access['funcion_user'] == "7"){ ?>
            <div style="float: right">
                <input type="text" class="daterange_cliente" placeholder="Filtrar por fecha" style="width: 215px;">
            </div>
            <div style="float: right; margin-right: 10px;">
                <select id="dbox_cliente" name="categories" multiple>
                    <option data-content="<span class='label label-default'>Todo</span>" value="" selected>TODO</option>
                    <option data-content="<span class='label label-warning'>Asignado</span>" value="ASIGNADO">ASIGNADO</option>
                    <option data-content="<span class='label label-primary'>Re-Asignado</span>" value="RE-ASIGNADO">RE-ASIGNADO</option>
                    <option data-content="<span class='label label-success'>Solucionado</span>" value="SOLUCIONADO">SOLUCIONADO</option>
                    <option data-content="<span class='label label-danger'>Cerrado</span>" value="CERRADO">CERRADO</option>
                </select>
                <br>
            </div>
            <table id="tabla_bitacora_cliente" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                  <thead>
                      <tr>
                        <th>ID Tabla</th>
                        <th>Fec.Bitácora</th>
                        <th>Impacto</th>
                        <th>U.Afectados</th>
                        <th>G.Asignado</th>
                        <th>Aplicativo</th>
                        <th>N.Bitácora</th>
                        <th>Responsable</th>
                        <th>#Caso</th>
                        <th>#Correos</th>
                        <th>Estado</th>
                        <th>Fec.Apertura</th>
                        <th>Fec.Solucion</th>
                        <th>Fec.Cierre</th>
                        <th>Fec.Reasignacion</th>
                        <th>Fec.Recepcion</th>
                        <th>D.Pendientes</th>
                      </tr>
                  </thead>
            </table>
            <?php }else{ ?>
            <table id="tabla_bitacora_usuario" cellspacing="0" class="table table-hover" width="100%">
                  <thead>
                      <tr>
                        <th>ID Tabla</th>
                        <th>#Caso</th>
                        <th>N.Bitácora</th>
                        <th>Aplicativo</th>
                        <th>G.Asignado</th>
                        <th>Responsable</th>
                        <th>Estado</th>
                        <th>Fec.Bitácora</th>
                        <th>D.Pendientes</th>
                      </tr>
                  </thead>
            </table>
            <?php } ?>
        </div>
        <script>
            var tabla_bitacora_gestor = $('#tabla_bitacora_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_bitacora_gestor.php",
                /*scrollY: "700px",*/
                scrollX: "100%",
                scrollCollapse: true,
                /*paging: false,*/
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                order: [[ 0, "dsc"]],
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
                            tabla_bitacora_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: 'date-uk', targets: 0 },
                    { searchable: false, targets: 10 },
                    { searchable: false, targets: 11 },
                    { searchable: false, targets: 12 },
                    { searchable: false, targets: 13 },
                    { searchable: false, targets: 14 },
                    { width: "100px", targets: 15 }
                ],
                columns: [
                    { visible: true },
                    { visible: false },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: true },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
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

            $('#dbox').selectpicker('show');

            $("select#dbox").change(function() {
                var choosedFilter = $("#dbox").val();
                //var choosedString = choosedFilter.join("|");
                if(choosedFilter == null || choosedFilter == ""){ 
                    choosedString = ""; 
                }else{ 
                    choosedString = "^("+choosedFilter.join("|")+")$"; 
                } 
                tabla_bitacora_gestor
                        .columns(9)
                        .search(choosedString,2,true,false)
                        .draw();
            });

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
                    var iStartDateCol = 0;
                    var iEndDateCol = 0;

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
                   tabla_bitacora_gestor.draw();
               });

               $(".daterange", this).on('cancel.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val('');
                   startDate = '';
                   endDate = '';
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_bitacora_gestor.draw();
               });
            });

            var tabla_bitacora_cliente = $('#tabla_bitacora_cliente').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_bitacora_cliente.php",
                scrollX: "100%",
                scrollCollapse: true,
                responsive: false,
                dom: 'B<"table-select-fix"l>frtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                processing: true,
                order: [[ 1, "dsc"]],
                pagingType: 'full_numbers_no_ellipses',
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td', nRow).addClass('td-cursor');
                },
                columnDefs: [
                    { type: 'date-uk', targets: 1 },
                    { searchable: false, targets: 11 },
                    { searchable: false, targets: 12 },
                    { searchable: false, targets: 13 },
                    { searchable: false, targets: 14 },
                    { searchable: false, targets: 15 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: false },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: true },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: true }
                ],
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
                            tabla_bitacora_cliente.ajax.reload( null, false );
                        }
                    }
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
                    lengthMenu: "Mostrar _MENU_ entradas<label>&nbsp;</label><label>&nbsp;</label><label>&nbsp;</label>",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }
            } );

            $('#tabla_bitacora_cliente tbody').on('click', 'tr', function () {
                var id_bitacora = tabla_bitacora_cliente.row(this).data();
                $("#modal_ver_bitacora").modal("show");
                $.ajax({
                    beforeSend: function(){
                       $('.view_bitacora_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                    },
                    cache: false,
                    type: 'GET',
                    url: 'ajax/view_pid/view_bitacora.php',
                    data: 'id=' + id_bitacora[0],
                    success:function(data){
                       $('.view_bitacora_body').html(data);
                    }
                });
            } );

            $('#dbox_cliente').selectpicker('show');

            $("select#dbox_cliente").change(function() {
               /* var choosedFilter = $("#dbox_cliente").val();
                var choosedString = choosedFilter.join("|");
                tabla_bitacora_cliente
                        .columns(10)
                        .search(choosedString,2,true,false)
                        .draw();*/
                var choosedFilter = $("#dbox_cliente").val();
                //var choosedString = choosedFilter.join("|");
                if(choosedFilter == null || choosedFilter == ""){ 
                    choosedString = ""; 
                }else{ 
                    choosedString = "^("+choosedFilter.join("|")+")$"; 
                } 
                tabla_bitacora_cliente
                        .columns(10)
                        .search(choosedString,2,true,false)
                        .draw();
            });

            $('.daterange_cliente').daterangepicker({
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
                    var iStartDateCol = 1;
                    var iEndDateCol = 1;

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

               $(".daterange_cliente", this).on('apply.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val(picker.startDate.format('DD-MM-YYYY') + ' hasta ' + picker.endDate.format('DD-MM-YYYY'));
                   startDate = picker.startDate.format('DD-MM-YYYY');
                   endDate = picker.endDate.format('DD-MM-YYYY');
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_bitacora_cliente.draw();
               });

               $(".daterange_cliente", this).on('cancel.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val('');
                   startDate = '';
                   endDate = '';
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_bitacora_cliente.draw();
               });
            });

            var tabla_bitacora_usuario = $('#tabla_bitacora_usuario').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_bitacora.php",
                responsive: true,
                dom: 'B<"table-select-fix"l>frtip',
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                processing: true,
                pagingType: 'full_numbers_no_ellipses',
                order: [[ 7, "dsc"]],
                select: {
                    style: 'single'
                },
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td', nRow).addClass('td-cursor');
                },
                columnDefs: [
                    { type: 'date-uk', targets: 7 },
                    { width: "20px", targets: 1 },
                    { width: "180px", targets: 2 },
                    { width: "10px", targets: 7 },
                    { width: "10px", targets: 8 }
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
                buttons: [
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_bitacora_usuario.ajax.reload( null, false );
                        }
                    }
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

            $('#tabla_bitacora_usuario tbody').on('click', 'tr', function () {
                var id_bitacora = tabla_bitacora_usuario.row(this).data();
                $("#modal_ver_bitacora").modal("show");
                $.ajax({
                    beforeSend: function(){
                       $('.view_bitacora_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                    },
                    cache: false,
                    type: 'GET',
                    url: 'ajax/view_pid/view_bitacora.php',
                    data: 'id=' + id_bitacora[0],
                    success:function(data){
                       $('.view_bitacora_body').html(data);
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
                tabla_bitacora_gestor.ajax.reload( null, false );
                tabla_bitacora_cliente.ajax.reload( null, false );
                tabla_bitacora_usuario.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_bitacora_gestor_processing").show();
                    $("#tabla_bitacora_cliente_processing").show();
                    $("#tabla_bitacora_usuario_processing").show();
                });
            });

        </script>
    </div>
</div>