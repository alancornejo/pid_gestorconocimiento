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

    /* Grafico Asignado/Pendiente y Solucionado */    
    $fecha_solu = $object->grafico_asigpen_solu($mes, $ano);
    $cantidad_solu = $object->grafico_asigpen_solu($mes, $ano);
    $promedio_solu = $object->grafico_asigpen_solu($mes, $ano);
    $caso_solu = $object->grafico_asigpen_solu($mes, $ano);
    /* Grafico Asignado/Pendiente y Solucionado */
    
    /* MiniTabla Asignado/Pendiente y Solucionado */
    $result_minitabla_solu = $object->mini_tabla_solu($mes, $ano);
    $row_minitabla_solu = $result_minitabla_solu->fetch_assoc();
    /* MiniTabla Asignado/Pendiente y Solucionado */
    
    /* Tabla Asignado/Pendiente y Solucionado */
    $tabla_fec_solu = $object->tabla_solu($mes, $ano);
    $tabla_cantidad_solu = $object->tabla_solu($mes, $ano);
    $tabla_promedio_solu = $object->tabla_solu($mes, $ano);
    $tabla_caso_antiguo_solu = $object->tabla_solu($mes, $ano);
    /* Tabla Asignado/Pendiente y Solucionado */
?>
<div class="cuerpo_grafico_solu">
    <div class="bootcards-chart-canvas" id="grafico_casos_solu" style="height: 400px; font-family: 'Roboto';"></div>
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
<script>
    
    function esconder_en_casos_solu(){
        $('.titulo_casos_solu').html("Graficos Seguimiento de Casos");
    }
    
    $('.ver_tabla_solu').click(function (){
        $('.cuerpo_grafico_solu,.ver_tabla_solu').fadeOut(100,function (){
            $('.titulo_casos_solu').html("Tabla Seguimiento de Casos");
            $('.cuerpo_tabla_solu,.ver_grafico_solu').fadeIn();
        });
    });
    
    $('.ver_grafico_solu').click(function (){
        $('.cuerpo_tabla_solu,.ver_grafico_solu').fadeOut(100,function (){
            $('.titulo_casos_solu').html("Graficos Seguimiento de Casos");
            $('.cuerpo_grafico_solu,.ver_tabla_solu').fadeIn();
        });
    });
    
    var draw_2 = function () {
        $('#grafico_casos_solu').highcharts({
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
                    while ($row = $fecha_solu->fetch_assoc())
                    {
                    ?>
                        '<?= date("d/m - H:i",  strtotime($row['Fecha_Solu'])) ?>',
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
                    while ($row = $cantidad_solu->fetch_assoc())
                    {
                    ?>
                        <?= $row['Cantidad_Solu'] ?>,
                    <?php
                    }
                    ?>
                ]
            }, {
                name: 'Promedio antiguedad (dias)',
                color : '#A3D1FF',
                data: [
                    <?php 
                    while ($row = $promedio_solu->fetch_assoc())
                    {
                    ?>
                        <?= $row['Promedio_Solu'] ?>,
                    <?php
                    }
                    ?>
                ]
            }, {
                name: 'Caso mas Antiguo (dias)',
                color : '#4297FF',
                data: [
                    <?php 
                    while ($row = $caso_solu->fetch_assoc())
                    {
                    ?>
                        <?= $row['Caso_Solu'] ?>,
                    <?php
                    }
                    ?>
                ]
            }],
        });
    };
    
    $(document).ready( function() {
        draw_2();
        esconder_en_casos_solu();
    });
    
    $(window).on('resize', function() {
        draw_2();
    });
    
</script>