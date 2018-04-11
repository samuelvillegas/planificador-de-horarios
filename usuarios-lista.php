<?php include_once "header.php";
include_once 'app/escuela.php';

if(isset($_POST['actualizar_usuario'])){

  $usuario = new Usuarios();
  $usuario->nombre = $_POST['nombre'];
  $usuario->apellido = $_POST['apellido'];
  $usuario->telefono = $_POST['telefono'];
  $usuario->direccion = $_POST['direccion'];
  $usuario->dni = $_POST['cedula'];
  $usuario->correo = $_POST['correo'];
  $usuario->usuario = $_POST['old_usuario'];
  $usuario->clave = $_POST['clave'];
  $usuario->perfiles = $_POST['perfil'];

  opendir(IMG_USER);
  $destino = IMG_USER.$_FILES['imagen']['name'];
  if(file_exists($_FILES['imagen']['tmp_name'])){
      try{
          copy($_FILES['imagen']['tmp_name'], $destino);
          $usuario->imagen = $destino;
      }catch (Exception $e){

      }
  }
    $actualizar_usuario = $usuario->actualizarUsuario(Conexion::obtenerConexion(), $_POST['usuario']) ;
}

$usuario = new Usuarios();

$lista_usuarios = $usuario->obtenerUsuarios(Conexion::obtenerConexion());

