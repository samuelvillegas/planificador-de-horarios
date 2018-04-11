<?php

/**
 *
 */
class Horarios {

    public $id;

    public $seccion;

    public $rutina ;

    public $estado;

    function __construct($id = "") {
        $this->id = $id;
    }
    public function obtenerIdPorSeccion($conexion){
        $sql = "SELECT horario.id_horario FROM horario WHERE id_seccion = {$this->seccion}";
        $retornoID = $conexion->query($sql);
        $id_horario = "";
        while($fila=mysqli_fetch_array($retornoID)){
            $id_horario = $fila['id_horario'];
        }

        $this->id = $id_horario;
        return $id_horario;
    }
    public function obtenerHorarioPorId($conexion){
        $sql ="SELECT * FROM horario WHERE id_horario = {$this->id}";

        $buscarHorario = $conexion->query($sql);

        while ($fila = mysqli_fetch_assoc($buscarHorario)){
            $this->estado = $fila['estado'];
            $this->seccion = $fila['id_seccion'];
        }
    }
    public function ingresarHorario($conexion){
        $insertar_horario = false;
        if($conexion != null){
            $sql = "INSERT INTO horario VALUES (null, '$this->seccion', '$this->estado')";
            $insertar_horario = $conexion->query($sql);


            $sql = "SELECT id_horario FROM horario WHERE id_seccion = '$this->seccion'";

            $retornoID = $conexion->query($sql);
            $id_horario = "";
            while($fila=mysqli_fetch_array($retornoID)){
                $id_horario = $fila['id_horario'];
            }

            $this->id = $id_horario;
            $this->ingresarRutinas($conexion);
        }



        return $insertar_horario;
    }

    public function ingresarRutinas($conexion){

        foreach ($this->rutina as $rutina) {

            $sql = "INSERT INTO rutina VALUES
           (null, {$rutina->materia}, {$rutina->docente}, {$rutina->aula}, 
           {$rutina->hora_inicio}, {$rutina->hora_fin}, {$rutina->dia}, 
           {$this->id},'{$rutina->color}')";

            $insertarRutina = $conexion->query($sql);
        }
    }

    public function actualizarHorarioRutinas($conexion){

        $actualizar_horario = false;
        if($conexion != null){
                $sql = "UPDATE horario SET estado = '{$this->estado}'";
            $conexion->query($sql);

            foreach ($this->rutina as $rutina) {

                if(isset($rutina->id_rutina)){

                    if($rutina->modificar == 2){
                        //var_dump($rutina); echo "<hr>";
                        $sql = "DELETE FROM rutina WHERE id_rutina = {$rutina->id_rutina}";
                        $conexion->query($sql);
                    }else{
                        $sql = "UPDATE rutina SET color = '{$rutina->color}', id_materia = {$rutina->id_materia}, {$rutina->id_persona}, 
                        id_aula = {$rutina->id_aula}, id_hora_inicio = {$rutina->hora_inicio}, id_hora_fin = {$rutina->hora_fin},
                         dia = {$rutina->dia} WHERE id_horario = {$this->id}";

                        $actualizar_horario = $conexion->query($sql);
                    }

                }else{
                    $sql = "INSERT INTO rutina VALUES
           (null, {$rutina->materia}, {$rutina->docente}, {$rutina->aula}, 
           {$rutina->hora_inicio}, {$rutina->hora_fin}, {$rutina->dia}, 
           {$this->id},'{$rutina->color}')";

                    $insertarRutina = $conexion->query($sql);
                }

            }

        }



        return $actualizar_horario;

    }
    public static function obtenerHorarios($conexion){

        $lista_horarios = array();

        if(isset($conexion) && $conexion != null){
            $sql = "SELECT horario.id_horario,horario.estado, seccion.numero_nombre as seccion, grado.numero as grado, grado.id_grado
                FROM horario INNER JOIN seccion ON horario.id_seccion = seccion.id_seccion
                INNER JOIN grado ON seccion.id_grado = grado.id_grado";

            $buscarHorarios  = $conexion->query($sql);

            while($fila = mysqli_fetch_assoc($buscarHorarios)){
                $lista_horarios[] = $fila;
            }
        }
        return $lista_horarios;
    }

