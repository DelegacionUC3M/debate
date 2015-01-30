<section id="admin" class="wrapper">

	<div class="lista">
		<?php echo isset($data['error']) ? '<p class="info error">' . $data['error'] . '</p>' : '' ?>
			
		<span class='menu'>Categorias 
		    <ul>
			    <li><a class="tab" id="alumnos">Alumnos</a></li>
				<li><a class="tab" id="pdi">PDI</a></li>
				<li><a class="tab" id="pas">PAS</a></li>
		    </ul>
		  </span>
		<ul id='preguntas'>
				<?php
				if(isset($alumnos)){
					foreach($alumnos as $pregunta){ ?>
					<li class='pregunta'>
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
					</li>
					<?php }
				}		
				?>
		</ul>
	</div>
	
</section>
