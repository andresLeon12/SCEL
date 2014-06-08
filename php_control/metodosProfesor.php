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
			$tiempo = 0;
			$fechaExamen; //Contendra la fecha de aplicacion de examen
			$getFecha = "select aplicacionExamen from Materia where clvMatNov = '$claveMat'";
			$resultado = mysqli_query($conn,$getFecha);
			 if($resultado){
			 	if(mysqli_affected_rows($conn)!=0){
			 		while($row2 = mysqli_fetch_array($resultado,MYSQLI_ASSOC)){
						$fechaExamen = $row2['aplicacionExamen'];
					}
					list($anio,$mes,$dia) = split("-", $fechaExamen);//Guardara el año,mes y dia respectivamente de la fecha de aplicacion de examen
					$hoy = date('y-m-d');
					list($anio2,$mes2,$dia2) = split("-", $hoy);
					if(true){
						$fecha1 = strtotime($fechaExamen);
						$fecha2 = strtotime($hoy);
						for($fecha1;$fecha1<=$fecha2;$fecha1=strtotime('+1 day ' . date('Y-m-d',$fecha1))){ 
						    if((strcmp(date('D',$fecha1),'Sun')!=0) and (strcmp(date('D',$fecha1),'Sat')!=0)){
						         $tiempo = $tiempo + 1;
						    }
						}
					}
			 	}
			 }
			if($tiempo <= 5){
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
				 	if(mysqli_affected_rows($conn)!=0){
				 		echo "Se inserto calificacion";
				 	}
				 }
			}else{
				echo "El periodo para ingresar calificaciones ha caducado, dirijase al departamento de servicios escolares para rehabilitar el periodo";
			}
			
		}
	}else{
		echo "ERROR al conectar";
	}
	
	
?>