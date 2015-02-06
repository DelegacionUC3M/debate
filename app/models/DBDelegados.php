<?php
class DBDelegados {
	public static function getRol($nia) {
		$db = new DB(SQL_DB_DELEGADOS);
		$db->run('SELECT permisos.rol FROM permisos LEFT JOIN personas ON personas.id = permisos.id_user
				where personas.nia = ? AND permisos.app_id = 3;',array($nia));
		$data = $db->data();
		return $data[0]['rol'];//Añadir la tabla permisos a la db delegados
	}
}