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
				$('#preguntaAdmin ul').html('').attr('data-type',id);
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

//FRONTAL
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

//ADMIN
	setInterval(function() {
		var type = $('#pregunta ul').attr('data-type');
				$.get('/debate/admin/preguntas?type=' + type, function(data) {
				$('#pregunta ul').html('');
					if(data.length == 0) {
						$('#pregunta ul').append('<li class="error">No se han encontrado preguntas de esa categoria.</li>');
					}
					$.each(data, function() {
						$('#pregunta ul').append('<li class='pregunta'>
						<form class="like" action="/debate/admin/" method="post">
							<div class="texto">
								<input type="hidden" name="pregunta_like" value="<?php echo $pregunta->id?>"> <?php echo $pregunta->text?>
								<p><?php echo $pregunta->likes?></p>
							</div>
							<!-- La vista de admin en teoria solo tiene la opción de borrar preguntas, ya que es para 
							controlarlas y no veo mucho sentido que un admin de like cuando para eso ya tendría su cuenta
							de la uni -->
								<button class="trash icon-trash" type="submit" name="delete" value=""></button>
						</form>
					</li>');
					});
				});
			
		
	}, 2000);

});

