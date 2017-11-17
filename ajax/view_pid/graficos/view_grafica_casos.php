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
    require_once ('../../../data/pid_data.php');
    require_once ('../../../data/pid_access.php');
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
    $id_user = $_SESSION['id_user_apl'];
    $object = new seguimiento_casos();
    $object_permisos = new pid_permisos();
    $result_permisos = $object_permisos->user_permisos($id_user);
    $row_permisos = $result_permisos->fetch_assoc();
    $mes = $id_mes;
    $ano = $_GET['ano'];

    if($row_permisos['add_seg_casos'] != "true"){
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
    <h3 class="modal-title">Gráfico Mensual de <?= $id_mes ?> del <?= $ano ?> </h3>
  </div>
  <div class="modal-body">
        <div class="row center-block">
            <div class="panel panel-default bootcards-chart">
                <div class="panel-heading">
                    <h3 class="panel-title titulo_casos_asig"></h3>
                </div>
                <div class="load_asigpen"></div>
            </div>
            <div class="panel panel-default bootcards-chart">
                <div class="panel-heading">
                    <h3 class="panel-title titulo_casos_solu"></h3>
                </div>
                <div class="load_solu"></div>
            </div>          
        </div>
  </div>
  <div class="modal-footer">
    <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
  </div>
</div>
<script type="text/javascript">
    $('.titulo_casos_asig').html("<center><img src='assets/images/loading.gif'><b> Cargando...</b></center>");    
    $('.titulo_casos_solu').html("<center><img src='assets/images/loading.gif'><b> Cargando...</b></center>");    
    $('.load_asigpen').html("<br><center><img src='assets/images/loading.gif'><b> Cargando...</b></center><br>");
    $('.load_solu').html("<br><center><img src='assets/images/loading.gif'><b> Cargando...</b></center><br>");
    
    setTimeout(function(){
        $('.load_asigpen').load("ajax/load_php/base_casos/graficos_casos/grafico_casos_asigpen.php?mes=<?= $mes_subida ?>&ano=<?= $ano ?>");
        $('.load_solu').load("ajax/load_php/base_casos/graficos_casos/grafico_casos_solu.php?mes=<?= $mes_subida ?>&ano=<?= $ano ?>");
    },1000);
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>


