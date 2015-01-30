<?php

class adminController extends Controller {
	
	function index() {
		if ($this->security(false)) {
			$this->panel();
		} else {
			$arrayAlumnos = Pregunta::findByCategory('alumnos');
			$arrayPDI = Pregunta::findByCategory('pdi');
			$arrayPAS = Pregunta::findByCategory('pas');
			$this->render('admin', array('Alumnos' => $arrayAlumnos), array('PDI' => $arrayPDI), array('PAS' => $arrayPAS));
		}
	}

	//Función necesaria para que el caso de que la seguridad falle exista el método panel de this.
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
}
