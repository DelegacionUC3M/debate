<?php
class DBDelegados {
	public static function getRol() {
		$db = new DB(SQL_DB_DELEGADOS);
		$db->run();
		$data = $db->data();
		return $data[0]['rol'];//Añadir la tabla permisos a la db delegados
	}
}