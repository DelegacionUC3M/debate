<?php

/**
* Clase correspondiente a los usuarios
**/
class User {
    
    /** User identifier. **/
	public $uid; 
    /** User full name. **/
    public $cn; 
    /** User email account.**/
    public $mail; 
    /** User LDAP path.**/
    public $dn;
    /** User rol (10 student, 100 admin) **/
    public $rol;
    /**  User category (Personal de Administracion y Servicios, Alumno...) **/
    public $category;

    /**
    * Constructor de la clase
    *
    * @param string     $nia    Nia del usuario
    * @param string     $name   Nombre del ususario
    * @param string     $email  Email del usuario
    * @param string     $dn     Ruta LDAP del usuario
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