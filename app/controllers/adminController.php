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
}
