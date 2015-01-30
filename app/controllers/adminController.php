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
}
