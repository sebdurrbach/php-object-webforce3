<?php
    require "Controller.php";
    class ApiController extends Controller{

        public function __construct(){
            parent::__construct();
        }

        public function detailItem($id){
            $picturesItem = $this->itemsModel->listenerPicturesItem($id);
            $reviewsItem = $this->itemsModel->listenerReviewsItem($id);
            echo json_encode( array("pictures" => $picturesItem,"reviews"=>$reviewsItem) );
        }

        public function searchItem(){
            $sql = "";
            $search = false;
            if(isset($_POST["price"])){  //$_post[price]=valeur 1 and valeur 2
                $sql .= " price BETWEEN ".$_POST["price"]. " AND ";
                $search = true;
            }
            if(isset($_POST["categorie"])){  
                $sql .=" categories_idcategories = ".$_POST["categorie"]." AND ";
                $search = true;
            }

            // $sql = "price BETWEEN 20 AND 100";
            if ($search == false) {
                $sql = 1;
            } else {
                $sql .= " iditems = items_iditems GROUP BY iditems";
            }

            $items = $this->itemsModel->select("i.*, p.url","items i, pictures p", $sql);
            echo json_encode($items);
        }

    }