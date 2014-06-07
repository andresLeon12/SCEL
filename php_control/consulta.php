<?php
	//Se inclullen las clases php que serán necesarias para realizar las funciones de esta clase
    	include_once ("conexion.php");
        include_once 'C_profesor.php'; 
		//Se crea el objeto de conexión a base de datos
        $bd = new conexion();
        $profesor = new C_profesor();
        //Capturamos los datos de inicio de sesión: n = nombre de usuario, p = contraseña
        $n = $_POST ['nom'];
        $p = $_POST ['cont'];
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
                	
                    //esta consulara me devuelve un obj de tipo claseProfesor
                    $profesor = $bd->getProfesor($tipoUsuario2);
                    if($profesor==null){
                        echo "ERROR creando a profesor";
                    }else{
                    	//Para fines demostrativos mostramos la información del objeto profesor
                        echo $profesor->getClvProfNov();
	                    echo $profesor->getNomProNov();
	                    echo $profesor->getApePatPro();
	                    echo $profesor->getApeMatPro();
	                    echo $profesor->getGrdProNov();
	                    echo $profesor->getLogProNov();
	                    echo $profesor->getPasProNov();
						header("Location: ../Vistas/Profesor.html"); 
                    }
                    
                    
                }else if($tipoUsuario2==0){
                    header("Location: ../index.php"); 
                    exit(); //terminamar
                }
             }
        }
?>