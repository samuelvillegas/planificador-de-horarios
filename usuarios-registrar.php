<?php 
include_once 'app/config.php';
include_once 'app/conexion.php';
include_once "header.php"; 
include_once 'app/escuela.php';  
Conexion::abrirConexion();

if(isset($_POST['guardar_usuario'])){

  $usuario = new Usuarios();
  $usuario->nombre = $_POST['nombre'];
  $usuario->apellido = $_POST['apellido'];
  $usuario->telefono = $_POST['telefono'];
  $usuario->direccion = $_POST['direccion'];
  $usuario->dni = $_POST['cedula'];
  $usuario->correo = $_POST['correo'];
  $usuario->usuario = $_POST['usuario'];
  $usuario->clave = $_POST['clave'];
  $usuario->perfiles = $_POST['perfil'];
  opendir(IMG_USER);
  $destino = IMG_USER.$_FILES['file']['name'];
  try{
      copy($_FILES['file']['tmp_name'], $destino);
        $usuario->imagen = $destino;
  }catch (Exception $e){

  }


  $insertar_usuario = $usuario->ingresarUsuario(Conexion::obtenerConexion());
}
?>
<div class="main-content container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>Registrar Usuario</h3>
        </div>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" id="registrar_usuario">
          <div class="panel-body">
            <h4>Datos personales</h4>
            <div class="form-horizontal">
              <div class="form-group">
                <label class="col-sm-3 control-label" for="name">Nombre*</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" required="" data-parsley-maxlength="45" data-parsley-pattern="/^[a-zñÑáéíóúÁÉÍÓÚ ]*$/i" data-parsley-error-message="No es válido, sólo datos alfabéticos, no pueder mayor a %s caracteres" name="nombre" id="nombre">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="apellido">Apellido*</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" required="" data-parsley-maxlength="45" data-parsley-error-message="No es válido, sólo datos alfabéticos, no pueder mayor a %s caracteres" data-parsley-pattern="/^[a-zñÑáéíóúÁÉÍÓÚ ]*$/i" name="apellido" id="apellido">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="cedula">Cédula*</label>
                <div class="col-sm-6">
                   <input type="hidden" id="hidden_id">
                  <input type="number" class="form-control" required="" data-parsley-type="digits" name="cedula" id="cedula">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="telefono">Teléfono*</label>
                <div class="col-sm-6">
                  <input type="text" data-mask="phone"  required="" data-parsley-minlength="7" placeholder="(999) 999-9999" class="form-control" name="telefono" id="telefono">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="correo">Correo electrónico</label>
                <div class="col-sm-6">
                  <input type="email"  data-parsley-type="email" class="form-control" name="correo" id="correo">
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label" for="direccion">Dirección</label>
                <div class="col-sm-6">
                  <textarea class="form-control" name="direccion" id="direccion"></textarea>
                </div>
              </div>
              <div class="form-group">

                <label class="control-label col-sm-3" for="file">Foto</label>

                <div class="col-sm-6">
                  <label for="file" class="btn-lg btn btn-warning col-sm-4">Foto de perfil <span class="mdi mdi-image"></span></label>
                  <div class="col-sm-8">
                     <input type="file" id="file" class="file" name="file" style="display: none;" required  data-parsley-filemaxmegabytes="5" data-parsley-trigger="change" data-parsley-filemimetypes="image/jpeg, image/png">
                      <input type="text" name="" class="filename form-control">
                  </div>
                </div>
                <div class="col-sm-10 col-sm-offset-3">
                  <small>Max 5 MB. Solo archivos JPG y PNG</small>
                </div>

              </div>
              <div class="panel-border-color-warning panel-border-color">
                <h4>Datos de la cuenta</h4>
                <div class="form-group">

                  <label class="col-sm-3 control-label" for="usuario">Usuario*</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" required="" data-parsley-type="alphanum" name="usuario" id="usuario">
                      <input type="hidden" id="hidden_name">
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-3 control-label" for="clave">Contraseña provisional*</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" required=""  name="clave" id="clave">
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
                        echo '<option value="'. $perfil_bd['id'] .'">'.$perfil_bd['nombre'].'</option>';
                      }
                      ?>
                    </select>
 <div id="error-perfil-container"></div>
                  </div>
                </div>
               
              </div>

            </div>
          </div>
          <div class="panel-footer">
            <button type="reset" class="btn btn-default">Cancelar</button>
            <button type="submit" name="guardar_usuario" class="btn btn-primary modal-close">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div id="crear-perfil" class="modal-container colored-header colored-header-warning modal-effect-10">
   <div class="modal-content">
    <div class="modal-header">
     <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
     <h3 class="modal-title">Crear perfil</h3>
   </div>
   <div class="modal-body">
     <form class="form-horizontal">
       <div class="form-group">
        <label class="col-sm-3 control-label">Nombre</label>
        <div class="col-sm-6">
          <input type="text" class="form-control" placeholder="Nombre del cargo o perfil">
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Descripcion</label>
        <div class="col-sm-6">
          <textarea class="form-control"></textarea>
        </div>
      </div>
      <div class="form-group">
        <label class="col-sm-3 control-label">Departamento</label>
        <div class="col-sm-6">
          <select multiple="" class="select2">
            <option value="AK">Coordinacion de año</option>
            <option value="HI">Comisión de horario</option>
            <option value="HI">Docentes</option>
          </select>

        </div>
      </div>
    </form>

  </div>
  <div class="modal-footer">
   <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
   <button type="submit" data-dismiss="modal" class="btn btn-primary modal-close">Guardar</button>
 </div>
</div>
</div>

</div>
<?php 
$modal = true;
$form_elements = true;
$form_mask = true;
$form_id = "#registrar_usuario";

include_once "scripts.php";

if(isset($insertar_usuario)){
    if( $insertar_usuario == true){
        echo "<script>successMsj('Se han registrado correctamente el usuario <b>$usuario->usuario</b>');</script>";
    } else{
        echo '<script>errorMsj("Ha ocurrido un erro al registrar el usuario");</script>';
    }
}

include_once "footer.php";
?>