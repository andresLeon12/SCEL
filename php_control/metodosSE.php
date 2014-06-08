<?php
	include_once 'conexion.php';
	$conexion = new conexion();
	$link = $conexion->crearConexion();
	$opcion = $_POST['opcion'];
	if($opcion=="setPeriodos"){
		$claves = $_POST['claveMat'];
		$fecha = $_POST['fechaInicio'];
		$clvMat;
		list($tipo,$clvMat) = split("-", $claves);
		$query = "update Materia set aplicacionExamen = '$fecha' where clvMatNov = '$clvMat'"; 
		$result = mysqli_query($link,$query);
		if($result){
			if(mysqli_affected_rows($link)!=0){
			 	echo "Se establecio fecha de examen";
			}
		}
	}	
?>