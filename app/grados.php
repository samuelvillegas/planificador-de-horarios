<?php
/**
 *
 */
class Grados
{
	public $id;

	public $numero;

	public $estado;

	function __construct($id_grado = null) {
		$this->id = $id_grado;
	}

	public function obtenerGradoPorId($conexion){
        $sql = "SELECT * FROM grado WHERE id_grado = {$this->id}";
        $buscarGrado = $conexion->query($sql);
        $datos_grado= array();
        while($fila = mysqli_fetch_assoc($buscarGrado)){
            $datos_grado = $fila;
        }
        return $datos_grado;
	}
	public static function obtenerGradosActivos($conexion){
		$sql = "SELECT * FROM grado WHERE estado = 'activo'";

		$buscarGrados = $conexion->query($sql);
		$grados_lista = array();
		while ($fila = mysqli_fetch_assoc($buscarGrados)) {
			$grados_lista[] = $fila;
		}

		return $grados_lista;
	}

	public function obtenerSecciones($conexion){
		$sql = "SELECT seccion.id_seccion, seccion.numero_nombre FROM seccion 
			INNER JOIN grado ON seccion.id_grado = grado.id_grado WHERE grado.id_grado = '$this->id' ";

		$buscarSecciones = $conexion->query($sql);
		$i = 0;
		while ($fila = mysqli_fetch_assoc($buscarSecciones)) {
			$secciones[$i]['id'] = $fila['id_seccion'];
			$secciones[$i]['seccion'] = $fila['numero_nombre'];
			$i++;
		}


		return $secciones;
	}

    public function obtenerSeccionesSinHorario($conexion){
	    $secciones = array();
        $sql = "SELECT seccion.id_seccion, seccion.numero_nombre FROM seccion 
                LEFT JOIN horario ON horario.id_seccion = seccion.id_seccion 
                INNER JOIN grado ON seccion.id_grado = grado.id_grado 
                WHERE horario.id_seccion IS NULL AND grado.id_grado = '$this->id' ";

        $buscarSecciones = $conexion->query($sql);
        $i = 0;
        while ($fila = mysqli_fetch_assoc($buscarSecciones)) {
            $secciones[$i]['id'] = $fila['id_seccion'];
            $secciones[$i]['seccion'] = $fila['numero_nombre'];
            $i++;
        }


        return $secciones;
    }

	public function obtenerMaterias($conexion){
		$sql = "SELECT materia.id_materia, materia.nombre, grado_materia_horas.hora
		FROM materia INNER JOIN grado_materia_horas ON materia.id_materia = grado_materia_horas.id_materia
		INNER JOIN grado ON grado_materia_horas.id_grado = grado.id_grado WHERE grado.id_grado = $this->id";

		$buscarSecciones = $conexion->query($sql);
		$i = 0;
		while ($fila = mysqli_fetch_assoc($buscarSecciones)) {
			$secciones[$i]['id'] = $fila['id_materia'];
			$secciones[$i]['materia'] = $fila['nombre'];
			$secciones[$i]['horas'] = $fila['hora'];
			$i++;
		}


		return $secciones;
	}

	public static function obtenerArrayGradosActivos($conexion){
		$grados_activos = array();

		$sql = "SELECT id_grado FROM `grado` WHERE `grado`.`numero` LIKE '%Año' AND `grado`.`id_grado` < 4 AND `grado`.`estado` = 'activo';";

		$response = $conexion->query($sql);
		if($response->num_rows > 0){
			$grados_activos['year_first'] = true;
		}else{
			$grados_activos['year_first'] = false;
		}

		$sql = "SELECT id_grado FROM `grado` WHERE `grado`.`numero` LIKE '%Año' AND `grado`.`id_grado` >= 4 AND `grado`.`estado` = 'activo';";

		$response = $conexion->query($sql);
		if($response->num_rows > 0){
			$grados_activos['year_second'] = true;
		}else{
			$grados_activos['year_second'] = false;
		}

		$sql = "SELECT id_grado FROM `grado`  WHERE `grado`.`numero` LIKE '%Grado' AND `grado`.`estado` = 'activo';";

		$response = $conexion->query($sql);
		if($response->num_rows > 0){
			$grados_activos['grado'] = true;
		}else{
			$grados_activos['grado'] = false;
		}

		return $grados_activos;
	}

	public static function activarGrados($tipos,$conexion){

		if(isset($tipos['year_first'])){
			$sql_year = 'UPDATE `grado` SET `estado` = \'activo\' WHERE `grado`.`numero` LIKE \'%Año\' AND `grado`.`id_grado` < 4;';
		}else{
			$sql_year = 'UPDATE `grado` SET `estado` = \'inactivo\' WHERE `grado`.`numero` LIKE \'%Año\' AND `grado`.`id_grado` < 4;';
		}

		$actualizar_grados[] =  $conexion->query($sql_year);

		if(isset($tipos['year_second'])){
			$sql_year = 'UPDATE `grado` SET `estado` = \'activo\' WHERE `grado`.`numero` LIKE \'%Año\' AND `grado`.`id_grado` >= 4;';
		}else{
			$sql_year = 'UPDATE `grado` SET `estado` = \'inactivo\' WHERE `grado`.`numero` LIKE \'%Año\' AND `grado`.`id_grado` >= 4;';
		}

		$actualizar_grados[] =  $conexion->query($sql_year);

		if(isset($tipos['grado'])){
			$sql_grado = 'UPDATE `grado` SET `estado` = \'activo\' WHERE `grado`.`numero` LIKE \'%Grado\';';
		}else{
			$sql_grado = 'UPDATE `grado` SET `estado` = \'inactivo\' WHERE `grado`.`numero` LIKE \'%Grado\';';
		}

		$actualizar_grados[] =  $conexion->query($sql_grado);

		return $actualizar_grados;
	}

	public function ingresarSeccion($conexion, $nombre){

		if($this->seccionExiste($conexion, $nombre) <= 0){
			$sql = "INSERT INTO seccion VALUES(null, '$nombre', $this->id)";

			$insertarSeccion = $conexion->query($sql);

		}else{
			$insertarSeccion = 2;
		}
		return $insertarSeccion;
	}

	public function seccionExiste($conexion, $nombre){
		$sql = "SELECT id_seccion FROM seccion WHERE numero_nombre LIKE '" . $nombre ."' AND id_grado= $this->id";
		$buscarSeccion = $conexion->query($sql);

		if($buscarSeccion->num_rows > 0){
			$seccion = 1;
		}else{
			$seccion = 0;
		}

		return $seccion;
	}

	public static function obtenerIdSeccion($conexion, $seccion, $grado){
		$sql = "SELECT id_seccion from seccion WHERE numero_nombre = '{$seccion}' AND id_grado = {$grado}";

		$buscarSeccion = $conexion->query($sql);
		$id_seccion = "";
		while($fila=mysqli_fetch_array($buscarSeccion)){
			$id_seccion = $fila['id_seccion'];
		}

		return $id_seccion;
	}
}