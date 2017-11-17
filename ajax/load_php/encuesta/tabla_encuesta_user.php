<div class="container content-md">
    <div class="row">
        <div class="tabla_gestion_encuesta">
            <table id="tabla_encuesta_user" cellspacing="0" class="table table-responsive table-hover" cellspacing="0" style="width: 100%">
                <thead>
                    <tr>
                        <th>ID Encuesta</th>
                        <th>ID</th>
                        <th>Titulo Encuesta</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>
        <script>
            var tabla_encuesta_user = $('#tabla_encuesta_user').DataTable( {
                bDeferRender: true,
                ajax: "ajax/pid_list/pid_list_encuesta_user.php",
                /*scrollY: "600px",*/
                scrollX: "100%",
                scrollCollapse: true,
                lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                pagingType: 'full_numbers_no_ellipses',
                paging: true,
                dom: 'Bfirtp',
                order: [[ 0, "asc"]],
                processing: true,
                buttons: [
                    {
                        text: '<i class="fa fa-refresh"></i> Actualizar Tabla',
                        action: function () {
                            tabla_encuesta_user.ajax.reload( null, false );
                        }
                    }
                ],
                responsive: false,
                columnDefs: [
                    { type: "currency", targets: 1 },
                    { width: "20px", targets: 1 },
                    { width: "820px", targets: 2 },
                    { class: "text-center", targets: 3 }
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

        </script>
    </div>
</div>