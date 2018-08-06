<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_access.php');
require_once ('../../../data/pid_view.php');
$id_user = $_SESSION['id_user_apl'];
$object = new pid_auth();
$object_permisos = new pid_permisos();
$object_list = new pid_view();
$result = $object->user_auth($id_user);
$result_permisos = $object_permisos->user_permisos($id_user);
$result_list = $object_list->view_category();
$row_access = $result->fetch_assoc();
$row_permisos = $result_permisos->fetch_assoc();
?>
<div class="container content-md">
    <div class="row">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="tabla_apl">
                <br>
                <div class="tabla_kdb_pid">
                    <?php if($row_permisos['gest_cono'] == "true"){ ?>
                    <div style="float: left; margin-right: 1px;">
                        <div class="btn-group" role="group">
                            <a class="dt-button btn_aplicaciones click_aplicaciones btn_servicio active" style="background-color: #19b698" href="#tabla_apl" data-toggle="tab" aria-expanded="true"><div class="aplicaciones"><span class="fa fa-database"></span> Aplicaciones</div></a>
                            <a class="dt-button btn_biometrico click_biometrico btn_servicio" style="background-color: #E51C23" href="#tabla_bio" data-toggle="tab" aria-expanded="true"><div class="biometrico"><span class="fa fa-bitbucket"></span> Biométrico</div></a>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($row_permisos['gest_cono'] == "true"){ ?>
                    <div style="float: right; margin-right: 10px;">
                        <select id="dbox_kdb_estado" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-width="160px" data-header="Estado de Documento">
                            <option data-content="<span class='label label-info'>Todos los estados</span>" value="" selected>TODO</option>
                            <option data-content="<span class='label label-success'>Publicado</span>" value="P">Publicado</option>
                            <option data-content="<span class='label label-danger'>No Publicado</span>" value="NP">No Publicado</option>
                        </select>
                        <br>
                    </div>
                    <?php } ?>
                    <?php if($row_permisos['gest_cono'] == "false" && $row_access['tipo_user'] == '0' || $row_permisos['gest_cono'] == "false" && $row_access['tipo_user'] == '1'){ ?>
                    <div style="float: right; margin-right: 10px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="daterange_act" placeholder="Filtrar por Fecha Actualización" style="width: 205px;">
                    </div>
                    <div style="float: right; margin-right: 10px;">
                        &nbsp;&nbsp;&nbsp;&nbsp;<input type="text" class="daterange" placeholder="Filtrar por Fecha Creación" style="width: 205px;">
                    </div>
                    <?php } ?>
                    <table <?php if($row_permisos['gest_cono'] == "true"){ echo 'id="tabla_kdb_gestor"'; }elseif($row_access['funcion_user'] == "6" || $row_access['funcion_user'] == "7"){ echo 'id="tabla_kdb_cliente"'; }elseif($row_access['tipo_user'] == '1'){ echo 'id="tabla_kdb_biometrico"'; }else{ echo 'id="tabla_kdb_usuario"'; } ?> class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                      <thead>
                          <tr>
                              <th>ID Tabla</th>
                              <th>ID</th>
                              <th>Titulo</th>
                              <th>Contenido</th>
                              <th><?php if($row_permisos['gest_cono'] == "false" && $row_access['tipo_user'] == '0' || $row_permisos['gest_cono'] == "false" && $row_access['tipo_user'] == '1'){ ?>
                                    <select id="<?php if($row_access['funcion_user'] == "6" || $row_access['funcion_user'] == "7"){ echo "sl_tabla_kdb_cliente"; }else{ echo "sl_tabla_kdb_usuario"; } ?>" class="selectpicker show-tick show-menu-arrow" data-live-search="true" data-width="fit" data-header="Aplicativo">
                                        <option value="" selected>Mostrar Todo</option>
                                        <?php while($row_list = $result_list->fetch_assoc()){ ?>
                                            <option value="<?= $row_list['nom_apli'] ?>"><?= $row_list['nom_apli'] ?></option>
                                        <?php } ?>
                                    </select>
                                  <?php }else{ ?>
                                    Aplicativo
                                  <?php } ?>
                              </th>
                              <th>Es.</th>
                              <th>V.Clt</th>
                              <th>E.P.</th>
                              <th>F.Crea.</th>
                              <th>F.Actu.</th>
                              <th>Contador</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <!-- <tfoot>
                          <tr>
                              <th>ID Tabla</th>
                              <th>ID</th>
                              <th>Titulo</th>
                              <th>Contenido</th>
                              <th>Aplicativo</th>
                              <th>Estado</th>
                              <th>V.Clt</th>
                              <th>Fec.Crea.</th>
                              <th>Fec.Actu.</th>
                              <th>Contador</th>
                              <th>Acciones</th>
                          </tr>
                      </tfoot> -->
                    </table>
                </div>
            </div>
            <div class="tab-pane fade" id="tabla_bio">
                <br>
                <div class="tabla_kdb_pid">
                    <?php if($row_permisos['gest_cono'] == "true"){ ?>
                    <div style="float: left; margin-right: 1px;">
                        <div class="btn-group" role="group">
                            <a class="dt-button btn_aplicaciones click_aplicaciones btn_servicio active" style="background-color: #19b698" href="#tabla_apl" data-toggle="tab" aria-expanded="true"><div class="aplicaciones"><span class="fa fa-database"></span> Aplicaciones</div></a>
                            <a class="dt-button btn_biometrico click_biometrico btn_servicio" style="background-color: #E51C23" href="#tabla_bio" data-toggle="tab" aria-expanded="true"><div class="biometrico"><span class="fa fa-bitbucket"></span> Biométrico</div></a>
                        </div>
                    </div>
                    <?php } ?>
                    <?php if($row_permisos['gest_cono'] == "true"){ ?>
                    <div style="float: right; margin-right: 10px;">
                        <select id="dbox_kdb_estado_bio" name="categories" class="show-tick show-menu-arrow" data-live-search="true" data-width="160px" data-header="Estado de Documento">
                            <option data-content="<span class='label label-info'>Todos los estados</span>" value="" selected>TODO</option>
                            <option data-content="<span class='label label-success'>Publicado</span>" value="P">Publicado</option>
                            <option data-content="<span class='label label-danger'>No Publicado</span>" value="NP">No Publicado</option>
                        </select>
                        <br>
                    </div>
                    <?php } ?>
                    <table <?php if($row_permisos['gest_cono'] == "true"){ echo 'id="tabla_kdb_bio_gestor"'; } ?> class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                      <thead>
                          <tr>
                              <th>ID Tabla</th>
                              <th>ID</th>
                              <th>Titulo</th>
                              <th>Contenido</th>
                              <th>Aplicativo</th>
                              <th>Estado</th>
                              <th>V.Clt</th>
                              <th>Fec.Crea.</th>
                              <th>Fec.Actu.</th>
                              <th>Contador</th>
                              <th>Acciones</th>
                          </tr>
                      </thead>
                      <!-- <tfoot>
                          <tr>
                              <th>ID Tabla</th>
                              <th>ID</th>
                              <th>Titulo</th>
                              <th>Contenido</th>
                              <th>Aplicativo</th>
                              <th>Estado</th>
                              <th>V.Clt</th>
                              <th>Fec.Crea.</th>
                              <th>Fec.Actu.</th>
                              <th>Contador</th>
                              <th>Acciones</th>
                          </tr>
                      </tfoot> -->
                    </table>
                </div>
            </div>
        </div>
        <script>
            
            $('.click_aplicaciones').click(function() {
                $('.btn_servicio').removeClass('active');
                $('.btn_aplicaciones').addClass('active');
            });
            
            $('.click_biometrico').click(function() {
                $('.btn_servicio').removeClass('active');
                $('.btn_biometrico').addClass('active');
            });
            
            $('.selectpicker').selectpicker();
            
            /*$('#tabla_kdb_gestor tfoot th').each( function () {
                var title = $(this).text();
                $(this).html( '<input type="text" placeholder="Search '+title+'" />' );
            } );*/

            var tabla_kdb_gestor = $('#tabla_kdb_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_gestor.php",
                scrollX: "100%",
                scrollCollapse: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                paging: true,
                dom: 'B<"table-select-fix"l>frtip',
                processing: true,
                responsive: false,
                stateSave: true,
                fixedHeader: true,
                order: [[ 1, "asc"]],
                buttons: [
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
                    /*{
                        extend: 'csv',
                        text: '<i class="fa fa-file-archive-o"></i> CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },*/
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
                    },
                    {
                        text: '<i class="fa fa-recycle"></i> Reiniciar Contador',
                        action: function () {
                            swal({
                                title: 'Deseas reiniciar los contadores?',
                                text: "Recuerda que los contadores se pondran en 0 !",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#1b9cdd',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<i class="fa fa-refresh"></i> Resetear',
                                showLoaderOnConfirm: false,
                                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                            }).then(function() {
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/action_class/reset/reset_contadores.php",
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
                                                        text: "Se reinicio los contadores con exito",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }, 600);
                                                tabla_kdb_gestor.ajax.reload( null, false );
                                            }else{
                                                swal({
                                                    title: "",
                                                    text: "Error al reiniciar los contadores, informalo al administrador y/o desarrollador",
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
                                    text: "No se reinicio los contadores",
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
                            tabla_kdb_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { className: "text-center", "targets": 5},
                    { type: 'date-uk', targets: 7 },
                    { type: 'date-uk', targets: 8 },
                    { width: '420px', targets: 2 },
                    { width: '90px', targets: 10 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: true },
                    { visible: false },
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
            
            var tabla_kdb_bio_gestor = $('#tabla_kdb_bio_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_gestor_bio.php",
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
                processing: true,
                responsive: false,
                stateSave: true,
                fixedHeader: true,
                order: [[ 1, "asc"]],
                buttons: [
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
                    /*{
                        extend: 'csv',
                        text: '<i class="fa fa-file-archive-o"></i> CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },*/
                    {
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
                    },
                    {
                        text: '<i class="fa fa-recycle"></i> Reiniciar Contador',
                        action: function () {
                            swal({
                                title: 'Deseas reiniciar los contadores?',
                                text: "Recuerda que los contadores se pondran en 0 !",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#1b9cdd',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<i class="fa fa-refresh"></i> Resetear',
                                showLoaderOnConfirm: false,
                                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                            }).then(function() {
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/action_class/reset/reset_contadores.php",
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
                                                        text: "Se reinicio los contadores con exito",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }, 600);
                                                tabla_kdb_gestor.ajax.reload( null, false );
                                            }else{
                                                swal({
                                                    title: "",
                                                    text: "Error al reiniciar los contadores, informalo al administrador y/o desarrollador",
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
                                    text: "No se reinicio los contadores",
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
                            tabla_kdb_bio_gestor.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { className: "text-center", "targets": 5},
                    { type: 'date-uk', targets: 7 },
                    { type: 'date-uk', targets: 8 },
                    { width: '420px', targets: 2 },
                    { width: '90px', targets: 10 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    <?php if($_SESSION['claro_user'] == "E78540"){ ?>
                        { visible: false },
                    <?php }else{ ?>
                         { visible: true },
                    <?php } ?>
                    { visible: false },
                    { visible: true },
                    <?php if($_SESSION['claro_user'] == "E78540"){ ?>
                        { visible: true },
                    <?php }else{ ?>
                         { visible: false },
                    <?php } ?>
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
            
            $('#dbox_kdb_estado').selectpicker('show');

            $("select#dbox_kdb_estado").change(function() {
                if($("#dbox_kdb_estado").val() == "" || $("#dbox_kdb_estado").val() == null){
                    choosedFilter = "";
                }else{
                    choosedFilter = "^\\s*"+$("#dbox_kdb_estado").val()+"\\s*$";
                }
                //var choosedString = choosedFilter.join("|");
                tabla_kdb_gestor
                        .columns(5)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            $('#dbox_kdb_estado_bio').selectpicker('show');

            $("select#dbox_kdb_estado_bio").change(function() {
                if($("#dbox_kdb_estado_bio").val() == "" || $("#dbox_kdb_estado_bio").val() == null){
                    choosedFilter = "";
                }else{
                    choosedFilter = "^\\s*"+$("#dbox_kdb_estado_bio").val()+"\\s*$";
                }
                //var choosedString = choosedFilter.join("|");
                tabla_kdb_bio_gestor
                        .columns(5)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            /*// Apply the search
            tabla_kdb_gestor.columns().every( function () {
                var that = this;

                $( 'input', this.footer() ).on( 'keyup change', function () {
                    if ( that.search() !== this.value ) {
                        that
                            .search( this.value )
                            .draw();
                    }
                } );
            } );*/

            var tabla_kdb_cliente = $('#tabla_kdb_cliente').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_cliente.php",
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
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> Ex. en Excel',
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                selected: true
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fa fa-file-excel-o"></i> Ex. todo en Excel',
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
                            tabla_kdb_cliente.ajax.reload( null, false );
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

            var tabla_kdb_usuario = $('#tabla_kdb_usuario').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_kdb_list.php",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                responsive: false,
                processing: true,
                select: {
                    style: 'single'
                },
                pagingType: 'full_numbers_no_ellipses',
                order: [[ 1, "asc"]],
                dom: 'B<"table-select-fix"l>frtip',
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td', nRow).addClass('td-cursor');
                },
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { type: 'date-uk', targets: 7 },
                    { type: 'date-uk', targets: 8 },
                    { width: "750px", targets: 2 },
                    { width: "120px", targets: 4 },
                    { orderable: false, targets: 4 },
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
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
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
            
            
            $("select#sl_tabla_kdb_usuario").change(function() {
                if($("#sl_tabla_kdb_usuario").val() == "" || $("#sl_tabla_kdb_usuario").val() == null){
                    choosedFilter = "";
                }else{
                    choosedFilter = "^\\s*"+$("#sl_tabla_kdb_usuario").val()+"\\s*$";
                }
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_kdb_usuario
                        .columns(4)
                        .search(choosedFilter,2,true,false)
                        .draw();
            });
            
            $("select#sl_tabla_kdb_cliente").change(function() {
                if($("#sl_tabla_kdb_cliente").val() == "" || $("#sl_tabla_kdb_cliente").val() == null){
                    choosedFilter = "";
                }else{
                    choosedFilter = "^\\s*"+$("#sl_tabla_kdb_cliente").val()+"\\s*$";
                }
                /*var choosedString3 = choosedFilter3.join("|");*/
                tabla_kdb_cliente
                        .columns(4)
                        .search(choosedFilter,2,true,false)
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
                    format: 'DD/MM/YYYY'
                }
            });

            $(document).ready(function (){
                var startDate;
                var endDate;
                var DateFilterFunction = (function (settings, data, iDataIndex) {
                    var filterstart = startDate;
                    var filterend = endDate; 
                    var iStartDateCol = 7;
                    var iEndDateCol = 7;

                    var tabledatestart = data[iStartDateCol] !== "" ? moment(data[iStartDateCol], "DD/MM/YYYY") : data[iStartDateCol];
                    var tabledateend = data[iEndDateCol] !== "" ? moment(data[iEndDateCol], "DD/MM/YYYY") : data[iEndDateCol];

                    if (filterstart === "" && filterend === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD/MM/YYYY").isSame(tabledatestart) || moment(filterstart, "DD/MM/YYYY").isBefore(tabledatestart)) && filterend === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD/MM/YYYY").isSame(tabledatestart) || moment(filterstart, "DD/MM/YYYY").isAfter(tabledatestart)) && filterstart === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD/MM/YYYY").isSame(tabledatestart) || moment(filterstart, "DD/MM/YYYY").isBefore(tabledatestart)) && (moment(filterend, "DD/MM/YYYY").isSame(tabledateend) || moment(filterend, "DD/MM/YYYY").isAfter(tabledateend))) {
                        return true;
                    }
                    return false;
                });

               $(".daterange", this).on('apply.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val(picker.startDate.format('DD/MM/YYYY') + ' hasta ' + picker.endDate.format('DD/MM/YYYY'));
                   startDate = picker.startDate.format('DD/MM/YYYY');
                   endDate = picker.endDate.format('DD/MM/YYYY');
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_kdb_usuario.draw();
                   tabla_kdb_cliente.draw();
               });

               $(".daterange", this).on('cancel.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val('');
                   startDate = '';
                   endDate = '';
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_kdb_usuario.draw();
                   tabla_kdb_cliente.draw();
               });
            });
            
            $('.daterange_act').daterangepicker({
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
                    format: 'DD/MM/YYYY'
                }
            });

            $(document).ready(function (){
                var startDate;
                var endDate;
                var DateFilterFunction = (function (settings, data, iDataIndex) {
                    var filterstart = startDate;
                    var filterend = endDate; 
                    var iStartDateCol = 8;
                    var iEndDateCol = 8;

                    var tabledatestart = data[iStartDateCol] !== "" ? moment(data[iStartDateCol], "DD/MM/YYYY") : data[iStartDateCol];
                    var tabledateend = data[iEndDateCol] !== "" ? moment(data[iEndDateCol], "DD/MM/YYYY") : data[iEndDateCol];

                    if (filterstart === "" && filterend === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD/MM/YYYY").isSame(tabledatestart) || moment(filterstart, "DD/MM/YYYY").isBefore(tabledatestart)) && filterend === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD/MM/YYYY").isSame(tabledatestart) || moment(filterstart, "DD/MM/YYYY").isAfter(tabledatestart)) && filterstart === "") {
                        return true;
                    }
                    else if ((moment(filterstart, "DD/MM/YYYY").isSame(tabledatestart) || moment(filterstart, "DD/MM/YYYY").isBefore(tabledatestart)) && (moment(filterend, "DD/MM/YYYY").isSame(tabledateend) || moment(filterend, "DD/MM/YYYY").isAfter(tabledateend))) {
                        return true;
                    }
                    return false;
                });

               $(".daterange_act", this).on('apply.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val(picker.startDate.format('DD/MM/YYYY') + ' hasta ' + picker.endDate.format('DD/MM/YYYY'));
                   startDate = picker.startDate.format('DD/MM/YYYY');
                   endDate = picker.endDate.format('DD/MM/YYYY');
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_kdb_usuario.draw();
                   tabla_kdb_cliente.draw();
               });

               $(".daterange_act", this).on('cancel.daterangepicker', function (ev, picker) {
                   ev.preventDefault();
                   $(this).val('');
                   startDate = '';
                   endDate = '';
                   $.fn.dataTableExt.afnFiltering.push(DateFilterFunction);
                   tabla_kdb_usuario.draw();
                   tabla_kdb_cliente.draw();
               });
            });
            
            var tabla_kdb_biometrico = $('#tabla_kdb_biometrico').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_kdb_biometrico_list.php",
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                responsive: false,
                processing: true,
                select: {
                    style: 'single'
                },
                pagingType: 'full_numbers_no_ellipses',
                order: [[ 1, "asc"]],
                dom: 'B<"table-select-fix"l>frtip',
                fnRowCallback: function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                    $('td', nRow).addClass('td-cursor');
                },
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
                            tabla_kdb_biometrico.ajax.reload( null, false );
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
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
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
            
            /* Modal Ver Datatable */
            $('#tabla_kdb_biometrico tbody').on('click', 'tr', function () {
                var id_documento = tabla_kdb_biometrico.row(this).data();
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
                tabla_kdb_gestor.ajax.reload( null, false );
                tabla_kdb_bio_gestor.ajax.reload( null, false );
                tabla_kdb_cliente.ajax.reload( null, false );
                tabla_kdb_usuario.ajax.reload( null, false ); 
                setTimeout(function(){
                    $("#tabla_kdb_gestor_processing").show();
                    $("#tabla_kdb_bio_gestor_processing").show();
                    $("#tabla_kdb_cliente_processing").show();
                    $("#tabla_kdb_usuario_processing").show();
                });
            });

        </script>
    </div>
</div>