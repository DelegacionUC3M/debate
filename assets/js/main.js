$(function(){
	$('#pregunta a.tab').on('click', function(){
		$.get('/debate/inicio/preguntas?type=' + $(this).attr('id'), function(data) {
			$('#pregunta ul').slideUp(400,function() {
				$('#pregunta ul').html('');
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
});