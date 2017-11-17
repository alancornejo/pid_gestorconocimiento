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
        <div class="tabla_pid_usuarios">
            <div style="float: right; margin-right: 10px;">
                <select id="dbox_usuarios" name="categories" data-width="120px" class="show-tick">
                    <option data-content="<span class='label label-default'>Todo</span>" value="" selected>TODO</option>
                    <option data-content="<span class='label label-danger'>Cesado</span>" value="CESADO">CESADO</option>
                    <option data-content="<span class='label label-success'>Activo</span>" value="ACTIVO">ACTIVO</option>
                </select>
                <br>
            </div>
            <table id="tabla_usuario_gestor" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>C.Claro</th>
                      <th>Nombre Analista</th>
                      <th>Nombre Completo</th>
                      <th>#DNI</th>
                      <th>#Celular</th>
                      <th>#Fijo</th>
                      <th>#Referencia</th>
                      <th>Parentesco#Ref</th>
                      <th>Género</th>
                      <th>Situación Familiar</th>
                      <th>N°Hijos</th>
                      <th>Cod.Empleado</th>
                      <th>Estado Académico</th>
                      <th>Situación Académica</th>
                      <th>Fec.Nacimiento</th>
                      <th>Fec.Ingreso</th>
                      <th>Correo Personal</th>
                      <th>IP</th>
                      <th>Rol</th>
                      <th>Cargo</th>
                      <th>Estado</th>
                      <th>Estado C.</th>
                      <th>Docum.A.</th>
                      <th>T. Inter.</th>
                      <th>C.C.</th>
                      <th>Ul. Acceso</th>
                      <th style="width:155px !important">Acciones</th>
                  </tr>
              </thead>
            </table>
        </div>
        <script>
            
            var tabla_usuarios_gestor = $('#tabla_usuario_gestor').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_usuarios.php",
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
                dom: 'Bfrtip',
                <?php } ?>
                processing: false,
                order: [[ 0, "asc"]],
                stateSave: true,
                fixedHeader: true,
                buttons: [
                    {
                        text: '<i class="fa fa-user"></i> Agregar Usuarios',
                        className: 'agregar_usuario'
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
                        extend: 'colvis',
                        text: '<i class="fa fa-list-alt"></i> Mostrar Columnas',
                        postfixButtons: ['colvisRestore']
                    },
                    {
                        text: '<i class="fa fa-recycle"></i> Re. Contador',
                        action: function () {
                            swal({
                                title: 'Deseas reiniciar las conexiones?',
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
                                    url: "ajax/action_class/reset/reset_conexiones.php",
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
                                                        text: "Se reinicio el contador de documentos con exito",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }, 600);
                                            }else{
                                                swal({
                                                    title: "",
                                                    text: "Error al reiniciar las conexiones, informalo al administrador y/o desarrollador.",
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
                                    text: "No se reinicio los contadores.",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                              }
                            })
                        }
                    },
                    {
                        text: '<i class="fa fa-sign-out"></i> Desc. Usuarios',
                        action: function () {
                            swal({
                                title: 'Deseas desconectar a todos los analistas?',
                                text: "Solo deberan actualizar la pagina para que vuelvan a aparecer !",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#1b9cdd',
                                cancelButtonColor: '#d33',
                                confirmButtonText: '<i class="fa fa-sign-out"></i> Desconectar',
                                showLoaderOnConfirm: false,
                                cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
                            }).then(function() {
                                $.ajax({
                                    type: "POST",
                                    url: "ajax/action_class/reset/reset_estado_pid.php",
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
                                                        text: "Se descontecto a todos los analistas con exito.",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }, 600);
                                            }else{
                                                swal({
                                                    title: "",
                                                    text: "Error al desconectar a los usuarios, informalo al administrador y/o desarrollador",
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
                                swal("PID - CLARO AN", "No se desconecto a ningun analista", "error");
                                swal({
                                    title: "",
                                    text: "No se desconecto a ningun analista",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                              }
                            })
                        }
                    },
                    {
                        text: '<i class="fa fa-recycle"></i> Re. T.Conexion',
                        action: function () {
                            swal({
                                title: 'Deseas reiniciar el tiempo de conexion?',
                                text: "Recuerda que se regresara el tiempo a 0s !",
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
                                    url: "ajax/action_class/reset/reset_tiempo_conexiones.php",
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
                                                        text: "Se reinicio el tiempo de conexion con exito",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }, 600);
                                            }else{
                                                swal({
                                                    title: "",
                                                    text: "Error al reiniciar el tiempo de conexion, informalo al administrador y/o desarrollador",
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
                        text: '<i class="fa fa-recycle"></i> Re. Come. Ca.',
                        action: function () {
                            swal({
                                title: 'Deseas reiniciar los comentarios calificados?',
                                text: "Recuerda que se regresara el los comentarios a 0 !",
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
                                    url: "ajax/action_class/reset/reset_comentarios_calificados.php",
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
                                                        text: "Se reinicio los comentarios calificados con exito",
                                                        type: "success",
                                                        showCancelButton: false,
                                                        showConfirmButton: true
                                                    });
                                                }, 600);
                                            }else{
                                                swal({
                                                    title: "",
                                                    text: "Error al reiniciar los comentarios calificados, informalo al administrador y/o desarrollador",
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
                                    text: "No se reinicio los comentarios calificados",
                                    type: "error",
                                    showCancelButton: false,
                                    showConfirmButton: true
                                });
                              }
                            })
                        }
                    }
                ],
                columnDefs: [
                    { type: "currency", targets: 0 },
                    { width: "50px", targets: 1 },
                    { width: "75px", targets: 22 },
                    { width: "70px", targets: 23 },
                    { width: "158px", targets: 2 },
                    { width: "10px", targets: 25 }
                ],
                columns: [
                    { visible: false },
                    { visible: true },
                    { visible: true },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: false },
                    { visible: true },
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

            $('#dbox_usuarios').selectpicker('show');
            
            $("select#dbox_usuarios").change(function() {
                if($("#dbox_usuarios").val() == "" || $("#dbox_usuarios").val() == null){
                    choosedFilter = "";
                }else{
                    choosedFilter = "^\\s*"+$("#dbox_usuarios").val()+"\\s*$";
                }
                //var choosedString = choosedFilter.join("|");
                tabla_usuarios_gestor
                        .columns(21)
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
                tabla_usuarios_gestor.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_usuario_gestor_processing").show();
                });
            });

            /* Modal Insertar Usuario */
            $('.agregar_usuario').click(function () {
                $("#modal_ins_usuario").modal("show");
                $.ajax({
                    beforeSend: function(){
                        $('.ins_usuario_body').html('<div class="cssload-container"><div class="cssload-lt"></div><div class="cssload-rt"></div><div class="cssload-lb"></div><div class="cssload-rb"></div></div>');
                     },
                    url: 'ajax/view_pid/insert/view_insert_usuario.php',
                    success:function(data){
                        $('.ins_usuario_body').html(data);
                    }
                });
            });
            /* Fin Modal Insertar Usuario */
        </script>
    </div>
</div>