?>
  <div class="main-content container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3>Lista de Usuarios</h3>
          </div>
          <div class="row">
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
              <?php

            // $perfiles_bd = Escuela::obtenerPerfiles(Conexion::obtenerConexion());
            // foreach ($perfiles_bd as $perfil_bd) {
            //   echo '<option value="'. $perfil_bd['id'] .'">'.$perfil_bd['nombre'].'</option>';
            //  }
            ?>
            </select>
          </div>

        </div>-->
            <!--<button class="btn btn-primary print-button"><span class="mdi mdi-print"></span> Imprimir</button>-->

          </div>
          <div class="panel-body">
            <table id="table3" class="table table-striped table-hover table-fw-widget results sortable">
              <thead>
              <tr>
                <th>Foto</th>
                <th>Nombre y apellido</th>
                <th>Usuario</th>
                <th>Perfil</th>
                <th>Correo</th>
                <th class="actions"></th>
              </tr>
              </thead>
              <tbody>
              <?php
              foreach ($lista_usuarios as $usuario_item) : ?>

                <tr>
                  <td class="user-avatar">
                    <img src="<?php echo $usuario_item['imagen']; ?>">
                  </td>
                  <td><?php echo $usuario_item['nombre'] . " " . $usuario_item['apellido']; ?></td>
                  <td><?php echo $usuario_item['usuario']; ?></td>
                  <td class="comma-space"> <?php
                    foreach ($usuario_item['perfiles'] as $perfil_item) {
                      echo "<span>".$perfil_item['nombre']."</span>";
                    }
                    ?></td>
                  <td><?php echo $usuario_item['correo']; ?></td>
                  <td class="actions">
                    <div class="dropdown">
                      <button data-toggle="dropdown" role="button" aria-expanded="false" class="hidden-print btn btn-default dropdown-toggle">Opciones  <span class="caret"></span>
                      </button>
                      <ul role="menu" class="dropdown-menu">
                        <li>
                          <a href="#" data-modal="usuario-detalles" data-val="<?php echo $usuario_item['usuario'] ?>" class="md-trigger ver-usuario">
                            <span class="icon mdi mdi-file-plus"></span>Ver detalles
                          </a>
                        </li>
                        <li>
                          <a href="#" data-modal="usuario-modificar"  data-val="<?php echo $usuario_item['usuario']; ?>" class="md-trigger modificar-usuario">
                            <span class="icon mdi mdi-edit"></span> Modificar
                          </a>
                        </li>
                        
                      </ul>
                    </div>
                  </td>
                </tr>

              <?php endforeach; ?>
              <tr class="no-result">
                <td colspan="5">
                  <div role="alert" class="alert alert-warning alert-icon alert-icon-border alert-dismissible">
                    <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                    <div class="message">
                      <strong>Ups!</strong> No se han encontrado resultados.
                    </div>
                  </div></td>
              </tr>
              </tbody>
            </table>
          </div>

        </div>
      </div>
    </div>

    <div id="usuario-detalles" class="modal-container colored-header colored-header-primary modal-effect-10">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
          <h3 class="modal-title">

          </h3>
        </div>
        <div class="modal-body">

        </div>
        <div class="modal-footer">
          <!--<button type="button" data-dismiss="modal" class="btn btn-default modal-close print-button">Imprimir</button>-->
          <button type="submit" data-dismiss="modal" class="btn btn-primary modal-close">Aceptar</button>
        </div>
      </div>
    </div>

    <div id="usuario-modificar" class="modal-container colored-header colored-header-primary modal-effect-10 full-width">
      <div class="modal-content">
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" id="modificar_usuario">
          <div class="panel-body modal-body">
              <h4>Datos personales</h4>
              <div class="form-horizontal">
                  <div class="col-md-6">
                      <div class="form-group">
                          <label class="col-sm-3 control-label" for="nombre">Nombres</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" required="" data-parsley-pattern="/^[a-zñÑáéíóúÁÉÍÓÚ ]*$/i"
                                     data-parsley-error-message="No es válido, sólo datos alfabéticos" name="nombre" id="nombre" value="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label" for="apellido">Apellido</label>
                          <div class="col-sm-6">
                              <input type="text" class="form-control" required=""
                                     data-parsley-error-message="No es válido, sólo datos alfabéticos"
                                     data-parsley-pattern="/^[a-zñÑáéíóúÁÉÍÓÚ ]*$/i" name="apellido" id="apellido" value="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label" for="cedula">Cédula</label>
                          <div class="col-sm-6">
                              <input type="hidden" id="hidden_id">
                              <input type="number" class="form-control" required="" data-parsley-type="digits" name="cedula" id="cedula" value="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label">Teléfono</label>
                          <div class="col-sm-6">
                              <input type="text" data-mask="phone"  required="" data-parsley-minlength="7"
                                     placeholder="(999) 999-9999" class="form-control" name="telefono" id="telefono" value="">
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="col-sm-3 control-label" for="direccion">Dirección</label>
                          <div class="col-sm-6">
                              <textarea  class="form-control" name="direccion" id="direccion" ></textarea>
                          </div>
                      </div>
                      <div class="form-group">
                          <label class="control-label col-sm-3">Foto</label>
                          <div class="col-sm-6">
                              <label for="file" class="btn-lg btn btn-warning">Cambiar foto <span class="mdi mdi-image"></span></label>
                              <input type="file" id="file" class="file" name="imagen" style="display: none;" data-parsley-filemaxmegabytes="5" data-parsley-trigger="change" data-parsley-filemimetypes="image/jpeg, image/png">
                              <input type="text" name="" class="filename" value="" id="imagen">
                              <hr><img src="" id="img_usuario" style="max-height: 75px;">
                          </div>
                          <div class="col-sm-10 col-sm-offset-3">
                              <small>Max 5 MB. Solo archivos JPG y PNG</small>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-6">
                      <div class="panel-border-color-warning panel-border-color">
                          <h4>Datos de la cuenta</h4>
                          <div class="form-group">
                              <label class="col-sm-3 control-label" for="correo">Correo electrónico</label>
                              <div class="col-sm-6">
                                  <input type="email"  data-parsley-type="email" class="form-control" name="correo" id="correo">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-3 control-label" for="usuario">Usuario</label>
                              <div class="col-sm-6">
                                  <input  type="text" class="form-control" required=""
                                          data-parsley-type="alphanum" name="usuario" id="usuario" value=":usuario:">
                                  <input type="hidden" id="hidden_name">
                                  <input type="hidden" name="old_usuario" id="old_usuario">
                              </div>
                          </div>
                          <div class="form-group">
                              <h5>Nueva contraseña</h5>
                          </div>
                          <div class="form-group">

                              <div class="col-sm-6">
                                  <input type="password" class="form-control"  name="clave" id="clave">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="col-sm-3 control-label" for="perfil">Perfil*</label>
                              <div class="col-sm-6">
                                  <select multiple="" required="" class="select2 form-control" id="perfil" name="perfil[]" data-parsley-errors-container="#error-perfil-container">
                                      <option value="0">--</option>
                                      <?php

                                      $perfiles_bd = Escuela::obtenerPerfiles(Conexion::obtenerConexion());
                                      foreach ($perfiles_bd as $perfil_bd) {
                                          echo '<option value="'. $perfil_bd['id'] .'" data-nombre="'.$perfil_bd['nombre'].'">'.$perfil_bd['nombre'].'</option>';
                                      }
                                      ?>
                                  </select>
                                  <div id="error-perfil-container"></div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="reset" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
            <button type="submit" name="actualizar_usuario" class="btn btn-primary ">Guardar</button>
          </div>
        </form>
      </div>
    </div>

    <div id="test-delete" class="modal-container modal-effect-1">
      <div style="max-width: 500px;" class="modal-content">
        <div class="modal-header">
          <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
        </div>
        <div class="modal-body" style="overflow-y: hidden;">
          <div class="text-center">
            <div class="text-danger"><span class="modal-main-icon mdi mdi-delete"></span></div>
            <h3>Eliminar usuario</h3>
            <p>Se eliminará el usuario : <b>John Doe</b></p>
            <p>¿Continuar?</p>
            <div class="xs-mt-50">
              <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-default btn-space modal-close">Cancelar</button>
              <button type="button" name="" class="btn btn-danger btn-space">Aceptar</button>
            </div>
          </div>
        </div>
        <div class="modal-footer"></div>
      </div>
    </div>

    <div class="modal-overlay"></div>
  </div>

<?php
$modal = true;
$form_elements = true;
$form_mask = true;
$form_id = "#modificar_usuario";

include_once "scripts.php";
if(isset($actualizar_usuario)){
    if( $actualizar_usuario == true && $actualizar_usuario == 1){
        echo "<script>successMsj('Se han actualizado correctamente el usuario <b>$usuario->usuario</b>');</script>";
    } else{
        echo '<script>errorMsj("Ha ocurrido un erro al actualizar el usuario");</script>';
    }
}
include_once "footer.php";
?>