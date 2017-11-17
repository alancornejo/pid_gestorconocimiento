<?php
session_start();
date_default_timezone_set('America/Bogota');
?>
<div class="container content-md">
    <div class="row">
        <div class="tabla_examen">
            <table id="tabla_examen_usuario" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
              <thead>
                  <tr>
                      <th>Examen</th>
                      <th>Titulo</th>
                      <th>Fecha Apertura</th>
                      <th>Fecha Cierre</th>
                      <th>Nota</th>
                      <th>Acciones</th>
                  </tr>
              </thead>
            </table>
            <br>
            <div class="panel panel-primary">
                <div class="panel-heading">
                  <h3 class="panel-title">Advertencias durante el Examen</h3>
                </div>
                <div class="panel-body">
                    <label>1. Todas las preguntas son asignadas aleatoriamente a cada examen.</label><br>
                    <label>2. En caso se cierre la ventana del examen antes de finalizar, las preguntas asignadas al examen cambiarán automáticamente.</label><br>
                    <label>3. El módulo de KDB así como los documentos de conocimiento (APL) asociados al examen en curso se encontrarán bloqueados durante el tiempo del examen.</label><br>
                    <label>4. La nota mínima aprobatoria es de 14.</label>
                </div>
            </div>
        </div>
        <script>
            var tabla_examen_usuario = $('#tabla_examen_usuario').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_examen.php",
                /*scrollY: "600px",*/
                scrollX: "100%",
                scrollCollapse: true,
                paging: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                processing: true,
                responsive: false,
                order: [[ 0, "dsc"]],
                dom: 'Bfirtp',
                buttons: [
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_examen_usuario.ajax.reload( null, false );
                        }
                    }
                ],
                columnDefs: [
                    { type: 'date-uk', targets: 2 },
                    { type: 'date-uk', targets: 3 }
                ],
                columns: [
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



        </script>
    </div>
</div>

