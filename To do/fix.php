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
                <input type="text" name="" class="filename" value="">
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
                </div>
            </div>
            <div class="be-checkbox">
                <input id="new_pass" type="checkbox">
                <label for="new_pass">Nueva contraseña</label>
            </div>
            <div class="form-group">
                <label class="col-sm-3 control-label" for="clave"> Nueva contraseña</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control"  name="clave" id="clave">
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