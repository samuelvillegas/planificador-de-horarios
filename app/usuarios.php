<?php

class Usuarios{
	public $id;

	public $nombre;

	public $apellido;

	public $telefono = "";

	public $correo;

	public $direccion = "";

	public $dni;

	public $usuario;

	public $clave;

	public $imagen = "";

	public $perfiles;

	public function __construct($id_usuario = null) {
        $this->id = $id_usuario;
        
    }

	public function ingresarUsuario($conexion){
		$insertar_usuario = false;
		
		if(isset($conexion)){
			

			$sql = "INSERT INTO persona VALUES (null, '$this->nombre', '$this->apellido', '$this->telefono', '$this->direccion', '$this->dni','$this->correo', '$this->usuario', '$this->clave', '$this->imagen')";
			$sentencia = $conexion->prepare($sql);

			$insertar_usuario = $sentencia->execute();

			
			
			$sql = "SELECT id_persona FROM persona WHERE usuario = '$this->usuario'";

			$retornoID = $conexion->query($sql);

			while($fila=mysqli_fetch_array($retornoID)){
				$id_persona = $fila['id_persona'];
			}
			
			$this->id = $id_persona;

			foreach ($this->perfiles as $perfil) {
				$this->asignarPerfil($conexion,$perfil);
			}
			
		}
		return $insertar_usuario;
	}


	public function actualizarUsuario($conexion, $nuevo_usuario = ""){
		$actualizar_usuario = false;
		
		if(isset($conexion)){
			$this->obtenerIdPorUsuario($conexion);

            if($this->clave != "" || $this->clave != null){
                $clave_sql = ", clave = '{$this->clave}'";
            }else{
                $clave_sql = "";
            }

            if(empty($this->imagen)){
                $imagen_sql = "";
            }else{
                $imagen_sql = ", 'imagen' = '{$this->imagen}' ";
            }
			$sql = "UPDATE persona SET nombre ='{$this->nombre}' , apellido = '{$this->apellido}', telefono = '{$this->telefono}', direccion='{$this->direccion}', dni = '{$this->dni}', correo = '{$this->correo}', usuario = '{$nuevo_usuario}' {$clave_sql} {$imagen_sql} WHERE id_persona = {$this->id}";

			$sentencia = $conexion->prepare($sql);

			$actualizar_usuario = $sentencia->execute();

			$sql = "DELETE FROM  `persona_perfil` WHERE `persona_perfil`.`id_persona` = {$this->id}";
            $this->usuario = $nuevo_usuario;
			$conexion->query($sql);
			foreach ($this->perfiles as $perfil) {
				$this->asignarPerfil($conexion,$perfil);
			}

		}
		return $actualizar_usuario;
	}

	public static function obtenerImagen($conexion, $id_usuario){

		$sql = "SELECT imagen FROM persona WHERE id_persona = '$id_usuario'";

		$buscarImagen = $conexion->query($sql);

		while($fila=mysqli_fetch_array($buscarImagen)){
				$imagen = $fila['imagen'];
			}
		return $imagen;
	}

	public function asignarPerfil($conexion,$perfil){
		$sql = "INSERT INTO persona_perfil VALUES ('$this->id','$perfil')";
		
		$sentencia = $conexion->prepare($sql);

		$insertar = $sentencia->execute();

		
	}

	public static function obtenerNombre($conexion, $id_usuario){

		$sql = "SELECT nombre, apellido FROM persona WHERE id_persona = '$id_usuario'";

		$buscarNombre = $conexion->query($sql);

		while($fila=mysqli_fetch_array($buscarNombre)){
				$nombre = $fila['nombre'] . " " . $fila['apellido'];
			}
		return $nombre;

	}

	public static function mostrarPerfil($perfiles){
		foreach ($perfiles as $perfil) {
			echo $perfil['perfil'] . " ";
		}
	}

