<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Establecer fechas</title>
        <link type="text/css" rel="stylesheet" href="../Css/jquery-ui-1.10.4.custom.css" />
        <script src="../Scripts/jquery-2.0.2.js"></script>
        <script src="../Scripts/jquery-ui.js"> </script>
        <script type="text/javascript">
        jQuery(function($){
              $.datepicker.regional['es'] = {
                    closeText: 'Cerrar',
                    prevText: '&#x3c;Ant',
                    nextText: 'Sig&#x3e;',
                    currentText: 'Hoy',
                    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
                    'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
                    monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
                    'Jul','Ago','Sep','Oct','Nov','Dic'],
                    dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
                    dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
                    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
                    weekHeader: 'Sm',
                    dateFormat: 'yy-mm-dd',
                    firstDay: 1,
                    isRTL: false,
                    showMonthAfterYear: false,
                    yearSuffix: ''};
              $.datepicker.setDefaults($.datepicker.regional['es']);
        });

        $(document).ready(function() {
           $(".calendario1").datepicker();
           
        });
       </script>
        
    </head>
    <body>
        <?php
        include_once '../php_control/conexion.php';
		$conexion = new conexion();
        $claves = $conexion->getAllClavesMateria();
		$nombre = $conexion->getAllNombresMateria();
        ?>
        <div id="cabecera">
            <div id="usuario">
                <div id="nombreU">
                    Sistema de Calificaciones<br>
                    SE
                </div>
            </div>
        </div>
        <section id="establecerFechas">
        	<?php
        		if($claves!=null and $nombre!=null){
					for($cont = 0 ;$cont < count($claves);$cont++){
						?>
						<form action="../php_control/metodosSE.php" method="post">
						<?php
						echo "<p>".$nombre[$cont]."</p>";
						$clave = $claves[$cont];
						?>
						<input type="hidden" name="opcion" value="setPeriodos" />	
			            <label>Fecha de aplicación de examen: </label><input type="text" name="fechaInicio" class="calendario1" readonly="readonly" /><br>
			            
						<?php
						echo "<input type='submit' name='claveMat' value='Activar-$clave' />";
						echo "</form>";
					}
				}
        	?>
        </section>
        
    </body>
</html>