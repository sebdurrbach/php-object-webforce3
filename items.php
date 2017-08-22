<?php

require "crud.php";

class Items extends CRUD {

	function __construct() {
		parent::__construct();
	}

	public function addItem($item, $categorie) {

		if (!is_string($item['libelle'])) {
			return 0;
		} elseif (!is_string($item['description'])) {
			return 0;
		} elseif (!is_int($item['availabity'])) {
			return 0;
		} elseif (!is_numeric($item['price'])) {
			return 0;
		} elseif (!is_int($categorie)) {
			return 0;
		} 

		$item["code_item"] = $this->randomByItemAlphaNum();
		$item["categories_idcategories"] = $categorie;

		var_dump($item);

		$isItem = $this->insert($item, "items");

	}

	public function updateItem($item) {

		if (!isset($item["iditems"])) {
			return 0;
		}

		$iditem = array("iditems" => $item["iditems"];
		unset($item["iditems"]);
		$this->update($item, $iditem, "items");

	} 

	public function deleteItem($item) {

		if (!isset($item["iditems"])) {
			return 0;
		}

		$this->delete($item, "items");
	}





	//**************************************************************

	private function randomByItemAlphaNum() {
		return "#".substr(md5(uniqid("User", true)), 10);
	}

}
	
$test = new Items();


/**

	-- Phase de test --

	$test->addItem(array("libelle" => "Verveine", "description" => "Verveine des Alpes", "availabity" => 1, "stocks" => 25, "price" => 5.50), 1);
	$test->updateItem(array("description" => "Verveine des Alpes", "iditems" => 3));
	$test->deleteItem(array("iditems" => 3));

	-- End Test --

**/


?>