<section id="panel" class="wrapper">
	<div>
		 <form action="/debate/inicio/panel" method="post">
			<div>          	       
				<input type="text" name="pregunta" placeholder="Pregunta">
				<button type="submit" value="ENVIAR">Enviar</button>
			</div>
		</form>	
	</div>

	<div class="lista">

		<?php echo isset($data['error']) ? '<p class="info error">' . $data['error'] . '</p>' : '' ?>
		<ul id='preguntas'>
				<?php
				if(isset($preguntas)){
					foreach($preguntas as $pregunta){ ?>
					<li class='pregunta'>
						<form id="like" action="/debate/inicio/panel" method="post">
							<div id="texto">
								<input type="hidden" name="pregunta_like" value="<?php echo $pregunta->text?>"> <?php echo $pregunta->text?>
								<p><?php echo $pregunta->likes?></p>
							</div>
							<button id="like" type="submit" name="like" value="LIKE">Me gusta</button>
						</form>
					</li>
					<?php }
				}		
				?>
		</ul>
	</div>
	
</section>