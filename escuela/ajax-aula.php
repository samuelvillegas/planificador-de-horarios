<?php
include_once '../app/conexion.php';
include_once '../app/aulas.php';

if(isset($_POST['registrar_aula'])){
	Conexion::abrirConexion();
	$aula = new Aula();
	$aula->numero = $_POST['nombre'];

	$exist = $aula->buscarAulaPorNumero(Conexion::obtenerConexion());

	if($exist == false){
        $aula->capacidad = $_POST['capacidad'];
        $aula->tipo = $_POST['tipo'];
        $insertar_aula = $aula->ingresarAula(Conexion::obtenerConexion());

    }else{
	    $insertar_aula = false;
    }

	echo $insertar_aula;
}

if(isset($_POST['buscar_aula'])){
    Conexion::abrirConexion();
    $aula = new Aula();
    $aula->numero = $_POST['aula_num'];

    $datos_aula = $aula->obtenerDatosAulaPorNumero(Conexion::obtenerConexion());

    echo json_encode($datos_aula);
}

