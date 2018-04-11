<?php
include_once '../app/conexion.php';
include_once '../app/usuarios.php';
/**
 * Created by PhpStorm.
 * User: Villegas
 * Date: 13/11/2017
 * Time: 7:12 PM
 */
if( isset($_POST['buscar_usuario']) && $_POST['buscar_usuario'] == true ){
	Conexion::abrirConexion();
	$usuario = new Usuarios();
	$usuario->usuario = $_POST['usuario'];
	$buscar_usuario = $usuario->usuarioExiste(Conexion::obtenerConexion());

	echo $buscar_usuario;
}

if(isset($_POST['buscar_existe']) && $_POST['buscar_existe'] == "buscar_cedula"){
	Conexion::abrirConexion();
	$usuario = new Usuarios();
	$usuario->dni = $_POST['elemento'];
	$buscar_usuario = $usuario->cedulaExiste(Conexion::obtenerConexion());

	echo $buscar_usuario;
}

if(isset($_POST['ver_usuario']) && $_POST['ver_usuario'] == true){
	Conexion::abrirConexion();
	$usuario = new Usuarios();
	$usuario->usuario = $_POST['usuario'];
	$datos_usuario = $usuario->obtenerDatosPorUsuario(Conexion::obtenerConexion());

	echo json_encode(
		$datos_usuario
	);
}