<?php
    require "Controller.php";
    class HomeController extends Controller{
        public function __construct(){
            parent::__construct();
        }
        public function home(){
            $itemsHome=$this->itemsModel->listenerItems();
            include("home.php");
        }
    }