	public function obtenerUsuarios($conexion, $limit = null, $offset = null){

		if($limit != null){
			$limit = " LIMIT $limit";
		}

		if($offset != null){
			$offset = " OFFSET $offset";
		}

		$sql = "SELECT id_persona,imagen, nombre, apellido, usuario, direccion, dni, correo FROM persona $limit $offset ORDER BY nombre";

		$buscarUsuarios = $conexion->query($sql);

	
		$i = 0;
		while($fila=mysqli_fetch_assoc($buscarUsuarios)){

			$sql_perfil = "SELECT perfil.id_perfil, perfil.nombre FROM perfil 
			INNER JOIN persona_perfil ON perfil.id_perfil = persona_perfil.id_perfil
			INNER JOIN persona ON persona_perfil.id_persona = persona.id_persona WHERE persona.id_persona = " . $fila['id_persona'];
			$buscarPerfiles = $conexion->query($sql_perfil);
			$lista_usuarios[$i] = $fila;

			while ($fila_perfil = mysqli_fetch_assoc($buscarPerfiles)) {
				$lista_usuarios[$i]['perfiles'][] = $fila_perfil;

			}
				$i++;
			}
		return $lista_usuarios;
	}

	public static function obtenerDocentes($conexion){
			$sql = "SELECT persona.id_persona, persona.nombre, persona.apellido FROM persona INNER JOIN persona_perfil ON persona.id_persona = persona_perfil.id_persona WHERE persona_perfil.id_perfil = 2";

			$buscarUsuarios = $conexion->query($sql);



		while($fila=mysqli_fetch_assoc($buscarUsuarios)){
				$lista_usuarios[] = $fila;
			}
		return $lista_usuarios;
	}

    public static function obtenerDocentesDetalles($conexion){
        $sql = "SELECT persona.id_persona, persona.nombre, persona.apellido, persona.imagen FROM persona INNER JOIN persona_perfil ON persona.id_persona = persona_perfil.id_persona WHERE persona_perfil.id_perfil = 2";

        $buscarUsuarios = $conexion->query($sql);



        while($fila=mysqli_fetch_assoc($buscarUsuarios)){
            $lista_usuarios[] = $fila;
        }
        return $lista_usuarios;
    }

	public function usuarioExiste($conexion){

		$sql = "SELECT id_persona FROM persona WHERE usuario LIKE '" . $this->usuario ."'";
		$buscarUsuario = $conexion->query($sql);

		if($buscarUsuario->num_rows > 0){
			$usuario = 1;
		}else{
			$usuario = 0;
		}

		return $usuario;
	}

	public function cedulaExiste($conexion){

		$sql = "SELECT id_persona FROM persona WHERE dni = '" . $this->dni ."'";
	
		$buscarUsuario = $conexion->query($sql);

		if($buscarUsuario->num_rows > 0){
			$usuario = 1;
		}else{
			$usuario = 0;
		}

		return $usuario;
	}

	public function obtenerDatosPorUsuario($conexion){
		$sql = "SELECT * FROM persona WHERE usuario = '". $this->usuario ."'";

		$buscarUsuario = $conexion->query($sql);
		$usuario = array();
		while($fila = mysqli_fetch_assoc($buscarUsuario)){
			$usuario['id'] = $fila['id_persona'];
			$usuario['nombre'] = $fila['nombre'];
			$usuario['apellido'] = $fila['apellido'];
			$usuario['cedula'] = $fila['dni'];
			$usuario['telefono'] = $fila['telefono'];
			$usuario['direccion'] = $fila['direccion'];
			$usuario['correo'] = $fila['correo'];
			$usuario['imagen'] = $fila['imagen'];
			$usuario['usuario'] = $fila['usuario'];

			$sql_perfil = "SELECT  perfil.nombre FROM perfil
			INNER JOIN persona_perfil ON perfil.id_perfil = persona_perfil.id_perfil
			INNER JOIN persona ON persona_perfil.id_persona = persona.id_persona WHERE persona.id_persona = " . $usuario['id'];
			$buscarPerfiles = $conexion->query($sql_perfil);

			while ($fila_perfil = mysqli_fetch_row($buscarPerfiles)) {
				$usuario['perfiles'][] = $fila_perfil;

			}
		}
		return $usuario;
	}

	public function obtenerIdPorUsuario($conexion){
		$sql = "SELECT * FROM persona WHERE usuario = '". $this->usuario ."'";

		$buscarUsuario = $conexion->query($sql);
		$usuario = array();
		while($fila = mysqli_fetch_assoc($buscarUsuario)){
			$this->id= $fila['id_persona'];
	
		}
		
	}
}



?>