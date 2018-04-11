<?php

if(isset($_GET['grado']) && isset($_GET['seccion'])){
$page_title = "Ver horario | Proyecto A+";
include_once "header.php";
include_once "app/materias.php";
include_once 'app/grados.php';
include_once 'app/horarios.php';


    $grado = new Grados($_GET['grado']);
    $datos_grado = $grado->obtenerGradoPorId(Conexion::obtenerConexion());
    $horario = new Horarios();
    $horario->seccion = Grados::obtenerIdSeccion(Conexion::obtenerConexion(), $_REQUEST['seccion'], $_REQUEST['grado']);
    $horario->id =  $horario->obtenerIdPorSeccion(Conexion::obtenerConexion());
    $horario->obtenerHorarioPorId(Conexion::obtenerConexion());
}else{
    header("index.php");
    $datos_grado = array(
            "numero" => 'Grado'
    );
}

//$lista_grados = Grados::obtenerGradosActivos(Conexion::obtenerConexion());

?> 

<div class="main-content container-fluid">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-default panel-table">
                <div class="panel-heading">
                    <h3 class="display-inline-block">Grado: <?php echo $datos_grado['numero']; ?></h3>
                    <?php
                        if(isset($horario)){

                            if($horario->estado == "Listo"){
                                echo '<h3 class="pull-right text-success display-inline-block">'. $horario->estado .'</h3>';
                            }else{
                                echo '<h3 class="pull-right text-warning display-inline-block">'. $horario->estado .'</h3>';

                            }


                        }
                    ?>
                </div>


                <div class="panel-body">
                    <table class="table table-striped table-hover table-bordered table-responsive table-lighter" style="margin-bottom: 40px;">
                        <thead>
                            <tr>
                                <th style="width: 100px">Sección</th>
                                <th style="text-align: center;">Docente</th>
                                <th style=" text-align: center;">Materia</th>
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

                    <button  type="button" class="btn btn-space btn-primary btn-lg print-button" ><span class="mdi mdi-print"></span> Imprimir</button>
                    <?php
                    if(isset($horario)){

                        if($horario->estado == "Incompleto"){
                            echo ' <a class="btn btn-space btn-warning btn-lg" href="horarios-modificar.php?grado='.$_GET['grado'].'&seccion='.$_GET['seccion'].'" >Modificar</a>';
                        }


                    }
                    ?>
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
            construirHorario(grado, seccion);

        });
    </script>
<?php include_once "footer.php"; ?>