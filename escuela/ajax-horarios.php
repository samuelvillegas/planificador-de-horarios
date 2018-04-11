<?php
include_once '../app/conexion.php';
include_once '../app/horarios.php';

if( isset($_POST['guardar_horario']) && $_POST['guardar_horario'] == true ){
	Conexion::abrirConexion();
	$rutinas = json_decode($_POST['horario_json']);

	$horario = new Horarios();
	$horario->seccion = $rutinas->seccion;
	$horario->rutina = $rutinas->rutina;
	$horario->estado = $_POST['estado'];
	$insertar_horario = $horario->ingresarHorario(Conexion::obtenerConexion());

	if($insertar_horario == false){
		echo 0;
	}else{
	    if($_POST['estado'] == "Completado"){
	        echo 1;
        }else{
            echo 2;

        }
	}
}

if( isset($_POST['actualizar_horario']) && $_POST['actualizar_horario'] == true ){
    Conexion::abrirConexion();
    $rutinas = json_decode($_POST['horario_json']);
    $horario = new Horarios();
    $horario->id = $_POST['id_horario'];
    $horario->seccion = $rutinas->seccion;
    $horario->rutina = $rutinas->rutina;
    $horario->estado = $_POST['estado'];
    $insertar_horario = $horario->actualizarHorarioRutinas(Conexion::obtenerConexion());

    if($insertar_horario == false){
        echo 0;
    }else{
        if($_POST['estado'] == "Completado"){
            echo 1;
        }else{
            echo 2;

        }
    }
}


if(isset($_POST['cargar_horario']) && $_POST['cargar_horario'] = true){
	include_once "../app/grados.php";
	Conexion::abrirConexion();
	$horario = new Horarios();
	$horario->seccion = Grados::obtenerIdSeccion(Conexion::obtenerConexion(), $_REQUEST['seccion'], $_REQUEST['grado']);
	$horario->obtenerIdPorSeccion(Conexion::obtenerConexion());
	$horario->obtenerRutinas(Conexion::obtenerConexion());

	echo json_encode($horario);
}

if(isset($_POST['buscar_disponibilidad']) && $_POST['buscar_disponibilidad'] == true){

    Conexion::abrirConexion();
    if(isset($_POST['modificar']) && $_POST['modificar'] == true){
        $where = "AND id_rutina != " . $_POST['rutina'];
    }else{
        $where = "";
    }
    $disponible = Horarios::buscarDisponibilidad(Conexion::obtenerConexion(),$_POST['docente'], $_POST['aula'], $_POST['hora_inicio'], $_POST['hora_fin'], $_POST['dia'], $where);

    echo json_encode($disponible);
}