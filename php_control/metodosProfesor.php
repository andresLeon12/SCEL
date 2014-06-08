<?php
	include_once 'conexion.php';
	$operacion = $_POST['operacion'];
	$conexion = new conexion();
	$conn = $conexion->crearConexion();
	if($conn != null){
		if($operacion == "insertCalif"){
			$calif = $_POST['calif'];
			$claveMat = $_POST['clave'];
			$matricula = $_POST['matricula'];
			$matAlu = '';
			$tipo;
			list($tipe,$matAlu,$tipo) = split("-", $matricula);
			//echo "Se ingresa: '$calif' a la materia '$claveMat' al alumno '$matAlu' y sera a '$tipo'";
			$query = "";
			switch ($tipo) {
				case 1:
					$query = "update RelAluMat set priParNo = '$calif' where clvMatNov = '$claveMat' and clvMatAlu = '$matAlu'";
					break;
				case 2:
					$query = "update RelAluMat set segParNov = '$calif' where clvMatNov = '$claveMat' and clvMatAlu = '$matAlu'";
					break;
				case 3:
					$query = "update RelAluMat set ordMatNov = '$calif' where clvMatNov = '$claveMat' and clvMatAlu = '$matAlu'";
					break;
				case 4:
					$query = "update RelAluMat set priExtNov = '$calif' where clvMatNov = '$claveMat' and clvMatAlu = '$matAlu'";
					break;
				case 5:
					$query = "update RelAluMat set segExtNov = '$calif' where clvMatNov = '$claveMat' and clvMatAlu = '$matAlu'";
					break;
				case 6:
					$query = "update RelAluMat set espMatNov = '$calif' where clvMatNov = '$claveMat' and clvMatAlu = '$matAlu'";
					break;
				
			}
			$result = mysqli_query($conn,$query);
			 if($result){
			 	echo "Se inserto calificacion";
			 	if(mysqli_affected_rows($link)!=0){
			 		echo "Se inserto calificacion";
			 	}
			 }
		}
	}else{
		echo "ERROR al conectar";
	}
	
	
?>