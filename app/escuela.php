<?php
class Escuela{
	public $id = 1;

	public $nombre;

	public $direccion;

	public $rif;

	public $telefono;

	public $correo;

	public $logo;

	public function __construct($id = 1, $nombre = "", $direccion = "" , $rif = "", $telefono = "", $correo = "", $logo = ""){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->direccion = $direccion;
		$this->rif = $rif;
		$this->correo = $correo;
		$this->logo = $logo;
	}

	public function insertarEscuela($conexion){
		$sql = "INSERT INTO `escuela` (`id_escuela`, `nombre`, `direccion`, `imagen`, `rif`, `telefono`, `correo`) VALUES (NULL, 'Colegio Los Alamos', 'Av 13A con calle 50, parroquia coquivacoa.', '/escuela/logo-escuela.jpeg', 'J-30900745-9', '02617194358', NULL);";
		$conexion->query($sql);
	}

	public function actualizarEscuela($conexion){
		$sql = "UPDATE escuela SET nombre = '{$this->nombre}', direccion = '{$this->direccion}', imagen = '{$this->logo}', 
            rif = '{$this->rif}', telefono = '{$this->telefono}', correo = '{$this->correo}' WHERE id_escuela = {$this->id}";
		$actualizar_escuela = $conexion->query($sql);
		return $actualizar_escuela;

	}

	public function obtenerDatosEscuela($conexion){
	    $sql = "SELECT * from escuela WHERE id_escuela = {$this->id}";

	    $buscarEscuela = $conexion->query($sql);
        $datos_escuela = mysqli_fetch_assoc($buscarEscuela);

        return $datos_escuela;
	}

	public static function obtenerPerfiles($conexion){

		$sql = "SELECT id_perfil, nombre FROM perfil";
		$buscarPerfiles = $conexion->query($sql);
		$i = 0;
		$perfiles = array();
		while ($fila = mysqli_fetch_array($buscarPerfiles)) {
			$perfiles[$i]['id'] = $fila['id_perfil'];
			$perfiles[$i]['nombre'] = $fila['nombre'];

			$i++;
		}

		return $perfiles;
	}

	public static function obenterSeccionesYHorarios($conexion){
        $sql = "SELECT grado.numero, grado.id_grado, seccion.numero_nombre, seccion.id_seccion
                FROM grado INNER JOIN seccion ON grado.id_grado = seccion.id_grado WHERE grado.estado = 'activo'";
        /*$secciones = array(
            'seccion' => '',
            'id_grado' => '',
            'grado_nombre' => '',
            'id_seccion' => '',
            'estado' => '',
        );*/
        $buscarSeccion = $conexion->query($sql);
        $i = 0;
        while ($fila = mysqli_fetch_assoc($buscarSeccion)){
            $secciones[$i]['seccion'] = $fila['numero_nombre'];
            $secciones[$i]['id_grado'] = $fila['id_grado'];
            $secciones[$i]['grado_nombre'] = $fila['numero'];
            $secciones[$i]['id_seccion'] = $fila['id_seccion'];

            $sql_estado = "SELECT horario.estado FROM horario WHERE id_seccion = " . $secciones[$i]['id_seccion'];

            $buscarEstado = $conexion->query($sql_estado);


            if($buscarEstado == false){
                $secciones[$i]['estado']['estado'] = "Sin horario";
            }else{

                while ($fila_2 =  mysqli_fetch_assoc($buscarEstado)){

                    $secciones[$i]['estado'] = $fila_2;

                }
            }

            $i++;
        }
        return $secciones;
    }

    public static function obenterSeccionesYHorariosDocente($conexion, $id_persona){
        $sql = "SELECT grado.numero, grado.id_grado, seccion.numero_nombre, seccion.id_seccion, materia.nombre
                FROM grado INNER JOIN seccion ON grado.id_grado = seccion.id_grado 
                INNER JOIN grado_materia_horas ON grado_materia_horas.id_grado = grado.id_grado 
                INNER JOIN materia ON materia.id_materia = grado_materia_horas.id_materia
                INNER JOIN persona_materia ON materia.id_materia = persona_materia.id_materia 
                INNER JOIN horario ON seccion.id_seccion = horario.id_seccion
                WHERE persona_materia.id_persona= {$id_persona}";

        $buscarSeccion = $conexion->query($sql);
        $i = 0;
        while ($fila = mysqli_fetch_assoc($buscarSeccion)){
            $secciones[] = $fila;
            $i++;
        }
        return $secciones;
    }

    public static function esAdminstrador($perfiles){

	    $adminstrador = 0;
	    foreach ($perfiles as $perfil){

        if( $perfil['perfil'] == "Administrador" ){
                $adminstrador++;
            }
        }

        if($adminstrador > 0){
	        return true;
        }else{
            return false;
        }
    }
}