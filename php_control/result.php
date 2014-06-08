<?php
include_once('conexion.php');
session_start();
$conexion = new conexion();
$link = $conexion->crearConexion();
$tipo = $_POST['getMaterias'];
//Funcion que obtiene las materias del profesor
if(isset($_POST['getMaterias'])){
	$profesor = $_SESSION['profesor'];
	$clave = $profesor->getClvProfNov();
	$query = "select clvMatNov from RelProfMat where clvProfNov = '$clave'";
	$result = mysqli_query($link,$query);
	if($result){
		if(mysqli_affected_rows($link)!=0){
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				$clvMateria = $row['clvMatNov'];
				$getMat = "select nomMatNov,clvMatNov from Materia where clvMatNov = '$clvMateria' ";
				$resultMat = mysqli_query($link,$getMat);
				if($resultMat){
					if(mysqli_affected_rows($link)!=0){
						while($row2 = mysqli_fetch_array($resultMat,MYSQLI_ASSOC)){
							$claveMat = $row2['clvMatNov'];
							/*echo '<a class="listmaterias" href="#" >'.$row2['nomMatNov'].'</a><br/>';
							echo '<section id="buscarAlumno">';
							echo '<h3>Ingrese el nombre o matricula del alumno:</h3>';*/
							echo '<form action="metodosProfesor.php" action="POST">';
							//echo 'Nombre: <input type="text" name="nombre"  class="buscar" onkeyup="info();"/><br />';
							echo "<input type='hidden' value='$claveMat' name='clvMat' class='clvMat'/>";
							echo "<input type='hidden' value='buscar' name='opcion' />";
							echo "<input type='submit' value='Continuar' />";
							
							echo '</form>'; 
							/*echo '<div id="result">';
							echo '</div>';*/
						}
					}
				}
			}
			//$getMat = "select nomMatNov from materia where clvMatNov"
		}
	}
}else{
	$query = $_POST['buscar'];
	$clv = $_POST['clave'];
	if(isset($_POST['buscar']) and isset($_POST['clave'])){
		 	//Obtenemos los alumnos que reciben una materia identificada por su clave
		 $clave = trim($_POST['clave']);
		 $clave = mysqli_real_escape_string($link, $clave);
		 /*$q = "select clvMatAlu from RelAluMat where clvMatNov='$clave'";
		 $res = mysqli_query($link,$q);*/
		 $keyword = trim($_POST['buscar']);
		 $keyword = mysqli_real_escape_string($link, $keyword);
		 
		 $query = "select Alumno.matAluNov,Alumno.nomAluNov,Alumno.apePatAlu,Alumno.apeMatAlu from Alumno,RelAluMat where RelAluMat.clvMatNov='$clave' and RelAluMat.clvMatAlu=Alumno.matAluNov and Alumno.nomAluNov LIKE '%$keyword%' or matAluNov LIKE '%$keyword%'"; //MUST BEGIN WITH $KEYWORD
		 
		//echo $query;
		 $result = mysqli_query($link,$query);
		 if($result){
			 if(mysqli_affected_rows($link)!=0){
			 	echo "<form action='../php_control/metodosProfesor.php' method='POST'>";
			 	echo '<table>';
				 echo '<tr>';
				 echo '<td>Matricula</td>';
				 echo '<td>Nombre</td>';
				 echo '<td>Se ingresará</td>';
				 echo '<td>Calificacion</td>';
				 echo '</tr>';
				 while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
				 	$matAlu = $row['matAluNov'];
					$tipo = $conexion->getTipoCalif($matAlu,$clave);
				 	echo '<tr>';
					 echo '<td>'.$row['matAluNov'].'</td>';
					 echo '<td>'.$row['nomAluNov'].' '.$row['apePatAlu'].' '.$row['apeMatAlu'].'</td>';
					 $matricula = $row['matAluNov'];
					 echo '<td><input type="hidden" name="operacion" value="insertCalif"/></td>';
					 echo "<td><input type='hidden' name='clave' value='$clave' style='display:none;' /></td>";
					 //Aca se ingresaran las calificaciones que ya tiene el alumno
					 for ($i=0; $i < $tipo ; $i++) { 
						 
					 }
					  switch ($tipo) {
						 case 1:
							 echo "<td>Primer parcial</td>";
							 break;
						case 2:
							 echo "<td>Segundo parcial</td>";
							 break;
					 }
					 echo '<td><input type="text" name="calif" size="4" required="" max="4"/></td>';
					
					 echo "<td><input type='submit' value='Enviar-$matricula-$tipo' name='matricula'/></td>";
					 echo '</tr>';
				 }
				 echo "</form>";
			 }else {
				 echo 'No se ha encontrado"'.$_POST['buscar'].'"';
			 }
		 }
	}else {
		 echo 'Error pasando argumento';
	}
}
?>