<?php
	include_once 'conexion.php';
	$operacion = $_POST['operacion'];
	$conexion = new conexion();
	$conn = $conexion->crearConexion();
	if($conn != null){
		if($operacion == "buscarAlumno"){
			$nombre = $_POST['nombre'];
			$apePat = '';
			$apeMat = '';
			$dom = '';
			$tel = '';
			try{
	            $consulta = $conn->prepare("select nomAluNov,apePatAlu,apeMatAlu,domAluNov,telMovAlu from Alumno where nomAluNov=?");
	            //$consulta = $this->conexion->prepare("select tipoUser from usuario where nombre=? and pass=?");
	            
	            $consulta->bind_param("s", $nombre);
	            
	            $consulta->execute();
	            
	            $consulta->store_result();
	            
	            $totalRegistros = $consulta->num_rows();
	            
	            if($totalRegistros==0){
	                echo "No se encontro al alumno";
	            }else{
	                //echo 'no es cero';
	                $consulta->data_seek(0);
	                $consulta->bind_result($nombre,$apePat,$apeMat,$dom,$tel);
	                $consulta->fetch();
	                echo "Nombre: ".$nombre." ".$apePat." ".$apeMat."<br/>";
					echo "Domicilio: ".$dom."<br/>";
					echo "Telefono: ".$tel."<br/>";
	            }
	            
	        } catch (Exception $ex) {
	            $ex->getMessage();
	            return "";
	            //echo 'Excepcion';
	        }
		}
	}else{
		echo "ERROR al conectar";
	}
	
	
?>