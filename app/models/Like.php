<?php 
class Like {
	public $id;
	public $id_pregunta;
	public $uid;
	public $author;
	public $date;
	public $text;

	public function save(){
		$db = new DB;
		$db->run('INSERT INTO `like` (id_pregunta, uid, author, date) VALUES (?,?,?,NOW())',
				array($this->id,$this->uid, $this->author));
	}
	
	public static function getLikes($id){
		$db = new DB;
		$db->run('SELECT * FROM `like` WHERE id_pregunta=?', array($id));
		$likes = $db->data();
		return count($likes)+1;
	}

	public static function isSetLike($author_id, $id_pregunta){
		$db = new DB;
		$db->run('SELECT * FROM `like` WHERE uid=? AND id_pregunta=?', array($author_id,$id_pregunta));
		$author = $db->data();
		return (!empty($author)) ? true : false;
	}
	
	public static function ownLike($author_id,$id){
		$db = new DB;
		$db->run('SELECT * FROM `pregunta` WHERE uid=? AND id=?', array($author_id,$id));
		$author_pregunta = $db->data();
		return (!empty($author_pregunta)) ? true : false;
	}

	
	public static function getId($texto){
		$db = new DB;
		$db->run('SELECT * FROM `pregunta` WHERE text=?', array($texto));
		$pregunta = $db->data();
		return $pregunta[0]['id'];
	}

}
