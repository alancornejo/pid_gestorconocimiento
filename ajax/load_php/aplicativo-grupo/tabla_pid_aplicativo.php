<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once ('../../../data/pid_access.php');
$id_user = $_SESSION['id_user_apl'];
$object = new pid_auth();
$result = $object->user_auth($id_user);
$row_access = $result->fetch_assoc();
?>
<div class="container content">
    <div class="row margin-bottom-40">
        <div class="tabla_pid_aplicativos">
            <div style="float: left; margin-right: 1px;">
                <div class="btn-group" role="group">
                    <a class="dt-button btn_aplicaciones click_aplicaciones btn_servicio active" href="#tabla_apl" data-toggle="tab" aria-expanded="true"><div class="aplicaciones"><span class="fa fa-database"></span> Aplicaciones</div></a>
                    <a class="dt-button btn_biometrico click_biometrico btn_servicio" href="#tabla_bio" data-toggle="tab" aria-expanded="true"><div class="biometrico"><span class="fa fa-bitbucket"></span> Biométrico</div></a>
                    <a class="dt-button btn_biometrico click_biometrico btn_servicio" href="#tabla_bio" data-toggle="tab" aria-expanded="true"><div class="biometrico"><span class="fa fa-bitbucket"></span> Biométrico</div></a>
                </div>
            </div>
            <table id="tabla_aplicativos" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
              <thead>
                  <tr>
                      <th>ID</th>
                      <th>ID</th>
                      <th>Nombre de Aplicativo</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
            </table>
        </div>
        <script>
            var tabla_aplicativos = $('#tabla_aplicativos').DataTable( {
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
                        text: '<i class="fa fa-user"></i> Agregar Aplicativo',
                        className: 'agregar_aplicativo'
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
                tabla_aplicativos.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_aplicativos_processing").show();
                });
            });

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

        </script>
    </div>
</div>

