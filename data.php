<?php


	require("functions.php");
	
	//kui ei ole kasutaja id'd
	if (!isset($_SESSION["userId"])) {
		
		//suunan sisselogimise lehele
		header("Location: login.php");
		
	}

	//kui on ?logout aadressi real siis login välja
	if(isset ($_GET["logout"])) {
		
		session_destroy();
		header("Location:login.php");
	}

	$msg = " ";
if(isset($_SESSION["message"])) {
	$msg = $_SESSION["message"];
	
		//kui ühe näitame siis kusutua ära, et pärast refreshi ei näita
	unset($_SESSION["message"]);
	
		}

		
	if(isset($_POST["plate"]) &&
		isset($_POST["color"]) &&
		!empty($_POST["plate"]) &&
		!empty($_POST["color"])
		) {
			
		saveCar($_POST["plate"], $_POST["color"]);
		
			
		}
		
		//Saan kõik auto andmed
		$carData = getAllCars();
		echo "<pre>";
		var_dump($carData);
		echo "</pre>";
?>

<h1>Data</h1>
<?=$msg;?>

<p> Tere tulemast <?=$_SESSION["userEmail"];?>!</p>
<a href="?logout=1"> Logi välja </a> 


<h2> Salvesta auto </h2>

<form method="POST">
<label>Auto nr:</label><br>
<input name="plate" type="text"> 
			
<br><br>

<label>Auto värv:</label><br>
<input type="color" name="color">
<br><br>
<input type="submit" value="Salvesta">


</form>

<h2>Autod</h2>

<?php
	
	$html = "<table>";
	
	$html .= "<tr>";
		$html .= "<th>id</th>";
		$html .= "<th>plate</th>";
		$html .= "<th>color</th>";
	$html .= "</tr>";
	
	
	//iga liikme kohta massiivis
	foreach($carData as $c){
		//iga auto on $c
		//echo $c->plate."<br>";
		
	
	$html .= "<tr>";
		$html .= "<td>".$c->id."</td>";
		$html .= "<td>".$c->plate."</td>";
		$html .= "<td style='background-color:".$c->color."'>".$c->color."</td>";
	$html .= "</tr>";
		
	}
	
	$html .= "</table>";

		echo $html;
		
		
		$listHtml = "";
		
		foreach($carData as $c) {
			
			$listHtml .= "<h1 style='color:".$c->color."'>".$c->plate."</h1>";
			$listHtml .= "<p>color = ".$c->color."</p>";
		}
		 
		echo $listHtml;
		
		
		
		
	
?>

<br><br>
<br><br>