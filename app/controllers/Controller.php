<?php

class Controller {
	
	protected function security($redirect = true) {

		if (isset($_SESSION['user']) && isset($_SESSION['user']->nia) && !empty($_SESSION['user']->nia)) {
			return true;
		}

		if ($redirect) {
			header('Location: /debate/inicio/login?url='.urlencode($_SERVER['REQUEST_URI']));
			die();
		}

		return false;
	}

	protected function render($view, $data = array()) {
		if(!empty($data)) {
			extract($data);
		}

		$title = isset($title) ? $title : 'DEBATE - Delegación UC3M';
		$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

		include ABSPATH . 'app/views/header.php';
		include ABSPATH . 'app/views/' . $view . '.php';
		include ABSPATH . 'app/views/footer.php';
	}

	protected function render_error($code = 404) {
		self::error($code);
	}

	public static function error($code = 404) {
		if ($code == 404) {
			header("HTTP/1.0 404 Not Found");
			$error = 'La página solicitada no existe :(';
		} else if ($code == 401) {
			header('HTTP/1.0 401 Unauthorized');
			$error = 'No tienes permiso para acceder aquí :(';
		}

		$title = isset($title) ? $title : 'DEBATE - Delegación UC3M | Error';
		$user = isset($_SESSION['user']) ? $_SESSION['user'] : NULL;

		include ABSPATH . 'app/views/header.php';
		include ABSPATH . 'app/views/error.php';
		include ABSPATH . 'app/views/footer.php';
	}

}
