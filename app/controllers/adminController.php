<?php

/**
 * Controlador correspondiente a las páginas de admin
 */
class adminController extends Controller {
	
	/**
	 * Comprueba la identidad del usuario y si es correcta realiza una llamada
	 * a la función panel.
	 * En caso de no validarse se redirige al inicio.
	 * 
	 * @return void
	 */
	function index() {
		if ($this->security(false)) {
			$this->panel();
		} else {
			$this->render('inicio');
		}
	}

	/**
	 * Rellena la página con las preguntas correspondientes a la categoría alumnos.
	 * En caso de fallar la validación se redirige a inicio.
	 * 
	 * @return void
	 */
	function panel() {
		
		if(!$this->security(false)) header('Location: /debate/inicio');	
		$pregunta = new Pregunta();

		//Solo se quieren poder borrar preguntas, los if para like o introducir preguntas sobrarían.
		//Tampoco haría falta comprobar si es el dueño de la pregunta ya que el administrador debería 
		//poder borrar todo.
		if (isset($_POST['delete'])) {
			$pregunta = Pregunta::findById($_POST['pregunta_like']);
			$pregunta[0]->remove();
		}
		
		//Un array de 3 posiciones en las que cada posición es un array de preguntas de cada grupo.
		$arrayAlumnos = Pregunta::findByCategory('alumnos');
		$this->render('admin', array('alumnos' => $arrayAlumnos));
	}

	/**
	 * AJAX
	 * Imprime las preguntas de una categoria.
	 * Si falla la validación, lanza un error.
	 * 
	 * @return void
	 */
	function preguntas() {
		header('Content-Type: application/json');
		if (!$this->security(false)) {
			header('HTTP/1.0 401 Unauthorized');
			echo json_encode(array());
		} else {
			$category = $_GET['type'];
			switch ($category) {
				case 'alumnos':
					echo json_encode(Pregunta::findByCategory('Alumnos'));
					break;
				case 'pdi':
					echo json_encode(Pregunta::findByCategory('Personal Docente e Investigador'));
					break;
				case 'pas':
					echo json_encode(Pregunta::findByCategory('Personal de Administracion y Servicios'));
					break;
				
				default:
					echo json_encode(array());
					break;
			}
		}
	}
}
