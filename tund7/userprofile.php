<?php
  require("functions.php");
  
  //kui pole sisseloginud, siis logimise lehele
  if(!isset($_SESSION["userId"])){
	header("Location: index_1.php");
	exit();  
  }
  
  //logime välja
  if(isset($_GET["logout"])){
	session_destroy();
    header("Location: index_1.php");
	exit();
  }
  
  
  
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
	<title>profiil</title>
  </head>
  <body>
    <h1>Profiili valimine</h1>
	<hr>
	<p>Oled sisse loginud nimega: <?php echo $_SESSION["firstName"] ." " .$_SESSION["lastName"] ."."; ?></p>
	<ul>
     <li><a href="main.php">Tagasi</a> pealehele!</li>
	 <textarea rows="10" cols="80" name="description"><?php echo $mydescription; ?></textarea></br>
	 <label>Minu valitud taustavärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	 <label>Minu valitud tekstivärv: </label><input name="bgcolor" type="color" value="<?php echo $mybgcolor; ?>"><br>
	
  </body>
</html>
