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
						<form class="like" action="/debate/inicio/panel" method="post">
							<div class="texto">
								<input type="hidden" name="pregunta_like" value="<?php echo $pregunta->id?>"><span><?php echo $pregunta->text?></span>
								<p><?php echo $pregunta->likes?></p>
							</div>
							<?php if ($pregunta->uid != $user->uid) { ?>
								<button class="like icon-like" type="submit" name="like" value=""></button>
							<?php } else { ?>
								<button class="trash icon-trash" type="submit" name="delete" value=""></button>
							<?php } ?>
						</form>
					</li>
					<?php }
				}		
				?>
		</ul>
	</div>
	
</section>
