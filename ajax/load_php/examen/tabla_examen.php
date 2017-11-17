<?php 
session_start();
require_once ('../../../data/pid_examen.php');
require_once ('../../../data/pid_access.php');
$object = new examen_usuario();
$id_user = $_SESSION['id_user_apl'];
$object_permisos = new pid_permisos();
$result_permisos = $object_permisos->user_permisos($id_user);
$row_permisos = $result_permisos->fetch_assoc();
$result = $object->view_examen_title();
$result_2 = $object->view_examen_asig();
$result_3 = $object->view_examen_asig();
?>
<div class="container content-md">
    <div class="row">
        <div class="tabla_gestion_examen">
            <div>
                <ul class="nav nav-tabs">
                    <li class="active examen"><a href="#examen" data-toggle="tab" aria-expanded="true"><span class="fa fa-plus"></span> Crear Examen [ID]</a></li>
                    <li class="universo"><a href="#universo" data-toggle="tab" aria-expanded="false"><span class="fa fa-globe"></span> Universo de Preguntas</a></li>
                    <li class="asignar"><a href="#asignar" data-toggle="tab" aria-expanded="false"><span class="fa fa-user-plus"></span> Asignar Examen a Usuario</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                  <div class="tab-pane fade active in" id="examen">
                    <br><br>
                    <?php if($row_permisos['crea_exam'] == "true" || $row_permisos['edit_exam'] == "true" || $row_permisos['chg_exam'] == "true" || $row_permisos['graf_exam'] == "true"){ ?>
                    <div style="float: right; margin-right: 10px;">
                        <select id="dbox_examenes" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-header="Titulo Examen">
                            <option data-content="<span class='label label-primary'>Todos los examenes</span>" value="" selected>TODO</option>
                            <?php while($row_examen = $result_3->fetch_assoc()){ ?>
                            <option value="<?= $row_examen['titulo_examen'] ?>"><?= $row_examen['titulo_examen'] ?></option>
                            <?php } ?>
                        </select>
                        <br>
                    </div>
                    <div style="float: right; margin-right: 10px;">
                        <select id="dbox_examenes_estado" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-header="Estado de Examen">
                            <option data-content="<span class='label label-info'>Todos los estados</span>" value="" selected>TODO</option>
                            <option data-content="<span class='label label-success'>Habilitado</span>" value="0" selected>Habilitado</option>
                            <option data-content="<span class='label label-danger'>No Habilitado</span>" value="1">No Habilitado</option>
                        </select>
                        <br>
                    </div>
                    <table id="tabla_examen_gestor" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                      <thead>
                          <tr>
                              <th>ID Examen</th>
                              <th>ID</th>
                              <th>Nombre Examen</th>
                              <th>Fecha Creación</th>
                              <th>Tiempo de Examen</th>
                              <th>Habilitado</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                    </table>
                    <?php }else{ ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Sin permisos para el acceso al módulo</h3>
                            </div>
                            <div class="panel-body text-center">
                              No cuentas con los permisos correspondientes para el acceso a este módulo, contacte con el desarrolador y/o administrador.
                            </div>
                        </div>
                    <?php } ?>
                  </div>
                  
                  <div class="tab-pane fade" id="universo">
                    <br><br>
                    <?php if($row_permisos['crea_pre_exam'] == "true" || $row_permisos['edit_pre_exam'] == "true" || $row_permisos['dele_pre_exam'] == "true" || $row_permisos['graf_pregunta'] == "true" || $row_permisos['graf_pregunta'] == "true"){ ?>
                    <div>
                        <center>
                            <div class="btn-group" role="group">
                                <a class="btn btn-info click_preguntas btn_preguntas active" href="#preguntas_ingresadas" data-toggle="tab" aria-expanded="true"><div class="preguntas_ingresadas btn_preguntas_ingresadas btn_preguntas"><span class="fa fa-question-circle"></span> Preguntas Ingresadas</div></a>
                                <a class="btn btn-warning click_preguntas_propuestas btn_preguntas" href="#preguntas_propuestas" data-toggle="tab" aria-expanded="true"><div class="preguntas_propuestas btn_preguntas_propuestas btn_preguntas"><span class="fa fa-question-circle-o"></span> Preguntas Propuestas</div></a>
                            </div>
                        </center>
                        <br>
                        <div id="myTabContent2" class="tab-content">
                            <div class="tab-pane fade active in" id="preguntas_ingresadas">
                                <br>
                                <div style="float: left">
                                    <a data-toggle="modal" data-target="#modal_ins_pregunta" class="dt-button modal_add_pregunta"><span><i class="fa fa-plus"></i> Agregar Preguntas</span></a>
                                </div>
                                <div style="float: right; margin-right: 10px;">
                                    <select id="dbox_universo" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-header="Titulo Examen">
                                        <option data-content="<span class='label label-primary'>Todos los examenes</span>" value="" selected>TODO</option>
                                        <?php while($row = $result->fetch_assoc()){ ?>
                                        <option value="<?= $row['id_examen'] ?>"><?= $row['titulo_examen'] ?></option>
                                        <?php } ?>
                                    </select>
                                    <br>
                                </div>
                                <table id="tabla_universo_preguntas" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                                    <thead>
                                          <tr>
                                            <th>ID Pregunta</th>
                                            <th>ID</th>
                                            <th>Titulo Pregunta</th>
                                            <th>[ID Examen]</th>
                                            <th>[ID APL]</th>
                                            <th>Aplicativo</th>
                                            <th>Dificultad</th>
                                            <th>Acciones</th>
                                          </tr>
                                    </thead>
                                </table>
                            </div>
                            <div class="tab-pane fade" id="preguntas_propuestas">
                                <br>
                                <table id="tabla_universo_preguntas_propuestas" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>ID Pregunta</th>
                                            <th>ID</th>
                                            <th>Titulo Pregunta</th>
                                            <th>Usuario</th>
                                            <th>Fec.Propuesta</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                    <?php }else{ ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Sin permisos para el acceso al módulo</h3>
                            </div>
                            <div class="panel-body text-center">
                              No cuentas con los permisos correspondientes para el acceso a este módulo, contacte con el desarrolador y/o administrador.
                            </div>
                        </div>
                    <?php } ?>
                  </div>
                  <div class="tab-pane fade" id="asignar">
                    <br><br>
                    <?php if($row_permisos['asig_exam'] == "true" || $row_permisos['edit_asig_exam'] == "true" || $row_permisos['dele_asig_exam'] == "true" || $row_permisos['graf_exam_usua'] == "true"){ ?>
                    <div style="float: left">
                        <a data-toggle="modal" data-target="#modal_ins_asignado" class="dt-button modal_add_asignado"><span><i class="fa fa-plus"></i> Asignar Examen</span></a>
                    </div>
                    <div style="float: right; margin-right: 10px;">
                        <select id="dbox" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-header="Titulo de Examen">
                            <option value="" selected>TODO</option>
                            <?php while($row_2 = $result_2->fetch_assoc()){ ?>
                            <option value="<?= $row_2['titulo_examen'] ?>"><?= $row_2['titulo_examen'] ?></option>
                            <?php } ?>
                        </select>
                        <br>
                    </div>
                    <div style="float: right; margin-right: 10px;">
                        <select id="dbox_estado" name="estado" class="show-tick show-menu-arrow" data-live-search="true" data-header="Estado Asignados">
                            <option data-content="<span class='label label-default'>Todo</span>" value="" selected>TODO</option>
                            <option data-content="<span class='label label-primary'>Pendiente</span>" value="PENDIENTE">PENDIENTE</option>
                            <option data-content="<span class='label label-warning'>En Proceso</span>" value="EN-PROCESO">EN-PROCESO</option>
                            <option data-content="<span class='label label-danger'>Expirado</span>" value="EXPIRADO">EXPIRADO</option>
                            <option data-content="<span class='label label-info' style='background-color:#AE8E11'>Observado</span>" value="OBSERVADO">OBSERVADO</option>
                            <option data-content="<span class='label label-success'>Resuelto</span>" value="RESUELTO">RESUELTO</option>            
                        </select>
                        <br>
                    </div>
                    <table id="tabla_examenes_asignados" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                      <thead>
                          <tr>
                              <th>ID Asignado</th>
                              <th>ID</th>
                              <th>C.Claro</th>
                              <th>Usuario</th>
                              <th>Examen</th>
                              <th>Fecha Asignado</th>
                              <th>Fecha Término</th>
                              <th>Estado</th>
                              <th>Nota</th>
                              <th>Acción</th>
                          </tr>
                      </thead>
                    </table>
                    <?php }else{ ?>
                        <div class="panel panel-danger">
                            <div class="panel-heading">
                                <h3 class="panel-title">Sin permisos para el acceso al módulo</h3>
                            </div>
                            <div class="panel-body text-center">
                              No cuentas con los permisos correspondientes para el acceso a este módulo, contacte con el desarrolador y/o administrador.
                            </div>
                        </div>
                    <?php } ?>
                  </div>
                </div>
                <div id="source-button" class="btn btn-primary btn-xs" style="display: none;">&lt; &gt;</div>
            </div>
        </div>
        <script>
            var tabla_examen_gestor = $('#tabla_examen_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_examen_gestor.php",
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
                        text: '<i class="fa fa-plus"></i> Agregar Examen',
                        className: 'modal_agregar_examen'
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
                            tabla_examen_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "250px", targets: 2 },
                    { width: "80px", targets: 3 },
                    { width: "80px", targets: 4 },
                    { type: "date-uk", targets: 3 },
                    { class: "text-center", targets: 3 },
                    { class: "text-center", targets: 4 },
                    { class: "text-center", targets: 5 },
                    { class: "text-center", targets: 6 }
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
                    lengthMenu: "Mostrar _MENU_ entradas"+"&nbsp;"+"&nbsp;",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );

            var tabla_universo_preguntas = $('#tabla_universo_preguntas').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_univero_preguntas.php",
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
                        text: '<i class="fa fa-recycle"></i> Reiniciar Estadisticas',
                        action: function () {
                            swal({
                                title: 'Deseas reiniciar todas las estadisticas?',
                                text: "Recuerda que los valores se pondran en 0 !",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#1b9cdd',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<i class="fa fa-recycle"></i> Resetear',
                                showLoaderOnConfirm: false,
                                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                            }).then(function() {
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/action_class/reset/reset_estadistica_pregunta_todas.php",
                                    success: function(data) {
                                        if(data == "sin_permiso"){
                                            swal({
                                                title: "",
                                                text: "No cuentas con el permiso correspondiente",
                                                type: "error",
                                                showCancelButton: false,
                                                showConfirmButton: true
                                            });
                                        }else{
                                            if(data == "true"){
                                                setTimeout(function(){     
                                                    swal({
                                                        title: "",
                                                        text: "Se reinicio las estadisticas de todas las preguntas con exito",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }, 600);
                                            }else{
                                                swal({
                                                    title: "",
                                                    text: "Error al reiniciar las estadisticas, informalo al administrador y/o desarrollador.",
                                                    type: "error",
                                                    showCancelButton: false,
                                                    showConfirmButton: true
                                                });
                                            }
                                        }
                                    }
                                });
                            }, function(dismiss) {
                              if (dismiss === 'cancel') {
                                swal({
                                    title: "",
                                    text: "No se reinicio las estadisticas.",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                              }
                            })
                        }
                    },
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_universo_preguntas.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { searchable: "false", targets: 1 },
                    { width: "10px", targets: 1 },
                    { width: "500px", targets: 2 },
                    { width: "70px", targets: 3 },
                    { width: "40px", targets: 4 },
                    { width: "110px", targets: 5 },
                    { width: "80px", targets: 7 },
                    { class: "text-center", targets: 3 },
                    { class: "text-center", targets: 5 },
                    { class: "text-center", targets: 7 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
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
                    lengthMenu: "Mostrar _MENU_ entradas"+"&nbsp;"+"&nbsp;",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );
            
            var tabla_universo_preguntas_propuestas = $('#tabla_universo_preguntas_propuestas').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_univero_preguntas_propuestas.php",
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
                            tabla_universo_preguntas_propuestas.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { searchable: "false", targets: 1 },
                    { width: "10px", targets: 1 },
                    { width: "500px", targets: 2 },
                    { width: "200px", targets: 3 },
                    { width: "150px", targets: 4 },
                    { width: "110px", targets: 5 },
                    { width: "110px", targets: 6 },
                    { class: "text-center", targets: 3 },
                    { class: "text-center", targets: 4 },
                    { class: "text-center", targets: 5 },
                    { class: "text-center", targets: 6 }
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
                    lengthMenu: "Mostrar _MENU_ entradas"+"&nbsp;"+"&nbsp;",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );

            var tabla_examenes_asignados = $('#tabla_examenes_asignados').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_exam_asignados.php",
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
                processing: false,
                buttons: [
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
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
                    }
                ],
                responsive: false,
                columnDefs: [
                    { type: "currency", targets: 1 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
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
                    lengthMenu: "Mostrar _MENU_ entradas"+"&nbsp;"+"&nbsp;",
                    oPaginate: {
                        sFirst:    "Primero",
                        sLast:     "Ultimo",
                        sNext:     "Siguiente",
                        sPrevious: "Anterior"
                    }
                }

            } );

            $('#dbox_examenes').selectpicker('show');

            $("select#dbox_examenes").change(function() {
                var choosedFilter = $("#dbox_examenes").val();
                //var choosedString = choosedFilter.join("|");
                tabla_examen_gestor
                        .columns(2)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            $('#dbox_examenes_estado').selectpicker('show');

            $("select#dbox_examenes_estado").change(function() {
                var choosedFilter = $("#dbox_examenes_estado").val();
                //alert(choosedFilter);
                //var choosedString = choosedFilter.join("|");
                tabla_examen_gestor
                        .columns(5)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#dbox').selectpicker('show');

            $("select#dbox").change(function() {
                var choosedFilter = $("#dbox").val();
                //var choosedString = choosedFilter.join("|");
                tabla_examenes_asignados
                        .columns(4)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#dbox_universo').selectpicker('show');
            
            $("select#dbox_universo").change(function() {
                if($("#dbox_universo").val() == null || $("#dbox_universo").val() == ""){
                    var choosedFilter = '';
                }else{
                    var choosedFilter = '((^|,)' + $("#dbox_universo").val() + '($|,))|';
                }
                
                //var choosedString = choosedFilter.join("|");
                choosedFilter = choosedFilter.replace(/\|$/g, '');
                tabla_universo_preguntas
                        .columns(3)
                        .search(choosedFilter,true,false)
                        .draw();
            });

            $('#dbox_estado').selectpicker('show');

            $("select#dbox_estado").change(function() {
                var choosedFilter = $("#dbox_estado").val();
                //var choosedString = choosedFilter.join("|");
                tabla_examenes_asignados
                        .columns(7)
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
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({ visible:true, api:true }).columns.adjust();
                });
                tabla_examen_gestor
                        .columns(5)
                        .search(0,2,true,false)
                        .draw();
            });
            
            $('.click_preguntas').click(function() {
                $('.btn_preguntas').removeClass('active');
                $('.btn_preguntas_ingresadas').addClass('active');
            });
            
            $('.click_preguntas_propuestas').click(function() {
                $('.btn_preguntas').removeClass('active');
                $('.btn_preguntas_propuestas').addClass('active');
            });

            /* Modal Insertar Examen */
            $('.modal_agregar_examen').click(function () {
                $("#modal_ins_examen").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_examen_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_examen.php',
                    success:function(data){
                        $('.ins_examen_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Examen */

            /* Modal Insertar Pregunta Examen */
            $('.modal_add_pregunta').click(function () {
                $.ajax({
                    beforeSend: function(){
                        $('.ins_pregunta_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_pregunta.php',
                    success:function(data){
                        $('.ins_pregunta_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Pregunta Examen */

            /* Modal Insertar Asignado */
            $('.modal_add_asignado').click(function () {
                $.ajax({
                    beforeSend: function(){
                        $('.ins_asignado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_asignado.php',
                    success:function(data){
                        $('.ins_asignado_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Asignado */

        </script>
    </div>
</div>