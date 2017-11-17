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
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="categorias">
                <div class="tabla_pid_categorias">
                    <div style="float: left; margin-right: 1px;">
                        <div class="btn-group" role="group">
                            <a class="dt-button btn_categorias click_categorias btn_categoria active" href="#categorias" data-toggle="tab" aria-expanded="true"><div class="categorias"><span class="fa fa-database"></span> Nivel 2</div></a>
                            <a class="dt-button btn_aplicativos click_aplicativos btn_categoria" href="#aplicativos" data-toggle="tab" aria-expanded="true"><div class="aplicativos"><span class="fa fa-wrench"></span> Nivel 3</div></a>
                            <a class="dt-button btn_grupo_asignado click_grupo_asignado btn_categoria" href="#grupo_asignados" data-toggle="tab" aria-expanded="true"><div class="grupo_asignados"><span class="fa fa-group"></span> Nivel 4</div></a>
                            <a class="dt-button btn_grupo_resolutor click_resolutor btn_categoria" href="#usuario_resolutor" data-toggle="tab" aria-expanded="true"><div class="usuario_resolutor"><span class="fa fa-user"></span> Usuarios Resolutores</div></a>
                        </div>
                    </div>
                    <table id="tabla_categorias" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>ID</th>
                              <th>Nombre de Categoria</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="aplicativos">
                <div class="tabla_pid_aplicativos">
                    <div style="float: left; margin-right: 1px;">
                        <div class="btn-group" role="group">
                            <a class="dt-button btn_categorias click_categorias btn_categoria" href="#categorias" data-toggle="tab" aria-expanded="true"><div class="categorias"><span class="fa fa-database"></span> Nivel 2</div></a>
                            <a class="dt-button btn_aplicativos click_aplicativos btn_categoria" href="#aplicativos" data-toggle="tab" aria-expanded="true"><div class="aplicativos"><span class="fa fa-wrench"></span> Nivel 3</div></a>
                            <a class="dt-button btn_grupo_asignado click_grupo_asignado btn_categoria" href="#grupo_asignados" data-toggle="tab" aria-expanded="true"><div class="grupo_asignados"><span class="fa fa-group"></span> Nivel 4</div></a>
                            <a class="dt-button btn_grupo_resolutor click_resolutor btn_categoria" href="#usuario_resolutor" data-toggle="tab" aria-expanded="true"><div class="usuario_resolutor"><span class="fa fa-user"></span> Usuarios Resolutores</div></a>
                        </div>
                    </div>
                    <table id="tabla_aplicativos" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>ID</th>
                              <th>Nombre de Aplicativo</th>
                              <th>Categoria Asociada</th>
                              <th>Grupo Asociada</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="grupo_asignados">
                <div class="tabla_pid_grupo_asignado">
                    <div style="float: left; margin-right: 1px;">
                        <div class="btn-group" role="group">
                            <a class="dt-button btn_categorias click_categorias btn_categoria" href="#categorias" data-toggle="tab" aria-expanded="true"><div class="categorias"><span class="fa fa-database"></span> Nivel 2</div></a>
                            <a class="dt-button btn_aplicativos click_aplicativos btn_categoria" href="#aplicativos" data-toggle="tab" aria-expanded="true"><div class="aplicativos"><span class="fa fa-wrench"></span> Nivel 3</div></a>
                            <a class="dt-button btn_grupo_asignado click_grupo_asignado btn_categoria" href="#grupo_asignados" data-toggle="tab" aria-expanded="true"><div class="grupo_asignados"><span class="fa fa-group"></span> Nivel 4</div></a>
                            <a class="dt-button btn_grupo_resolutor click_resolutor btn_categoria" href="#usuario_resolutor" data-toggle="tab" aria-expanded="true"><div class="usuario_resolutor"><span class="fa fa-user"></span> Usuarios Resolutores</div></a>
                        </div>
                    </div>
                    <table id="tabla_grupo_asignado" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID</th>
                                <th>Nombre del Grupo Asignado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="usuario_resolutor">
                <div class="tabla_pid_usuario_resolutor">
                    <div style="float: left; margin-right: 1px;">
                        <div class="btn-group" role="group">
                            <a class="dt-button btn_categorias click_categorias btn_categoria" href="#categorias" data-toggle="tab" aria-expanded="true"><div class="categorias"><span class="fa fa-database"></span> Nivel 2</div></a>
                            <a class="dt-button btn_aplicativos click_aplicativos btn_categoria" href="#aplicativos" data-toggle="tab" aria-expanded="true"><div class="aplicativos"><span class="fa fa-wrench"></span> Nivel 3</div></a>
                            <a class="dt-button btn_grupo_asignado click_grupo_asignado btn_categoria" href="#grupo_asignados" data-toggle="tab" aria-expanded="true"><div class="grupo_asignados"><span class="fa fa-group"></span> Nivel 4</div></a>
                            <a class="dt-button btn_grupo_resolutor click_resolutor btn_categoria" href="#usuario_resolutor" data-toggle="tab" aria-expanded="true"><div class="usuario_resolutor"><span class="fa fa-user"></span> Usuarios Resolutores</div></a>
                        </div>
                    </div>
                    <table id="tabla_usuario_resolutor" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>ID</th>
                                <th>Nombre del Usuario Resolutor</th>
                                <th>Área</th>
                                <th>Jefe</th>
                                <th>Cargo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <script>
            
            $('.click_categorias').click(function() {
                $('.btn_categoria').removeClass('active');
                $('.btn_categorias').addClass('active');
            });
            
            $('.click_aplicativos').click(function() {
                $('.btn_categoria').removeClass('active');
                $('.btn_aplicativos').addClass('active');
            });
            
            $('.click_grupo_asignado').click(function() {
                $('.btn_categoria').removeClass('active');
                $('.btn_grupo_asignado').addClass('active');
            });
            
            $('.click_resolutor').click(function() {
                $('.btn_categoria').removeClass('active');
                $('.btn_grupo_resolutor').addClass('active');
            });
            
            var tabla_categorias = $('#tabla_categorias').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_categorias.php",
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
                        text: '<i class="fa fa-database"></i> Agregar Categoria',
                        className: 'agregar_categoria'
                    },
                    {
                        extend: 'csv',
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
                            tabla_categorias.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { "type": "currency", targets: 1 }
                ],
                columns: [
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
                    lengthMenu: "Mostrar _MENU_ entradas",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );
            
            var tabla_aplicativos = $('#tabla_aplicativos').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_aplicativos.php",
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
                        text: '<i class="fa fa-wrench"></i> Agregar Aplicativo',
                        className: 'agregar_aplicativo'
                    },
                    {
                        extend: 'csv',
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
                            tabla_aplicativos.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { "type": "currency", targets: 1 }
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
            
            var tabla_grupo_asignado = $('#tabla_grupo_asignado').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_grupo_asignado.php",
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
                        text: '<i class="fa fa-group"></i> Agregar Grupo Asignado',
                        className: 'agregar_grupo_asignado'
                    },
                    {
                        extend: 'csv',
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
                            tabla_grupo_asignado.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { "type": "currency", targets: 1 }
                ],
                columns: [
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
                    lengthMenu: "Mostrar _MENU_ entradas",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );
            
            var tabla_usuario_resolutor = $('#tabla_usuario_resolutor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_usuario_resolutor.php",
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
                        text: '<i class="fa fa-group"></i> Agregar Usuario Resolutor',
                        className: 'agregar_usuario_resolutor'
                    },
                    {
                        extend: 'csv',
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
                            tabla_usuario_resolutor.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { "type": "currency", targets: 1 }
                ],
                columns: [
                    { visible: false },
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

            $('.clear_input_search').click(function() {
                $('.search_close').val('').keyup();
                setTimeout(function(){
                    $(document.body).css('padding-right','');
                },1000);
            });

            $(document).ready(function () {
                tabla_categorias.ajax.reload( null, false );
                tabla_aplicativos.ajax.reload( null, false );
                tabla_grupo_asignado.ajax.reload( null, false );
                tabla_usuario_resolutor.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_categorias_processing").show();
                    $("#tabla_aplicativos_processing").show();
                    $("#tabla_grupo_asignado_processing").show();
                    $("#tabla_usuario_resolutor_processing").show();
                });
            });
            
            $(document).ready(function () {
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({ visible:true, api:true }).columns.adjust();
                });
            });
            
            /* Modal Insertar Categoria */
            $('.agregar_categoria').click(function () {
                $("#modal_ins_categoria").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_categoria_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_categoria.php',
                    success:function(data){
                        $('.ins_categoria_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Categoria */

            /* Modal Insertar Aplicativo */
            $('.agregar_aplicativo').click(function () {
                $("#modal_ins_aplicativo").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_aplicativo_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_aplicativo.php',
                    success:function(data){
                        $('.ins_aplicativo_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Aplicativo */
            
            /* Modal Insertar Grupo Asignado */
            $('.agregar_grupo_asignado').click(function () {
                $("#modal_ins_grupo_asignado").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_grupo_asignado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_grupo.php',
                    success:function(data){
                        $('.ins_grupo_asignado_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Grupo Asignado */
            
            /* Modal Insertar Usuario Resolutor */
            $('.agregar_usuario_resolutor').click(function () {
                $("#modal_ins_resolutor").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_resolutor_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_resolutor.php',
                    success:function(data){
                        $('.ins_resolutor_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Usuario Resolutor */
            
        </script>
    </div>
</div>

