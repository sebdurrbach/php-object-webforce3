<?php

require "crud.php";

class Users extends CRUD { // CreateReadUpdateDelete

	function __construct() {
		parent::__construct();
	}

	public function addUser($user = array()) {
		if (!isset($user['firstname'])) {
			return 0;
		} elseif(!isset($user['lastname'])) {
			return 0;
		} elseif (!isset($user['email'])) {
			return 0;
		} elseif (!isset($user['password'])) {
			return 0;
		}

		$user['password'] = password_hash($user['password'], PASSWORD_DEFAULT); // cryptage du mdp.
		$this->insert($user, "clients" );
	}

	public function addFavorite($userId, $itemId) {

		if (!is_int($userId)) {
			return 0;
		} elseif (!is_int($itemId)) {
			return 0;
		}

		$idFavorite = $this->insert(array("clients_idclients" => $userId, "items_iditems" => $itemId), "clients_has_items");

	}

	public function listFavorite($userId) {

		if (!is_int($userId)) {
			return 0;
		}

		$myFavorite = $this->select("*", "listFavorite", array("idclients" => $userId));
		var_dump($myFavorite);
	}

	public function addDelivery($userId, $delivery) {

		if (!is_int($userId)) {
			return 0;
		} elseif (!is_int($delivery['street'])) {
			return 0;
		} elseif (!is_int($delivery['city'])) {
			return 0;
		} elseif (!is_int($delivery['country'])) {
			return 0;
		} 

		$delivery["clients_idclients"] = $userId;
		$idDelivery = $this->insert($delivery, "delivery");
	}


	public function listDelivery($userId, $type = null) {

		if (!is_int($userId)) {
			return 0;
		}

		if ($type == null) {
			$myDelivery = $this->select("*", "delivery", array("clients_idclients" => $userId));
		} else {
			$myDelivery = $this->select("*", "delivery", array("clients_idclients" => $userId, "type" => $type));
		}
		
		var_dump($myDelivery);
	}

	public function addOrder($userId, $deliveryId) {

		// Status --> 0 = Pas payé / 1 = Payé / 2 = En cours / 3 = Envoyé / 4 = Devis.

		if (!is_int($userId)) {
			return 0;
		} elseif (!is_int($deliveryId)) {
			return 0;
		} 

		$order = array("num_order" => $this->randomByUserAlphaNum());
		$order["clients_idclients"] = $userId;
		$order["delivery_iddelivery"] = $deliveryId;
		$isOrder = $this->insert($order, "orders");

	}

	public function listOrder($userId, $dateOrder = null) {

		if (!is_int($userId)) {
			return 0;
		}

		if ($dateOrder == null) {
			$myOrders = $this->select("*", "orders", array("clients_idclients" => $userId));
		} else {
			$myOrders = $this->select("*", "orders", array("clients_idclients" => $userId, "date_order" => $dateOrder));
		}
		
		var_dump($myOrders);
	}

	//****************************************************************************************

	private function randomByUserAlphaNum() {
		return "#".substr(md5(uniqid("User", true)), 10);
	}

}

$test = new Users();

/**

	-- Phase de test --

	$test->addUser(array('firstname' => "Mike", 'lastname' => "Sylvestre", 'email' => "mike@mike.mike", 'password' => "password"));
	$test->addFavorite(1,2);
	$test->listFavorite(1);
	$test->listDelivery(1, "Livraisons");
	$test->listOrder(1);

	-- End Test --

**/



?>