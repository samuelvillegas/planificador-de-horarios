<?php
include_once '../app/conexion.php';
include_once '../app/grados.php';
/**
 * Created by PhpStorm.
 * User: Villegas
 * Date: 13/11/2017
 * Time: 7:12 PM
 */


if(isset($_POST['buscar_seccion']) && $_POST['buscar_seccion'] == true){
	Conexion::abrirConexion();
	$grado = new Grados();
	$grado->id = $_POST['grado'];
	$datos_grado = $grado->obtenerSeccionesSinHorario(Conexion::obtenerConexion());

	echo json_encode(
		$datos_grado
	);
}

if(isset($_POST['buscar_materias']) && $_POST['buscar_materias'] == true){
	Conexion::abrirConexion();
	$grado = new Grados();
	$grado->id = $_POST['grado'];
	$datos_grado = $grado->obtenerMaterias(Conexion::obtenerConexion());

	echo json_encode(
		$datos_grado
	);
}
if(isset($_POST['registrar_seccion']) && $_POST['registrar_seccion'] == true){
	Conexion::abrirConexion();
	$grado = new Grados();
	$grado->id = $_POST['grado'];
	$datos_seccion = $grado->ingresarSeccion(Conexion::obtenerConexion(), $_POST['nombre']);

	echo $datos_seccion;
}