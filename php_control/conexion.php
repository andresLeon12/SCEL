<?php

/**
 * Description of conexion
 *
 * @author Lucho
 */
include_once 'C_profesor.php';

class conexion {
    //variables que utilizaremos para establecer la conexión a bd
    private $servidor = "localhost";
    private $nombreBD = "SCEL";
    private $user = "root";
    private $pass = "and_123dres_456";
    private $conexion;
    public $C_profesor = null;
    
    function conexion(){
        $this->crearConexion();
        
    }
    
    function crearConexion(){
        //Datos para la conexión con el servidor
        //Creando la conexión, nuevo objeto mysqli
        $this->conexion = new mysqli($this->servidor,$this->user,$this->pass,$this->nombreBD);
        //Si sucede algún error la función muere e imprimir el error
        if($this->conexion->connect_error){
            die("Error en la conexion : ".$this->conexion->connect_errno."-".$this->conexion->connect_error);
        }else
            //echo'Se establecio conexion con BD';
        return $this->conexion;
        //Si nada sucede retornamos la conexión
        
    }
    //Función que identifica si el usuario es alumno
    function verifAlumno($log,$cont){
        
        try{
            $consulta = $this->conexion->prepare("select matAluNov from Alumno where logAluNov=? and pasAluNov=?");
            //$consulta = $this->conexion->prepare("select tipoUser from usuario where nombre=? and pass=?");
            
            $consulta->bind_param("ss", $log,$cont);
            
            $consulta->execute();
            
            $consulta->store_result();
            
            $totalRegistros = $consulta->num_rows();
            
            if($totalRegistros==0){
                //echo $totalRegistros;
                return "";
            }else{
                //echo 'no es cero';
                $consulta->data_seek(0);
                $consulta->bind_result($tipo);
                $consulta->fetch();
                echo $tipo;
                return $tipo;
                //return $totalRegistros;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
            return "";
            //echo 'Excepcion';
        }
        return "";
    }
    //Función que verifica si el usuario es profesor
    function verifProfe($log,$cont){
        try{
            $consulta = $this->conexion->prepare("select clvProfNov from Profesor where logProNov=? and pasProNov=?");
            //$consulta = $this->conexion->prepare("select tipoUser from usuario where nombre=? and pass=?");
            
            $consulta->bind_param("ss", $log,$cont);
            
            $consulta->execute();
            
            $consulta->store_result();
            
            $totalRegistros = $consulta->num_rows();
            
            if($totalRegistros==0){
                //echo $totalRegistros;
                return 0;
            }else{
                //echo 'no es cero';
                $consulta->data_seek(0);
                $consulta->bind_result($tipo);
                $consulta->fetch();
                //echo $tipo;
                return $tipo;
                //return $totalRegistros;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
            return 0;
            //echo 'Excepcion';
        }
        return 0;
    }
    //Función que crea un objeto tipo profesor que será utilizado en el sistema
    function getProfesor($clave){
        //echo $clave;
        
        $this->C_profesor = new C_profesor();
        $clv=null;
        $nom=null;
        $apeP=null;
        $apeM=null;
        $grd=null;
        $log=null;
        $pas=null;
        try{
            //echo $clave;
            $consulta = $this->conexion->prepare("select * from Profesor where clvProfNov=?");
            
            $consulta->bind_param("i", $clave);
            
            $consulta->execute();
            
            $consulta->store_result();
            
            $totalRegistros = $consulta->num_rows();
            
            if($totalRegistros>0){
               
                for( $contador = 0 ; $contador < $totalRegistros ; $contador++ ){
                    $consulta->data_seek($contador);
                    $consulta->bind_result($clv,$nom,$apeP,$apeM,$grd,$log,$pas);
                    $consulta->fetch();
                }
                //echo $nom . '' . $apeP . '' . $apeM;
                $this->C_profesor->setClvProfNov($clv);
                $this->C_profesor->setNomProNov($nom);
                $this->C_profesor->setApePatPro($apeP);
                $this->C_profesor->setApeMatPro($apeM);
                $this->C_profesor->setGrdProNov($grd);
                $this->C_profesor->setLogProNov($log);
                $this->C_profesor->setPasProNov($pas);
                return $this->C_profesor;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
            return null;
        }
        return null;
    }
	//Funcion que realiza busquedas de alumnos en tiempo real
	function buscarAlumno($query){
		$q = $this->conexion->prepare("select nomAluNov,apePatAlu,apeMatAlu from Alumno where clvProfNov LIKE '%$query%'");
		$consulta->execute();
            
        $consulta->store_result();
            
        $totalRegistros = $consulta->num_rows();
		if($totalRegistros>0){
               
            for( $contador = 0 ; $contador < $totalRegistros ; $contador++ ){
                $consulta->data_seek($contador);
                $consulta->bind_result($nom);
                $consulta->fetch();
				echo $nom;
            }
		}
	}
    //Función que cierra la conexión
    function cerraConexion(){
        $this->conexion->close();
    }
    
}
