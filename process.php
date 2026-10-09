<?php
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Headers: Origin, x-Requested-With, Content-Type, Accept, Access-Control-Request-Method');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Max-Age:1000');
header('Access-Control-Allow-Credentials: true');
header('Allow: GET, POST, OPTIONS, PUT, DELETE');
require('classes/estudiante.class.php');

$Estudiante = new Estudiante();

//PREGUNTO POR EL METODO ENVIADO
if($_SERVER["REQUEST_METHOD"] === "GET"){
    //OBTENGO EL VALOR DEL PARAMETRO ENVIADO
    $tipo_peticion = ((isset($_GET["t"])) ? (($_GET["t"])!="" ? $_GET : null): null);
    switch($tipo_peticion){
        case "selectAll":
            $resultado = $Estudiante ->obtenerEstudiantes();
            break;
        case "select":
            $id = ((isset($_GET["id"])) ? (($_GET["id"]!="") ? intval($_GET["id"]) : 0): 0);
            if($id > 0){
                $resultado = $Estudiante -> obtenerEstudiantes();
            }else{
                header('HTTP/1.1 412 Precondition Failed');
                $resultado = array("Mensaje"=>"El parametro ID no es correcto","Valor"=>"");
            }
            break;
        case "insert":
            //INSERTA UN REGISTRO
            if(array_key_exists("fecha_nac",$_GET) and array_key_exists("id_genero",$_GET)){
                //SI SE ENVIARON VALORES DESDE EL METODO GET
                if($_GET["fecha_nac"]!="" and $_GET["id_genero"]!=""){
                    $resultado = $Estudiante->nuevosEstudiante($_GET["fecha_nac"],$_GET["id_genero"]);
                }else{
                    //UNO DE LOS PARAMETROS ENVIADOS NO POSEE VALORES
                    header('HTTP/1.1 400 Bad Request');
                    $resultado = array("mensaje"=>"Verifique el valor de la fecha de nacimiento o del genero","valores"=>"");
                }
            }else{
                //NO SE HAN ENVIADO VALORES DESDE EL METODO GET
                header('HTTP/1.1 400 Bad Request');
                $resultado = array("mensaje"=>"No se han enviado lo parámetros requeridos","valores"=>"");
            }
            break;
        default:
            header('HTTP/1.1 403 Forbidden');
            $resultado = array('mensaje'=> 'Debe de indicar el tipo de procesamiento que se realizara','valores'=> '');
            break;
    }
}elseif($_SERVER["REQUEST_METHOD"] === "POST"){
    
            if(array_key_exists("fecha_nac",$_POST) and array_key_exists("id_genero",$_POST)){
                //SI SE ENVIARON VALORES DESDE EL METODO GET
                if($_POST["fecha_nac"]!="" and $_POST["id_genero"]!=""){
                    $resultado = $Estudiante->nuevosEstudiante($_POST["fecha_nac"],$_POST["id_genero"]);
                }else{
                    //UNO DE LOS PARAMETROS ENVIADOS NO POSEE VALORES
                    header('HTTP/1.1 400 Bad Request');
                    $resultado = array("mensaje"=>"Verifique el valor de la fecha de nacimiento o del genero","valores"=>"");
                }
            }else{
                //NO SE HAN ENVIADO VALORES DESDE EL METODO GET
                header('HTTP/1.1 400 Bad Request');
                $resultado = array("mensaje"=>"No se han enviado lo parámetros requeridos","valores"=>"");
            }
}else{
    header('HTTP/1.1 400 Bad Request');
    $resultado = array('mensaje'=> '¿?','valores'=> '');
}
header('Content-type: application/json');
echo(json_encode($resultado));
?>
