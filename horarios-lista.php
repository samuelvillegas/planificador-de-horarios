  <?php 

  include_once 'app/horarios.php';
  include_once "header.php";
  if( Escuela::esAdminstrador($_SESSION['perfiles']) ){
      $lista_horarios = Horarios::obtenerHorarios(Conexion::obtenerConexion());
  }else{
      $lista_horarios = Horarios::obtenerHorariosDocente(Conexion::obtenerConexion(), $_SESSION['id_datos']);
  }

  ?>
  <div class="main-content container-fluid">
    <div class="panel" id="tabla-horarios">
      <div class="panel-heading" >
        <h3>Lista de horarios</h3>
      </div>
      
        <div class="row" style="margin-bottom: 20px;">
          <div class="col-sm-5 col-sm-offset-1">
            <label class="col-sm-5 text-right">Buscar:</label>
            <div class="col-sm-7" >
             <input type="text" class="form-control search input-xs">
           </div>
         </div>
         <!--<div class="col-sm-4">
           <label class="col-sm-5 text-right">Ver perfil:</label>
           <div class="col-sm-7" >
             <select class="form-control input-xs">
              <option value="0">Todos</option>
              
            </select>
          </div>

        </div>-->

        <div class="col-sm-6 text-center">
            <button class="btn btn-primary btn-space print-button2" data-print="#tabla-horarios"><span class="mdi mdi-print"></span> Imprimir</button>
        </div>
      </div>
<div class="panel-body">


        <!--<form>
          <div class="row paddingadd">
            <div class="col-md-4 col-md-offset-2">
                <label class="col-sm-5 text-right">Mostrar por:</label>
              <div class="col-sm-7" >
               <select class="form-control ">
                <option>Año</option>
                <option>Grado</option>
                <option>Sección</option>

              </select>
            </div>
            </div>
            <div class="col-md-4">
            <div class="input-group">
                <input type="text" class="form-control" id="myInput" onkeyup="BrowserHorarios()"  placeholder="Buscar por..">
                <div class="input-group-btn">
                  <button class="btn btn-default" type="submit">
                    <i class="glyphicon glyphicon-search"></i>
                  </button>
                </div>

              </div>
              
          </div>
        </div>
      </form>-->

      <table class="table table-striped table-hover results" id="myTable" style="table-layout: fixed">
        <tr class="header">
          <th>N</th>
          <th>Grado</th>
          <th>Sección</th>
            <th>Estado</th>
          <th class="actions"></th>
        </tr>
          <?php
          $n = 1;

            foreach($lista_horarios as $horario):?>
                <tr>
                    <td><?php echo $n ?></td>
                    <td><?php echo $horario['grado'] ?></td>
                    <td><?php echo $horario['seccion'] ?></td>
                    <?php

                    if($horario['estado'] == "Listo"){
                        echo '<td class="text-success"><b>'. $horario['estado'] .'</b></td>';
                    }else{
                        echo '<td class="text-warning"><b>'. $horario['estado'] .'</b></td>';

                    }

                    ?>
                    <?php if( in_array("Administrador",$_SESSION['perfiles']) ): ?>

                        <td class="actions">
                            <div class="dropdown">
                                <button data-toggle="dropdown" role="button" aria-expanded="false" class="btn btn-default dropdown-toggle">Opciones  <span class="caret"></span></button>
                                <ul role="menu" class="dropdown-menu">
                                    <li><a href="horarios-vista.php?grado=<?php echo $horario['id_grado'] ?>&seccion=<?php echo $horario['seccion'] ?>"  class="md-trigger"><span class="icon mdi mdi-file-plus"></span>Ver detalles</a></li>
                                    <li><a href="horarios-modificar.php?grado=<?php echo $horario['id_grado'] ?>&seccion=<?php echo $horario['seccion'] ?>" data-modal="subject-modificar" class="md-trigger"><span class="icon mdi mdi-edit"></span> Modificar</a></li>
                                    
                                </ul>
                            </div>

                        </td>
                    <?php else: ?>
                        <td><a class="btn btn-default dropdown-toggle"  href="horarios-vista.php?grado=<?php echo $horario['id_grado'] ?>&seccion=<?php echo $horario['seccion'] ?>"><span class="icon mdi mdi-file-plus"></span>Ver detalles</td>
                    <?php endif; ?>

                </tr>
            <?php $n++; endforeach; ?>
        <tr class="no-result">
          <td colspan="5">
            <div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
              <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
              <div class="message">
               <strong>Ups!</strong> No se han encontrado resultados.
             </div>
           </div></td>
         </tr>
      </table> 



<div id="subject-delete" class="modal-container modal-effect-1">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
    </div>
    <div class="modal-body" style="overflow-y: hidden;">
      <div class="text-center">
        <div class="text-danger"><span class="modal-main-icon mdi mdi-delete"></span></div>
        <h3>Eliminar materia</h3>
        <p>Se eliminará la materia : <b>Nombre de la materia</b></p>
        <p>¿Continuar?</p>
        <div class="xs-mt-50">
          <button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Cancelar</button>
          <button type="submit" data-dismiss="modal" data-subject="" id="delete-subject-button" class="btn btn-danger btn-space modal-close">Aceptar</button>
        </div>
      </div>
    </div>
    <div class="modal-footer"></div>
  </div>
</div>
<div class="modal-overlay"></div>


      <?php 
      $modal = true;
      $form_elements = true;

  include_once "scripts.php";
  include_once "footer.php";
      ?>