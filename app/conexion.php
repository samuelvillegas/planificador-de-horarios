<?php

class Conexion {

	private static $conexion;

	public static function abrirConexion() {
		if(!isset(self::$conexion)){
			include_once 'config.php';		

			$nombre_servidor = 'localhost';
			$nombre_usuario = 'todomark_lyon';
			$clave = '=g8&c2v+(}R$';
			$nombre_bd = "todomark_constructor_horarios";
			self::$conexion = new mysqli($nombre_servidor, $nombre_usuario, $clave, $nombre_bd);
			if(self::$conexion->connect_error){
				die('ERROR: No se estableci&oacute; la conexi&oacute;n. '. mysqli_connect_error() );
			}

			self::$conexion->set_charset("utf8");
		}
	}

	public static function cerrarConexion() {
		if(isset(self::$conexion)) {
			self::$conexion = null;
		}
	}


	public static function obtenerConexion() {
		return self::$conexion;
	}
}

