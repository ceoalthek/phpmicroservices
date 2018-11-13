$(document).ready(function(){

	$('#btnCalcular').click(function(){
		var numero = $('#numero').val()
		var operacion = $('#operacion').val()
		var params = {
			"numero": numero,
			"operacion": operacion,
			"usuario": 'malag@unam.mx',
			"passwd":'e4421674ba428a7429ee1aaa3f8fc075',
		};
		$.ajax({
			type: "POST",
			url: "http://orion.dgsca.unam.mx/ms/cliente.php",
			data: params,
			success: function(respuesta) {
				console.log(respuesta);
				respuesta = JSON.parse(respuesta);
				res = respuesta.resultado;
				setTimeout(function () {
					$('#loader').remove();
					$('#resultado').html('=== ' + res + '===');
				}, 1000);
			},
			error: function() {
				console.log("No se ha podido obtener la información");
				$('#loader').remove();
				$('#resultado').html('No se ha podido obtener la información');
			},
			beforeSend: function() { 
				console.log('CARGANDO');
				$('#resultado').html('<img class="mx-auto d-block" id="loader" src="images/ajax-loader.gif" />').slideDown(2);
			},
		});	
	});
});