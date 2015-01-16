<?php

class inicioController extends Controller {
	
	function index() {
		if ($this->security(false)) {
			//$this->panel();
			$this->logout();
		} else {
			$this->render('inicio');
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
							header('Location: /debate/inicio');
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
}