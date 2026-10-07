<?php 
require_once("classes/com.class.php"); 
require_once("classes/validaciones.inc.php"); 

class Estudiante { 
    public $idestudiante; 
    public $fechanacimiento; 
    public $estadoregistroestudiante; 
    public $idgenero; 
    public $conexion; 
    public $validacion; 

    // Constructor para inicializar las clases en un objeto nuevo
    public function __construct() {
        $this->conexion = new DB(); 
        $this->validacion = new Validaciones(); 
    }

    public function __clone() { 
        $this->conexion = new DB(); 
        $this->validacion = new Validaciones(); 
    } 

    public function setIdestudiante($idestudiante) { 
        $this->idestudiante = intval($idestudiante); 
    } 

    public function getIdestudiante() { 
        return intval($this->idestudiante); 
    } 

    public function setFechanacimiento($fechanacimiento) { 
        $this->fechanacimiento = $fechanacimiento; 
    } 

    public function getFechanacimiento() { 
        return $this->fechanacimiento; 
    } 

    public function setIdgenero($idgenero) { 
        $this->idgenero = $idgenero; 
    } 

    public function getIdgenero() { 
        return $this->idgenero; 
    } 

    public function obtenerEstudiante(int $idestudiante) { 
        // Asignamos el ID limpio usando el método de la clase
        $this->setIdestudiante($idestudiante); 
        
        if ($this->idestudiante > 0) { 
            // Se asume que tu clase DB maneja PDO o similar y requiere preparar la consulta
            // Esto previene Inyección SQL
            $stmt = $this->conexion->prepare('SELECT * FROM estudiante WHERE id_estudiante = :id');
            $stmt->execute(['id' => $this->idestudiante]);
            $resultado = $stmt->fetch();

            return array(
                "mensaje" => "Registros encontrados", 
                "valores" => $resultado
            ); 
        } else { 
            return array(
                "mensaje" => "No se puede ejecutar la consulta, el parámetro ID es incorrecto","valores" => ""
            ); 
        } 
    } 

    public function obtenerEstudiantes() { 
        // Se asume el uso de un método query() en tu clase de conexión
        $stmt = $this->conexion->query('SELECT * FROM estudiante;'); 
        $resultado = $stmt->fetchAll(); // fetchAll para traer todos los registros

        return array(
            "mensaje" => "Registros encontrados", 
            "valores" => $resultado
        ); 
    } 

    public function nuevosEstudiante($fechanacimiento,$idgenero) { 
        if(!empty($fechanacimiento)and !empty($idestudiante)) {
            $parametros = array(
                "fecha nacimiento" => $fechanacimiento,
                "id_genero"=> $idgenero,
            );
            $resultado = $this->conexion('INSERT INTO estudiante(fecha_nacmiento_estudiante,id_genero)VALUES(:fecha_nac,:id_genero);'.$parametros);

    }else{
        return array("mensaje"=> "No se puedo realizar eel insert","Valores"=>"");
    } 
    }
}
?>
