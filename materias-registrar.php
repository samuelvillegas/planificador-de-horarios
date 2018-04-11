<?php include_once "header.php";

include_once 'app/grados.php'; 
include_once 'app/usuarios.php';
include_once 'app/materias.php';
$lista_grados = Grados::obtenerGradosActivos(Conexion::obtenerConexion());
$lista_docentes = Usuarios::obtenerDocentes(Conexion::obtenerConexion());


if(isset($_POST['guardar_materia'])){

  $materias = new Materias();
  $materias->nombre = $_POST['materia-nombre'];
  $materias->descripcion = "";
  $materias->grados = $_POST['id_grado'];
  $materias->horas = $_POST['id_hora'];
  $docentes = $_POST['docentes'];

  $insertar_materia = $materias->ingresarMateria(Conexion::obtenerConexion());
  $materias->asignarDocentes(Conexion::obtenerConexion(), $docentes);
  


}

?>
<div class="main-content container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3>Registrar materia</h3>
        </div>
        <form id="registrar_materia" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
          <div class="panel-body">
            <div class="form-horizontal">
             <div class="form-group">
              <label for="materia-nombre" class="col-sm-3 control-label">Nombre de la materia*</label>
              <div class="col-sm-6">
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
              <label class="col-sm-3 control-label">Grado / Año escolar*</label>
              <div class="col-sm-6">
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
                    <div class="col-xs-8">
                      <input type="number" data-parsley-error-message="Requerido"  name="id_hora[<?php echo $grado['id_grado']-1; ?>]" class="form-control hora_check input-xs">

                    </div>

                  </div>
                </div>
              <?php endforeach; ?>
              <div id="error-container1"></div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-3 control-label">Docentes*</label>
            <div class="col-sm-6">
              <select multiple="" required=""  data-parsley-errors-container="#error-2" class="select2" name="docentes[]">
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
        <button type="submit" class="btn btn-primary modal-close" name="guardar_materia">Guardar</button>
      </div>
    </form>
  </div>
</div>
</div>
</div>




<?php 

$form_elements = true;
$form_id = "#registrar_materia";



include_once "scripts.php";
if(isset($insertar_materia)){
  if( $insertar_materia != false){
    echo "<script>successMsj('Se ha ingresado correctamente la materia <b>$materias->nombre</b>');</script>";
  } else{
    echo '<script>errorMsj("Ha ocurrido un erro al registrar la materia");</script>';
  }
}
include_once "footer.php";

?>