<?php include_once "header.php";
include_once "app/materias.php";
include_once 'app/grados.php';

if(isset($_POST['actualizar_materia'])){

    $materias = new Materias();
    $materias->nombre = $_POST['old_name'];
    $materias->descripcion = "";
    $materias->grados = $_POST['id_grado'];
    $materias->horas = $_POST['id_hora'];
    $docentes = $_POST['docentes'];

    $insertar_materia = $materias->actualizarMateria(Conexion::obtenerConexion(), $_POST['materia-nombre']);
    $materias->asignarDocentes(Conexion::obtenerConexion(), $docentes);


}

$lista_materias = Materias::obtenerMaterias(Conexion::obtenerConexion());
$lista_grados = Grados::obtenerGradosActivos(Conexion::obtenerConexion());
$lista_docentes = Usuarios::obtenerDocentes(Conexion::obtenerConexion());


?>

    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Lista de materias
                        <div class="tools">

                        </div>
                        <div class="row">
                            <div class="col-sm-5 col-sm-offset-1">
                                <label class="col-sm-5 text-right">Buscar:</label>
                                <div class="col-sm-7" >
                                    <input type="text" class="form-control search input-xs">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-hover results">
                            <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Grados</th>
                                <th class="actions"></th>
                            </tr>
                            </thead>
                            <tbody id="tbody-subjects">
                            <?php $n=1; foreach ($lista_materias as $materia_item) : ?>
                                <tr>
                                    <td  class="data-subject" data-subject="<?php echo $materia_item['id_materia']; ?>" ><?php echo $n; ?></td>
                                    <td><?php echo $materia_item['nombre']; ?></td>
                                    <td class="comma-space">
                                        <?php
                                        foreach ($materia_item['grados'] as $grado) {
                                            echo "<span>". $grado['grado'] ."</span>";
                                        }
                                        ?>
                                    </td>
                                    <td class="actions">
                                        <div class="dropdown">
                                            <button data-toggle="dropdown" role="button" aria-expanded="false" class="btn btn-default dropdown-toggle">Opciones  <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="#" data-modal="subject-detalles" class="md-trigger ver_detalles_materia" data-materia="<?php echo $materia_item['id_materia']; ?>"><span class="icon mdi mdi-file-plus"></span>Ver detalles</a></li>
                                                <li><a href="#" data-modal="subject-modificar" class="modificar_detalles_materia md-trigger" data-materia="<?php echo $materia_item['id_materia']; ?>"><span class="icon mdi mdi-edit"></span> Modificar</a></li>
                                                
                                            </ul>
                                        </div>

                                    </td>
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
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="subject-detalles" class="modal-container colored-header colored-header-primary modal-effect-10">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
                <h3 class="modal-title materia-nombre"></h3>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-10 col-md-offset-1">
                        <h3>Nombre: <b class="materia-nombre"></b></h3>
                    </div>
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width:37%;">Año escolar</th>
                                <th>Cant. Horas</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-materias-horas">

                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-10 col-md-offset-1">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th style="width:37%;">Docentes</th>
                            </tr>
                            </thead>
                            <tbody id="tbody-docentes">

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <!--<button type="button" data-dismiss="modal" class="btn btn-default modal-close">Imprimir</button>-->
                <button type="submit" data-dismiss="modal" class="btn btn-primary modal-close">Aceptar</button>
            </div>
        </div>
    </div>
    <div id="subject-modificar" class="modal-container colored-header colored-header-primary modal-effect-10">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
                <h3 class="modal-title">Modificar materia</h3>
            </div>
            <form id="actualizar_materia" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="materia-nombre" class="col-sm-3 control-label">Nombre de la materia*</label>
                            <div class="col-sm-7">
                                <input type="hidden" name="old_name" id="old_name">
                                <input type="hidden" id="hidden_materia">
                                <input type="text" class="form-control" name="materia-nombre" data-parsley-maxlength="45" required="" id="materia-nombre" data-parsley-pattern="/^[a-zñáéíóúÁÉÍÓÚÑ0-9 ]*$/i" >
                            </div>
                        </div>
                        <!--<div class="form-group">
                          <label class="col-sm-3 control-label">Descripcion</label>
                          <div class="col-sm-6">
                            <textarea class="form-control" data-parsley-maxlength="130" name="materia-descripcion"></textarea>
                          </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Grado / Año escolar*</label>
                            <div class="col-sm-9 col-sm-offset-3">
                                <label for="">Seleccione los años escolares de la materia y las horas académicas</label>
                                <?php

                                foreach ( $lista_grados as $grado) : ?>

                                    <div class="be-checkbox row">
                                        <div class="col-xs-4">
                                            <input id="<?php echo $grado['id_grado'] ?>_id" class="grado_check" data-parsley-errors-container="#error-container1"
                                                   data-parsley-multiple="grados"
                                                   data-parsley-mincheck="1" required="" name="id_grado[<?php echo $grado['id_grado']-1; ?>]" type="checkbox" value="<?php echo $grado['id_grado'] ?>">
                                            <label for="<?php echo $grado['id_grado'] ?>_id"><?php echo $grado['numero'] ?></label>
                                        </div>

                                        <div class="col-xs-5">

                                            <label for="" class="col-xs-4 control-label">Horas:</label>
                                            <div class="col-xs-10">
                                                <input type="number" data-parsley-error-message="Requerido"  name="id_hora[<?php echo $grado['id_grado']-1; ?>]" class="form-control hora_check input-xs">

                                            </div>

                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <div id="error-container1"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="docente_materia">Docentes*</label>
                            <div class="col-sm-7">
                                <select multiple="" required=""  data-parsley-errors-container="#error-2" id="docente_materia" class="select2 form-control" name="docentes[]">
                                    <option value="0">--</option>
                                    <?php foreach ($lista_docentes as $docente ) :
                                        echo "<option value='" .$docente['id_persona']."'>".$docente['nombre'] . " " . $docente['apellido']."</option>";
                                    endforeach; ?>
                                </select>

                                <div id="error-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <button type="button" class="btn btn-default modal-close">Cancelar</button>
                    <button type="submit" class="btn btn-primary" name="actualizar_materia">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <div id="subject-delete" class="modal-container modal-effect-1">
        <div style="width: 500px;" class="modal-content">
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
                        <button type="submit" data-subject="" id="delete-subject-button" class="btn btn-danger btn-space">Aceptar</button>
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
$form_id = "#actualizar_materia";

include_once "scripts.php";
if(isset($insertar_materia)){
    if( $insertar_materia == true){
        echo "<script>successMsj('Se ha actualizado correctamente la materia <b>$materias->nombre</b>');</script>";
    } else{
        echo '<script>errorMsj("Ha ocurrido un erro al actualizar la materia");</script>';
    }
}
include_once "footer.php";
?>