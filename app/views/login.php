<div class="wrapper">
	<h2>Entrar a Elecciones</h2>
	<p>Está intentando acceder a un área protegida. </br> Introduzca usuario y contraseña para validarse, las preguntas son anónimas:</p>

	<p class="error"><?php echo isset($error) ? $error : '' ?></p>
	
	<form class="<?php echo isset($error) ? 'error' : '' ?>" action="?<?php if (isset($_GET['url'])) {echo 'url='.$_GET['url'];} ?>" method="post">
		<input type="text" name="nia" id="nia" placeholder="NIA" />
		<input type="password" id="password" name="password" placeholder="Contraseña" />

		<button type="submit" value="Entrar">Entrar</button>
	</form>
</div>