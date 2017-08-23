<?php 
   require "UsersModel.php"; // Charger le fichier php
	class UsersController{
        
        public function addUser(){
            $error = $this->arrayIsEmpty($_POST, array("firstname","lastname","email","password"));
            if($error == -1)
                return -1;
            $dbUser = new UsersModel();
            $user = $dbUser->listenerClientsByEmail($_POST['email']);

            if(count($user) >= 1)
                return -1;

            $_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT); // cryptage du mdp.
            return $dbUser->addUser($_POST);
        }


        public function arrayIsEmpty($data = array(), $keyObligatory = array()){
            if(!is_array($data))
                return -1;
            
            $isOk = false;

            foreach($data as $key => $val){
                foreach($keyObligatory as $valO)
                    if($valO == $key)
                        $isOk = true;
                if(!$isOk || empty(trim($val))){
                    return -1;die();
                }
            }

            return 1;
        }

    }