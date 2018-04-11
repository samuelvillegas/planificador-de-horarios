<?php

class Materias{

	public $id;

	public $nombre;

	public $descripcion;

	public $grados_horas;

	public $grados;

	public $horas;

	public function ingresarMateria($conexion) {

		$insertar_materia = false;
		
		if(isset($conexion)){

			$sql = "INSERT INTO materia VALUES (null, '$this->nombre', '$this->descripcion')";
			$insertar_materia = $conexion->query($sql);

			$sql = "SELECT id_materia FROM materia WHERE nombre = '$this->nombre'";

			$retornoID = $conexion->query($sql);

			while($fila=mysqli_fetch_array($retornoID)){
				$id_materia = $fila['id_materia'];
			}
			
			$this->unirGradosHoras($this->grados, $this->horas);
			$this->id = $id_materia;
			foreach ($this->grados_horas as $grado_hora) {
				$grado_tmp = $grado_hora['grado'];
				$hora_tmp = $grado_hora['horas'];
				$sql_i = "INSERT INTO grado_materia_horas VALUES ('$grado_tmp','$this->id', '$hora_tmp')";

				$conexion->query($sql_i);
				# code...
			}
			
		}
		return $insertar_materia;
	}

    public function actualizarMateria($conexion, $nuevo_nombre) {

        $actualizar_materia = false;

        if(isset($conexion)){
            $this->id = $this->obtenerIdPorNombre($conexion);

            $sql = "UPDATE materia SET nombre = '{$nuevo_nombre}' WHERE id_materia = {$this->id}";

            $this->nombre = $nuevo_nombre;

            $actualizar_nombre = $conexion->query($sql);

            $this->unirGradosHoras($this->grados, $this->horas);

            $sql_j = "DELETE  FROM grado_materia_horas WHERE id_materia = {$this->id}";
            $actualizar_horas = $conexion->query($sql_j);
            foreach ($this->grados_horas as $grado_hora) {
                $grado_tmp = $grado_hora['grado'];
                $hora_tmp = $grado_hora['horas'];
                $sql_i = "INSERT INTO grado_materia_horas VALUES ('$grado_tmp','$this->id', '$hora_tmp')";
                $actualizar_horas = $conexion->query($sql_i);
            }
            $sql = "DELETE FROM persona_materia WHERE id_materia = {$this->id}";
            $buscarEliminar = $conexion->query($sql);

            if($actualizar_nombre != false && $actualizar_horas != false && $buscarEliminar != false){
                $actualizar_materia = true;
            }

        }
        return $actualizar_materia;
    }

    public function obtenerIdPorNombre($conexion){
	    $sql = "SELECT id_materia FROM materia WHERE nombre = '{$this->nombre}'";

	    $buscarId = $conexion->query($sql);

	    while ($fila = mysqli_fetch_assoc($buscarId)){
	        $this->id = $fila['id_materia'];

        }

        return $this->id;
    }
	public function unirGradosHoras($grados, $horas){

		for ($i = 0 ; $i < count($horas) ; $i++) {
			if(isset($grados[$i])){
				$this->grados_horas[] = array('grado' => $grados[$i],
					'horas' => $horas[$i]);	
			}
			

		}
	}

	public function asignarDocentes($conexion, $docentes){
		foreach ($docentes as $docente) {
			$sql = "INSERT INTO persona_materia VALUES ('$docente', '$this->id')";
			$conexion->query($sql);
		}
	}

	public function buscarDocentes($conexion){
		$sql = "SELECT persona.id_persona, persona.nombre, persona.apellido FROM persona "
		. "INNER JOIN persona_materia ON persona.id_persona = persona_materia.id_persona "
		. "INNER JOIN materia ON persona_materia.id_materia = materia.id_materia "
		. "WHERE materia.id_materia = $this->id";

		
		$buscarDocentes = $conexion->query($sql);
		$i = 0;
		while($fila = mysqli_fetch_assoc($buscarDocentes)){
			$docentes[$i]['id'] = $fila['id_persona'];               
			$docentes[$i]['nombre'] = $fila['nombre'] . " " . $fila['apellido'];
			$i++;
		}

		return $docentes;
	}


