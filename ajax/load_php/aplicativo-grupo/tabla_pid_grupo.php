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
        <div class="tabla_pid_grupo_asignado">
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
        <script>
            var tabla_grupo_asignado = $('#tabla_grupo_asignado').DataTable( {
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
                        text: '<i class="fa fa-user"></i> Agregar Grupo Asignado',
                        className: 'agregar_grupo_asignado'
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

            $('.clear_input_search').click(function() {
                $('.search_close').val('').keyup();
                setTimeout(function(){
                    $(document.body).css('padding-right','');
                },1000);
            });

            $(document).ready(function () {
                tabla_grupo_asignado.ajax.reload( null, false );
                setTimeout(function(){
                    $("#tabla_grupo_asignado_processing").show();
                });
            });

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

        </script>
    </div>
</div>