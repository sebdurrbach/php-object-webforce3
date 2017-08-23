<?php
	require "crud.php"; // Charger le fichier php
	class Items extends CRUD{

		function __construct() {
			parent::__construct();
        }

        public function addItem($item = array()){
			if(!isset($item['libelle'])){
				return 0;
			}
			elseif(!isset($item['description'])){
				return 0;
			}
			elseif(!isset($item['availabity']) && !is_int($item['availabity'])){
				return 0;
			}
			elseif(!isset($item['price'])){
				return 0;
			}
			elseif(!isset($item['categories_idcategories']) && !is_int($item['categories_idcategories'])){
				return 0;
			}
			
			$item['code_item'] = $this->randomByAlphaNum("Items");
			return $this->insert( $item, "items" );
		}
        
        public function updateItem($itemData){
			if(!isset($itemData['iditems'])){
				return 0;
			}
            $idItem = array("iditems" => $itemData['iditems']);
            unset($itemData['iditems']);
            $this->update($itemData, $idItem, "items");
        }
        
        public function deleteItem($item = array()){
            if(!isset($item['iditems'])){
                return 0;
            }
            return $this->delete( $item, "items" );
        }

        public function addOrderByItem($orderId, $itemId, $qte){
			if (!is_int($orderId)) {
				return 0;
			} elseif (!is_int($itemId)) {
				return 0;
			}
			
			$price = $this->select("price", "items", array("iditems" => $itemId));
			$priceTotal = $price[0]["price"] * $qte;
			$priceTotal = number_format($priceTotal, 2, '.', '');
			settype($priceTotal, "float");
			$idOrderByItem = $this->insert( array("orders_idorders"=>$orderId, "items_iditems"=>$itemId, "price_final" => $priceTotal, "qte" => $qte), "orders_has_items");
		}

    }

    $test = new Items();
    $test->addOrderByItem(1,2,5);

	/**
		-- Phase de test --

    $id = $test->addItem( array("libelle" =>"tt", "description"=>"test1", "availabity"=>2, "price"=>2.2, "categories_idcategories"=>1) );
    echo $id;
    $test->updateItem( array("iditems" =>1, "libelle"=>"test1") );
    sleep(10);
    $test->deleteItem( array("iditems" =>$id) );

		-- End Test --
	**/