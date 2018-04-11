<?php 

/**
* 
*/
class Aula {
	
	public $id;

	public $numero;

	public $capacidad;

	public $tipo = "General";

	function __construct() {
		# code...
	}

	public function ingresarAula($conexion){
		$insertar_aula = false;
		if($conexion != null){
            $sql = "INSERT INTO aula VALUES (null, '$this->numero', '$this->capacidad', '$this->tipo')";
            $insertar_aula = $conexion->query($sql);


            $sql = "SELECT id_aula FROM aula WHERE numero = '$this->numero'";

            $retornoID = $conexion->query($sql);
            $id_aula = "";
            while($fila=mysqli_fetch_array($retornoID)){
                $id_aula = $fila['id_aula'];
            }

            $this->id = $id_aula;
        }

        return $insertar_aula;
	}

	public function actualizarAula($conexion){
        $insertar_aula = false;
        if($conexion != null){
            $sql = "UPDATE aula SET numero ='{$this->numero}' , capacidad = '{$this->capacidad}', tipo = '{$this->tipo}' WHERE id_aula = {$this->id}";

            $insertar_aula = $conexion->query($sql);

        }

        return $insertar_aula;
    }

	public function buscarAulaPorNumero($conexion){
        $buscar_aula = false;
        if($conexion != null){

            $sql = "SELECT id_aula FROM aula WHERE numero = '$this->numero'";

            $retornoID = $conexion->query($sql);

            while($fila=mysqli_fetch_array($retornoID)){
                $buscar_aula = $fila['id_aula'];
            }

        }

        return $buscar_aula;
    }

    public function obtenerDatosAulaPorNumero($conexion){
        $sql = "SELECT * FROM aula WHERE numero = '$this->numero'";

        $buscarAulas = $conexion->query($sql);

        $lista_aulas = array();
        while($fila=mysqli_fetch_assoc($buscarAulas)){
            $lista_aulas[] = $fila;

        }
        return $lista_aulas;
    }

    public static function  obtenerAulas($conexion, $limit = null, $offset = null){

        if($limit != null){
            $limit = " LIMIT $limit";
        }

        if($offset != null){
            $offset = " OFFSET $offset";
        }

        $sql = "SELECT * FROM aula $limit $offset ORDER BY numero";

        $buscarAulas = $conexion->query($sql);

        $lista_aulas = array();
        while($fila=mysqli_fetch_assoc($buscarAulas)){
            $lista_aulas[] = $fila;

        }
        return $lista_aulas;
    }
}
