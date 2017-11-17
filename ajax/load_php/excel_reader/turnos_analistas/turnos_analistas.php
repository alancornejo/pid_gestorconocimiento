<?php
error_reporting(E_ALL ^ E_NOTICE);
require_once ('../../../../data/pid_read_excel.php');
require_once ('../../../../data/pid_view.php');
$object_view = new pid_view();
$result_view = $object_view->view_ruta_turnos_analistas_claro();
$row_view = $result_view->fetch_assoc();
$file = $row_view['src_ruta'];
$ruta = explode("/", $file);
$ruta_excel = "../../../../assets/images/KDB/RD/TURNOS/".end($ruta);
$data = new Spreadsheet_Excel_Reader($ruta_excel,true,"UTF-8");
$data->setOutputEncoding('UTF-8');
$nr_sheets = count($data->sheets);
?>
<br>
<style>
    a:focus {
        color: #0a6ebd;
        text-decoration: -moz-none;
    }
</style>
<div class="panel panel-default bootcards-summary">
  <div class="panel-heading">
    <h3 class="panel-title">Turnos Analistas Claro</h3>
  </div>
  <div class="panel-body">
    <div class="row">
      <?php
      for($sheet=0;$sheet<$nr_sheets;$sheet++) {
      ?>
      <div class="col-xs-6 col-sm-4">
        <a class="bootcards-summary-item" target="_blank" href="visualizar_turnos_claro/<?= $sheet ?>">
          <i class="fa fa-3x fa-file-excel-o"></i>
          <h5><?= $data->boundsheets[$sheet]['name']; ?> <span class="label label-primary"><i class="fa fa-eye"></i></span></h5>
        </a>
      </div>
      <?php } ?>
    </div>
  </div>
  <div class="panel-footer">
      <small class="text-danger">Debes dar clic al item para ser redireccionado automaticamente</small>
  </div>
</div>