<?php
error_reporting(E_ALL ^ E_NOTICE);
session_start();
require_once ('../data/pid_view.php');
$object_view = new pid_view();
$result_view = $object_view->view_ruta_turnos_analistas_claro();
$row_view = $result_view->fetch_assoc();
$file = $row_view['src_ruta'];
$ruta = explode("/", $file);
$ruta_excel = "../assets/images/KDB/RD/TURNOS/".end($ruta);
if(empty($_SESSION['id_user_apl']))
{
header('Location: ../login');
}
$id = $_GET['id'];
require_once ('../data/pid_read_excel.php');
$data = new Spreadsheet_Excel_Reader($ruta_excel,true,"UTF-8");
$data->setOutputEncoding('UTF-8');
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>PID - Claro Aplicaciones de Negocio</title>
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../assets/images/favicon.png">
    <!-- CSS -->
    <link href="../assets/js/plugins/pid/css/boostrap_excel.css" rel="stylesheet" type="text/css">
    <link href="../assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css">
    <link href="../assets/js/plugins/pid/css/sky-mega-menu.css" rel="stylesheet">
    <link href="../assets/js/plugins/pid/css/sky-mega-menu-blue.css" rel="stylesheet">
    <!-- Javascript -->
    <script src="../assets/plugins/jquery/jquery.js" type="text/javascript"></script>
    <script src="../assets/plugins/bootstrap/js/bootstrap.js" type="text/javascript"></script>
  </head>
  <body>
      <div style="margin-bottom: -28px">
        <ul class="sky-mega-menu sky-mega-menu-fixed sky-mega-menu-anim-slide sky-mega-menu-response-to-icons">
            <li>
                <a style="cursor: pointer;"><img class="img-responsive" alt="Cosapi Data" src="../assets/images/pid_plataforma_verano.png" style="max-width: 80px !important"></a>
            </li>
            <li>
                <a style="cursor: pointer"><i class="fa fa-file-excel-o"></i><b><?= $data->boundsheets[$id]['name']; ?></b></a>
            </li>
        </ul>
      </div>
      <div class="container-fluid">
        <?= $data->dump(false,false,$id,"table table-condensed"); ?>
      </div>
  </body>
</html>
