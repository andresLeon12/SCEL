<?php
	//Se inclullen las clases php que serán necesarias para realizar las funciones de esta clase
    	include_once ("conexion.php");
        include_once 'C_profesor.php'; 
		session_start();
		//Se crea el objeto de conexión a base de datos
        $bd = new conexion();
        $profesor = new C_profesor();
        //Capturamos los datos de inicio de sesión: n = nombre de usuario, p = contraseña
        $n = $_POST ['nom'];
        $p = $_POST ['cont'];
		//$bd->getTipoCalif();
        //Para este caso tomamos a SE definido co el login y password janet
        if($n=="janet" && $p="janet"){
            //redireccionar pagina html de SE
            header("Location: ../Vistas/ServiciosEscolares.html");
            exit(); //terminar
        }else{
           //Verificamos en la tabla de alumnos si se encuentra el usuario
           
            $tipoUsuario = $bd->verifAlumno($n,$p);
            
            if($tipoUsuario!=""){
            	//Guardamos los datos en la session
            	
                $_SESSION['nom'] = $_POST['nom'];
                $_SESSION['cont'] = $_POST['cont'];
                header("Location: Alumno.php");
                exit(); //terminar
            
                
            }else if($tipoUsuario==""){
                //tipousuario me guarda la clave del profesor que es int
                
                $tipoUsuario2 = $bd->verifProfe($n,$p);
                if($tipoUsuario2>0){
                	
                    //esta consulta me devuelve un obj de tipo claseProfesor
		            $profesor = $bd->getProfesor($tipoUsuario2);
		            if($profesor!=null){
		                //obtengo todas la claves de las materias a las que esta relacionado el profe
		                //los guardo en un array
		                $arrayClavesMat = $bd->getClavesMateria($profesor->getClvProfNov());
		                if($arrayClavesMat!=null){
		                    $aux = 0;
		                    //para cada clave saco el nombre de la materia y el nom de la materia la guardo en otro arreglo
		                    for($cont = 0 ;$cont < count($arrayClavesMat);$cont++){
		                        $mat = $bd->getMaterias($arrayClavesMat[$cont]);//este metod me saca el nombre de una materia de acuerdo a la clave que se le manda
		                        if($mat!=null){
		                            //la materia la guardo en mi array de materias
		                            $arrayMaterias[$aux] = $mat;
		                            $aux = $aux+1;
		                        }
		                    }
							
			                $_SESSION['clavesMat'] = $arrayClavesMat;
			                $_SESSION['materiasProfe'] = $arrayMaterias;
			                
	                    }
	                    $_SESSION['profesor'] = $profesor;
						header("Location: ../Vistas/Profesor.php"); 
                    	exit();
                }else if($tipoUsuario2==0){
                    header("Location: ../index.php"); 
                    exit(); //terminamar
                }
             }
        }
        }
?>