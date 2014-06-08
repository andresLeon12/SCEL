<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Insertar calificación</title>
        <link rel="stylesheet" type="text/css" href="styleSCEL.css">
        <script src="../Scripts/jquery-2.0.2.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {
	           $(".buscar").keyup(function(){
	           		var valor = $(this).val();
	           		var clv = $("#clave").val();
	           		var dato = "buscar="+ valor +"&clave="+clv; 
	           		if(valor.length <= 0){
	           			$("#result").remove();
	           		}else{
	           			if ( $("#result").length ==0 ) {
			                 $('<div id="result" ></div>').appendTo('#buscarAlumno');
			             }
	           			$.ajax({
	           				type: "POST",
	           				url: "../php_control/result.php",
	           				data: dato,
	           				success: function(response){
	           					$("#result").html(response).show();
	           				}	
	           			});
	           		}
	           });
	           
	           
	        });
	        
		</script>
        
    </head>
    <body>
        <?php
        session_start();
        $datos = $_POST['boton'];
		$nombre = '';
		$clave = '';
		list($param,$nombre,$clave) = split("-", $datos);
        ?>
        <div id="cabecera">
            <div id="usuario">
                <div id="nombreU">
                    Sistema de Calificaciones<br>
                    Profesor
                </div>
            </div>
        </div>
        <section id="buscarAlumno">
        	<?php
        		echo "<h2 class=titulo>Materia: ".$nombre."</h2>";
				echo "<input type='hidden' value='$clave' id='clave' />";
        	?>
			<h3>Ingrese el nombre o matricula del alumno:</h3>
			Nombre: <input type="text" name="nombre" id="nombre" class="buscar"/><br />
			<div id="result">
								
			</div>
		</section>
        
        
    </body>
</html>