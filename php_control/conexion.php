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
//Funcione que obtiene los datos de un alumno y los guarda en el objeto alumno
	function getAlumno($matricula){
        $this->Calumno = new Calumno();
        $mat = null;
        $clv=null;
        $nom=null;
        $apeP=null;
        $apeM=null;
        $log=null;
        $pas=null;
        
        try{
            //echo $clave;
            $consulta = $this->conexion->prepare("select matAluNov,clvAluNov,nomAluNov,apePatAlu,apeMatAlu,logAluNov,pasAluNov from Alumno where matAluNov=?");
            $consulta->bind_param("s", $matricula);
            $consulta->execute();
            $consulta->store_result();
            $totalRegistros = $consulta->num_rows();
            if($totalRegistros>0){
               
                for( $contador = 0 ; $contador < $totalRegistros ; $contador++ ){
                    $consulta->data_seek($contador);
                    $consulta->bind_result($mat,$clv,$nom,$apeP,$apeM,$log,$pas);
                    $consulta->fetch();
                }
                //echo $nom . '' . $apeP . '' . $apeM;
                $this->Calumno->setMatAluNov($mat);
                $this->Calumno->setClvAluNov($clv);
                $this->Calumno->setNomAluNov($nom);
                $this->Calumno->setApePatAlu($apeP);
                $this->Calumno->setApeMatAlu($apeM);
                $this->Calumno->setLogAluNov($log);
                $this->Calumno->setPasAluNov($pas);
                return $this->Calumno;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
            return null;
        }
        return null;
    }
    //Funcion que obtiene las calificaciones de una materia en base a la clave de la materia
    function getCalificaciones($matricula){
        $this->Materias = new Materias();
        $this->crearConexion();
        $clv=null;
        $nom=null;
        $Pri=null;
        $Seg=null;
        $Ter=null;
        $Ord=null;
        $calFinal=null;
        
        try{
            //echo $clave;
            $consulta = $this->conexion->prepare("select clvMatNov,nomMatNov,priParMat,segParMat,terParMat,ordMatNov,calMatNov from RelAluMat where clvMatNov=?");
            
            $consulta->bind_param("s", $matricula);
            
            $consulta->execute();
            
            $consulta->store_result();
            
            $totalRegistros = $consulta->num_rows();
            
            if($totalRegistros>0){
               
                for( $contador = 0 ; $contador < $totalRegistros ; $contador++ ){
                    $consulta->data_seek($contador);
                    $consulta->bind_result($clv,$nom,$Pri,$Seg,$Ter,$Ord,$calFinal);
                    $consulta->fetch();
                }
                //echo $nom . '' . $apeP . '' . $apeM;
                $this->Materias->setClvMatNov($clv);
                $this->Materias->setNomMatNov($nom);
                $this->Materias->setPriParMat($Pri);
                $this->Materias->setSegParMat($Seg);
                $this->Materias->setTerParMat($Ter);
                $this->Materias->setOrdMatNov($Ord);
                $this->Materias->setCalMatNov($calFinal);
                return $this->Materias;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
            return null;
        }
        return null;
    }
    //Funcion que obtiene las claves de las materias asignadas a un profesor en base a la clave del profesor
    function getClavesMateria($clave){
        //$this->Materias = new Materias();
        $this->crearConexion();
        $clv = array();
        
        try{
            //echo $clave;
            $consulta = $this->conexion->prepare("select clvMatNov from RelProfMat where clvProfNov=?");
            //$consulta = $this->conexion->prepare("select clvMatNov,nomMatNov,priParMat,segParMat,terParMat,ordMatNov,calMatNov from materia where clvMatNov=?");
            
            $consulta->bind_param("i", $clave);
            
            $consulta->execute();
            
            $consulta->store_result();
            
            $totalRegistros = $consulta->num_rows();
            
            if($totalRegistros>0){
               
                for( $contador = 0 ; $contador < $totalRegistros ; $contador++ ){
                    $consulta->data_seek($contador);
                    
                    $consulta->bind_result($clv[$contador]);
                    $consulta->fetch();
                }
                return $clv;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
            return null;
        }
        return null;
    }
	//Funcion que obtiene las claves de todas las materias
	function getAllClavesMateria(){
        //$this->Materias = new Materias();
        $this->crearConexion();
        $clv = array();
        $query = "select clvMatNov from Materia"; 
		$result = mysqli_query($this->conexion,$query);
		if($result!=null){
			if(mysqli_affected_rows($this->conexion)!=0){
				$cont = 0;
				while($row2 = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$clv[$cont] = $row2['clvMatNov'];
					$cont = $cont+1;
				}
				return $clv;
			}
		}
		return null;
    }
    //Funcion que obtiene nombres de materias en base a su clave
    function getMaterias($claveMateria){
        //$this->Materias = new Materias();
        $this->crearConexion();
        $mat;
        
        try{
            //echo $clave;
            $consulta = $this->conexion->prepare("select nomMatNov from Materia where clvMatNov=?");
            //$consulta = $this->conexion->prepare("select clvMatNov,nomMatNov,priParMat,segParMat,terParMat,ordMatNov,calMatNov from materia where clvMatNov=?");
            
            $consulta->bind_param("s", $claveMateria);
            
            $consulta->execute();
            
            $consulta->store_result();
            
            $totalRegistros = $consulta->num_rows();
            
            if($totalRegistros==0){
                //echo $totalRegistros;
                return null;
            }else{
                //echo 'no es cero';
                $consulta->data_seek(0);
                $consulta->bind_result($mat);
                $consulta->fetch();
                //echo $tipo;
                return $mat;
                //return $totalRegistros;
            }
            
        } catch (Exception $ex) {
            $ex->getMessage();
            return null;
        }
        return null;
    }
    function getAllNombresMateria(){
        //$this->Materias = new Materias();
        $this->crearConexion();
        $clv = array();
        $query = "select nomMatNov from Materia"; 
		$result = mysqli_query($this->conexion,$query);
		if($result!=null){
			if(mysqli_affected_rows($this->conexion)!=0){
				$cont = 0;
				while($row2 = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					$clv[$cont] = $row2['nomMatNov'];
					$cont = $cont+1;
				}
				return $clv;
			}
		}
		return null;
    }
	//Funcion que nos devolvera que tipo de calificacion de ingresara, primer paracial,segundo...
	function getTipoCalif($matricula,$clave){
		$query = "SELECT * FROM RelAluMat where clvMatAlu='$matricula' and clvMatNov='$clave'"; 
		$result = mysqli_query($this->conexion,$query);
		if($result!=null){
			if(mysqli_affected_rows($this->conexion)!=0){
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
					if($row['priParNo'] == "0"){
						return 1;
					}else if($row['segParNov']=="0"){
						return 2;
						//echo "Es segundo parcial";
					}else if($row['terParNov']=="0"){
						return 3;
						echo "Es segundo parcial";
					}else if($row['ordMatNov']=="0"){
						return 4;
						echo "Es segundo parcial";
					}else if($row['priExtNov']=="0"){
						return 5;
						echo "Es segundo parcial";
					}else if($row['segExtNov']=="0"){
						return 6;
						echo "Es segundo parcial";
					}else if($row['espMatNov']=="0"){
						return 7;
						echo "Es segundo parcial";
					}
					
				}
			}
		}
	}
	//Funcion que obtendra las calificaciones que tiene el alumno
	/*function getCalificaciones($matricula){
		$query = "SELECT * FROM RelAluMat where clvMatAlu='$matricula'"; 
		$result = mysqli_query($this->conexion,$query);
	}*/
    //Función que cierra la conexión
    function cerraConexion(){
        $this->conexion->close();
    }
    
}
