<?php

class Users {

	private $db;

	function __construct() {

		$db = new CRUD("localhost", "root", "", "myshop");

	}

	public function addUser($user = array()) {

		if(!isset($user['firstname'])){
			return 0;
		} elseif(!isset($user['lastname'])){
			return 0;
		} elseif(!isset($user['email'])){
			return 0;
		} elseif(!isset($user['password'])){
			return 0;
		}

		$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT); // cryptage mdp

		$this->db->insert(array("firstname", "lastname", "email", "password"), $user, "clients");

	}

	public function connexion($email, $password, $bd) {
		$password = $bd->select("*", "clients", $this->email);
		if ($password == $this->password) {
			return 
		}
	}

}

?>