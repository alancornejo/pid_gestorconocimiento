<?php
    require_once ('../../../../data/pid_data.php');
    $fecha_inicio = $_POST['fec_inicio']." 00:00:00";
    $fecha_final = $_POST['fec_final']." 24:00:00";
    
    $object = new seguimiento_casos();
    
    /* Gráfico Asignado/Pendiente */
    $fecha_asig = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    $cantidad_asig = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    $promedio_asig = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    $caso_asig = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    /* Gráfico Asignado/Pendiente */
    
    /* Gráfico Solucionado */
    $fecha_solu = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    $cantidad_solu = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    $promedio_solu = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    $caso_solu = $object->grafico_asigpen_solu_gestionable($fecha_inicio, $fecha_final);
    /* Grafico Solucionado */
    
    /* MiniTabla Asignado/Pendiente */
    $result_minitabla = $object->mini_tabla_gestionable_asigpen($fecha_inicio, $fecha_final);
    $row_minitabla = $result_minitabla->fetch_assoc();
    /* MiniTabla Asignado/Pendiente */
    
    /* MiniTabla Solucionado */
    $result_minitabla_solu = $object->mini_tabla_gestionable_solu($fecha_inicio, $fecha_final);
    $row_minitabla_solu = $result_minitabla_solu->fetch_assoc();
    /* MiniTabla Solucionado */
    
    /* Tabla Asignado/Pendiente */
    $tabla_fec_asigpen = $object->tabla_gestionable_asigpen($fecha_inicio, $fecha_final);
    $tabla_cantidad_asigpen = $object->tabla_gestionable_asigpen($fecha_inicio, $fecha_final);
    $tabla_promedio_asigpen = $object->tabla_gestionable_asigpen($fecha_inicio, $fecha_final);
    $tabla_caso_antiguo_asigpen = $object->tabla_gestionable_asigpen($fecha_inicio, $fecha_final);
    /* Tabla Asignado/Pendiente */
    
    /* Tabla Solucionado */
    $tabla_fec_solu = $object->tabla_gestionable_solu($fecha_inicio, $fecha_final);
    $tabla_cantidad_solu = $object->tabla_gestionable_solu($fecha_inicio, $fecha_final);
    $tabla_promedio_solu = $object->tabla_gestionable_solu($fecha_inicio, $fecha_final);
    $tabla_caso_antiguo_solu = $object->tabla_gestionable_solu($fecha_inicio, $fecha_final);
    /* Tabla Solucionado */
    
    if(strtotime($_POST['fec_inicio']) > strtotime($_POST['fec_final'])){
?>
    <div class="col-md-12 col-sm-12">
        <div class="alert alert-danger" role="warning">
            <span class="fa fa-warning" aria-hidden="true"></span>
            <span class="sr-only">Fechas Incorrectas</span>
            La fecha de inicio debe ser menor a la fecha final.
        </div>
    </div>
<?php
    }else{
    if(mysqli_num_rows($fecha_asig) == "0"){
?>
    <div class="col-md-12 col-sm-12">
        <div class="alert alert-warning" role="warning">
            <span class="fa fa-warning" aria-hidden="true"></span>
            <span class="sr-only">Sin Datos</span>
            Aun no hay datos ingresados con las fechas escogidas.
        </div>
    </div>
<?php
    }else{
   
?>
    <div class="row center-block">
        <div class="panel panel-default bootcards-chart">
            <div class="panel-heading">
                <h3 class="panel-title titulo_casos_asig">Grafico de Asignados y Pendientes</h3>
            </div>
            <div class="cuerpo_grafico_asig">
                <div class="bootcards-chart-canvas" id="grafico_casos_asig_gest" style="height: 400px; font-family: Roboto;"></div>
            </div>
            <div class="cuerpo_tabla_asig" hidden>
            <center>
                <br>
                <div class="table-overflow-x">
                    <table class="table table-bordered" style="width:40% !important">
                        <tbody>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Asignados</strong></span></td>
                                <td style="text-align: center;"><?= date("d/m/Y H:i",  strtotime($row_minitabla['fec_AsigPen_mini'])) ?></td>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Cantidad</strong></span></td>
                                <td style="text-align: center;"><?= $row_minitabla['cantidad_AsigPen_mini'] ?></td>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Promedio Antiguedad (días)</strong></span></td>
                                <td style="text-align: center;"><?= $row_minitabla['promedio_AsigPen_mini'] ?></td>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Caso más Antiguo (días)</strong></span></td>
                                <td style="text-align: center;"><?= $row_minitabla['caso_antiguo_AsigPen_mini'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-overflow-x" style="width: 95% !important">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Casos Pendientes/Asignados mayor a 24 horas</strong></span></td>
                                <?php while($row_fec_caso_asigpe = $tabla_fec_asigpen->fetch_assoc()) { ?>
                                <td style="text-align: center;background-color: #F9F9F9;"><b><?= date("d/m - H:i", strtotime($row_fec_caso_asigpe['fec_asignados'])) ?></b></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Cantidad</strong></span></td>
                                <?php while($row_cantidad_asigpe = $tabla_cantidad_asigpen->fetch_assoc()) { ?>
                                <td style="text-align: center;"><?= $row_cantidad_asigpe['num_cantidad'] ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Promedio Antigüedad (días)</strong></span></td>
                                <?php while($row_promedio_asigpe = $tabla_promedio_asigpen->fetch_assoc()) { ?>
                                <td style="text-align: center;"><?= $row_promedio_asigpe['prom_antiguedad'] ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Caso más Antiguo (días)</strong></span></td>
                                <?php while($row_caso_antiguo_asigpe = $tabla_caso_antiguo_asigpen->fetch_assoc()) { ?>
                                <td style="text-align: center;"><?= $row_caso_antiguo_asigpe['caso_mas_antiguo'] ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </center>
            </div>
            <div class="panel-footer">
              <center>
                <button class="ver_tabla_asig btn btn-default"><i class="fa fa-table"></i> Ver Tabla </button>
                <button class="ver_grafico_asig btn btn-default" style="display: none;"><i class="fa fa-bar-chart"></i> Ver Gráfico </button>
              </center>
            </div>
        </div>
        <div class="panel panel-default bootcards-chart">
            <div class="panel-heading">
                <h3 class="panel-title titulo_casos_solu">Grafico de Solucionados</h3>
            </div>
            <div class="cuerpo_grafico_solu">
                <div class="bootcards-chart-canvas" id="grafico_casos_solu_gest" style="height: 400px; font-family: Roboto;"></div>
            </div>
            <div class="cuerpo_tabla_solu" hidden>
            <center>
                <br>
                <div class="table-overflow-x">
                    <table class="table table-bordered" style="width:40% !important">
                        <tbody>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Asignados</strong></span></td>
                                <td style="text-align: center;"><?= date("d/m/Y H:i",  strtotime($row_minitabla_solu['fec_Solu_mini'])) ?></td>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Cantidad</strong></span></td>
                                <td style="text-align: center;"><?= $row_minitabla_solu['cantidad_Solu_mini'] ?></td>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Promedio Antiguedad (días)</strong></span></td>
                                <td style="text-align: center;"><?= $row_minitabla_solu['promedio_Solu_mini'] ?></td>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Caso más Antiguo (días)</strong></span></td>
                                <td style="text-align: center;"><?= $row_minitabla_solu['caso_antiguo_Solu_mini'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="table-overflow-x" style="width: 95% !important">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Casos Pendientes/Asignados mayor a 24 horas</strong></span></td>
                                <?php while($row_fec_caso_solu = $tabla_fec_solu->fetch_assoc()) { ?>
                                <td style="text-align: center;background-color: #F9F9F9;"><b><?= date("d/m - H:i", strtotime($row_fec_caso_solu['fec_asignados'])) ?></b></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Cantidad</strong></span></td>
                                <?php while($row_cantidad_solu = $tabla_cantidad_solu->fetch_assoc()) { ?>
                                <td style="text-align: center;"><?= $row_cantidad_solu['num_cantidad'] ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Promedio Antigüedad (días)</strong></span></td>
                                <?php while($row_promedio_solu = $tabla_promedio_solu->fetch_assoc()) { ?>
                                <td style="text-align: center;"><?= $row_promedio_solu['prom_antiguedad'] ?></td>
                                <?php } ?>
                            </tr>
                            <tr>
                                <td style="background-color: #F9F9F9;"><span><strong>Caso más Antiguo (días)</strong></span></td>
                                <?php while($row_caso_antiguo_solu = $tabla_caso_antiguo_solu->fetch_assoc()) { ?>
                                <td style="text-align: center;"><?= $row_caso_antiguo_solu['caso_mas_antiguo'] ?></td>
                                <?php } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </center>
            </div>
            <div class="panel-footer">
              <center>
                <button class="ver_tabla_solu btn btn-default"><i class="fa fa-table"></i> Ver Tabla </button>
                <button class="ver_grafico_solu btn btn-default" style="display: none;"><i class="fa fa-bar-chart"></i> Ver Gráfico </button>
              </center>
            </div>
        </div>
    </div>

    <script>
    
    $('.ver_tabla_asig').click(function (){
        $('.cuerpo_grafico_asig,.ver_tabla_asig').fadeOut(100,function (){
            $('.titulo_casos_asig').html("Tabla de Asignados y Pendientes");
            $('.cuerpo_tabla_asig,.ver_grafico_asig').fadeIn();
        });
    });
    
    $('.ver_grafico_asig').click(function (){
        $('.cuerpo_tabla_asig,.ver_grafico_asig').fadeOut(100,function (){
            $('.titulo_casos_asig').html("Grafico de Asignados y Pendientes");
            $('.cuerpo_grafico_asig,.ver_tabla_asig').fadeIn();
        });
    });
    
    $('.ver_tabla_solu').click(function (){
        $('.cuerpo_grafico_solu,.ver_tabla_solu').fadeOut(100,function (){
            $('.titulo_casos_solu').html("Tabla de Solucionados");
            $('.cuerpo_tabla_solu,.ver_grafico_solu').fadeIn();
        });
    });
    
    $('.ver_grafico_solu').click(function (){
        $('.cuerpo_tabla_solu,.ver_grafico_solu').fadeOut(100,function (){
            $('.titulo_casos_solu').html("Graficos de Solucionados");
            $('.cuerpo_grafico_solu,.ver_tabla_solu').fadeIn();
        });
    });
        
    var draw_3 = function () {
        $('#grafico_casos_asig_gest').highcharts({
            chart: {
                type: 'line',
                style: {
                    "fontFamily": "Roboto"
                }
            },
            title: {
                text: '<b>Casos asignados/pendientes</b>',
                style: {
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            subtitle: {
                text: '',
                style: {
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            xAxis: {
                labels: {
                    rotation: -45,
                    style: {
                        "fontSize": '11px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                },
                categories: [
                    <?php 
                    while ($row = $fecha_asig->fetch_assoc())
                    {
                    ?>
                        '<?= date("d/m - H:i",  strtotime($row['Fecha_AsigPen'])) ?>',
                    <?php
                    }
                    ?>
                ]
            },
            yAxis: {
                title: {
                    text: '',
                    style: {
                        "fontSize": '11px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Cantidad',
                color : '#FF0004',
                data: [
                    <?php 
                    while ($row = $cantidad_asig->fetch_assoc())
                    {
                    ?>
                        <?= $row['Cantidad_AsigPen'] ?>,
                    <?php
                    }
                    ?>
                ]
            }, {
                name: 'Promedio antiguedad (dias)',
                color : '#FF4F49',
                data: [
                    <?php 
                    while ($row = $promedio_asig->fetch_assoc())
                    {
                    ?>
                        <?= $row['Promedio_AsigPen'] ?>,
                    <?php
                    }
                    ?>
                ]
            }, {
                name: 'Caso mas Antiguo (dias)',
                color : '#FFA0A8',
                data: [
                    <?php 
                    while ($row = $caso_asig->fetch_assoc())
                    {
                    ?>
                        <?= $row['Caso_AsigPen'] ?>,
                    <?php
                    }
                    ?>
                ]
            }],
        });
    };
    
    var draw_4 = function () {
        $('#grafico_casos_solu_gest').highcharts({
            chart: {
                type: 'line',
                style: {
                    "fontFamily": "Roboto"
                }
            },
            title: {
                text: '<b>Casos solucionados</b>',
                style: {
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            subtitle: {
                text: '',
                style: {
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            xAxis: {
                labels: {
                    rotation: -45,
                    style: {
                        "fontSize": '11px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                },
                categories: [
                    <?php 
                    while ($row_solu = $fecha_solu->fetch_assoc())
                    {
                    ?>
                        '<?= date("d/m - H:i",  strtotime($row_solu['Fecha_Solu'])) ?>',
                    <?php
                    }
                    ?>
                ]
            },
            yAxis: {
                title: {
                    text: '',
                    style: {
                        "fontSize": '11px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Cantidad',
                color : '#004CFF',
                data: [
                    <?php 
                    while ($row_solu = $cantidad_solu->fetch_assoc())
                    {
                    ?>
                        <?= $row_solu['Cantidad_Solu'] ?>,
                    <?php
                    }
                    ?>
                ]
            }, {
                name: 'Promedio antiguedad (dias)',
                color : '#A3D1FF',
                data: [
                    <?php 
                    while ($row_solu = $promedio_solu->fetch_assoc())
                    {
                    ?>
                        <?= $row_solu['Promedio_Solu'] ?>,
                    <?php
                    }
                    ?>
                ]
            }, {
                name: 'Caso mas Antiguo (dias)',
                color : '#4297FF',
                data: [
                    <?php 
                    while ($row_solu = $caso_solu->fetch_assoc())
                    {
                    ?>
                        <?= $row_solu['Caso_Solu'] ?>,
                    <?php
                    }
                    ?>
                ]
            }],
        });
    };
    
    $(document).ready( function() {
        draw_3();
        draw_4();
    });
    
    $(window).on('resize', function() {
        draw_3();
        draw_4();
    });
        
    </script>

<?php         
    }}
?>    
