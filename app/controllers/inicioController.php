<?php

class inicioController extends Controller {
	
	function index() {
		if ($this->security(false)) {
			$this->panel();
		} else {
			$preguntas = Pregunta::findAll();
			$this->render('inicio', array('preguntas' => $preguntas));
		}
	}

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

	function logout() {
		session_start();
		session_destroy();
   		session_regenerate_id(true);
		header('Location: /debate/inicio');
	}

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
