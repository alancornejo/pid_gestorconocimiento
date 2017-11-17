<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_access.php');
require_once ('../../../data/pid_view.php');
$id_user = $_SESSION['id_user_apl'];
$object = new pid_auth();
$object_view = new pid_view();
$object_permisos = new pid_permisos();
$result = $object->user_auth($id_user);
$result_area = $object_view->view_area_resp();
$result_apl_pl = $object_view->view_aplicativo_plataforma_caso();
$result_cargo = $object_view->view_cargo();
$result_responsable = $object_view->view_responsable();
$result_ruta_speech = $object_view->view_ruta_speech();
$result_permisos = $object_permisos->user_permisos($id_user);
$result_generado_por_seg = $object_view->view_generado_por_seguimiento();
$result_supervisor_seg = $object_view->view_supervisor_seguimiento();
$result_grupo_responsable_seg = $object_view->view_grupo_responsable_seguimiento();
$result_generado_por_seg_solu = $object_view->view_generado_por_seguimiento_solu();
$result_supervisor_seg_solu = $object_view->view_supervisor_seguimiento_solu();
$result_grupo_responsable_seg_solu = $object_view->view_grupo_responsable_seguimiento_solu();
$row_access = $result->fetch_assoc();
$row_permisos = $result_permisos->fetch_assoc();
$row_ruta_speech = $result_ruta_speech->fetch_assoc();
?>
<div class="container content-md">
    <div class="row">
        <div class="tabla_nas">
            <div>
                <ul class="nav nav-tabs">
                    <li class="active matriz_responsable"><a href="#matriz_responsable" data-toggle="tab" aria-expanded="true"><span class="fa fa-balance-scale"></span> Matriz Responsables</a></li>
                    <li class="speech"><a href="<?php if($_SERVER['SERVER_NAME'] == "localhost"){ echo "http://".$_SERVER['SERVER_NAME'].":8080/apl/".$row_ruta_speech['src_ruta']; }else if($_SERVER['SERVER_NAME'] == "10.200.10.90" || $_SERVER['SERVER_NAME'] == "10.200.10.90/"){ echo "http://".$_SERVER['SERVER_NAME']."/apl".$row_ruta_speech['src_ruta']; }else{ echo "http://".$_SERVER['SERVER_NAME'].$row_ruta_speech['src_ruta'];  } ?>" target="_blank"><span class="fa fa-comment"></span> Speech's del Servicio</a></li>
                    <li class="matriz_jobs"><a href="#matriz_jobs" data-toggle="tab" aria-expanded="true"><span class="fa fa-gears"></span> Matriz Jobs</a></li>
                    <li class="turnos_analistas"><a href="#turnos_analistas" data-toggle="tab" aria-expanded="true"><span class="fa fa-clock-o"></span> Turnos Analistas Claro</a></li>
                    <li class="horarios_cacs"><a href="#horarios_cacs" data-toggle="tab" aria-expanded="true"><span class="fa fa-calendar"></span> Horarios/Resp. CAC'S</a></li>
                    <li class="comunicado_atc"><a href="#comunicado_atc" data-toggle="tab" aria-expanded="true"><span class="fa fa-play-circle-o"></span> Comunicados ATC</a></li>
                    <li class="seguimiento_casos"><a href="#seguimiento_casos" data-toggle="tab" aria-expanded="true"><span class="fa fa-database"></span> Seguimiento Casos</a></li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="matriz_responsable">
                    <br>
                        <table <?php if($row_permisos['add_ma_resp'] == 'true'){ echo 'id="tabla_responsable_gestor"'; }else{ echo 'id="tabla_responsable"'; } ?> class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID Matriz</th>
                                    <th>Área Responsable</th>
                                    <th>Aplicativo/Plataforma/Caso</th>
                                    <th>Cargo</th>
                                    <th>Responsable</th>
                                    <th>Acción</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>
                                        <select class="selectpicker show-tick show-menu-arrow" <?php if($row_permisos['add_ma_resp'] == 'true'){ echo 'id="area_responsable_gestor"'; }else{ echo 'id="area_responsable"'; } ?> data-live-search="true" data-width="fit" data-header="Área Responsable">
                                            <option value="" selected>Mostrar Todo</option>
                                            <?php while($row_area = $result_area->fetch_assoc()){ ?>
                                            <option value="<?= utf8_encode($row_area['area_resp']) ?>"><?= utf8_encode($row_area['area_resp']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th>
                                        <select class="selectpicker show-tick show-menu-arrow" <?php if($row_permisos['add_ma_resp'] == 'true'){ echo 'id="aplicativo_plataforma_caso_gestor"'; }else{ echo 'id="aplicativo_plataforma_caso"'; } ?> data-live-search="true" data-width="fit" data-header="Aplicativo/Plataforma/Caso">
                                            <option value="" selected>Mostrar Todo</option>
                                            <?php while($row_apl_pl = $result_apl_pl->fetch_assoc()){ ?>
                                            <option value="<?= utf8_encode($row_apl_pl['apl_pla']) ?>"><?= utf8_encode($row_apl_pl['apl_pla']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th>
                                        <select class="selectpicker show-tick show-menu-arrow" <?php if($row_permisos['add_ma_resp'] == 'true'){ echo 'id="cargo_gestor"'; }else{ echo 'id="cargo"'; } ?> data-live-search="true" data-width="fit" data-header="Cargo">
                                            <option value="" selected>Mostrar Todo</option>
                                            <?php while($row_cargo = $result_cargo->fetch_assoc()){ ?>
                                            <option value="<?= utf8_encode($row_cargo['tipo_cargo']) ?>"><?= utf8_encode($row_cargo['tipo_cargo']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th>
                                        <select class="selectpicker show-tick show-menu-arrow" <?php if($row_permisos['add_ma_resp'] == 'true'){ echo 'id="responsable_gestor"'; }else{ echo 'id="responsable"'; } ?> data-live-search="true" data-width="fit" data-header="Analista Responsable">
                                            <option value="" selected>Mostrar Todo</option>
                                            <?php while($row_responsable = $result_responsable->fetch_assoc()){ ?>
                                            <option value="<?= utf8_encode($row_responsable['nom_responsable']) ?>"><?= utf8_encode($row_responsable['nom_responsable']) ?></option>
                                            <?php } ?>
                                        </select>
                                    </th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="turnos_analistas">
                        <div id="turno_analista"></div>
                    </div>
                    <div class="tab-pane fade" id="horarios_cacs">
                        <div id="horarios_cacs"></div>
                    </div>
                    <div class="tab-pane fade" id="matriz_jobs">
                        <br>
                        <table id="<?php if($row_permisos['edit_ma_jobs'] == "true"){ echo "tabla_jobs_gestor"; }else{ echo "tabla_jobs"; } ?>" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>ID JOB</th>
                                    <th>Nombre de JOB</th>
                                    <th>Analista</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="comunicado_atc">
                        <br>
                        <?php if($row_permisos['add_com_atc'] == 'true'){ ?>
                            <table id="tabla_comunicado_atc_gestor" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID Com.</th>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th>Reg. Por :</th>
                                        <th class="text-center">Fec.Reg</th>
                                        <th class="text-center">Fec.Act</th>
                                        <th>Dias</th>
                                        <th>Tipo Aviso</th>
                                        <th class="text-center">Correo</th>
                                        <th class="text-center">Acción</th>
                                        <th>Contenido</th>
                                    </tr>
                                </thead>
                            </table>
                        <?php }else{ ?>
                            <table id="tabla_comunicado_atc" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>ID Com.</th>
                                        <th>ID</th>
                                        <th>Titulo</th>
                                        <th class="text-center">Fec.Reg</th>
                                        <th class="text-center">Fec.Act</th>
                                        <th class="text-center">Correo</th>
                                        <th class="text-center">Acción</th>
                                        <th>Contenido</th>
                                    </tr>
                                </thead>
                            </table>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="seguimiento_casos">
                        <br>
                        <div>
                            <center>
                                <div class="btn-group" role="group">
                                    <a class="btn btn-primary click_asig_pen_seg btn_seg active" href="#asig_pen_seg" data-toggle="tab" aria-expanded="true"><div class="asig_pen_seg btn_asig_pen_seg btn_seg"><span class="fa fa-medkit"></span> Asignados / Pendientes / En Progreso</div></a>
                                    <a class="btn btn-success click_solu_seg btn_seg" href="#solu_seg" data-toggle="tab" aria-expanded="true"><div class="solu_seg btn_solu_seg btn_seg"><span class="fa fa-check"></span> Solucionados</div></a>
                                </div>
                            </center>
                            <br>
                            <div id="myTabContent2" class="tab-content">
                                <div class="tab-pane fade active in" id="asig_pen_seg">
                                    <br>
                                    <table id="tabla_seguimiento_casos" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID Seguimiento</th>
                                                <th>N° Caso</th>
                                                <th>Generado Por :</th>
                                                <th>Supervisor</th>
                                                <th>Grupo Responsable</th>
                                                <th>Estado</th>
                                                <th>Dias Pendientes</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                    <select class="selectpicker show-tick show-menu-arrow" id="generado_por_seguimiento_casos" data-live-search="true" data-width="fit" data-header="Generado Por :">
                                                        <option value="" selected>Mostrar Todo</option>
                                                        <?php while($row_generado_por_seg = $result_generado_por_seg->fetch_assoc()){ ?>
                                                        <option value="<?= utf8_encode($row_generado_por_seg['generado_por']) ?>"><?= utf8_encode($row_generado_por_seg['generado_por']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="selectpicker show-tick show-menu-arrow" id="supervisor_seguimiento_casos" data-live-search="true" data-width="fit" data-header="Supervisor">
                                                        <option value="" selected>Mostrar Todo</option>
                                                        <?php while($row_supervisor_seg = $result_supervisor_seg->fetch_assoc()){ ?>
                                                        <option value="<?= utf8_encode($row_supervisor_seg['nom_supervisor']) ?>"><?= utf8_encode($row_supervisor_seg['nom_supervisor']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="selectpicker show-tick show-menu-arrow" id="grupo_responsable_seguimiento_casos" data-live-search="true" data-width="fit" data-header="Grupo Responsable">
                                                        <option value="" selected>Mostrar Todo</option>
                                                        <?php while($row_grupo_responsable_seg = $result_grupo_responsable_seg->fetch_assoc()){ ?>
                                                        <option value="<?= utf8_encode($row_grupo_responsable_seg['nom_grupo']) ?>"><?= utf8_encode($row_grupo_responsable_seg['nom_grupo']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="selectpicker show-tick show-menu-arrow" id="estado_seguimiento_casos" data-live-search="true" data-width="fit" data-header="Estado">
                                                        <option value="" selected>Mostrar Todo</option>
                                                        <option value="ASIGNADO" data-content='<span class="label label-warning">ASIGNADO</span>'>Mostrar Todo</option>
                                                        <option value="PENDIENTE" data-content='<span class="label label-primary">PENDIENTE</span>'>Mostrar Todo</option>
                                                        <option value="EN-PROGRESO" data-content='<span class="label label-info">EN-PROGRESO</span>'>Mostrar Todo</option>
                                                    </select>
                                                </th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="solu_seg">
                                    <br>
                                    <table id="tabla_seguimiento_casos_solu" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>ID Seguimiento</th>
                                                <th>N° Caso</th>
                                                <th>Generado Por :</th>
                                                <th>Supervisor</th>
                                                <th>Grupo Responsable</th>
                                                <th>Estado</th>
                                                <th>Dias Solucionados</th>
                                            </tr>
                                            <tr>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th>
                                                    <select class="selectpicker show-tick show-menu-arrow" id="generado_por_seguimiento_casos_solu" data-live-search="true" data-width="fit" data-header="Generado Por :">
                                                        <option value="" selected>Mostrar Todo</option>
                                                        <?php while($row_generado_por_seg_solu = $result_generado_por_seg_solu->fetch_assoc()){ ?>
                                                        <option value="<?= utf8_encode($row_generado_por_seg_solu['generado_por']) ?>"><?= utf8_encode($row_generado_por_seg_solu['generado_por']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="selectpicker show-tick show-menu-arrow" id="supervisor_seguimiento_casos_solu" data-live-search="true" data-width="fit" data-header="Supervisor">
                                                        <option value="" selected>Mostrar Todo</option>
                                                        <?php while($row_supervisor_seg_solu = $result_supervisor_seg_solu->fetch_assoc()){ ?>
                                                        <option value="<?= utf8_encode($row_supervisor_seg_solu['nom_supervisor']) ?>"><?= utf8_encode($row_supervisor_seg_solu['nom_supervisor']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th>
                                                    <select class="selectpicker show-tick show-menu-arrow" id="grupo_responsable_seguimiento_casos_solu" data-live-search="true" data-width="fit" data-header="Grupo Responsable">
                                                        <option value="" selected>Mostrar Todo</option>
                                                        <?php while($row_grupo_responsable_seg_solu = $result_grupo_responsable_seg_solu->fetch_assoc()){ ?>
                                                        <option value="<?= utf8_encode($row_grupo_responsable_seg_solu['nom_grupo']) ?>"><?= utf8_encode($row_grupo_responsable_seg_solu['nom_grupo']) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </div>
        <script>

            $('#turno_analista').load("ajax/load_php/excel_reader/turnos_analistas/turnos_analistas.php");
            $('#horarios_cacs').load("ajax/load_php/excel_reader/horarios_responsables_cacs/horarios_responsables.php");

            function format ( n ) { //n.num_anexo
                return '<table class="table table-bordered table-striped">'+
                            '<tbody>'+
                                '<tr style="height: 14px;">'+
                                    '<td style="width: 283.533px; height: 14px; text-align: center;" colspan="2"><span><strong>Contacto</strong></span></td>'+
                                '</tr>'+
                                '<tr style="height: 14px;">'+
                                    '<td style="width: 155.067px; height: 14px; text-align: center;"><b><i class="fa fa-phone"></i> Anexo</b> : '+n.num_anexo+'</td>'+
                                    '<td style="width: 122.233px; height: 14px; text-align: center;"><b><i class="fa fa-mobile"></i> Telefono Celular</b> : '+n.num_celular+'</td>'+
                                '</tr>'+
                            '</tbody>'+
                        '</table>';
            }

            function format_2 ( m ) { //n.num_anexo
                return '<table class="table table-bordered">'+
                            '<tbody>'+
                                '<tr style="height: 14px;">'+
                                    '<td style="width: 283.533px; height: 14px; text-align: center;background-color: #F9F9F9;" colspan="2"><span><strong>Informacion Adicional</strong></span></td>'+
                                '</tr>'+
                                '<tr style="height: 14px;">'+
                                    '<td style="width: 155.067px; height: 14px; text-align: center;"><b><i class="fa fa-android"></i> Aplicativo</b> : '+m.apl_job+'</td>'+
                                    '<td style="width: 122.233px; height: 14px; text-align: center;"><b><i class="fa fa-group"></i> Grupo</b> : '+m.group_job+'</td>'+
                                '</tr>'+
                                '<tr style="height: 14px;">'+
                                    '<td style="width: 155.067px; height: 14px; text-align: center;"><b><i class="fa fa-spinner"></i> Ciclico</b> : '+m.cyclic_job+'</td>'+
                                    '<td style="width: 122.233px; height: 14px; text-align: center;"><b><i class="fa fa-book"></i> Observacion</b> : '+m.obs_job+'</td>'+
                                '</tr>'+
                                '<tr style="height: 14px;">'+
                                    '<td colspan="2" style="width: 100%; height: 14px; text-align: center;"><b><i class="fa fa-comment"></i> Descripcion</b> : '+m.desc_job+'</td>'+
                                '</tr>'+
                            '</tbody>'+
                        '</table>';
            }

            var tabla_responsable_gestor = $('#tabla_responsable_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_responsable_gestor.php",
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
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
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_responsable_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                columns: [
                    {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                    },
                    { data: "id_matriz" },
                    { data: "area_resp" },
                    { data: "apl_pla" },
                    { data: "tipo_cargo" },
                    { data: "nom_responsable" },
                    { data: "boton" }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 0},
                    { targets: 1, visible: false},
                    { targets: 6, visible: true},
                    { targets: 2, orderable: false},
                    { targets: 3, orderable: false},
                    { targets: 4, orderable: false},
                    { targets: 5, orderable: false},
                    { targets: 6, orderable: false}
                ],
                order: [[1, 'asc']],
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

            var tabla_responsable = $('#tabla_responsable').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_responsable_gestor.php",
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                dom: 'B<"table-select-fix"l>frtip',
                buttons: [
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_responsable.ajax.reload( null, false );
                        }
                    }
                ],
                columns: [
                    {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                    },
                    { data: "id_matriz" },
                    { data: "area_resp" },
                    { data: "apl_pla" },
                    { data: "tipo_cargo" },
                    { data: "nom_responsable" },
                    { data: "boton" }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 0},
                    { targets: 1, visible: false},
                    { targets: 6, visible: false},
                    { targets: 2, orderable: false},
                    { targets: 3, orderable: false},
                    { targets: 4, orderable: false},
                    { targets: 5, orderable: false},
                    { targets: 6, orderable: false}
                ],
                order: [[1, 'asc']],
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

            $('#tabla_responsable_gestor tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_responsable_gestor.row( tr );

                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );

            $('#tabla_responsable tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_responsable.row( tr );

                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( format(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );

            $('#area_responsable_gestor').selectpicker('show');

            $("select#area_responsable_gestor").change(function() {
                var choosedFilter = $("#area_responsable_gestor").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable_gestor
                        .columns(2)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#aplicativo_plataforma_caso_gestor').selectpicker('show');

            $("select#aplicativo_plataforma_caso_gestor").change(function() {
                var choosedFilter = $("#aplicativo_plataforma_caso_gestor").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable_gestor
                        .columns(3)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#cargo_gestor').selectpicker('show');

            $("select#cargo_gestor").change(function() {
                var choosedFilter = $("#cargo_gestor").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable_gestor
                        .columns(4)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#responsable_gestor').selectpicker('show');

            $("select#responsable_gestor").change(function() {
                var choosedFilter = $("#responsable_gestor").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable_gestor
                        .columns(5)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#area_responsable').selectpicker('show');

            $("select#area_responsable").change(function() {
                var choosedFilter = $("#area_responsable").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable
                        .columns(2)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#aplicativo_plataforma_caso').selectpicker('show');

            $("select#aplicativo_plataforma_caso").change(function() {
                var choosedFilter = $("#aplicativo_plataforma_caso").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable
                        .columns(3)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#cargo').selectpicker('show');

            $("select#cargo").change(function() {
                var choosedFilter = $("#cargo").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable
                        .columns(4)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            $('#responsable').selectpicker('show');

            $("select#responsable").change(function() {
                var choosedFilter = $("#responsable").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_responsable
                        .columns(5)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });

            /* Modal Insertar Responsable */
            $('.modal_responsable_gestor').click(function () {
                $("#modal_ins_responsable").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_responsable_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_responsable.php',
                    success:function(data){
                        $('.ins_responsable_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Responsable */

            var tabla_jobs_gestor = $('#tabla_jobs_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_jobs_gestor.php",
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                pageLength: 200,
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
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_jobs_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                columns: [
                    {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                    },
                    { data: "id_jobs" },
                    { data: "nom_job" },
                    { data: "nom_analista_job" },
                    { data: "boton" }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 0},
                    { targets: 1, visible: false}/*,
                    { targets: 6, visible: true},
                    { targets: 2, orderable: false},
                    { targets: 3, orderable: false},
                    { targets: 4, orderable: false},
                    { targets: 5, orderable: false},
                    { targets: 6, orderable: false}*/
                ],
                order: [[1, 'asc']],
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

            $('#tabla_jobs_gestor tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_jobs_gestor.row( tr );

                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( format_2(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );

            var tabla_jobs = $('#tabla_jobs').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_jobs_gestor.php",
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                pageLength: 200,
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
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_jobs.ajax.reload( null, false );
                        }
                    }
                ],
                columns: [
                    {
                    className: 'details-control',
                    orderable: false,
                    data: null,
                    defaultContent: ''
                    },
                    { data: "id_jobs" },
                    { data: "nom_job" },
                    { data: "nom_analista_job" },
                    { data: "boton" }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 0},
                    { targets: 1, visible: false},
                    { targets: 4, visible: false}/*,
                    { targets: 6, visible: true},
                    { targets: 2, orderable: false},
                    { targets: 3, orderable: false},
                    { targets: 4, orderable: false},
                    { targets: 5, orderable: false},
                    { targets: 6, orderable: false}*/
                ],
                order: [[1, 'asc']],
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

            $('#tabla_jobs tbody').on('click', 'td.details-control', function () {
                var tr = $(this).closest('tr');
                var row = tabla_jobs.row( tr );

                if ( row.child.isShown() ) {
                    row.child.hide();
                    tr.removeClass('shown');
                }
                else {
                    row.child( format_2(row.data()) ).show();
                    tr.addClass('shown');
                }
            } );

            var tabla_comunicados_gestor = $('#tabla_comunicado_atc_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_comunicados_atc_gestor.php",
                /*scrollY: "600px",*/
                scrollX: "100%",
                scrollCollapse: true,
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                stateSave: true,
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    if( aData[6] == "3" ){
                        $('td', nRow).css('background-color','#D8D8D8');
                        $('td', nRow).css('color','#000000');
                    }else if( aData[6] == "2" ){
                        if( aData[7] == "culminado" ){
                            $('td', nRow).css('background-color','#FE9A2E');
                            $('td', nRow).css('color','#000000');
                        }
                    }else if( aData[6] == "1" ){
                        if( aData[7] == "culminado" ){
                            $('td', nRow).css('background-color','#00FF40');
                            $('td', nRow).css('color','#000000');
                        }
                    }
                },
                order: [[ 1, "asc"]],
                dom: 'Bfirtp',
                buttons: [
                    {
                        text: '<i class="fa fa-plus"></i> Agregar Comunicado',
                        className: 'modal_comunicado_gestor'
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
                    },
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_comunicados_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 1 },
                    { width: "465px", targets: 2 },
                    { width: "114px", targets: 4 },
                    { width: "114px", targets: 5 },
                    { width: "60px", targets: 8 },
                    { width: "107px", targets: 9 },
                    { className: "text-center", targets: 4},
                    { className: "text-center", targets: 5},
                    { className: "text-center", targets: 9},
                    { type: "date", targets: 4},
                    { type: "date", targets: 5}
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false }
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

            var tabla_comunicados = $('#tabla_comunicado_atc').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_comunicados_atc.php",
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
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_comunicados.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 1 },
                    { width: "496px", targets: 2 },
                    { width: "115px", targets: 3 },
                    { width: "115px", targets: 4 },
                    { width: "65px", targets: 5 },
                    { width: "65px", targets: 6 },
                    { className: "text-center", targets: 3},
                    { className: "text-center", targets: 4},
                    { className: "text-center", targets: 5},
                    { className: "text-center", targets: 6}
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: false }
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

            var tabla_seguimiento_casos = $('#tabla_seguimiento_casos').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_seguimiento_casos.php",
                /*scrollY: "600px",
                scrollX: "100%",
                scrollCollapse: true,*/
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                stateSave: true,
                order: [[ 1, "asc"]],
                dom: 'B<"table-select-fix"l>frtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_seguimiento_casos.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { className: "text-center", targets: 7},
                    { targets: 3, orderable: false},
                    { targets: 4, orderable: false},
                    { targets: 5, orderable: false},
                    { targets: 6, orderable: false}
                ],
                columns: [
                    { visible: false },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true }
                ],
                /*columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 1 },
                    { width: "496px", targets: 2 },
                    { width: "115px", targets: 3 },
                    { width: "115px", targets: 4 },
                    { width: "65px", targets: 5 },
                    { width: "65px", targets: 6 },
                    { className: "text-center", targets: 3},
                    { className: "text-center", targets: 4},
                    { className: "text-center", targets: 5},
                    { className: "text-center", targets: 6}
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: false }
                ],*/
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
            
            $('#generado_por_seguimiento_casos').selectpicker('show');
            
            $("select#generado_por_seguimiento_casos").change(function() {
                var choosedFilter = $("#generado_por_seguimiento_casos").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_seguimiento_casos
                        .columns(3)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            
            $('#supervisor_seguimiento_casos').selectpicker('show');
            
            $("select#supervisor_seguimiento_casos").change(function() {
                var choosedFilter = $("#supervisor_seguimiento_casos").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_seguimiento_casos
                        .columns(4)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            $('#grupo_responsable_seguimiento_casos').selectpicker('show');
            
            $("select#grupo_responsable_seguimiento_casos").change(function() {
                var choosedFilter = $("#grupo_responsable_seguimiento_casos").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_seguimiento_casos
                        .columns(5)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            $('#estado_seguimiento_casos').selectpicker('show');
            
            $("select#estado_seguimiento_casos").change(function() {
                var choosedFilter = $("#estado_seguimiento_casos").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_seguimiento_casos
                        .columns(6)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            var tabla_seguimiento_casos_solu = $('#tabla_seguimiento_casos_solu').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_seguimiento_casos_solu.php",
                /*scrollY: "600px",
                scrollX: "100%",
                scrollCollapse: true,*/
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                stateSave: true,
                order: [[ 1, "asc"]],
                dom: 'B<"table-select-fix"l>frtip',
                buttons: [
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> EXCEL',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_seguimiento_casos_solu.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { className: "text-center", targets: 7},
                    { targets: 3, orderable: false},
                    { targets: 4, orderable: false},
                    { targets: 5, orderable: false},
                    { targets: 6, orderable: false}
                ],
                columns: [
                    { visible: false },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true }
                ],
                /*columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "15px", targets: 1 },
                    { width: "496px", targets: 2 },
                    { width: "115px", targets: 3 },
                    { width: "115px", targets: 4 },
                    { width: "65px", targets: 5 },
                    { width: "65px", targets: 6 },
                    { className: "text-center", targets: 3},
                    { className: "text-center", targets: 4},
                    { className: "text-center", targets: 5},
                    { className: "text-center", targets: 6}
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: false }
                ],*/
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
            
            $('#generado_por_seguimiento_casos_solu').selectpicker('show');
            
            $("select#generado_por_seguimiento_casos_solu").change(function() {
                var choosedFilter = $("#generado_por_seguimiento_casos_solu").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_seguimiento_casos_solu
                        .columns(3)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            
            $('#supervisor_seguimiento_casos_solu').selectpicker('show');
            
            $("select#supervisor_seguimiento_casos_solu").change(function() {
                var choosedFilter = $("#supervisor_seguimiento_casos_solu").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_seguimiento_casos_solu
                        .columns(4)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            $('#grupo_responsable_seguimiento_casos_solu').selectpicker('show');
            
            $("select#grupo_responsable_seguimiento_casos_solu").change(function() {
                var choosedFilter = $("#grupo_responsable_seguimiento_casos_solu").val();
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_seguimiento_casos_solu
                        .columns(5)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            $('.click_asig_pen_seg').click(function() {
                $('.btn_seg').removeClass('active');
                $('.btn_asig_pen_seg').addClass('active');
            });
            
            $('.click_solu_seg').click(function() {
                $('.btn_seg').removeClass('active');
                $('.btn_solu_seg').addClass('active');
            });

            /* Modal Insertar Responsable */
            $('.modal_comunicado_gestor').click(function () {
                $("#modal_ins_comunicado").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_comunicado_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_comunicado.php',
                    success:function(data){
                        $('.ins_comunicado_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Responsable */

            $(document).ready(function () {
                $('a[data-toggle="tab"]').on( 'shown.bs.tab', function(e) {
                    $.fn.dataTable.tables({ visible:true, api:true }).columns.adjust();
                });
            });

            $('.clear_input_search').click(function() {
                $('.search_close').val('').keyup();
                setTimeout(function(){
                    $(document.body).css('padding-right','');
                },1000);
            });

        </script>
    </div>
</div>