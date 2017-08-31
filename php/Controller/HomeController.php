<?php
    require "Controller.php";
    class HomeController extends Controller{

        public function  __construct(){
            parent::__construct();
        }

        /*
        *   Appeller au lancement de la route par default (la route /)
        */
        public function home(){
            $itemsHome = $this->itemsModel->listenerItems(); // Recupération des items de ma bdd ( par default les 8 permier items)
            include("home.php"); // Chargement de la view (page home.php)
        }
    }