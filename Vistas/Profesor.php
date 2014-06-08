<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Profesor-SCEL</title>
        <link rel="stylesheet" type="text/css" href="styleSCEL.css">
        <script src="../Scripts/jquery-2.0.2.js"></script>
        <script type="text/javascript">
			$(document).ready(function() {
	           $(".buscar").keyup(function(){
	           		var valor = $(this).val();
	           		var dato = 'buscar='+ valor;
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
	           $("#verMaterias").click(function(){
	           		var consulta = 'getMaterias=';
	           		$.ajax({
	           			type: "POST",
	           			url: "../php_control/result.php",
	           			data: consulta,
	           			success: function(response){
	           				$("#materias").html(response).show();
	           			}
	           		});
	           });
	           
	        });
	        
		</script>
        <script>
            $(document).ready(function(){
               $('#inserta').fadeOut();
               $('#consulta').fadeOut();

            });
            function desplegarInsertar(){
               //alert("hizo click");
                ocultarConsultar();
                $('#inserta').fadeIn(3000);
            };
            function desplegarConsultar(){
               //alert("hizo click");
               ocultarInsertar();
                $('#consulta').fadeIn(3000);
            };
            function ocultarInsertar(){
                $('#inserta').fadeOut();
            };
            function ocultarConsultar(){
                $('#consulta').fadeOut();
            };
            
         </script>
    </head>
    <body>
        <?php
        session_start();
        // put your code here
        $clavesMaterias = array();
        $matertiasProfes = array();
        $materiasProfe = $_SESSION['materiasProfe'];
        $clavesMaterias = $_SESSION['clavesMat'];
        ?>
        <div id="cabecera">
            <div id="usuario">
                <div id="nombreU">
                    Sistema de Calificaciones<br>
                    Profesor
                </div>
            </div>
        </div>
        <ul class="nav2">
        <li>
            <input id="botonStyle" type="submit" name="insertar" value="Insertar Calificaciones" onclick="desplegarInsertar()"/>
            <div id="inserta">
	            <div id="contenedorP2">
	                <h1>Insertar Calificaciones</h1>
	                <h2>Seleccionar Materia</h2>
	                <form action="InsertarCalificaciones.php" method="POST">
	                    <?php
	                        for($cont = 0 ;$cont < count($materiasProfe);$cont++){
	                            
	                            echo "<input type=hidden name=clvMat value=".$clavesMaterias[$cont]." ><br/>";
							    echo '<input type="hidden" name="nomMat"  value='.$materiasProfe[$cont].'/><br/>';
	                            
								echo '<p class="nombresMat">'.$materiasProfe[$cont].'</p>';
								echo "<input type='submit' name='boton' value='Continuar-$materiasProfe[$cont]-$clavesMaterias[$cont]' style='height=80px;'/>";
								//echo '<input type="submit" name="boton" value="Enviar " '.$materiasProfe[$cont].' '.$clavesMaterias[$cont].' class=botones /><br/>';
	                    ?>
		                
	                    <?php
	                        }
	                    ?>
	                </form>
	            </div>
	        </div>
        </li>
        <li>
            <input id="botonStyle" type="submit" name="consultar" value="Consultar Calificaciones" onclick="desplegarConsultar()"/>
             <div id="consulta">
	            <h1>Consultar Calificaciones</h1>
	            <?php
	            ?>
	        </div>
        </li>
    </ul>
        
    </body>
</html>