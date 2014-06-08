$(document).ready(function() {
	alert("hola");
	//funcion que devuleve los alumnos buscados
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
	 //Funcion que carga las materias del profesor
	 $("#verMaterias").click(function{
	 	alert("Diste click");
	 });
});