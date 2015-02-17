<?php

/**
 * Clase padre de los controladores con métodos genéricos.
 */
class Controller {
	
	/**
	 * Comprueba la identidad del usuario contra el LDAP
	 * 
	 * @param  boolean $redirect  si es true redirige al login, pasandole la url desde la que se llega.
	 * @return boolean            true si el usuario existe en el LDAP
	 */
	protected function security($redirect = true) {

		if (isset($_SESSION['user']) && isset($_SESSION['user']->uid) && !empty($_SESSION['user']->uid)) {
			return true;
		}

		if ($redirect) {
			header('Location: /debate/inicio/login?url='.urlencode($_SERVER['REQUEST_URI']));
			die();
		}

		return false;
	}

	/**
	 * Carga la vista correspondiente a la página
	 * @param  string $view nombre del archivo de la vista a renderizar
	 * @param  array  $data variables a inyectar en la vista
	 * 
	 * @return void
	 */
	protected function render($view, $data = array()) {
		if(!empty($data)) {
			extract($data);
		}

		$title = isset($title) ? $title : 'ELECCIONES - Delegación UC3M';
		$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

		if ($view == 'inicio' || $view == 'login') {
			$section = $view;
		}

		include ABSPATH . 'app/views/header.php';
		include ABSPATH . 'app/views/' . $view . '.php';
		include ABSPATH . 'app/views/footer.php';
	}

	/**
	 * Renderización del mensaje de error.
	 * @param  integer $code código de error
	 *
	 * @return void
	 */
	protected function render_error($code = 404) {
		self::error($code);
	}

	/**
	 * Renderización del mensaje de error.
	 * @param  integer $code código de error
	 *
	 * @return void
	 */
	public static function error($code = 404) {
		if ($code == 404) {
			header("HTTP/1.0 404 Not Found");
			$error = 'La página solicitada no existe :(';
		} else if ($code == 401) {
			header('HTTP/1.0 401 Unauthorized');
			$error = 'No tienes permiso para acceder aquí >:(';
		}

		$title = isset($title) ? $title : 'DEBATE - Delegación UC3M | Error';
		$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

		include ABSPATH . 'app/views/header.php';
		include ABSPATH . 'app/views/error.php';
		include ABSPATH . 'app/views/footer.php';
	}
}
