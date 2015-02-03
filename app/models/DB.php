<?php
/*
The MIT License (MIT)

Copyright (c) 2014 Mario Montes mmontesgonz@gmail.com

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.
*/

class DB {
// Connection configurations
	private $host = SQL_HOST;
	private $user = SQL_USER;
	private $pass = SQL_PASSWD;
	private $dbs;
	private $db;
	private $stmt;
	function __construct($dbs = SQL_DB) {
		$this->dbs = $dbs;
		$this->db = new PDO('mysql:host='.$this->host.';dbname='.$this->dbs.';charset=utf8', $this->user, $this->pass);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}
// Prepares and executes the queries
	public function run($sql,$data = array()) {
		$this->stmt = $this->db->prepare($sql);
	try {
		return $this->stmt->execute($data);
	} catch(PDOException $e) {
		print_r($e);
		return false;
	}
	}
// Returns an array with the data of the query
	public function data() {
		return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	}
// Counts the number of rows of the data returned
	public function count() {
		return $this->stmt->rowCount();
	}
}
