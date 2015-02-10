<?php

/**
 * Controlador correspondiente para el resto de vistas (no admin)
 */
class inicioController extends Controller {
	
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
	 * Verifica si existe una sesión actualmente, en caso de existir redirige a inicio.
	 * Renderiza la página de login.
	 * Cuando recibe contraseña y nia por POST las valida.
	 * 
	 * @return void
	 */
	function login() {
		if($this->security(false)) {
			header('Location: /debate/inicio');
		} else {
			if(isset($_POST['nia']) && isset($_POST['password'])) {
				$ldapUser = LDAP_Gateway::login($_POST['nia'],$_POST['password']);
				try {
					if($ldapUser) {
						$user = new User($ldapUser->getUserId(), $ldapUser->getUserNameFormatted(), $ldapUser->getUserMail()
							, $ldapUser->getDn());
						$_SESSION['user'] = $user;

						if(isset($_GET['url'])) {	
							header('Location: ' . $_GET['url']);
						} else {
							header('Location: /debate/inicio/panel');
						}
					} else {
						$error = 'Usuario o contraseña incorrectos.';
						$this->render('login', array('error'=>$error));
					}

				} catch (Exception $e) {
					$error = 'Ha habido algun problema con la autenticacion. Inténtelo de nuevo, por favor.';
					$this->render('login', array('error'=>$error));
				}
			} else {
				$this->render('login');
			}
		}
	}

	/**
	 * Cierre de sesión.
	 * Redirige a inicio.
	 * 
	 * @return void
	 */
	function logout() {
		session_start();
		session_destroy();
   		session_regenerate_id(true);
		header('Location: /debate/inicio');
	}

	/**
	 * Valida la sesión del usuario, en caso de fallar redirige a inicio.
	 * Permite introducir nuevas preguntas si no existe una igual.
	 * Permite darle like a preguntas de otras personas.
	 * Permite eliminar tus propias preguntas.
	 * Renderiza todas las preguntas de la categoría a la que pertenece el usuario.
	 * 
	 * @return void
	 */
	function panel() {
		if(!$this->security(false)) header('Location: /debate/inicio');	
		$preguntas = new Pregunta();
		$likes = new Like();
		if (isset($_POST['pregunta'])) {
			if(!empty($_POST['pregunta'])){
				if($preguntas->isSetText(htmlspecialchars($_POST['pregunta']))){
					$data['error'] = 'Ya existe la pregunta';
				}else{
					$preguntas->uid = $_SESSION['user']->uid;
					$preguntas->author = $_SESSION['user']->cn;
					$preguntas->text = htmlspecialchars($_POST['pregunta']);
					$preguntas->category = $_SESSION['user']->category;
					$preguntas->likes = 0;
					$preguntas->save();
				}
			}else{
				$data['error'] = 'Debes escribir una pregunta.';
			}
		}

		if (isset($_POST['like'])) {
			if($likes->isSetLike($_SESSION['user']->uid,$_POST['pregunta_like'])){
				$data['error'] = 'Ya has hecho like en esa pregunta.';
			}else{
				if($likes->ownLike($_SESSION['user']->uid,$_POST['pregunta_like'])){
					$data['error'] = 'No puedes hacerte like a ti mismo.';
				}else{
					$likes->uid = $_SESSION['user']->uid;
					$likes->author = $_SESSION['user']->cn;
					$likes->id_pregunta = $_POST['pregunta_like'];
					$preguntas->upgradeLikes($likes->id_pregunta,$likes->getLikes($likes->id_pregunta));
					$likes->save();
				}
			}	
		}

		if (isset($_POST['delete'])) {
			$preguntas = Pregunta::findById($_POST['pregunta_like']);
			if ($preguntas[0]->uid == $_SESSION['user']->uid) {
				$preguntas[0]->remove();
			} else {
				$data['error'] = 'Solo puedes borrar tus preguntas';
			}
		}

		$data['preguntas'] = Pregunta::findByCategory($_SESSION['user']->category); 
		$this->render('panel',$data);	
	}

	/**
	 * AJAX
	 * Imprime las 10 preguntas más votadas de una categoria.
	 * 
	 * @return void
	 */
	function preguntas() {
		$category = $_GET['type'];
		header('Content-Type: application/json');
		switch ($category) {
			case 'alumnos':
				echo json_encode(Pregunta::findByCategoryF('Alumnos'));
				break;
			case 'pdi':
				echo json_encode(Pregunta::findByCategoryF('Personal Docente e Investigador'));
				break;
			case 'pas':
				echo json_encode(Pregunta::findByCategoryF('Personal de Administracion y Servicios'));
				break;
			
			default:
				echo json_encode(array());
				break;
		}
	}
}
