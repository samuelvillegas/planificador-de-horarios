<?php
if(isset($_GET['grado']) && isset($_GET['seccion'])){

$page_title = "Construir horario";
include_once "header.php";
include_once "app/materias.php";
include_once 'app/grados.php';
include_once 'app/horarios.php';
include_once 'app/aulas.php';


    $grado = new Grados($_GET['grado']);
    $datos_grado = $grado->obtenerGradoPorId(Conexion::obtenerConexion());
    $horario = new Horarios();
    $horario->seccion = Grados::obtenerIdSeccion(Conexion::obtenerConexion(), $_REQUEST['seccion'], $_REQUEST['grado']);
    $horario->id =  $horario->obtenerIdPorSeccion(Conexion::obtenerConexion());
    $horario->obtenerHorarioPorId(Conexion::obtenerConexion());
    $seccion_numero = $_GET['seccion'];

    $grado = new Grados($_GET['grado']);
    $lista_materias = $grado->obtenerMaterias(Conexion::obtenerConexion());

    $lista_aulas = Aula::obtenerAulas(Conexion::obtenerConexion());


}else{
    $seccion_numero = "";
    header("Location:index.php");
    $datos_grado = array(
        "numero" => 'Grado'
    );
}


?> 

<div class="main-content container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="display-inline-block">Modificar horario de:
                        <b> <?php echo $datos_grado['numero']; ?> </b> Sección:
                        <b><?php echo $seccion_numero?></b></h3>

                </div>
                <div class="panel-body panel-body-contrast panel-padding">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="grado-construir" class="control-label">Grado</label>
                            <select id="grado-construir" disabled name="grado-construir" class="form-control">
                                <option value="999" selected><?php echo $datos_grado['numero']; ?></option>
                            </select>
                            
                            <label for="seccion-construir" class="control-label">Sección</label>
                            <div class="input-group xs-mb-15">
                                <select id="seccion-construir" disabled name="seccion-construir" class="form-control">
                                    <option value="999" ><?php echo $seccion_numero?></option>
                                </select>
                                <span class="input-group-btn">
                                    <button disabled data-toggle="modal" data-target="#mod-primary" type="button" class="btn btn-primary">Crear sección</button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7" id="settings-section">
                        <div class="row centrar-vertical">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="materia-construir" class="control-label">Materia</label>
                                    <select name="materia-construir" id="materia-construir" class="form-control input-sm" >
                                        <option value="">--</option>
                                        <optgroup label="Actividades">
                                            <option value="999"><b>Marcar como receso</b></option>
                                        </optgroup>
                                        <optgroup label="Materias">
                                           <?php
                                            foreach ($lista_materias as $materia){
                                                echo '<option value="'. $materia['id'] .'" data-horas="'. $materia['horas'] .'">'. $materia['materia'] .'</option>';
                                            }
                                           ?>
                                        </optgroup>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    <label for="docente-construir" class="control-label">Docente</label>
                                    <select id="docente-construir" name="docente-construir" class="form-control input-sm" >
                                        <option value="0">--</option>
                                        <option value="">Debe seleccionar una materia primero</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4  col-sm-6">
                                <div class="form-group">
                                    <label for="aula-construir" class="control-label">Aula</label>
                                    <select id="aula-construir" name="aula-construir" class="form-control input-sm" >
                                        <option value="0">--</option>
                                        <?php
                                        foreach($lista_aulas as $aula){
                                            echo '<option value="'. $aula['id_aula'] .'">'. $aula['numero'] .'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4  col-sm-6">
                                <div class="form-group">
                                    <label for="dia-construir" class="control-label">Día de la semana:</label>
                                    <select id="dia-construir" name="dia-construir" class="form-control input-sm" >
                                        <option value="0">--</option>
                                        <option value="1">Lunes</option>
                                        <option value="2">Martes</option>
                                        <option value="3">Miércoles</option>
                                        <option value="4">Jueves</option>
                                        <option value="5">Viernes</option>
                                        <option value="6">Sábado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3  col-sm-6">
                                <div class="form-group">
                                    <label for="hora-inicio-construir" class="control-label">Hora de inicio:</label>
                                    <select id="hora-inicio-construir" name="hora-inicio-construir" class="form-control input-sm" >
                                        <option value="0">--</option>
                                        <option value="1"  id="hora_1">7:00</option>
                                        <option value="2"  id="hora_2">7:40</option>
                                        <option value="4"  id="hora_3">8:25</option>
                                        <option value="5"  id="hora_4">9:05</option>
                                        <option value="7"  id="hora_5">9:50</option>
                                        <option value="8"  id="hora_6">10:30</option>
                                        <option value="9"  id="hora_7">11:10</option>
                                        <option value="10"  id="hora_8">11:50</option>
                                        <option value="11"  id="hora_9">12:30</option>
                                        <option value="12"  id="hora_10">1:10</option>
                                        <option value="13"  id="hora_11">1:50</option>
                                        <option value="14"  id="hora_12">2:30</option>
                                        <option value="15"  id="hora_13">3:10</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3  col-sm-6">
                                <div class="form-group">
                                    <label for="hora-fin-construir" class="control-label">Hora de salida:</label>
                                    <select id="hora-fin-construir" name="hora-fin-construir" class="form-control input-sm" >
                                        <option value="0" >--</option>
                                        <option value="2" >7:40</option>
                                        <option value="3" >8:20</option>
                                        <option value="5" >9:05</option>
                                        <option value="6" >9:45</option>
                                        <option value="8" >10:30</option>
                                        <option value="9" >11:10</option>
                                        <option value="10" >11:50</option>
                                        <option value="11" >12:30</option>
                                        <option value="12">1:10</option>
                                        <option value="13">1:50</option>
                                        <option value="14">2:30</option>
                                        <option value="15">3:10</option>
                                        <option value="16">4:00</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2  col-sm-12 text-center">
                                <span class="input-group-btn">
                                    <button id="add-routine" type="button" class="btn btn-primary">Añadir</button>
                                </span>
                            </div>
                        </div>
                    </div>

                </div>


                <div class="panel-body">
                    <table class="table table-striped table-hover table-bordered table-responsive table-lighter" style="margin-bottom: 40px;">
                        <thead>
                            <tr>
                                <th style="width: 100px">Sección</th>
                                <th style="text-align: center;">Docente</th>
                                <th style=" text-align: center;">Materia</th>
                                <th class="actions" style="width: 100px">Retirar</th>
                            </tr>
                        </thead>
                        <tbody id="general-view-table">
                            <!--<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td class="actions"><span class="mdi mdi-delete text-danger" style="cursor: pointer;font-size: 24px;"></span></td>
                            </tr>-->
                        </tbody>
                    </table>
                </div>

                <!--  Horario  -->
                <div class="panel-body">
                    <table class="table table-striped table-hover table-bordered table-lighter" id="tabla-constructor">
                        <thead id="head-constructor">
                        <tr>
                            <th style="width: 100px">Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sábado</th>
                        </tr>
                        </thead>
                        <tbody style="text-align: center;" id="body-constructor">
                        <tr data-hora-inicio="1" data-hora-fin="2">
                            <td>7:00 - 7:40</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="2" data-hora-fin="3">
                            <td>7:40 - 8:20</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="4" data-hora-fin="5">
                            <td>8:25 - 9:05</td>
                            <td  data-dia="1"  > </td>
                            <td  data-dia="2"  > </td>
                            <td  data-dia="3"  > </td>
                            <td  data-dia="4"  > </td>
                            <td  data-dia="5"  > </td>
                            <td  data-dia="6"  > </td>
                        </tr>
                        <tr  data-hora-inicio="5" data-hora-fin="6">
                            <td>9:05 - 9:45</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="7" data-hora-fin="8">
                            <td>9:50 - 10:30</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="8" data-hora-fin="9">
                            <td>10:30 - 11:10</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="9" data-hora-fin="10">
                            <td>11:10 - 11:50</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="10" data-hora-fin="11">
                            <td>11:50 - 12:30</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="11" data-hora-fin="12">
                            <td>12:30 - 1:10</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="12" data-hora-fin="13">
                            <td>1:10 - 1:50</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="13" data-hora-fin="14">
                            <td>1:50 - 2:30</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="14" data-hora-fin="15">
                            <td>2:30 - 3:10</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>
                        <tr  data-hora-inicio="15" data-hora-fin="16">
                            <td>3:10 - 4:00</td>
                            <td data-dia="1" > </td>
                            <td data-dia="2" > </td>
                            <td data-dia="3" > </td>
                            <td data-dia="4" > </td>
                            <td data-dia="5" > </td>
                            <td data-dia="6" > </td>
                        </tr>

                        </tbody>
                    </table>
                </div>

                <div class="panel-footer" style="background: #fff">

                    <button  id="actualizar_horario" type="button" class="btn btn-space btn-primary btn-lg" >Actualizar Horario como listo</button>
                    <button  id="actualizar_horario_2" type="button" class="btn btn-space btn-warning btn-lg" >Actualizar como borrador</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- modal horarioguardado -->
<div id="horarioguardado-modal" tabindex="-1" role="dialog" class="modal fade in" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
            </div>
            <div class="modal-body" style="overflow: hidden;">
                <div class="text-center">
                    <div class="text-primary"><span class="modal-main-icon mdi mdi-info-outline"></span></div>
                    <h3>¡Muy bien!</h3>
                    <p>Su horario ha sido creado con exito.</p>
                </div>
            </div>
            <div class="modal-footer"></div>
        </div>
    </div>
</div>
<!-- modal Seccion -->
<div id="mod-primary" tabindex="-1" role="dialog" class="modal fade" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <div class="text-primary"><span class="modal-main-icon mdi mdi-info-outline"></span></div>
                    <h3>Crear Sección</h3><div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Nombre:</label>
                            <div class="col-sm-6" style="
                            display: inline-block;
                            ">
                            <input type="text" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="crear-grado-construir" class="col-sm-3 control-label">Grado</label>
                        <div class="col-sm-6">
                            <select id="crear-grado-construir" name="crear-grado-construir" class="form-control">
                                <option value="0">--</option>
                                <option value="1">1 Año</option>
                                <option value="2">2 Año</option>
                                <option value="3">3 Año</option>
                                <option value="4">4 Año</option>
                                <option value="5">5 Año</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn  btn-default">Cancel</button>
                    <button type="button" data-dismiss="modal" class="btn btn-space btn-primary">Proceder</button>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<?php

$modal = true;
$form_elements = true;
include_once "scripts.php";?>
    <script>
        $(document).ready(function(){
            var grado = getParameterByName('grado');
            var seccion = getParameterByName('seccion');
            construirHorarioModificar(grado, seccion);

        });
    </script>
<?php include_once "footer.php"; ?>