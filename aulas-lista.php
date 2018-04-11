<?php
include_once "header.php";
include_once "app/aulas.php";

if(isset($_POST['actualizar_aula'])){
    $aula = new Aula();
    $aula->numero = $_POST['old_number'];
    $aula->id = $aula->buscarAulaPorNumero(Conexion::obtenerConexion());
    $aula->numero = $_POST['m_nombre_aula'];
    $aula->capacidad = $_POST['m_capacidad_aula'];
    $aula->tipo = $_POST['m_tipo_aula'];
    $actualizar_aula = $aula->actualizarAula(Conexion::obtenerConexion());
}
    $lista_aulas = Aula::obtenerAulas(Conexion::obtenerConexion());

?>

    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3>Lista de Aulas</h3>
                        <div class="tools"></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 col-sm-offset-1">
                            <label class="col-sm-4 text-right">Buscar:</label>
                            <div class="col-sm-8" >
                                <input type="text" class="form-control search input-xs">
                            </div>
                        </div>
                        <!--<div class="col-sm-4">
                            <label class="col-sm-5 text-right">Ver tipo:</label>
                            <div class="col-sm-7">
                                <select class="form-control input-xs">
                                    <option value="0">Todos</option>
                                    <option value="General">General</option>
                                    <option value="Laboratorio">Laboratorio</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>

                        </div>-->
                        <div class="col-sm-2 col-md-offset-5">
                            <button data-modal="crear-aula" class="btn btn-primary btn-lg md-trigger btn-space"><span class="mdi mdi-plus-circle"></span> Añadir aula</button>
                            <!--<button class="btn btn-primary print-button2 btn-space"><span class="mdi mdi-print"></span> Imprimir</button>-->

                        </div>

                    </div>
                    <div class="panel-body">
                        <table id="lista-aulas" class="sortable table table-striped table-hover table-fw-widget results">
                            <thead>
                            <tr>
                                <th>id</th>
                                <th>Nombre</th>
                                <th>Capacidad</th>
                                <th>Tipo</th>
                                <th class="actions"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $n = 1; foreach ($lista_aulas as $aula_item): ?>
                                <tr class="">
                                    <td><?php echo $n ?></td>
                                    <td><?php echo $aula_item['numero'] ?></td>
                                    <td><?php echo $aula_item['capacidad'] ?></td>
                                    <td><?php echo $aula_item['tipo'] ?></td>
                                    <td class="actions">
                                        <div class="dropdown">
                                            <button data-toggle="dropdown" role="button" aria-expanded="false" class="btn btn-default dropdown-toggle">Opciones  <span class="caret"></span></button>
                                            <ul role="menu" class="dropdown-menu">
                                                <li><a href="#" data-modal="aula-modificar" data-aula="<?php echo $aula_item['numero'] ?>" class="modificar_aula md-trigger"><span class="icon mdi mdi-edit"></span> Modificar</a></li>
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

        <div id="crear-aula" class="modal-container modal-effect-1">
            <form action="" method="post" id="registrar_aula">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Añadir aula</h3>
                        <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label for="nombre-aula" class="col-sm-3 control-label">Nombre o número del aula</label>
                                <div class="col-sm-6">
                                    <input type="text" id="nombre-aula" name="nombre-aula" required="" data-parsley-pattern="/^[a-zñáéíóúÁÉÍÓÚÑ0-9- ]*$/i" data-parsley-error-message="Sólo caracteres alfanuméricos" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label" for="capacidad-aula">Capacidad</label>
                                <div class="col-sm-6">
                                    <input type="number" id="capacidad-aula" name="capacidad-aula"  required="" class="form-control" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Tipo</label>
                                <div class="col-sm-6">
                                    <select required="" id="tipo-aula" name="tipo-aula" class="form-control">
                                        <option value="General">General</option>
                                        <option value="Laboratorio">Laboratorio</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div id="aula-loading-registrar" class="text-center" style="display: none;"><span class="text-center text-primary mdi spin mdi-spinner" style="font-size: 5rem;"></span></div>
                        <div class="text-right">
                            <div class="xs-mt-50">
                                <button type="button" data-dismiss="modal" class="modal-close btn btn-default btn-space">Cancelar</button>
                                <button type="submit" id="submit-registrar-aula" class="btn btn-primary btn-space">Guardar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </div>
        <div id="aula-modificar" class="modal-container colored-header colored-header-primary modal-effect-10">
            <div class="modal-content">
                <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                    <div class="modal-header">
                    <h3>Modificar aula</h3>
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
                </div>
                    <div class="modal-body">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="m_nombre_aula">Nombre o número del aula</label>
                            <div class="col-sm-6">
                                <input type="hidden" value="" id="m_h_nombre" name="old_number">
                                <input type="text" id="m_nombre_aula" name="m_nombre_aula" required=""
                                       data-parsley-pattern="/^[a-zñáéíóúÁÉÍÓÚÑ0-9- ]*$/i"
                                       data-parsley-error-message="Sólo caracteres alfanuméricos" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="m_capacidad_aula">Capacidad</label>
                            <div class="col-sm-6">
                                <input type="number" id="m_capacidad_aula" name="m_capacidad_aula"  required="" class="form-control" value="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label" for="m_tipo_aula">Tipo</label>
                            <div class="col-sm-6">
                                <select required="" id="m_tipo_aula" name="m_tipo_aula" class="form-control">
                                    <option value="General">General</option>
                                    <option value="Laboratorio">Laboratorio</option>
                                    <option value="Otro">Otro</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <div class="xs-mt-50">
                            <button type="reset" data-dismiss="modal" class="modal-close btn btn-default btn-space">Cancelar</button>
                            <button type="submit" class="btn btn-primary btn-space" name="actualizar_aula">Guardar</button>
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>

        <div id="aula-delete" class="modal-container modal-effect-1">
            <div style="" class="modal-content">
                <div class="modal-header">
                    <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
                </div>
                <div class="modal-body" style="overflow-y: hidden;">
                    <div class="text-center">
                        <div class="text-danger"><span class="modal-main-icon mdi mdi-delete"></span></div>
                        <h3>Eliminar aula</h3>
                        <p>Se eliminará el aula : <b>F-00</b></p>
                        <p>¿Continuar?</p>
                        <div class="xs-mt-50">
                            <button type="button" data-dismiss="modal" class="modal-close btn btn-default btn-space">Cancelar</button>
                            <button type="submit" data-dismiss="modal" class="modal-close btn btn-danger btn-space">Aceptar</button>
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
$form_masks = true;

include_once "scripts.php";
if(isset($actualizar_aula)){
    if( $actualizar_aula != false || $actualizar_aula != null){
        echo "<script>successMsj('Se han actualizado correctamente el aula <b>$aula->numero</b>');</script>";
    } else{
        echo '<script>errorMsj("Ha ocurrido un error al actualizar el aula");</script>';
    }
}
?>
    <script>
        var myTH = document.getElementsByTagName("th")[1];
        sorttable.innerSortFunction.apply(myTH, []);
    </script>
<?php

include_once "footer.php";
?>