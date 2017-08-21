<?php

class CRUD {
	private $host;
	private $user;
	private $password;
	public $database;
	private $pdo;

	function __construct($host == '', $user == '', $password == '', $database == '') {
		require_once "config.php";
		$this->host = DB_HOST;
		$this->user = DB_USER;
		$this->password = DB_PASSWORD;
		$this->database = DB_NAME;
		$this->pdo = new PDO('mysql:host='.$this->host.';dbname='.$this->database,$this->user,$this->password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
	}

	public function select($champs = '*', $table = '', $where = 1) {

		$theChamps = $this->arrayToString($champs);
		$theChamps = $this->arrayToString($champs, 3);

		try {
			$result = $this->pdo->query("SELECT $theChamps FROM $table");
			return $result->fetchAll(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			echo "Votre traitement n'a pas abouti \n";
			// echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function insert($champs, $values, $table = '') {
		$theChamps = $this->arrayToString($champs);
		$theValues = $this->arrayToString($values, 2);

		try {
			$result = $this->pdo->prepare("INSERT INTO $table ($theChamps) VALUES ($theValues)");
			$result->execute();
			return $this->pdo->lastInsertId();
		} catch (Exception $e) {
			echo "Votre traitement n'a pas abouti \n";
			// echo 'Exception reçue : ',  $e->getMessage(), "\n";
		}
	}

	public function update($table = '', $champs, $where) {

		$theChamps = $this->arrayToString($champs, 4);
		$where = $this->arrayToString($where, 3);

		try {
			$result = $this->pdo->prepare("UPDATE $table SET $theChamps WHERE $where");
			$result->execute();
		} catch (Exception $e) {
			echo "Votre traitement n'a pas abouti \n";
		}
		
	}

	public function delete($table = '', $champs) {

		$theChamps = $this->arrayToString($champs, 3);

		try {
			$result = $this->pdo->prepare("DELETE FROM $table WHERE $theChamps");
			$result->execute();
		} catch (Exception $e) {
			echo "Votre traitement n'a pas abouti \n";
		}
		
	}

	public function insert2($champs, $table){ // Avec un array_assoc        
		$theChamps ="";
        $theNewChamps = array();
        $point ="";            
        //Passer l'array $champs en string utilisable dans la requête/
        if (is_array($champs)) {
            foreach ($champs as $key => $value) {
                $theChamps .= trim($key).',';
                array_push($theNewChamps, trim($value));
                $point .= "?,";
            }
            $theChamps = substr($theChamps,0,-1);
            $point = substr($point,0,-1);
        } else {
            $theChamps = $champs;
        }            
        $result = $this->pdo->prepare("INSERT INTO $table ($theChamps) VALUES ($point)");
        $result->execute($theNewChamps);
        
    }

	/*******************************************************************/

	private function arrayToString($champs, $type = 'select') {
		$theChamps = "";
		if (is_array($champs)) { // Si c'est un tableau
			if ($type == 1) { // Pour l'INSERT, les valeurs doivent être insérées entre quotes
				foreach ($champs as $champ) {
					$theChamps .= $champ.',';
				}
			} elseif ($type == 3) {
				foreach ($champs as $key => $value) {
					$theChamps = $theChamps.$key." = '".$value."' AND ";
				}
				$theChamps = substr($theChamps, 0,-4);
			} elseif ($type == 4) {
				foreach ($champs as $key => $value) {
					$theChamps = $theChamps.$key." = '".$value."',";
				}
			} else { // Type 2
				foreach ($champs as $champ) {
					$theChamps .= "'".$champ."',";
				}
			}
			$theChamps = substr($theChamps, 0,-1); // Delete de la dernière virgule
		} else {
			$theChamps = $champs; // Si ce n'est pas un tableau 
		}
		return $theChamps;
	}

}

$bd = new CRUD("localhost", "root", "", "mike-js");
// $bd->select(array("nom", "prenom"), "users");
// $bd->insert(array("nom", "prenom"), array("Mike", "Mike"), "users");
// $bd->delete("users", array('nom'=>'durrbach', "id" => 7));
$bd->update("users", array("nom" => "Sylvestre", "prenom" => "Mike", "age" => 2), array("id" => 6));

?>