<?php
  //kutsume välja funktsioonide faili
  require("functions.php");
  $notice = "";
  $firstName = "";
  $lastName = "";
  $birthMonth = null;
  $birthDay = null;
  $birthYear = null;
  $birthDate = null;
  $gender = null;
  $email = "";
  
  
   
  $firstNameError = "";
  $lastNameError = "";
  $birthMonthError = null;
  $birthDayError = null;
  $birthYearError = null;
  $birthDateError = null;
  $genderError = null;
  $emailError = "";
  $passwordError = "";
  
  $monthNamesET = ["jaanuar", "veebruar", "märts", "aprill", "mai", "juuni","juuli", "august", "september", "oktoober", "november", "detsember"];
  
  
  //kontrollime, kas kasutaja on nuppu vajutanud
  
  if(isset($_POST["submitUserData"])){
  //var_dump($_POST);
  if (isset($_POST["firstName"]) and !empty($_POST["firstName"])){
	  //$firstName = $_POST["firstName"];
	  $firstName = test_input($_POST["firstName"]);
  } else {
	 $firstNameError = "palun sisesta oma eesnimi";
  }
  if (isset($_POST["lastName"]) and !empty($_POST["lastName"])){
	  //$lastName = $_POST["lastName"];
	  $lastName = test_input($_POST["lastName"]);
  } else {
	 $lastNameError = "palun sisesta oma perekonnanimi";
  }
  if (isset($_POST["gender"]) and !empty($_POST["gender"])){
	  $gender = intval($_POST["gender"]);
  } else {
	  $genderError = "Palun vali sugu";
  }
  
  //kui päev ja kuu ja aasta on olemas, kontrollitud
  //võiks ju hoopis kontrollida, kas kuupäevadega seotud error muutujad on endiselt tühjad
  if(isset($_POST["birthday"]) and isset($_POST["birthMonth"]) and isset($_POST["birthyear"])){
  
	//kas oodatav kuupäev on üldse võimalik
	  //checkdate(kuu, päev, aasta) tahab täisarve
	  if(checkdate(intval($_POST["birthMonth"]), intval($_POST["birthday"]), intval($_POST["birthyear"]))){
 
		$birthDate = date_create($_POST["birthMonth"] ."/" .$_POST["birthDay"] ."/" .$_POST["birthYear"]);
		$birthDate = date_format($birthDate, "Y-m-d");
		
		}
	 else  {
		 $birthDateError = "Palun vali võimalik kuupäev";
	 }
  }
	 
	 //kui kõik on korras, salvestan kasutaja
	   if(empty($firstNameError) and empty($lastNameError) and empty($birthMonthError) and empty($birthDayError) and empty($birthDateError) and empty($birthYearError) and empty($genderError) and empty($emailError) and empty($passwordError)) {
	$notice = signup($firstName, $lastName, $birthDate, $gender, $_POST["email"], $_POST["password"]);
	  
  }
	 
	 
	 
  }//kui on üldse vajutatud, lõpp
	  
  
  

 
?>
   
   <!--//kas vajutati nuppu - lõpp--!>
   

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>
	  <?php
	    echo $firstName;
		echo " ";
		echo $lastName;
	  ?>
	, õppetöö</title>
</head>
<body>
	<h1>
	  Sisesta oma andmed, loo kasutaja</h1>
	<p>See leht on loodud <a href="http://www.tlu.ee" target="_blank">TLÜ</a> õppetöö raames, ei pruugi parim väljanäha ning kindlasti ei sisalda tõsiseltvõetavat sisu!</p>
	
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Eesnimi:</label><br>
	  <input type="text" name="firstName"> <value="<?php echo $firstName; ?>"><span><?php echo $firstNameError; ?></span><br>
	  <label>Perekonnanimi:</label><br>
	  <input type="text" name="lastName"> <value="<?php echo $lastName; ?>"><span><?php echo $lastNameError; ?></span><br>
	  <label>Sünnipäev: </label>
	  <?php
	    echo '<select name="birthDay">' ."\n";
		for ($i = 1; $i < 32; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthDay){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünnikuu: </label>
	  <?php
	    echo '<select name="birthMonth">' ."\n";
		for ($i = 1; $i < 13; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $birthMonth){
				echo " selected ";
			}
			echo ">" .$monthNamesET[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <label>Sünniaasta: </label>
	  <!--<input name="birthYear" type="number" min="1914" max="2003" value="1998">-->
	  <?php
	    echo '<select name="birthYear">' ."\n";
		for ($i = date("Y") - 15; $i >= date("Y") - 100; $i --){
			echo '<option value="' .$i .'"';
			if ($i == $birthYear){
				echo " selected ";
			}
			echo ">" .$i ."</option> \n";
		}
		echo "</select> \n";
	  ?>

	  <br>
	  
	  <input type="radio" name="gender" value="2" <?php if($gender = 2) {echo "checked";} ?>><label>Naine</label><br>
	  <input type="radio" name="gender" value="1" <?php if($gender = 1) {echo "checked";} ?>><label>Mees</label><br>
	  <span><?php echo $genderError; ?></span>
	  <br>
	  <label>E-postiaadress (kasutajatunnuseks):</label><br>
	  <input name="email" type="email">
	  <br>
	  <br>
	   <label>Salasõna (min 8 märki):</label><br>
	  <input name="password" type="password">
	  
	  <input type="submit" name="submitUserData" value="Loo kasutaja">
    </form>
	<hr>
	<?php
	  if (isset($_POST["firstName"])){
	    echo "<p>" .$fullName .", olete elanud järgnevatel aastatel: </p> \n";
		echo "<ol> \n";
		  for ($i = $_POST["birthYear"]; $i <= date("Y"); $i ++){
			echo "<li>" .$i ."</li> \n";  
		  }
		echo "</ol> \n";
      }
	?>
</body>
</html>





