<?php
    if($_POST){
        if($_POST["type"] == "register"){
            require "UsersController.php"; // Charger le fichier php
            unset($_POST["type"]);
            $test = new UsersController();
            $redirect = $test->addUser();
            if($redirect == -1)
                header("Location: http://localhost/php-object-webforce3/404.html");
            else
                header("Location: http://localhost/php-object-webforce3/index.html");
        }

    }