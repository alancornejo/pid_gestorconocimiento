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
    $id_pregunta = $_GET['id'];
    $id_user = $_SESSION['id_user_apl'];
    $object_permisos = new pid_permisos();
    $object_preguntas = new examen_usuario();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    $result_grafico = $object_preguntas->view_grafico_pregunta($id_pregunta);
    $row_grafico = $result_grafico->fetch_assoc();

    if($row_permisos['graf_pregunta'] != "true"){
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
<style>
    .highcharts-container {
        width: 100% !important;
        height: 100% !important;
        text-align: center !important;
    }
</style>
<div class="modal-content">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h3 class="modal-title">Gráfico Estadistico : Pregunta N°<?= $row_grafico['id_pregunta'] ?></h3>
  </div>
  <div class="modal-body">
      <div class="row center-block">
          <div id="grafico_preguntas"></div>
      </div>
  </div>
  <div class="modal-footer">
    <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
  </div>
</div>
<script>
    $(function () {
    $('#grafico_preguntas').highcharts({
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: 0,
            plotShadow: true,
            style: {
                "fontFamily": "Roboto"
            }
        },
        title: {
            text: '',
            align: 'center',
            verticalAlign: 'middle',
            y: 40,
            style: {
                "color": '#000',
                "fontSize": '16px',
                "fontFamily": "Roboto",
                "fontWeight": "bold"
            }
        },
        /*tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },*/
        plotOptions: {
            pie: {
                dataLabels: {
                    enabled: true,
                    distance: 20,
                    style: {
                        color: 'black',
                        textShadow: '-1px -1px white',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                },
                startAngle: -90,
                endAngle: 90,
                center: ['50%', '75%']
            }
        },
        series: [{
            type: 'pie',
            name: 'Cantidad',
            innerSize: '50%',
            data: [
                <?php 
                    if($row_grafico['correctas'] == "0" && $row_grafico['incorrectas'] == "0" && $row_grafico['sin_respuesta'] == "0"){
                ?>        
                {
                    name: 'No cuenta con datos',
                    y: 1000,
                    color : '#CCCCCC',
                    style: {
                        "fontSize": '12px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                }
                <?php
                    }else{
                ?>
                    {
                        name: 'Correctas [<?= $row_grafico['correctas'] ?>]',
                        y: <?= $row_grafico['correctas'] ?>,
                        color : '#267F00',
                        style: {
                            "fontSize": '12px',
                            "fontFamily": "Roboto",
                            "fontWeight": "bold"
                        }
                    },
                    {
                        name: 'Incorrectas [<?= $row_grafico['incorrectas'] ?>]',
                        y: <?= $row_grafico['incorrectas'] ?>,
                        color : '#FF2D2D',
                        style: {
                            "fontSize": '12px',
                            "fontFamily": "Roboto",
                            "fontWeight": "bold"
                        }
                    },
                    {
                        name: 'Sin Respuesta [<?= $row_grafico['sin_respuesta'] ?>]',
                        y: <?= $row_grafico['sin_respuesta'] ?>,
                        color : '#CCCCCC',
                        style: {
                            "fontSize": '12px',
                            "fontFamily": "Roboto",
                            "fontWeight": "bold"
                        }
                    }            
                <?php    
                    }
                ?>
            ]
        }]
    });
});
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>


