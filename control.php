<?php 
include_once "app/conexion.php";

Conexion::abrirConexion();

$mysqli = Conexion::obtenerConexion();
$usuario = $_POST['user'];
$clave = $_POST['pass'];

if(!empty($usuario) && !empty($clave)){
	
	$querybuscarUsuario = $mysqli->query("SELECT id_persona,usuario, clave FROM persona WHERE usuario='$usuario'");
if($querybuscarUsuario->num_rows > 0){

	$querybuscarUsuario2 = $mysqli->query("SELECT id_persona,usuario, clave FROM persona WHERE usuario='$usuario' and clave='$clave' ");

	if ($querybuscarUsuario2->num_rows > 0) {
		while ( $fila=mysqli_fetch_array($querybuscarUsuario) )
	{
		$usuariobd= $fila['usuario'];
		$clavebd= $fila['clave'];
		$id_datos= $fila['id_persona'];
	}

	$querybuscarPerfil = $mysqli->query("SELECT perfil.nombre, perfil.nivel_acceso FROM perfil INNER JOIN persona_perfil ON
		perfil.id_perfil = persona_perfil.id_perfil WHERE persona_perfil.id_persona='$id_datos' ");
	$i = 0;
	while ( $fila=mysqli_fetch_array($querybuscarPerfil) )
	{
		$perfilbd[$i]['perfil']= $fila['nombre'];
		$perfilbd[$i]['nivel_acceso']= $fila['nombre'];
		$i++;
	}


	if(  $usuario == $usuariobd && $clave == $clavebd )
	{
		// Inicio la sesión
		session_start();

		// Declaro las variables de sesión
		$_SESSION['autentificado'] = true;
		$_SESSION['user'] = $usuario;
		$_SESSION['id_datos'] = $id_datos;
		$_SESSION['perfiles'] = $perfilbd;

		header("Location: index.php");
		//var_dump($_SESSION['perfiles']);
	}
	}else{
		header("Location:" . $_REQUEST['self'] . "?error=2");
	}
	
	
}else{
	header("Location:" . $_REQUEST['self'] . "?error=0");
}
}else{
	header("Location:" . $_REQUEST['self'] . "?error=1");
}


?>