<?php
require("classes/conn.class.php");
require("classes/validaciones.inc.php");
class Estudiante{
    public $idestudiante;
    public $fechanacimiento;
    public $estadoregistroestudiante;
    public $idgenero;
    public $conexion; //OBJETO DE CONEXION
    public $validacion; //OBJETO DE VALIACION
    
    public function __construct(){
        $this->conexion = new DB();
        $this->validacion = new Validaciones();
    }
    
    public function idestudiante($idestudiante){
        $this->idestudiante = intval($idestudiante);
    }
    
    public function getIdEstudiante(){
        return intval($this->idestudiante);
    }
    
    public function setFechaNacimiento($fechanacimiento){
        $this->fechanacimiento = $fechanacimiento;
    }
    
    public function getFechaNacimiento(){
        return $this->fechanacimiento;
    }
    
    public function idgenero($idgenero){
        $this->idgenero = $idgenero;
    }
    
    public function getIdGenero(){
        return $this->idgenero;
    }
    
    //MTODO PARA OBTENER EL REGISTRO DE UN UNICO ESTUDIANTE
    public function obtenerEstudiante(int $idestudiante){
        $this->idestudiante($idestudiante);
        if($this->idestudiante > 0){
            $resultado = $this->conexion->run('SELECT * FROM estudiante WHERE id_estudiante='.$this->idestudiante.';');
            $array = array("mensaje"=>"Registros encontrados","Valores"=>$resultado->fetch());
            return $array;
        }else{
            return array("mensaje"=>"No se puede ejecutar la consulta, el parametro ID es incorrecto","Valores"=>"");
        }
    }
    
    //MTODO PARA OBTENER LOS REGISTROS DE TODOS LOS ESTUDIANTES
    public function obtenerEstudiantes(){
        $resultado = $this->conexion->run('SELECT * FROM estudiante;');
        $array = array("mensaje"=>"Registros encontrados","Valores"=>$resultado->fetch());
        return $array;
    }
    
    //MTODO PARA INSERTAR UN REGISTRO DE ESTUDIANTE
    public function nuevoEstudiante($fechanacimiento,$idgenero){
        if(!empty($fechanacimiento) and !empty($idgenero)){
            $parametros = array(
                "fecha_nac" => $fechanacimiento,
                "id_genero" => $idgenero
            );
            $resultado = $this->conexion->run('INSERT INTO estudiante(fecha_nacimiento_estudiante,id_genero)VALUES(:fecha_nac,:id_genero);',$parametros);
            if($this->conexion->n > 0 and $this->conexion->id > 0){
                $resultado = $this->obtenerEstudiante($this->conexion->id);
                $array = array("mensaje"=>"Registros encontrados","Valores"=>$resultado["Valores"]);
                return $array;
            }else{
                return array("mensaje"=>"No se pudo realizar el insert","Valores"=>"");
            }
        }else{
            return array("mensaje"=>"Parametro enviados vacios","Valores"=>"");
        }
    }
}
?>
