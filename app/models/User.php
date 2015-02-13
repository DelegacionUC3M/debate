<?php

/**
* Clase correspondiente a los usuarios
**/
class User {
	public $uid; // User identifier.
    public $cn; // User full name.
    public $mail; // User email account.
    public $dn; // User LDAP path.
    public $rol; //User rol (10 student, 100 admin)
    public $category; //User category (Personal de Administracion y Servicios, Alumno, )

    /**
    * Constructor de la clase
    *
    * @param ???    $nia    Nia del usuario
    * @param ???    $name   Nombre del ususario
    * @param ???    $email  Email del usuario
    * @param ???    $dn     Ruta LDAP del usuario
    **/
    public function __construct($nia,$name,$email,$dn) {
    	$this->uid = $nia;
    	$this->cn = $name;
    	$this->mail = $email;
    	$this->dn = $dn;
        $rol = DBDelegados::getRol($nia);
        $this->rol = !empty($rol) ? $rol : 10;
    	//Pedir a la base de datos si el nia esta en la tabla de usuarios.

    	$cat = explode(",",$dn);
    	$cat = str_replace("ou=", "", $cat[2]);
    	$this->category = $cat;
    }
}