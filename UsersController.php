<?php

require "UsersModel.php";

class UsersController {

	public function addUser() {

		$error = $this->arrayIsEmpty($_POST, array("firstname", "lastname", "email", "password"));

		if ($error == -1)
			return -1;

		$dbUser = new UsersModel();
		$user = $dbUser->listenerClientsByEmail($_POST['email']);

		if (count($user) >= 1)
			return -1;

		$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT); // crypt du mdp

		return $dbUser->addUser($_POST);
		
	}

	public function arrayIsEmpty($data = array(), $keyObligatory = array()) {
		if (!is_array($data)) 
			return -1;
		
		$isOk = false;

		foreach ($data as $key => $val) {
			foreach ($keyObligatory as $valO)
				if ($valO == $key)
					$isOk = true;
			if (!$isOk || empty(trim($val)))
				return -1;
		}

		return 1;

	}

}
	



?>