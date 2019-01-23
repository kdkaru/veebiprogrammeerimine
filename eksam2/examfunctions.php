<?php
  require("config.php");
  $database = "if18_karldaniel_ka_1";
  session_start();
  
  
  function signup($firstname, $surname, $studentcode){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	//kontrollime, ega kasutajat juba olemas pole
	$stmt = $mysqli->prepare("SELECT id FROM register WHERE studentcode=?");
	echo $mysqli->error;
	$stmt->bind_param("s",$studentcode);
	$stmt->execute();
	if($stmt->fetch()){
		//leiti selline, seega ei saa uut salvestada
		$notice = "Sellise üliõpilaskoodiga (" .$studentcode .") osaleja on juba olemas!";
	} else {
		$stmt->close();
		$stmt = $mysqli->prepare("INSERT INTO register (firstname, surname, studentcode) VALUES(?,?,?)");
    	echo $mysqli->error;
	    //$options = ["cost" => 12, "salt" => substr(sha1(rand()), 0, 22)];
	    //$pwdhash = password_hash($password, PASSWORD_BCRYPT, $options);
	    $stmt->bind_param("sss", $firstname, $surname, $studentcode);
	    if($stmt->execute()){
		  $notice = "ok";
	    } else {
	      $notice = "error" .$stmt->error;	
	    }
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
 function listallusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, surname, studentcode FROM register WHERE id !=0");
	
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $surname, $studentcode);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$firstname ." " .$surname ." " .$studentcode ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "<p>Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  /* function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, surname, studentcode, payment FROM register WHERE id !=0");
	
	echo $mysqli->error;
	$stmt->bind_param("i", $_SESSION["id"]);
	$stmt->bind_result($firstname, $surname, $studentcode, $payment);
	if($stmt->execute()){
	  $notice .= "<ol> \n";
	  while($stmt->fetch()){
		  $notice .= "<li>" .$firstname ." " .$surname ." " .$studentcode ." " .$payment ."</li> \n";
	  }
	  $notice .= "</ol> \n";
	} else {
		$notice = "<p>Kasutajate nimekirja lugemisel tekkis tehniline viga! " .$stmt->error;
	}
	
	$stmt->close();
	$mysqli->close();
	return $notice;
  } */
  
  
  
  
  function listpaidusers(){
	$html = "";
	$valid = 1;
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, surname, studentcode FROM register WHERE payment=1 ");
	echo $mysqli->error;
	$stmt->bind_param("ii", $_SESSION["userId"], $payment);
	$stmt->bind_result($firstname, $surname, $studentcode);
	$stmt->execute();
	while($stmt->fetch()){
		$html .= "<p>" .$firstname ." " .$surname ."</p> \n";
	}
	$stmt->close();
	$mysqli->close();
	if(empty($html)){
		$html = "<p>Maksnud registreerunuid pole.</p>";
	}
	return $html;
  }
  
  
  function setpayment($payment){
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("UPDATE register SET payment=1 WHERE id=?");
	$stmt->bind_param("i", $payment);
	if($stmt->execute()){
	  echo "Õnnestus";
	  header("Location: adminpage.php");
	  exit();
	} else {
	  echo "Tekkis viga: " .$stmt->error;
	}
	$stmt->close();
	$mysqli->close();
  }
  
  function listusers(){
	$notice = "";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT firstname, surname, studentcode FROM register WHERE id = ?");
	$stmt->bind_param("i", $_SESSION["userId"]);
	$stmt->bind_result($firstname, $surname, $studentcode);
	$stmt->execute();
	if($stmt->fetch()){
		$notice = $unpaiduserslist;
	}
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  function listunpaidusers(){
	$notice = "<ul> \n";
	$mysqli = new mysqli($GLOBALS["serverHost"], $GLOBALS["serverUsername"], $GLOBALS["serverPassword"], $GLOBALS["database"]);
	$stmt = $mysqli->prepare("SELECT id, firstname, surname, studentcode FROM register WHERE payment IS NULL");
	echo $mysqli->error;
	$stmt->bind_result($id, $firstname, $surname, $studentcode);
	$stmt->execute();
	
	while($stmt->fetch()){
		$notice .= "<li>" .$firstname ." " .$surname ." " .$studentcode .'<br><a href="adminpage.php?id=' .$id .'">Vali</a>' ."</li> \n";
	}
	$notice .= "</ul> \n";
	$stmt->close();
	$mysqli->close();
	return $notice;
  }
  
  
  
  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>