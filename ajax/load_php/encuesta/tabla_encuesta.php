<?php 
session_start();
?>
<div class="container content-md">
    <div class="row">
        <div class="tabla_gestion_encuesta">
            <div>
                <ul class="nav nav-tabs">
                    <li class="active encuesta"><a href="#encuesta" data-toggle="tab" aria-expanded="true"><span class="fa fa-plus"></span> Crear Encuesta [ID]</a></li>
                    <li class="universo"><a href="#universo" data-toggle="tab" aria-expanded="false"><span class="fa fa-globe"></span> Universo de Preguntas</a></li>
                    <li class="opciones"><a href="#opciones" data-toggle="tab" aria-expanded="false"><span class="fa fa-support"></span> Gestionar Opciones</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="encuesta">
                        <br><br>
                        <table id="tabla_encuesta_gestor" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID Encuesta</th>
                                    <th>ID</th>
                                    <th>Titulo Encuesta</th>
                                    <th>Comentario</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="universo">
                        <br><br>
                        <div style="float: left">
                            <a data-toggle="modal" data-target="#modal_ins_enc_pregunta" class="dt-button modal_agregar_enc_pregunta"><span><i class="fa fa-plus"></i> Agregar Preguntas</span></a>
                        </div>
                        <table id="tabla_preguntas_encuesta" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID Pregunta</th>
                                    <th>ID</th>
                                    <th>Titulo Pregunta</th>
                                    <th>[ID Encuesta]</th>
                                    <th>Tipo Pregunta</th>
                                    <th>Estado Pregunta</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="opciones">
                        <br><br>
                        <div style="float: left">
                            <a data-toggle="modal" data-target="#modal_ins_enc_opciones" class="dt-button modal_agregar_enc_opciones"><span><i class="fa fa-plus"></i> Agregar Opciones</span></a>
                        </div>
                        <table id="tabla_opciones_encuesta" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>ID Pregunta</th>
                                    <th>ID</th>
                                    <th>Pregunta</th>
                                    <th>N° Opciones</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
                <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
            </div>
        </div>
        <script>
            var tabla_encuesta_gestor = $('#tabla_encuesta_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_encuesta_gestor.php",
                /*scrollY: "600px",*/
                <?php if($_SESSION['claro_user'] == "E78540"){ ?>
                scrollY: "700px",
                scrollX: "100%",
                scrollCollapse: true,
                paging: false,
                dom: 'Bfrtip',
                <?php }else{ ?>
                scrollX: "100%",
                scrollCollapse: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                paging: true,
                dom: 'B<"table-select-fix"l>frtip',
                <?php } ?>
                order: [[ 0, "asc"]],
                processing: true,
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Agregar Encuesta',
                        className: 'modal_agregar_encuesta'
                    },
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
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_encuesta_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { width: "20px", targets: 1 },
                    { width: "420px", targets: 2 },
                    { class: "text-center", targets: 3 },
                    { class: "text-center", targets: 4 },
                    { class: "text-center", targets: 5 }
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
                    lengthMenu: "Mostrar _MENU_ entradas"+"&nbsp;"+"&nbsp;",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );
            
            var tabla_preguntas_encuesta = $('#tabla_preguntas_encuesta').DataTable( {
                ajax: "ajax/pid_list/pid_list_enc_preguntas.php",
                /*scrollY: "600px",*/
                <?php if($_SESSION['claro_user'] == "E78540"){ ?>
                scrollY: "700px",
                scrollX: "100%",
                scrollCollapse: true,
                paging: false,
                dom: 'Bfrtip',
                <?php }else{ ?>
                scrollX: "100%",
                scrollCollapse: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                paging: true,
                dom: 'B<"table-select-fix"l>frtip',
                <?php } ?>
                order: [[ 0, "asc"]],
                processing: true,
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
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_preguntas_encuesta.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { width: "20px", targets: 1 },
                    { width: "520px", targets: 2 },
                    { class: "text-center", targets: 4 },
                    { class: "text-center", targets: 5 },
                    { class: "text-center", targets: 6 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
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
                    lengthMenu: "Mostrar _MENU_ entradas"+"&nbsp;"+"&nbsp;",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );
            
            var tabla_opciones_encuesta = $('#tabla_opciones_encuesta').DataTable( {
                ajax: "ajax/pid_list/pid_list_enc_opciones.php",
                /*scrollY: "600px",*/
                <?php if($_SESSION['claro_user'] == "E78540"){ ?>
                scrollY: "700px",
                scrollX: "100%",
                scrollCollapse: true,
                paging: false,
                dom: 'Bfrtip',
                <?php }else{ ?>
                scrollX: "100%",
                scrollCollapse: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                paging: true,
                dom: 'B<"table-select-fix"l>frtip',
                <?php } ?>
                order: [[ 1, "asc"]],
                processing: true,
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
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_opciones_encuesta.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { width: "20px", targets: 1 },
                    { width: "850px", targets: 2 },
                    { class: "text-center", targets: 3 },
                    { class: "text-center", targets: 4 }
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
                    lengthMenu: "Mostrar _MENU_ entradas"+"&nbsp;"+"&nbsp;",
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
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({ visible:true, api:true }).columns.adjust();
                });
            });
            
            /* Modal Insertar Encuesta */
            $('.modal_agregar_encuesta').click(function () {
                $("#modal_ins_encuesta").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_encuesta_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_encuesta.php',
                    success:function(data){
                        $('.ins_encuesta_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Encuesta */
            
            /* Modal Insertar Encuesta */
            $('.modal_agregar_enc_pregunta').click(function () {
                $.ajax({
                    beforeSend: function(){
                        $('.ins_enc_pregunta_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_enc_pregunta.php',
                    success:function(data){
                        $('.ins_enc_pregunta_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Encuesta */
            
            /* Modal Insertar Encuesta */
            $('.modal_agregar_enc_opciones').click(function () {
                $.ajax({
                    beforeSend: function(){
                        $('.ins_enc_opciones_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_enc_opciones.php',
                    success:function(data){
                        $('.ins_enc_opciones_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Encuesta */

        </script>
    </div>
</div>