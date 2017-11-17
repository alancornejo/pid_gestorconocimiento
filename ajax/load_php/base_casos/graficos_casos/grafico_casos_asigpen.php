<?php
    require_once ('../../../../data/pid_data.php');
    $mes_subida = $_GET['mes'];
    if($mes_subida == "1"){
        $id_mes = "Enero";
    }elseif($mes_subida == "2"){
        $id_mes = "Febrero";
    }elseif($mes_subida == "3"){
        $id_mes = "Marzo";
    }elseif($mes_subida == "4"){
        $id_mes = "Abril";
    }elseif($mes_subida == "5"){
        $id_mes = "Mayo";
    }elseif($mes_subida == "6"){
        $id_mes = "Junio";
    }elseif($mes_subida == "7"){
        $id_mes = "Julio";
    }elseif($mes_subida == "8"){
        $id_mes = "Agosto";
    }elseif($mes_subida == "9"){
        $id_mes = "Setiembre";
    }elseif($mes_subida == "10"){
        $id_mes = "Octubre";
    }elseif($mes_subida == "11"){
        $id_mes = "Noviembre";
    }elseif($mes_subida == "12"){
        $id_mes = "Diciembre";
    }
    $object = new seguimiento_casos();
    $mes = $id_mes;
    $ano = $_GET['ano'];
    
    /* Gráfico Asignado/Pendiente y Solucionado */
    $fecha_asig = $object->grafico_asigpen_solu($mes, $ano);
    $cantidad_asig = $object->grafico_asigpen_solu($mes, $ano);
    $promedio_asig = $object->grafico_asigpen_solu($mes, $ano);
    $caso_asig = $object->grafico_asigpen_solu($mes, $ano);
    /* Grafico Asignado/Pendiente y Solucionado */
    
    /* MiniTabla Asignado/Pendiente y Solucionado */
    $result_minitabla = $object->mini_tabla_asigpen($mes, $ano);
    $row_minitabla = $result_minitabla->fetch_assoc();
    /* MiniTabla Asignado/Pendiente y Solucionado */
    
    /* Tabla Asignado/Pendiente y Solucionado */
    $tabla_fec_asigpen = $object->tabla_asigpen($mes, $ano);
    $tabla_cantidad_asigpen = $object->tabla_asigpen($mes, $ano);
    $tabla_promedio_asigpen = $object->tabla_asigpen($mes, $ano);
    $tabla_caso_antiguo_asigpen = $object->tabla_asigpen($mes, $ano);
    /* Tabla Asignado/Pendiente y Solucionado */
?>
<div class="cuerpo_grafico_asig">
    <div class="bootcards-chart-canvas" id="grafico_casos_asig" style="height: 400px; font-family: 'Roboto';"></div>
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
<script>
    
    function esconder_en_casos(){
        $('.titulo_casos_asig').html("Graficos Seguimiento de Casos");
    }
    
    $('.ver_tabla_asig').click(function (){
        $('.cuerpo_grafico_asig,.ver_tabla_asig').fadeOut(100,function (){
            $('.titulo_casos_asig').html("Tabla Seguimiento de Casos");
            $('.cuerpo_tabla_asig,.ver_grafico_asig').fadeIn();
        });
    });
    
    $('.ver_grafico_asig').click(function (){
        $('.cuerpo_tabla_asig,.ver_grafico_asig').fadeOut(100,function (){
            $('.titulo_casos_asig').html("Graficos Seguimiento de Casos");
            $('.cuerpo_grafico_asig,.ver_tabla_asig').fadeIn();
        });
    });
    
    var draw_1 = function () {
        $('#grafico_casos_asig').highcharts({
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
    
    $(document).ready( function() {
        draw_1();
        esconder_en_casos();
    });
    
    $(window).on('resize', function() {
        draw_1();
    });
    
</script>