    public static function obtenerHorariosDocente($conexion, $id_docente){

        $lista_horarios = array();

        if(isset($conexion) && $conexion != null){
            $sql = "SELECT horario.id_horario,horario.estado, seccion.numero_nombre as seccion, grado.numero as grado, grado.id_grado
                FROM horario INNER JOIN seccion ON horario.id_seccion = seccion.id_seccion
                INNER JOIN grado ON seccion.id_grado = grado.id_grado
                 INNER JOIN rutina ON horario.id_horario = rutina.id_horario
                 WHERE rutina.id_persona = {$id_docente}";

            $buscarHorarios  = $conexion->query($sql);

            while($fila = mysqli_fetch_assoc($buscarHorarios)){
                $lista_horarios[] = $fila;
            }
        }
        return $lista_horarios;
    }

    public function obtenerRutinas($conexion){
        //$sql = "SELECT * FROM rutina WHERE id_horario = {$this->id}";

        $sql = "SELECT `rutina`.`id_rutina`, rutina.id_materia, rutina.id_persona, rutina.id_aula,
                rutina.id_hora_inicio AS hora_inicio, rutina.id_hora_fin AS hora_fin, rutina.dia, rutina.id_horario, 
                rutina.color, seccion.numero_nombre AS seccion_nombre, grado.numero AS grado_numero,grado.id_grado AS grado,
                materia.nombre AS materia_nombre, CONCAT(persona.nombre, ' ', persona.apellido) AS docente, 
                aula.numero AS aula_numero, horario.estado FROM rutina 
                INNER JOIN horario ON rutina.id_horario = horario.id_horario
                INNER JOIN seccion ON horario.id_seccion = seccion.id_seccion
                INNER JOIN grado ON seccion.id_grado = grado.id_grado
                INNER JOIN aula ON rutina.id_aula = aula.id_aula
                INNER JOIN persona ON persona.id_persona = rutina.id_persona
                INNER JOIN materia ON rutina.id_materia = materia.id_materia
                WHERE rutina.id_horario = {$this->id}";
        $buscarRutinas = $conexion->query($sql);
        $i = 0;
        while($fila = mysqli_fetch_assoc($buscarRutinas)){
            $this->rutina[$i] = $fila;
            if($fila['id_materia'] == 999){
                $this->rutina[$i]['data'] = "receso_".$fila['id_materia'] . $fila['hora_fin'] . $fila['hora_inicio'];

            }else{
                $this->rutina[$i]['data'] = $fila['id_materia']."_" . $fila['grado'];

            }
            $this->rutina[$i]['modificar'] = 1;
            $i++;
        }

    }

    public static function buscarDisponibilidad($conexion, $docente, $aula, $hora_inicio, $hora_fin, $dia, $where = ""){
        $disponible = array("disp_docente" => 1, "disp_aula" => 1);

        $sql = "SELECT id_rutina FROM `rutina` 
                WHERE id_persona = {$docente} 
                AND ( (id_hora_inicio >= {$hora_inicio} AND id_hora_fin > {$hora_inicio} ) OR (id_hora_inicio > {$hora_fin} AND id_hora_fin <= {$hora_fin} ) )
                AND dia = '{$dia}' {$where}";


        $buscarDocente = $conexion->query($sql);
        if($buscarDocente != false){
            if($buscarDocente->num_rows > 0){
                $disponible['disp_docente'] = 0;
            }
        }


        $sql= "SELECT id_rutina FROM `rutina` WHERE id_aula = {$aula}
                AND ( (id_hora_inicio >= {$hora_inicio} AND id_hora_fin > {$hora_inicio} ) OR (id_hora_inicio > {$hora_fin} AND id_hora_fin <= {$hora_fin} ) )
                AND dia = '{$dia} {$where}'";

        $buscarAula = $conexion->query($sql);
    if($buscarAula != false){
        if($buscarAula->num_rows > 0){
            $disponible['disp_aula'] = 0;
        }
    }


        return $disponible;
    }
}
