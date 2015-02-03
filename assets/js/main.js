$(function(){

	$('#pregunta a.tab').on('click', function(){
		var id = $(this).attr('id');
		$.get('/debate/inicio/preguntas?type=' + id, function(data) {
			$('#pregunta ul').slideUp(400,function() {
				$('#pregunta ul').html('').attr('id',id);
				if(data.length == 0) {
					$('#pregunta ul').append('<li class="error">No se han encontrado preguntas de esa categoria.</li>');
				}
				$.each(data, function() {
					$('#pregunta ul').append('<li><p>' + this.text + '</p><span>' + this.likes + '</span></li>');
				});
			});
			
			$('#pregunta ul').slideDown();
		});
	});

	$('#preguntaAdmin a.tab').on('click', function(){
		var id = $(this).attr('id');
		$.get('/debate/admin/preguntas?type=' + id, function(data) {
			$('#preguntaAdmin ul').slideUp(400,function() {
				$('#preguntaAdmin ul').html('').attr('id',id);
				if(data.length == 0) {
					$('#preguntaAdmin ul').append('<li class="error">No se han encontrado preguntas de esa categoria.</li>');
				}
				$.each(data, function() {
					$('#preguntaAdmin ul').append('<li><p>' + this.text + '</p><span>' + this.likes + '</span></li>');
				});
			});
			
			$('#preguntaAdmin ul').slideDown();
		});
	});


	setInterval(function() {
		var type = $('#pregunta ul').attr('id');
		if(type && type.length != 0) {
			$.get('/debate/inicio/preguntas?type=' + type, function(data) {
			$('#pregunta ul').html('');
				if(data.length == 0) {
					$('#pregunta ul').append('<li class="error">No se han encontrado preguntas de esa categoria.</li>');
				}
				$.each(data, function() {
					$('#pregunta ul').append('<li><p>' + this.text + '</p><span>' + this.likes + '</span></li>');
				});
			});
		}
	}, 2000);

	setInterval(function() {
		var type = $('#preguntaAdmin ul').attr('id');
		if (type == null){
		}
		else{
			if(type && type.length != 0) {
				$.get('/debate/admin/preguntas?type=' + type, function(data) {
				$('#preguntaAdmin ul').html('');
					if(data.length == 0) {
						$('#preguntaAdmin ul').append('<li class="error">No se han encontrado preguntas de esa categoria.</li>');
					}
					$.each(data, function() {
						$('#preguntaAdmin ul').append('<li><p>' + this.text + '</p><span>' + this.likes + '</span></li>');
					});
				});
			}
		}
	}, 3000);
});

