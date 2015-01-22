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
});