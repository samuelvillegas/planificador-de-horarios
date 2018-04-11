<?php 
include_once 'control_salir.php'; 
include_once "app/conexion.php";
include_once "app/usuarios.php";
include_once 'app/materias.php';
include_once 'app/aulas.php';
include_once 'app/grados.php';
include_once 'app/horarios.php';

Conexion::abrirConexion();
if(Escuela::esAdminstrador($_SESSION['perfiles'])){
    echo "es";
}

Conexion::cerrarConexion();
