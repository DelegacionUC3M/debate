<?php
class Pregunta {
	public $id;
	public $uid;
	public $likes;
	public $author;
	public $category;
	public $text;
	public $date;
	
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

	public static function findByCategory($category){
		$db = new DB;
		$db->run('SELECT * FROM pregunta WHERE category=?', array($category));
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
	
	public static function isSetText($texto){
		$db = new DB;
		$db->run ('SELECT * FROM `pregunta` WHERE text=?', array($texto));
		$texto_pregunta = $db->data();
		return (!empty($texto_pregunta)) ? true : false;

	}
	public function upgradeLikes($id,$likes){
		$db = new DB;
		$this->likes++;
		$db->run('UPDATE `pregunta` SET likes=? WHERE id=?' , array($likes, $id));

	}

	public function save(){
		$db = new DB;
		return $db->run('INSERT INTO pregunta (uid, likes, author, category, text, date) VALUES (?, 0, ?, ?, ?, NOW())', 
				array($this->uid, $this->author, $this->category, $this->text));
		}
}
