<?php
include_once('conexion.php');
$conexion = new conexion();
$link = $conexion->crearConexion();
$query = $_POST['buscar'];
if(isset($_POST['buscar'])){
 $keyword = trim($_POST['buscar']);
 $keyword = mysqli_real_escape_string($link, $keyword);
 
 $query = "select nomAluNov,apePatAlu,apeMatAlu from Alumno where nomAluNov LIKE '%$keyword%' or matAluNov LIKE '%$keyword%'"; //MUST BEGIN WITH $KEYWORD
 
//echo $query;
 $result = mysqli_query($link,$query);
 if($result){
 if(mysqli_affected_rows($link)!=0){
 while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
 echo '<span><a class="meterRow">'.$row['nomAluNov'].'</a><span>'.$row['apePatAluNov'].'</span></a><span>'.$row['apeMatAluNov'].'</span></span><br />';
 }
 }else {
 echo 'No se ha encontrado"'.$_POST['buscar'].'"';
 }
 }
}else {
 echo 'Error pasando argumento';
}
?>