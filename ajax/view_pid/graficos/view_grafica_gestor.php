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
    $result_nota = $object->view_grafico_gestor($id_examen);
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
    <h3 class="modal-title">Gráfico Completo : <?= $row['titulo_examen'] ?></h3>
  </div>
  <div class="modal-body">
    <div class="panel panel-default">
        <div class="panel-body">
            <div id="grafico_gestor"></div>
        </div>
    </div>
  </div>
  <div class="modal-footer">
    <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
  </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#grafico_gestor').highcharts({
            chart: {
                type: 'column',
                style: {
                    "fontFamily": "Roboto"
                }
            },
            exporting:{
                fallbackToExportServer: false
            },
            position: {
                spacingLeft: 0,
                marginRight: 0
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
            subtitle: {
                text: 'Todos los resultados de los analistas',
                style: {
                    color: '#666666',
                    "fontSize": '12px',
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                }
            },
            xAxis: {
                type: 'category',
                labels: {
                    rotation: -45,
                    style: {
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
                        "fontSize": '12px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                }
            },
            yAxis: {
                min: 0,
                //max: 20,
                tickInterval: 2,
                lineColor: '#000',
                lineWidth: 1,
                tickWidth: 1,
                tickColor: '#000',
                labels: {
                    style: {
                        color: '#000',
                        "fontSize": '11px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                },
                title: {
                    text: 'Resultados',
                    style: {
                        color: '#333',
                        "fontSize": '12px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold"
                    }
                }
            },
            legend: {
                enabled: false
            },
            series: [{
                name: 'Nota',
                style: {
                    "fontSize": '12px',
                    "fontFamily": "Roboto",
                    "fontWeight": "bold"
                },
                data: [
                <?php while($reg = $result_nota->fetch_assoc()){ ?>
                    {
                        name: '<?php if($reg['examen_tomado'] == 0 || $reg['examen_tomado'] == 2){ 
                                        if(strtotime($reg['fecha_termino']) < strtotime(date("Y-m-d H:i:s"))){
                                            echo substr(utf8_encode($reg['nom_user']),0,19)."... (expirado)";
                                        }else{
                                            echo utf8_encode($reg['nom_user']);
                                        }
                                     }else{ 
                                        echo utf8_encode($reg['nom_user']);
                                     } ?>',
                        color: '<?php if($reg['examen_tomado'] == 0){
                                    echo "#FF2D2D";
                                }elseif($reg['examen_tomado'] == 1){ 
                                    if($reg['nota_final'] < 14){
                                        echo "#FF2D2D";
                                    }else{
                                        echo "#267F00";
                                    }
                                }else{ 
                                    echo "#CCCCCC";
                                } ?>',
                        
                        y : <?php if($reg['nota_final'] == NULL){
                                    echo "0";
                                }else{
                                    echo $reg['nota_final'];
                                } ?>
                    },
                <?php } ?>
                ],
                dataLabels: {
                    enabled: true,
                    rotation: 00,
                    color: '#303030',
                    shadow: false,
                    align: 'center',
                    y: 8, // 10 pixels down from the top
                    style: {
                        "fontSize": '13px',
                        "fontFamily": "Roboto",
                        "fontWeight": "bold",
                        textShadow: false
                    }
                }
            }]
        });
    });
    
    var chart2 = $('#grafico_gestor').highcharts();
    $('#modal_view_grafica_gestor').on('show.bs.modal', function() {
        $('#grafico_gestor').css('visibility', 'hidden');
    });
    $('#modal_view_grafica_gestor').on('shown.bs.modal', function() {
        $('#grafico_gestor').css('visibility', 'initial');
        chart2.reflow();
    });
    
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>


