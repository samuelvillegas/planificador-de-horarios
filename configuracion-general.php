<?php  include_once "header.php";
include_once "app/grados.php";
include_once "app/escuela.php";



if(isset($_POST['activar_grados'])){
    $actualizar_grados = Grados::activarGrados($_POST['tipo'], Conexion::obtenerConexion());
}

if(isset($_POST['configuracion_escuela'])){

    $escuela = new Escuela();
    $escuela->nombre = $_POST['nombre'];
    $escuela->direccion = $_POST['direccion'];
    $escuela->rif = $_POST['rif'];
    $escuela->telefono = $_POST['telefono'];
    $escuela->correo = $_POST['correo'];

    opendir(IMG_USER);

    if(isset($_FILES['file']) && $_FILES['file'] != null && !empty($_FILES['file']) && $_FILES['file']['size'] != 0){
        $destino = IMG_USER.$_FILES['file']['name'];
        try{
            copy($_FILES['file']['tmp_name'], $destino);
            $escuela->logo = $destino;
        }catch (Exception $e){

        }
    }else{
        $escuela->logo = $_POST['old_image'];
    }

    $actualizar_escuela_datos = $escuela->actualizarEscuela(Conexion::obtenerConexion());

}
$escuela = new Escuela();
$data_escuela = $escuela->obtenerDatosEscuela(Conexion::obtenerConexion());
$grados_activos = Grados::obtenerArrayGradosActivos(Conexion::obtenerConexion());
?>

    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="panel">
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>" enctype="multipart/form-data" id="modificar_escuela">
                    <div class="panel-heading">
                        Datos de la escuela
                    </div>
                    <div class="panel-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="nombre" class="col-sm-3 control-label">Nombre</label>
                                <div class="col-sm-8">
                                    <input type="text" id="nombre" name="nombre" required=""
                                           data-parsley-pattern="/^[a-zñÑáéíóúÁÉÍÓÚ ]*$/i"
                                           data-parsley-error-message="No es válido, sólo datos alfabéticos"
                                           class="form-control" value="<?php echo $data_escuela['nombre'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="direccion" class="col-sm-3 control-label">Dirección</label>
                                <div class="col-sm-8">
                                    <textarea id="direccion" name="direccion" class="form-control"><?php echo $data_escuela['direccion'] ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="rif" class="col-sm-3 control-label">Rif</label>
                                <div class="col-sm-8">
                                    <input id="rif" name="rif"  required="" data-parsley-type="alphanum" type="text" class="form-control" value="<?php echo $data_escuela['rif'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Teléfono</label>
                                <div class="col-sm-8">
                                    <input type="text" data-mask="phone"  required="" data-parsley-minlength="7" name="telefono"
                                           placeholder="(999) 999-9999" class="form-control" value="<?php echo $data_escuela['telefono'] ?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="correo" class="col-sm-3 control-label">Correo electrónico</label>
                                <div class="col-sm-8">
                                    <input type="email" id="correo" name="correo" class="form-control" value="<?php echo $data_escuela['correo'] ?>">
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="logo_name" class="control-label col-sm-3">Logo</label>
                                <div class="col-sm-8">
                                    <input type="hidden" value="<?php echo $data_escuela['imagen'] ?>" name="old_image">
                                    <label for="file" class="btn-lg btn btn-warning">Ingrese una foto <span class="mdi mdi-image"></span></label>
                                    <input type="file" id="file" class="file" style="display: none;"  name="file" data-parsley-filemaxmegabytes="5" data-parsley-trigger="change" data-parsley-filemimetypes="image/jpeg, image/png">
                                    <input id="logo_name" type="text" name="" class="filename">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button class="btn btn-primary" type="submit" name="configuracion_escuela">Guardar</button>
                    </div>
                    </form>
                </div>
            </div>


            <div class="col-md-6">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                    <div class="panel">
                        <div class="panel-heading">
                            Ajustes generales
                        </div>

                        <div class="panel-body">
                            <div class="form-horizontal">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Añadir grados</label>
                                    <div class="col-sm-6">
                                        <div class="be-checkbox">
                                            <input type="checkbox" name="tipo[grado]" value="1"
                                                <?php
                                                    if($grados_activos['grado'] == true){
                                                        echo " checked";
                                                    }
                                                ?> id="rad3">
                                            <label for="rad3">Primaria</label>
                                        </div>
                                        <div class="be-checkbox">
                                            <input type="checkbox" name="tipo[year_first]" value="1" <?php
                                            if($grados_activos['year_first'] == true){
                                                echo " checked";
                                            }
                                            ?>  id="rad2">
                                            <label for="rad2">Desde 1° año hasta 3° año</label>
                                        </div>
                                        <div class="be-checkbox">
                                            <input type="checkbox" name="tipo[year_second]" value="1"
                                                <?php
                                                if($grados_activos['year_second'] == true){
                                                    echo " checked";
                                                }
                                                ?>  id="rad4">
                                            <label for="rad4">4° - 5° año</label>
                                        </div>
                                    </div>
                                </div>
                                <!--<div class="form-group">
                                    <label class="col-sm-8 control-label">Añadir lista de materias por defecto</label>
                                    <div class="col-sm-3">
                                        <div class="switch-button">
                                            <input type="checkbox" checked="" name="swt3" id="swt3">
                                            <span><label for="swt3"></label></span>
                                        </div>
                                    </div>
                                </div>-->
                            </div>

                        </div>
                        <div class="panel-footer">
                            <button class="btn btn-primary" type="submit" name="activar_grados">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>


<?php
$form_elements = true;
$form_mask = true;

include_once "scripts.php";

if(isset($_POST['activar_grados'])):

    if(isset($actualizar_grados) && $actualizar_grados == true):
        ?>
        <script>
            successMsj("Se han guardado los cambios de los grados correctamente.");
        </script>
        <?php
    else: ?>
        <script>
            successMsj("No se han podido guardar los cambios.");
        </script>

        <?php
    endif;
endif;

if(isset($_POST['configuracion_escuela'])):

    if(isset($actualizar_escuela_datos) && $actualizar_escuela_datos == true):
        ?>
        <script>
            successMsj("Se han guardado los cambios de la escuela correctamente.");
        </script>
        <?php
    else: ?>
        <script>
            errorMsj("No se han podido guardar los cambios.");
        </script>

        <?php
    endif;
endif;
include_once "footer.php"; ?>