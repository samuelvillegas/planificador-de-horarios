<?php
include_once '../app/conexion.php';
include_once '../app/materias.php';
/**
 * Created by PhpStorm.
 * User: Villegas
 * Date: 13/11/2017
 * Time: 7:12 PM
 */
if( isset($_POST['buscar_existe']) && $_POST['buscar_existe'] == true ){
    Conexion::abrirConexion();
    $materia = new Materias();
    $materia->nombre = $_POST['elemento'];
    $buscar_materia = $materia->materiaExiste(Conexion::obtenerConexion());

    echo $buscar_materia;
}

if( isset($_POST['buscar_docentes']) && $_POST['buscar_docentes'] == true ){
    Conexion::abrirConexion();
    $materia = new Materias();
    $materia->id = $_POST['materia'];
    $buscar_materia = $materia->buscarDocentes(Conexion::obtenerConexion());

    echo json_encode($buscar_materia);
}

if( isset($_POST['detalles_materia']) && $_POST['detalles_materia'] == true ){
    Conexion::abrirConexion();
    $materia = new Materias();
    $materia->id = $_POST['id_materia'];
    $buscar_materia = $materia->obtenerDetallesMateria(Conexion::obtenerConexion());

    echo json_encode($buscar_materia);
}