<?php
class Pregunta {
	public $id;
	public $uid;
	public $likes;
	public $author;
	public $category;
	public $text;
	public $date;
	
	/**
	* Busca todas las preguntas y las devuelve.
	*
	* @return array  $debate 	Array que contiene todas las preguntas encontradas
	**/

	public static function findAll(){
		$db = new DB;
		$db->run('SELECT * FROM pregunta');
		$data = $db->data();
		$debate = array();
		foreach($data as $row){
			$pregunta = new Pregunta();
			foreach($row as $key => $value){
				$pregunta->{$key} = $value;
			}
			$debate[] = $pregunta;
		}
		return $debate;
	}

	/**
	* Busca preguntas en función del id.
	*
	* @param ??? 	 $id		Identificador de la pregunta
	* @return array  $debate 	Array que contiene todas las preguntas encontradas
	**/

	public static function findById($id){
		$db = new DB;
		$db->run('SELECT * FROM pregunta WHERE id=?', array($id));
		$data = $db->data();
		$preguntas = array();
		foreach($data as $row){
			$pregunta = new Pregunta();
			foreach($row as $key => $value){
				$pregunta->{$key} = $value;
			}
			$preguntas[] = $pregunta;
		}
		return $preguntas;
	}

	/**
	* Busca todas las preguntas que se corresponden a una categoría.
	* Las devuelve ordenadas según sus likes en orden descendente.
	*
	* @param  ???	 $category 	Categoría a buscar.
	* @return array  $debate 	Array que contiene todas las preguntas encontradas.
	**/
	public static function findByCategory($category){
		$db = new DB;
		$db->run('SELECT * FROM pregunta WHERE category=? ORDER BY likes DESC' , array($category));
		$data = $db->data();
		$debate = array();
		foreach($data as $row){
			$pregunta = new Pregunta();
			foreach($row as $key => $value){
				$pregunta->{$key} = $value;
			}
			$debate[] = $pregunta;
		}
		return $debate;
	}

	/**
	* Busca las 10 mejores preguntas de una categoría.
	* Las devuelve ordenadas según sus likes en orden descendente.
	*
	* @param  ??? 	 $category 	Categoría a buscar
 	* @return array  $debate 	Array que contiene todas las preguntas encontradas
	**/
	public static function findByCategoryF($category){
		$db = new DB;
		$db->run('SELECT text,likes FROM pregunta WHERE category=? ORDER BY likes DESC LIMIT 0,10', array($category));
		$data = $db->data();
		$debate = array();
		foreach($data as $row){
			$pregunta = new Pregunta();
			foreach($row as $key => $value){
				$pregunta->{$key} = $value;
			}
			$debate[] = $pregunta;
		}
		return $debate;
	}
	
	/**
	* Comprueba si existe alguna pregunta que se corresponda al texto
	*
	* @param  string 	$texto 	Texto a comprobar
	* @return boolean 			True si existe alguna pregunta que se corresponda
	**/
	public static function isSetText($texto){
		$db = new DB;
		$db->run('SELECT * FROM `pregunta` WHERE text=?', array($texto));
		$texto_pregunta = $db->data();
		return (!empty($texto_pregunta)) ? true : false;

	}

	/**
	* Elimina una pregunta de la BD.
	*
	* @return void
	**/
	public function remove() {
		$db = new DB;
		$db->run('DELETE FROM `pregunta` WHERE `id`=?', array($this->id));
	}

	/**
	* Aumenta en uno los likes de una pregunta.
	*
	* @param ??? 	$id 	Identificador de la pregunta
	* @param ??? 	$likes 	Likes de la pregunta 
	* @return void
	**/
	public function upgradeLikes($id,$likes){
		$db = new DB;
		$this->likes++;
		$db->run('UPDATE `pregunta` SET likes=? WHERE id=?' , array($likes, $id));
	}

	/**
	* Guarda una pregunta en la BD
	* 
	* @return ????
	**/
	public function save(){
		$db = new DB;
		return $db->run('INSERT INTO `pregunta` (uid, likes, author, category, text, date) VALUES (?, 0, ?, ?, ?, NOW())', 
				array($this->uid, $this->author, $this->category, $this->text));
	}
}
