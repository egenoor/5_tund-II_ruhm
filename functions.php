<?php

	require("../../config.php");

	//functions.php
	//var_dump($GLOBALS)
	
	// see fail peab olema kõigil lehtedel, kus tahan
	//kasutada SESSION muutujat
	session_start();
	
	//*****************
	//**** SIGNUP *****
	//*****************	
		
	function signUp ($email, $password)	{
		
		$database = "if16_ege";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		//sqli rida
		$stmt = $mysqli->prepare("INSERT INTO user_sample (email, password) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $email, $password);
		
		//täida käsku
		if($stmt ->execute() ) {
			
			echo "salvestamine õnnestus";
			
		} else {
			echo "ERROR ". $stmt->error;
		}
		
	$stmt->close();
	$mysqli->close();
		
		
		
		
	}
		
	function login ($email, $password) {
		
		$error = "";
		
		
		$database = "if16_ege";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		//sqli rida
		$stmt = $mysqli->prepare("
		SELECT id, email, password, created 
		FROM user_sample WHERE email = ?");
		
		echo $mysqli->error;
		
		//asendan küsimärgi s on string (d on komaga arv, i on täisarv)
		$stmt->bind_param("s", $email);
		
		//määran väärtused muutujatesse
		$stmt->bind_result($id, $emailFromDb, $passwordFromDb, $created);
		$stmt->execute();
		
		//andmed tulid andmebaasist või mitte
		//on tõene kui on vähemalt üks vaste
		if($stmt->fetch()){
			
			//oli sellise emailiga kasutajat
			//password millega kasutaja tahab sisse logida
		$hash = hash("sha512", $password);
		if ($hash == $passwordFromDb) {
			echo "kasutaja logis sisse" .$id;
			
			$_SESSION["userId"] = $id;
			$_SESSION["userEmail"] = $emailFromDb;
			
			$_SESSION["message"] = "<h1>Tere tulemast!</h1>";
			
			//määran sessiooni muutujad millele saan ligi teistelt lehtedelt
			header("Location: data.php");
			
		} else {
			$error = "vale parool";
			
		}
		
		} else {
			
			//ei leidnud kasutajat selle nimega
			$error = "ei ole sellist emaili";
		}
			
		return $error; 
		
	}	
		

		
		//*****************
		//*****SAVECAR*****
		//*****************
		
		function saveCar ($plate, $color) {
		
		$database = "if16_ege";
		$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
	
		//sqli rida
		$stmt = $mysqli->prepare("INSERT INTO cars_and_colors (plate, color) VALUES (?, ?)");
		
		echo $mysqli->error;
		
		$stmt->bind_param("ss", $plate, $color);
		if($stmt ->execute() ) {
			
			echo "salvestamine õnnestus";
			
		} else {
			echo "ERROR ". $stmt->error;
		}
		
	$stmt->close();
	$mysqli->close();
		
		
		}
	
		
		function getAllCars() {
		
			$database = "if16_ege";
			$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $database);
		
			$stmt = $mysqli->prepare("
			
			SELECT id, plate, color
			FROM cars_and_colors
			");
			
			echo $mysqli->error;
			
			$stmt->bind_result($id, $plate, $color);
			$stmt->execute();
			
			//tekitan massiivi
			$result = array();
			
			//tee seda seni, kuni on rida andmeid
			//mis vastab select lausele
			while($stmt->fetch()) {
				
				
			//tekitan objekti
			$car = new StdClass();
			
			$car->id = $id;
			$car->plate = $plate;
			$car->color = $color;	
			
				//echo $plate."<br>";
				//igakord massiivi lisan juurde nr märgi
				array_push($result, $car);				
			}
			
		
			
			$stmt->close();
			$mysqli->close();
		
		return $result;
		
	}
		
		
		
		
		
		
		
		
		

		
		

?>