	public static function obtenerMaterias($conexion, $limit = null, $offset = null){

		if($limit != null){
			$limit = " LIMIT $limit";
		}

		if($offset != null){
			$offset = " OFFSET $offset";
		}

		$sql = "SELECT * FROM materia $limit $offset WHERE id_materia != 999 ORDER BY nombre";

		$buscarMaterias = $conexion->query($sql);

		$i = 0;
		$lista_materias = array();
		while($fila=mysqli_fetch_assoc($buscarMaterias)){
			$sql_grados = "SELECT grado.numero as grado, grado_materia_horas.hora as horas FROM grado
			INNER JOIN grado_materia_horas ON grado.id_grado = grado_materia_horas.id_grado
			INNER JOIN materia ON grado_materia_horas.id_materia = materia.id_materia WHERE materia.id_materia = " . $fila['id_materia'];

			$buscarGrados = $conexion->query($sql_grados);

			$lista_materias[$i] = $fila;

			while ($fila_grado = mysqli_fetch_assoc($buscarGrados)) {
				$lista_materias[$i]['grados'][] = $fila_grado;

			}

			$i++;
		}
		return $lista_materias;
	}

	public function materiaExiste($conexion){
		$sql = "SELECT id_materia FROM materia WHERE nombre LIKE '" . $this->nombre ."'";
		$buscarMateria = $conexion->query($sql);

		if($buscarMateria->num_rows > 0){
			$materia = 1;
		}else{
			$materia = 0;
		}

		return $materia;

	}
	public static function obtenerMateriasPorGrado($conexion, $id_grado){
	    $sql = "SELECT * FROM materia INNER JOIN grado_materia_horas ON materia.id_materia = grado_materia_horas.id_materia WHERE grado_materia_horas = " . $id_grado;

	    $buscarMaterias = $conexion->query($sql);
	    $lista_materias = array();
	    while ($fila = mysqli_fetch_assoc($buscarMaterias)){
	        $lista_materias[] = $fila;
        }

        return $lista_materias;
    }

    public function obtenerDetallesMateria($conexion){
	    /*
	     SELECT materia.*, CONCAT(persona.nombre, ' ', persona.apellido) AS docente, grado.id_grado, grado_materia_horas.hora,
	    grado.numero FROM materia INNER JOIN persona_materia ON materia.id_materia = persona_materia.id_materia
	    INNER JOIN persona ON persona_materia.id_persona = persona.id_persona
	    INNER JOIN grado_materia_horas ON materia.id_materia = grado_materia_horas.id_materia INNER JOIN grado ON grado_materia_horas.id_grado = grado.id_grado WHERE materia.id_materia = 1
	     */
	    $sql = "SELECT * FROM materia WHERE id_materia = {$this->id}";

	    $buscarMateria = $conexion->query($sql);

	    while ($fila = mysqli_fetch_assoc($buscarMateria)){
	        $datos_materia['id_materia'] = $fila['id_materia'];
	        $datos_materia['nombre'] = $fila['nombre'];
        }

        $sql = "SELECT CONCAT(persona.nombre, ' ', persona.apellido) AS docente, persona.imagen, persona.id_persona 
                FROM materia JOIN persona_materia ON materia.id_materia = persona_materia.id_materia
	            INNER JOIN persona ON persona_materia.id_persona = persona.id_persona WHERE materia.id_materia = {$this->id}";

        $buscarMateria = $conexion->query($sql);

        while ($fila = mysqli_fetch_assoc($buscarMateria)){
            $datos_materia['docentes'][] = $fila;

        }

        $sql = "SELECT grado.id_grado, grado_materia_horas.hora, grado.numero FROM materia
                INNER JOIN grado_materia_horas ON materia.id_materia = grado_materia_horas.id_materia 
                INNER JOIN grado ON grado_materia_horas.id_grado = grado.id_grado  WHERE materia.id_materia = {$this->id}";
        $buscarMateria = $conexion->query($sql);
        while ($fila = mysqli_fetch_assoc($buscarMateria)){
            $datos_materia['grados'][] = $fila;
        }

        return $datos_materia;
    }
}