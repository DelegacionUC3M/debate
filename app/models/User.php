<?php

class User {
	public $uid; // User identifier.
    public $cn; // User full name.
    public $mail; // User email account.
    public $dn; // User LDAP path.
    public $rol; //User rol (10 student, 100 admin)
    public $category; //User category (Personal de Administracion y Servicios, Alumno, )

    public function __construct($nia,$name,$email,$dn) {
    	$this->uid = $nia;
    	$this->cn = $name;
    	$this->mail = $email;
    	$this->dn = $dn;
        $this->$rol = DBDelegados::getRol($nia);
    	//Pedir a la base de datos si el nia esta en la tabla de usuarios.

    	$cat = explode(",",$dn);
    	$cat = str_replace("ou=", "", $cat[2]);
    	$this->category = $cat;
    }
}