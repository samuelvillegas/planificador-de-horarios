<?php
include_once "header.php";
include_once "app/escuela.php";
include_once "app/usuarios.php";
$escuela = new Escuela();
$datos_escuela = $escuela->obtenerDatosEscuela(Conexion::obtenerConexion());

$lista_docentes = Usuarios::obtenerDocentesDetalles(Conexion::obtenerConexion());
?>
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-full-color panel-full-primary" style="padding: 30px;">
                    <div class="row">
                        <div class="col-sm-3 ">
                            <img src="<?php echo $datos_escuela['imagen']; ?>" class="img-responsive img-thumbnail" alt="">
                        </div>
                        <div class="col-sm-5">
                            <h2><?php echo $datos_escuela['nombre'] ?></h2>
                            <h4><?php echo $datos_escuela['rif'] ?></h4>
                            <h4><?php echo $datos_escuela['direccion'] ?></h4>
                        </div>
                        <div class="col-sm-4">
                            <h4><a style="color: white" href="mailto:<?php echo $datos_escuela['correo'] ?>"><?php echo $datos_escuela['correo'] ?></a></h4>
                            <h4><?php echo $datos_escuela['telefono'] ?></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="tools"></div>
                        <div class="title">Horarios de las secciones</div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-striped table-borderless">
                            <thead>
                            <tr>
                                <?php
                                if( Escuela::esAdminstrador($_SESSION['perfiles'])  ) :
                                    ?>
                                    <th>Año escolar o grado</th>
                                    <th class="number">Sección</th>
                                    <th>Estado del horario</th>
                                    <th  class="actions"></th>
                                <?php else: ?>
                                    <th>Año escolar o grado</th>
                                    <th class="text-center">Sección</th>
                                    <th>Materia</th>
                                    <th  class="actions">Ver horario</th>
                                <?php endif; ?>
                            </tr>
                            </thead>
                            <tbody class="no-border-x">
                            <?php
                            if( Escuela::esAdminstrador($_SESSION['perfiles'])  ) :
                                $datos_secciones = Escuela::obenterSeccionesYHorarios(Conexion::obtenerConexion());
                                foreach ($datos_secciones as $seccion ):
                                    ?>

                                    <tr>
                                        <td><?php echo $seccion['grado_nombre'] ?></td>
                                        <td class="text-center"><?php echo $seccion['seccion'] ?></td>
                                        <?php
                                        if(isset($seccion['estado']['estado'])):
                                            if( $seccion['estado']['estado'] == "Listo"):
                                                ?>
                                                <td class="text-success">Listo</td>
                                                <td class="actions">
                                                    <a href="horarios-vista.php?grado=<?php echo $seccion['id_grado'] ?>&seccion=<?php echo $seccion['seccion'] ?>" data-toggle="tooltip" data-placement="left" title="Ver horario" class="icon"><i class="mdi mdi-eye"></i></a>
                                                </td>
                                            <?php else: if($seccion['estado']['estado'] == "Incompleto"):?>
                                                <td class="text-warning">Incompleto</td>
                                                <td class="actions">
                                                    <a href="horarios-vista.php?grado=<?php echo $seccion['id_grado'] ?>&seccion=<?php echo $seccion['seccion'] ?>" data-toggle="tooltip" data-placement="left" title="Ver horario" class="icon"><i class="mdi mdi-eye"></i></a>
                                                    <a href="horarios-modificar.php?grado=<?php echo $seccion['id_grado'] ?>&seccion=<?php echo $seccion['seccion'] ?>" data-toggle="tooltip" data-placement="left" title="Modificar horario" class="icon"><i class="mdi mdi-edit"></i></a>
                                                </td>
                                            <?php    endif;
                                            endif;
                                        else: ?>
                                            <td class="text-danger">No tiene horario</td>
                                            <td class="actions"><a href="horarios-construir.php" data-toggle="tooltip" data-placement="left" title="Crear horario" class="icon"><i class="mdi mdi-plus-circle-o"></i></a></td>

                                            <?php
                                        endif; ?>

                                    </tr>

                                <?php endforeach; ?>

                            <?php else:
                                $datos_secciones = Escuela::obenterSeccionesYHorariosDocente(Conexion::obtenerConexion(), $_SESSION['id_datos']);
                                foreach ($datos_secciones as $seccion ):
                                    ?>

                                    <tr>
                                        <td><?php echo $seccion['numero'] ?></td>
                                        <td class="text-center"><?php echo $seccion['numero_nombre'] ?></td>
                                        <td><?php echo $seccion['nombre'] ?></td>
                                        <td class="actions">
                                            <a href="horarios-vista.php?grado=<?php echo $seccion['id_grado'] ?>&seccion=<?php echo $seccion['numero_nombre'] ?>" data-toggle="tooltip" data-placement="left" title="Ver horario" class="icon"><i class="mdi mdi-eye"></i></a>
                                        </td>
                                    </tr>

                                <?php endforeach;
                            endif;
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">
                        <div class="title">Docentes</div>
                    </div>
                    <div class="panel-body table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th >Nombre</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($lista_docentes as $docente):
                                ?>
                                <tr>
                                    <td class="user-avatar">
                                        <img src="<?php echo $docente['imagen'] ?>" alt="">
                                        <?php echo $docente['nombre'] . " " . $docente['apellido'] ?>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Cronograma de Actividades</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                </div>
            </div>
        </div>
    </div>





<?php include_once "scripts.php";
include_once "footer.php"; ?>