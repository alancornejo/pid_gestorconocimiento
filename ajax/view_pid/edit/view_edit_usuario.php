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
    require_once ('../../../data/pid_view.php');
    require_once ('../../../data/pid_access.php');
    $user_id = $_SESSION['id_user_apl'];
    $id = $_GET['id'];
    $id_user = $_GET['id'];
    $object = new pid_view();
    $object_permisos = new pid_permisos();
    $result = $object->view_usuario($id);
    $result_permisos = $object_permisos->user_permisos($id_user);
    $result_permisos_modulo = $object_permisos->user_permisos_modulo($user_id);
    $row = $result->fetch_assoc();
    $row_permisos = $result_permisos->fetch_assoc();
    $row_permisos_modulo = $result_permisos_modulo->fetch_assoc();
    
    if($row_permisos_modulo['edit_usua'] != "true"){
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
              <h3 class="modal-title">Editar Usuario</h3>
            </div>
            <div class="modal-body">
                <form id="edit_usuario" class="sky-form">
                    <fieldset>
                        <div class="row">
                          <section class="col col-9">
                             <label>Nombre de Usuario</label>
                             <div class="input-group">
                                 <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                 <input name="txt_usuario" type="text" class="txt_usuario form-control" id="inputUsuarioEdit" value="<?= utf8_encode($row['nom_user']) ?>">
                                 <input name="id_usuario" type="text" value="<?= $id_user ?>" hidden>
                             </div>
                          </section>
                          <section class="col col-3">
                              <label>Claro Usuario</label>
                              <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-code"></i></span>
                                <input name="txt_claro" type="text" class="txt_claro form-control" id="inputClaroUsuarioEdit" value="<?= $row['claro_user'] ?>">
                              </div>
                          </section>
                        </div>
                        <div class="row">
                          <section class="col col-4">
                              <label>Rol de Usuario</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                  <select name="sl_rol" id="inputRol" class="sl_rol selectpicker_edit form-control" data-header="Rol de Usuario">
                                      <option value="0" <?php if($row['rol_user'] == 0){ echo "selected"; } ?>>Analista de Soporte 1er Nivel</option>
                                      <option value="1" <?php if($row['rol_user'] == 1){ echo "selected"; } ?>>Supervisor de Soporte 1er Nivel</option>
                                      <option value="2" <?php if($row['rol_user'] == 2){ echo "selected"; } ?>>Gestor de Servicio</option>
                                      <option value="3" <?php if($row['rol_user'] == 3){ echo "selected"; } ?>>Monitor de Calidad</option>
                                      <option value="4" <?php if($row['rol_user'] == 4){ echo "selected"; } ?>>Practicante de Mesa de Ayuda</option>
                                      <option value="5" <?php if($row['rol_user'] == 5){ echo "selected"; } ?>>Especialista BES</option>
                                      <option value="6" <?php if($row['rol_user'] == 6){ echo "selected"; } ?>>Asistente Administrativo</option>
                                      <option value="7" <?php if($row['rol_user'] == 7){ echo "selected"; } ?>>Jefe de Proyecto</option>
                                      <option value="8" <?php if($row['rol_user'] == 8){ echo "selected"; } ?>>Cliente de Proyecto</option>
                                      <option value="9" <?php if($row['rol_user'] == 9){ echo "selected"; } ?>>Apoyo de Cliente de Proyecto</option>
                                  </select>
                              </div>
                          </section>
                          <section class="col col-4">
                              <label>Funcion del Usuario</label>
                              <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-group"></i></span>
                                  <select name="sl_funcion" id="inputFuncionEdit" class="sl_funcion_edit selectpicker_edit form-control" data-header="Funcion del Usuario">
                                      <option value="0" <?php if($row['funcion_user'] == 0){ echo "selected"; } ?>>Analista de Mesa de Ayuda</option>
                                      <option value="9" <?php if($row['funcion_user'] == 9){ echo "selected"; } ?>>Analista Escalado</option>
                                      <option value="2" <?php if($row['funcion_user'] == 2){ echo "selected"; } ?>>Gestor de Conocimiento</option>
                                      <option value="1" <?php if($row['funcion_user'] == 1){ echo "selected"; } ?>>Gestor de Correo</option>
                                      <option value="8" <?php if($row['funcion_user'] == 8){ echo "selected"; } ?>>Apoyo PID</option>
                                      <?php if($_SESSION['funcion_user'] == 4 || $_SESSION['funcion_user'] == 5){ ?>
                                      <option value="4" <?php if($row['funcion_user'] == 4){ echo "selected"; } ?>>Administrador</option>
                                      <?php } ?>
                                      <?php if($_SESSION['funcion_user'] == 2 || $_SESSION['funcion_user'] == 4 || $_SESSION['funcion_user'] == 5){ ?>
                                      <option value="6" <?php if($row['funcion_user'] == 6){ echo "selected"; } ?>>Cliente Proyecto</option>
                                      <option value="7" <?php if($row['funcion_user'] == 7){ echo "selected"; } ?>>Apoyo Cli.Proyecto</option>
                                      <?php } ?>
                                  </select>
                              </div>
                          </section>
                          <section class="col col-4">
                            <label>Tipo de Servicio</label>
                            <div class="input-group">
                                  <span class="input-group-addon"><i class="fa fa-asterisk"></i></span>
                                  <select name="sl_servicio" id="inputServicioEdit" class="sl_servicio_edit selectpicker_edit form-control" data-header="Tipo de Servicio">
                                        <option value="0" <?php if($row['tipo_user'] == 0){ echo "selected"; } ?>>Aplicaciones</option>
                                        <option value="1" <?php if($row['tipo_user'] == 1){ echo "selected"; } ?>>Biométrico</option>
                                  </select>
                            </div>
                          </section>
                        </div>
                        <div class="row">
                            <section id="edit_0" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 0){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Analista de Mesa de Ayuda</h4>
                                  <p>Podra interactuar de manera dinamica, las vistas de la plataforma.</p>
                                </div>
                            </section>
                            <section id="edit_2" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 2){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Gestor de conocimiento y/o Apoyo</h4>
                                  <p>Podra agregar, modificar y/o aprobar documentos del módulo KDB, como tambien poder eliminarlos, reiniciar los contadores de los documentos del KDB, como tambien exportar la data de esta misma.</p>
                                </div>
                            </section>
                            <section id="edit_1" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 1){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Gestor de Correo y/o Apoyo</h4>
                                  <p>Podra agregar y modificar las bitácoras en la plataforma, como tambien exportar la data de esta misma.</p>                      
                                </div>
                            </section>
                            <section id="edit_4" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 4){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Administrador</h4>
                                  <p>Este rol tendra el acceso a todas las funciones de la plataforma.</p>
                                </div>
                            </section>
                            <section id="edit_6" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 6){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Cliente de Proyecto</h4>
                                  <p>Este rol solo podra tener acceso al módulo visual del KDB y de la Bitácora.</p>
                                </div>
                            </section>
                            <section id="edit_7" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 7){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Apoyo de Cli.Proyecto</h4>
                                  <p>Cuenta con las mismas caracteristicas que el Cliente de Proyecto.</p>
                                </div>
                            </section>
                            <section id="edit_8" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 8){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Apoyo PID</h4>
                                  <p>Este rol, define a los usuarios que tendran permisos y estaran de apoyo en la plataforma para distintas tareas.</p>
                                </div>
                            </section>
                            <section id="edit_9" class="funcion_estado_edit col col-12" <?php if($row['funcion_user'] == 9){ echo ""; }else{ echo "hidden"; } ?>>
                                <label>&nbsp;</label>
                                <div class="alert alert-dismissible alert-warning">
                                  <h4>Analista Escalado</h4>
                                  <p>Este rol, podra gestionar la pestaña de comunicados ATC.</p>
                                </div>
                            </section>
                        </div>
                        <div class="row">
                            <section class="col col-12">
                              <h4 class="text-center">Permisos en la plataforma</h4>
                              <center>
                                  <select name="sl_permisos" class="sl_permisos selectpicker_edit form-control" data-width="238px" data-header="Gestion de Permisos">
                                      <option value="nada" selected disabled>Seleccionar Aqui</option>
                                      <?php if($row_permisos_modulo['mod_ges'] == "true"){ ?>
                                      <option value="permisos">GESTIONAR PERMISOS</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_kdb'] == "true"){ ?>
                                      <option value="conocimiento">Módulo KDB</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_bit'] == "true"){ ?>
                                      <option value="bitacora">Módulo BITÁCORAS</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_bor'] == "true"){ ?>
                                      <option value="borrador">Módulo BORRADOR</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_cat'] == "true"){ ?>
                                      <option value="categorias">Módulo CATEGORIAS</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_usu'] == "true"){ ?>
                                      <option value="usuarios">Módulo USUARIOS</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_exa'] == "true"){ ?>
                                      <option value="examenes">Módulo EXÁMENES</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_enc'] == "true"){ ?>
                                      <option value="encuestas">Módulo ENCUESTAS</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_nas'] == "true"){ ?>
                                      <option value="nas">Módulo RD</option>
                                      <?php } ?>
                                      <?php if($row_permisos_modulo['mod_port'] == "true"){ ?>
                                      <option value="portal">Módulo PORTAL</option>
                                      <?php } ?>
                                      <?php if($_SESSION['funcion_user'] == 4 || $_SESSION['funcion_user'] == 5){ ?>
                                      <option value="registros">Módulo REGISTROS</option>
                                      <?php } ?>
                                  </select>
                              </center>
                            </section>
                        </div>
                        <br>
                        <div class="row">
                            <section id="permisos" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo GESTIONAR PERMISOS</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_ges" class="switch_opcion" <?php if($row_permisos['mod_ges'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo KDB</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_kdb" class="switch_opcion" <?php if($row_permisos['mod_kdb'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo BITÁCORAS</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_bit" class="switch_opcion" <?php if($row_permisos['mod_bit'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo BORRADOR</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_bor" class="switch_opcion" <?php if($row_permisos['mod_bor'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo CATEGORIAS</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_apl" class="switch_opcion" <?php if($row_permisos['mod_cat'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo USUARIOS</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_usu" class="switch_opcion" <?php if($row_permisos['mod_usu'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo EXÁMENES</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_exa" class="switch_opcion" <?php if($row_permisos['mod_exa'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo ENCUESTAS</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_enc" class="switch_opcion" <?php if($row_permisos['mod_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo RD</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_nas" class="switch_opcion" <?php if($row_permisos['mod_nas'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Módulo PORTAL</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="mod_port" class="switch_opcion" <?php if($row_permisos['mod_port'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="conocimiento" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Opciones KDB</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_cono" class="switch_opcion" <?php if($row_permisos['gest_cono'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Conocimiento</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_cono" class="switch_opcion" <?php if($row_permisos['crea_cono'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Conocimiento</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_cono" class="switch_opcion" <?php if($row_permisos['edit_cono'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Aprobar Conocimiento</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="apro_cono" class="switch_opcion" <?php if($row_permisos['apro_cono'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar Contador</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_con_cono" class="switch_opcion" <?php if($row_permisos['rein_con_cono'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Gestionar Comentarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_comment" class="switch_opcion" <?php if($row_permisos['gest_comment'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Calificar / Descalificar comentarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="apro_comment" class="switch_opcion" <?php if($row_permisos['apro_comment'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Gestionar Estado de Comentarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_est_comment" class="switch_opcion" <?php if($row_permisos['gest_est_comment'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar Comentarios de un Documento</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_comment" class="switch_opcion" <?php if($row_permisos['rein_comment'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="bitacora" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Opciones Bitácora</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_bita" class="switch_opcion" <?php if($row_permisos['gest_bita'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Bitácora</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_bita" class="switch_opcion" <?php if($row_permisos['crea_bita'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Bitácora</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_bita" class="switch_opcion" <?php if($row_permisos['edit_bita'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Bitácora</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_bita" class="switch_opcion" <?php if($row_permisos['dele_bita'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="borrador" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Opcion Tabla KDB Borrador</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_borra" class="switch_opcion" <?php if($row_permisos['gest_borra'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Borradores</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_borra" class="switch_opcion" <?php if($row_permisos['edit_borra'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Borradores</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_borra" class="switch_opcion" <?php if($row_permisos['dele_borra'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="categorias" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Gestion de Categorias</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_cat" class="switch_opcion" <?php if($row_permisos['gest_cat'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Categorias</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_cat" class="switch_opcion" <?php if($row_permisos['crea_cat'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Categorias</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_cat" class="switch_opcion" <?php if($row_permisos['edit_cat'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Categorias</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_cat" class="switch_opcion" <?php if($row_permisos['dele_cat'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Aplicaciones</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_apli" class="switch_opcion" <?php if($row_permisos['crea_apli'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Aplicaciones</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_apli" class="switch_opcion" <?php if($row_permisos['edit_apli'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Aplicaciones</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_apli" class="switch_opcion" <?php if($row_permisos['dele_apli'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Grupo Asignado</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_grupo" class="switch_opcion" <?php if($row_permisos['crea_grupo'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Grupo Asignado</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_grupo" class="switch_opcion" <?php if($row_permisos['edit_grupo'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Grupo Asignado</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_grupo" class="switch_opcion" <?php if($row_permisos['dele_grupo'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="usuarios" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Gestion de Usuarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_usua" class="switch_opcion" <?php if($row_permisos['gest_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Nuevo Usuario</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_usua" class="switch_opcion" <?php if($row_permisos['crea_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Usuario</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_usua" class="switch_opcion" <?php if($row_permisos['edit_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Perfil de Usuarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_perfil_usua" class="switch_opcion" <?php if($row_permisos['edit_perfil_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar Conexiones</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_cone_usua" class="switch_opcion" <?php if($row_permisos['rein_cone_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Desconectar Usuarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="descs_usua" class="switch_opcion" <?php if($row_permisos['descs_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Desconectar a Usuario</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="desc_usua" class="switch_opcion" <?php if($row_permisos['desc_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar Tiempo de Conexion</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_tiem_usua" class="switch_opcion" <?php if($row_permisos['rein_tiem_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar Contraseña a Usuarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_password" class="switch_opcion" <?php if($row_permisos['rein_password'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar Comentarios Calificados a Usuarios</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_comment_cali" class="switch_opcion" <?php if($row_permisos['rein_comment_cali'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar Todos los Comentarios Calificados</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_comment_cali_all" class="switch_opcion" <?php if($row_permisos['rein_comment_cali_all'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Usuario</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_usua" class="switch_opcion" <?php if($row_permisos['dele_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="examenes" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Gestion de Exámenes</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_exam" class="switch_opcion" <?php if($row_permisos['gest_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Examen [ID]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_exam" class="switch_opcion" <?php if($row_permisos['crea_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Examen [ID]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_exam" class="switch_opcion" <?php if($row_permisos['edit_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Cambiar Estado de Examen [ID]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="chg_exam" class="switch_opcion" <?php if($row_permisos['chg_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Ver Gráfico de Examen [ID]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="graf_exam" class="switch_opcion" <?php if($row_permisos['graf_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Agregar Preguntas</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_pre_exam" class="switch_opcion" <?php if($row_permisos['crea_pre_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Preguntas</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_pre_exam" class="switch_opcion" <?php if($row_permisos['edit_pre_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Ocultar Preguntas</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_pre_exam" class="switch_opcion" <?php if($row_permisos['dele_pre_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Ver Gráfico Estadistico de cada Pregunta</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="graf_pregunta" class="switch_opcion" <?php if($row_permisos['graf_pregunta'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar las estadisticas de cada Pregunta</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_est_pregunta" class="switch_opcion" <?php if($row_permisos['rein_est_pregunta'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Reiniciar las estadisticas de todas las Pregunta</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="rein_all_est_pregunta" class="switch_opcion" <?php if($row_permisos['rein_all_est_pregunta'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Asignar Examen</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="asig_exam" class="switch_opcion" <?php if($row_permisos['asig_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Examen Asignado</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_asig_exam" class="switch_opcion" <?php if($row_permisos['edit_asig_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Examen Asignado</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_asig_exam" class="switch_opcion" <?php if($row_permisos['dele_asig_exam'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Ver Gráfico Individual de Examen</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="graf_exam_usua" class="switch_opcion" <?php if($row_permisos['graf_exam_usua'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="encuestas" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Gestion de Encuestas</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_enc" class="switch_opcion" <?php if($row_permisos['gest_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Encuesta [ID]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_enc" class="switch_opcion" <?php if($row_permisos['crea_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Encuesta [ID]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_enc" class="switch_opcion" <?php if($row_permisos['edit_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Cambiar Estado de Encuesta [ID]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="esta_enc" class="switch_opcion" <?php if($row_permisos['esta_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Preguntas</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_pre_enc" class="switch_opcion" <?php if($row_permisos['crea_pre_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Preguntas</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_pre_enc" class="switch_opcion" <?php if($row_permisos['edit_pre_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Cambiar Estado de Preguntas</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="esta_pre_enc" class="switch_opcion" <?php if($row_permisos['esta_pre_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Crear Opciones [Preguntas]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_opc_enc" class="switch_opcion" <?php if($row_permisos['crea_opc_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Opciones [Preguntas]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_opc_enc" class="switch_opcion" <?php if($row_permisos['edit_opc_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Opciones [Preguntas]</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_opc_enc" class="switch_opcion" <?php if($row_permisos['dele_opc_enc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="registros" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Gestion de Registros</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_log_reg" class="switch_opcion" <?php if($row_permisos['gest_log_reg'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="nas" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Gestion de RD</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_nas" class="switch_opcion" <?php if($row_permisos['gest_nas'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Agregar Base Matriz Responsable</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="add_ma_resp" class="switch_opcion" <?php if($row_permisos['add_ma_resp'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Base Matriz Responsable</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_ma_resp" class="switch_opcion" <?php if($row_permisos['edit_ma_resp'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Gestionar Base de Seguimiento de Casos</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_seg_casos" class="switch_opcion" <?php if($row_permisos['gest_seg_casos'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Agregar Base de Seguimiento de Casos</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="add_seg_casos" class="switch_opcion" <?php if($row_permisos['add_seg_casos'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Agregar Base Matriz Jobs</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="add_ma_jobs" class="switch_opcion" <?php if($row_permisos['add_ma_jobs'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Base Matriz Jobs</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_ma_jobs" class="switch_opcion" <?php if($row_permisos['edit_ma_jobs'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Ruta de Speech de Servicio</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_dir_spee" class="switch_opcion" <?php if($row_permisos['edit_dir_spee'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Ruta de Turnos Analista Claro</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_dir_tur" class="switch_opcion" <?php if($row_permisos['edit_dir_tur'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Ruta de Horario y Responsables Cac's</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_dir_cac" class="switch_opcion" <?php if($row_permisos['edit_dir_cac'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Agregar Comunicado ATC</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="add_com_atc" class="switch_opcion" <?php if($row_permisos['add_com_atc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Comunicado ATC</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_com_atc" class="switch_opcion" <?php if($row_permisos['edit_com_atc'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                            <section id="portal" class="permisos_estado text-center col col-12" hidden>
                              <center>
                                  <table class="table table-bordered table-striped" style="width: 50%">
                                      <tbody>
                                          <tr>
                                              <td style="text-align: center;"><b>Visualizar Gestion de Portal</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="gest_port" class="switch_opcion" <?php if($row_permisos['gest_port'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Agregar Noticias al Portal</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="crea_port_not" class="switch_opcion" <?php if($row_permisos['crea_port_not'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Editar Noticias del Portal</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="edit_port_not" class="switch_opcion" <?php if($row_permisos['edit_port_not'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                          <tr>
                                              <td style="text-align: center;"><b>Eliminar Noticias del Portal</b></td>
                                              <td style="text-align: center;"><input type="checkbox" name="dele_port_not" class="switch_opcion" <?php if($row_permisos['dele_port_not'] == "true"){ echo "checked"; }else{ echo ""; } ?>></td>
                                          </tr>
                                      </tbody>
                                  </table>
                              </center>
                            </section>
                        </div>
                        <div class="row modal-footer">
                            <a data-dismiss="modal" class="btn btn-default">Cerrar</a>
                            <input class="btn btn-primary" type="submit" value="Editar">
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
<script>
    
    $('.selectpicker_edit').selectpicker();
    
    $(document).ready(function() {
        $('select.sl_funcion_edit').on('changed.bs.select', function(){
            $('.funcion_estado_edit').hide();
            $('#edit_' + $(this).val()).fadeIn("blind");
        });
                
        $('select.sl_permisos').on('changed.bs.select', function(){
            $('.permisos_estado').hide();
            $('#' + $(this).val()).fadeIn("slideup");
        });
        
        $(".switch_opcion").bootstrapSwitch({
            size : 'mini',
            onText: 'SI',
            offText: 'NO'
        })
        
    });
    
    $('#edit_usuario').submit(function( event ) {
        var datos = $(this).serialize();
        swal({
            title: 'Deseas editar a este usuario?',
            text: "Recuerda que todo cambio se reflejara en el usuario",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#1b9cdd',
            cancelButtonColor: '#d33',
            confirmButtonText: '<i class="fa fa-edit"></i> Actualizar',
            showLoaderOnConfirm: false,
            cancelButtonText: '<i class="fa fa-times"></i> Cancelar'
        }).then(function() {
            $.ajax({
                type: "POST",
                url: "ajax/action_class/update/update_usuario.php",
                data: datos,
                success: function(data) {
                    if(data == "true"){
                        setTimeout(function(){     
                            swal({
                                title: "",
                                text: "Se actualizo al usuario con exito",
                                type: "success",
                                showCancelButton: false,
                                showConfirmButton: true
                            });
                            $('#modal_edit_usuario').modal('toggle');
                        }, 600);
                        tabla_usuarios_gestor.ajax.reload( null, false );
                    }else{
                        swal({
                            title: "",
                            text: "Error al editar al usuario, informalo al administrador y/o desarrollador",
                            type: "error",
                            showCancelButton: false,
                            showConfirmButton: true
                        });
                    }
                }
            });
        }, function(dismiss) {
          if (dismiss === 'cancel') {
            swal({
                title: "",
                text: "No se edito al usuario",
                type: "error",
                showCancelButton: false,
                showConfirmButton: true
            });
          }
        });
        event.preventDefault();
    });
    
</script>
<?php }} ?>
<script>
    $(".cierre_modal").click(function(){
       window.location.reload(true); 
    });
</script>