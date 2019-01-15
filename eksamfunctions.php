<?php
  //laen andmebaasi info
    require("config.php");
  $database = "if18_karldaniel_ka_1";
  
   //võtan kasutusele sessiooni
  session_start();
  
  
  
  
  //auto andmete
  function savecar($kiirus, $numbrimark, $regioon){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"],$GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("INSERT INTO autod (kiirus, numbrimark, regioonid) VALUES(?, ?, ?)");
	echo $mysqli->error;
	//asendame SQL käsus küsimargi päris infoga (andmetüüp, andmed ise)
	//s - string; i - integer; d - decimal
	$stmt->bind_param("iss", $kiirus, $numbrimark, $regioon);
	if($stmt->execute()){
		  $notice = "ok";
	    } else {
	      $notice = "error" .$stmt->error;	
	    }
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  
   //tekstsisestuse kontroll
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  
  function listcars(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT kiirus, numbrimark, regioonid FROM autod WHERE  id !=?");
	
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["id"]);
	$stmt->bind_result($kiirus, $numbrimark, $regioon);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$kiirus ." " .$numbrimark ." " .$regioon ." </li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "<p>Autode nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  
 