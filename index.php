<?php

    // Demarage de la SESSION
    session_start();

    // Chargement du fichier config.php
    require_once "php/config.php";

    /*
    *   Retrieve the last element in the url and modify the url
    */
    function recoveryLastElemToUrl(){

        $statements = preg_split("(/)",$_SERVER["REQUEST_URI"]); // Converti string to array by Regex

        /*
            * Premier methode
        */
            $nbElem = sizeof(preg_split("(/)",FOLDER));
            $id = (sizeof($statements) > $nbElem)?$statements[$nbElem]:0; // Ternair
            unset($statements[$nbElem]);
        /*
            * Seconde methode
            $id = (sizeof($statements) > NBSEPARATOR)?$statements[NBSEPARATOR]:0;
            unset($statements[NBSEPARATOR]);
        */
        $_SERVER["REQUEST_URI"] = implode("/", $statements); // Redefinition de la variable $_SERVER["REQUEST_URI"]

        return $id;
    }

    
    $id = recoveryLastElemToUrl(); // Appel de function

    // Recuperation du chemin ( de l'url apres le nom de domaine)
    // echo $_SERVER["REQUEST_URI"];die(); // Mike/php-object-webforce3/


    if($_SERVER["REQUEST_METHOD"] == "POST"){ // Si la method est POST


        // Test l'existance de la route
        switch($_SERVER["REQUEST_URI"]){


            case FOLDER."user-register": // Chargement de la Class et lancement de la methode
                require "php/Controller/UsersController.php"; // Charger le fichier php
                $usersController = new UsersController();
                $usersController->addUser();
            break;

            case FOLDER."single": // Chargement de la Class et lancement de la methode
                require "php/Controller/ApiController.php"; // Charger le fichier php
                $apiController = new ApiController();
                $apiController->detailItem((int)$id);
            break;

            case FOLDER."shop-list": // Chargement de la Class et lancement de la methode
                require "php/Controller/ApiController.php"; // Charger le fichier php
                $apiController = new ApiController();
                $apiController->searchItem();
            break;

            default: // Redirection vers la route 404
                header("Location: ".HOST.FOLDER."404");


        }

    }elseif($_SERVER["REQUEST_METHOD"] == "GET"){

        switch($_SERVER["REQUEST_URI"]){
            case FOLDER:
                require "php/Controller/HomeController.php";
                $home = new HomeController();
                $home->home();
            break;

            case FOLDER."logout":                       
                require "php/Controller/UsersController.php";
                $usersController = new UsersController();
                $usersController->logClientOut();
            break;
            
            case FOLDER."single":
                require "php/Controller/ShopController.php";
                $shop = new ShopController();
                $shop->single((int)$id);
            break;
            
            case FOLDER."404":
                require "php/Controller/Controller.php";
                Controller::show404();
                
            break;

            case FOLDER."shop-list": // Chargement de la Class et lancement de la methode
                require "php/Controller/ShopController.php"; // Charger le fichier php
                $apiController = new ShopController();
                $apiController->shopListView();
            break;

            default:
                header("Location: ".HOST.FOLDER."404");
        }


    }