<?php
    session_start();
    $seconds = 0;
    sleep($seconds);
    if(empty($_SESSION['id_user_apl'])){
?>
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3 class="modal-title">Su sesión ha culminado</h3>
        </div>
        <div class="modal-body">
            <div class="panel panel-warning">
                <div class="panel-heading">
                    <h3 class="panel-title">No te encuentras logeado</h3>
                </div>
                <div class="panel-body text-center">
                  La sesión ya ha culminado por el cual no podras visualizar nada en la plataforma, 
                  favor de actualizar la web para poder ingresar nuevamente o darle click al siguiente boton : <a data-dismiss="modal" class="btn btn-warning cierre_modal">Actualizar</a>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <a data-dismiss="modal" class="btn btn-default cierre_modal">Cerrar</a>
        </div>
    </div>
<?php
    }else{
    require_once ('../../../data/pid_examen.php');
    require_once ('../../../data/pid_access.php');
    $id_examen = $_GET['id_examen'];
    $id_user = $_SESSION['id_user_apl'];
    $object = new examen_usuario();
    $object_permisos = new pid_permisos();
    $result_correctas = $object->view_grafico_pregunta_gestor($id_examen);
    $result_incorrectas = $object->view_grafico_pregunta_gestor($id_examen);
    $result_sinrespuesta = $object->view_grafico_pregunta_gestor($id_examen);
    $result_examen = $object->view_examen_grafico($id_examen);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row = $result_examen->fetch_assoc();
    $row_permisos = $result_permisos->fetch_assoc();

    if($row_permisos['graf_exam'] != "true"){
?>
<div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Acceso Bloqueado</h3>
    </div>
    <div class="modal-body">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <h3 class="panel-title">Sin permisos para el acceso al módulo</h3>
            </div>
            <div class="panel-body text-center">
              No cuentas con los permisos correspondientes para el acceso a este módulo, contacte con el desarrolador y/o administrador.
            </div>
        </div>
    </div>
    <div class="modal-footer">
      <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
    </div>
</div>
<?php }else{ ?>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3 class="modal-title">Gráfico Completo de las preguntas de : <?= $row['titulo_examen'] ?></h3>
  </div>
  <div class="modal-body">
        <div class="panel panel-default">
            <div class="panel-body">
                <div id="grafico_gestor_pregunta"></div>
            </div>
        </div>
  </div>
  <div class="modal-footer">
    <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
  </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#grafico_gestor_pregunta').highcharts({
            chart: {
                type: 'column',
                style: {
                    "fontFamily": "Roboto"
                }
            },
            position: {
                spacingLeft: 0,
                marginRight: 0
            },
            exporting:{
                fallbackToExportServer: false
            },
            title: {
                text: '<?= $row['titulo_examen'] ?>',
                style: {
                    "color": '#000',
                    "fontSize": '16px',
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
                        "color": '#000',
                        "fontSize": '10px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                },
                gridLineWidth: 1,
                lineColor: '#000',
                tickColor: '#000',
                title: {
                    style: {
                        color: '#333',
                        fontWeight: 'bold',
                        fontSize: '12px',
                        fontFamily: 'Roboto'
                    }
                }
            },
            yAxis: {
                min: 0,
                //max: 100,
                tickInterval: 2,
                lineColor: '#000',
                lineWidth: 1,
                tickWidth: 1,
                tickColor: '#000',
                labels: {
                    style: {
                        color: '#000',
                        font: '11px Roboto'
                    }
                },
                title: {
                    text: 'Resultados',
                    style: {
                        color: '#333',
                        fontWeight: 'bold',
                        fontSize: '12px',
                        fontFamily: 'Roboto'
                    }
                },
                stackLabels: {
                    enabled: false,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            legend: {
                align: 'right',
                x: -30,
                verticalAlign: 'top',
                y: 25,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
                borderColor: '#CCC',
                borderWidth: 1,
                shadow: false
            },
            tooltip: {
                formatter: function () {
                    return '<b>Pregunta : ID ' + this.x + '</b><br/>' +
                        this.series.name + ': ' + this.y + '<br/>' ;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black',
                        style: {
                            textShadow: '0 0 0px black'
                        }
                    }
                }
            },
            series: [{
                name: 'Correctas',
                data: [
                <?php while($reg_correctas = $result_correctas->fetch_assoc()){ ?>
                    {
                        name: '<?= "P".$reg_correctas['id_pregunta'] ?>',
                        color: '#267F00',
                        
                        y : <?php 
                        $id_pregunta =  $reg_correctas['id_pregunta'];
                        $campo = "correctas";
                        $result_count_c = $object->view_count_grafico_pregunta_gestor($id_examen, $id_pregunta, $campo);
                        echo $result_count_c->num_rows;
                        ?>
                    },
                <?php } ?>
                ]
            }, {
                name: 'Incorrectas',
                data: [
                <?php while($reg_incorrectas = $result_incorrectas->fetch_assoc()){ ?>
                    {
                        name: '<?= "P".$reg_incorrectas['id_pregunta'] ?>',
                        color: '#FF2D2D',
                        
                        y : <?php 
                        $id_pregunta =  $reg_incorrectas['id_pregunta'];
                        $campo = "incorrectas";
                        $result_count_i = $object->view_count_grafico_pregunta_gestor($id_examen, $id_pregunta, $campo);
                        echo $result_count_i->num_rows;
                        ?>
                    },
                <?php } ?>
                ]
            }, {
                name: 'Sin Respuesta',
                data: [
                <?php while($reg_sinrespuesta = $result_sinrespuesta->fetch_assoc()){ ?>
                    {
                        name: '<?= "P".$reg_sinrespuesta['id_pregunta'] ?>',
                        color: '#CCCCCC',
                        
                        y : <?php 
                        $id_pregunta =  $reg_sinrespuesta['id_pregunta'];
                        $campo = "sin_respuesta";
                        $result_count_s = $object->view_count_grafico_pregunta_gestor($id_examen, $id_pregunta, $campo);
                        echo $result_count_s->num_rows;
                        ?>
                    },
                <?php } ?>
                ]
            }],
            colors: ['#267F00','#FF2D2D','#CCCCCC']
        });
    });
    
    
    var chart = $('#grafico_gestor_pregunta').highcharts();
    $('#modal_view_grafica_pregunta_gestor').on('show.bs.modal', function() {
        $('#grafico_gestor_pregunta').css('visibility', 'hidden');
    });
    $('#modal_view_grafica_pregunta_gestor').on('shown.bs.modal', function() {
        $('#grafico_gestor_pregunta').css('visibility', 'initial');
        chart.reflow();
    });
    
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>


