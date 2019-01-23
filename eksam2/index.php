<?php
  
  require("examfunctions.php");
  $notice = "";
  $firstname = "";
  $surname = "";
  $studentcode = "";
  $userslist = listusers();
  $paiduserslist = listusers();
  $firstnameError = "";
  $surnameError = "";
  $studentcodeError = "";
  $paidusers = listpaidusers();
  $unpaiduserslist = listunpaidusers();
  $alluserslist = listallusers();
 
  
 
  if(isset($_POST["submitUserData"])){
  
  if (isset($_POST["firstname"]) and !empty($_POST["firstname"])){
	$firstname = test_input($_POST["firstname"]);
  } else {
	  $firstnameError = "Palun sisesta eesnimi!";
  }
  
  if (isset($_POST["surname"]) and !empty($_POST["surname"])){
	$surname = test_input($_POST["surname"]);
  } else {
	  $surnameError = "Palun sisesta perekonnanimi!";
  }
  
  if(isset($_POST["studentcode"])){
	$studentcode = test_input($_POST["studentcode"]);
  } else {
	  $studentcodeError = "Palun sisesta üliõpilaskood!";
  }
  
  //kui kõik on korras, siis salvestame kasutaja
  if(empty($nameError) and empty($surnameError) and empty($studentcodeError) ){
    $notice = signup($firstname, $surname, $studentcode);
  }
  }
  
?>
 
<!DOCTYPE html>
<html>
<title>Registreerumisleht</title>
<body>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Eesnimi:</label><br>
	  <input name="firstname" type="text" value="<?php echo $firstname; ?>"><span><?php echo $firstnameError; ?></span><br>
      <label>Perekonnanimi:</label><br>
	  <input name="surname" type="text" value="<?php echo $surname; ?>"><span><?php echo $surnameError; ?></span><br>
	  <label>Üliõpilaskood (6 numbrit):</label><br>
	  <input name="studentcode" type="text" value="<?php echo $studentcode; ?>"><span><?php echo $studentcodeError; ?></span><br>
	  <input name="submitUserData" type="submit" value="Registreeri"><span><?php echo $notice; ?></span>
</form>
<hr>
<h1>registreerinud:</h1>
	
	<?php echo $alluserslist; ?>
<hr>	
<h1>kindlad tulijad:</h1>
	
	
	<?php
    echo $paidusers;
  ?>







 </body>
</html>
	  