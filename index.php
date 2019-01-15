<?php
  require("eksamfunctions.php");
  
  $notice = "";
  $kiirus = "";
  $numbrimark = "";
  $regioon = null;
  
  $regioonid = ["Euroopa", "Aasia", "Ameerika", "Austraalia", "Sindi"];
  
  $kiirusError = "";
  $numbrimarkError = "";
  $regioonError = "";
  $lubatudEuroopas = "50";
  $lubatudAasias = "55";
  $lubatudAmeerikas = "60";
  $lubatudAustraalias = "65";
  $lubatudSindis = "13";
  $listcars = listcars();
  //$trahvisumma = $kiirusUle * "10";
  
  
  
  if(isset($_POST["submitCarData"])){
  
  if (isset($_POST["kiirus"]) and !empty($_POST["kiirus"])){
	$kiirus = test_input($_POST["kiirus"]);
  } else {
	  $kiirusError = "Palun sisesta kiirus!";
  }
  
  if (isset($_POST["numbrimark"]) and !empty($_POST["numbrimark"])){
	$numbrimark = test_input($_POST["numbrimark"]);
  } else {
	  $numbrimarkError = "Palun sisesta numbrimärk!";
  }
  
  if(isset($_POST["regioon"]) and !empty($_POST["regioon"])){
	  $regioon = test_input($_POST["regioon"]);
  } else {
	  $regioonError = "Palun vali regioon!";
  }
  
  $notice = savecar($kiirus, $numbrimark, $regioon);
  }
  
  
  
  if(isset($_GET["id"])){
	$msg = readmsgforvalidation($_GET["id"]);  
  }
  
  if(isset($_POST["submitMakstud"])){
	validatemsg(intval($_POST["id"]), intval($_POST["makstud"]));
  }
  
  
  ?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Auto andmete lisamine</title>
</head>
<body>
	<h1>Auto andmete lisamine</h1>
	
	<hr>
	
	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	  <label>Numbrimärk</label>
	  <br>
	  <textarea rows="1" cols="50" name="kiirus">Siia sisesta kiirus</textarea>
	  <br>
	  <label>Kiirus</label>
	  <br>
	  <textarea rows="1" cols="50" name="numbrimark">Siia sisesta numbrimark</textarea>
	  <br>
	  
	  <label>Regioon </label>
	  <br>
	  <?php
	    echo '<select name="regioon">' ."\n";
		echo '<option value="" selected disabled>Vali siit</option>' ."\n";
		for ($i = 1; $i < 6; $i ++){
			echo '<option value="' .$i .'"';
			if ($i == $regioon){
				echo " selected ";
			}
			echo ">" .$regioonid[$i - 1] ."</option> \n";
		}
		echo "</select> \n";
	  ?>
	  <br>
	  <input name="submitCarData" type="submit" value="salvesta"><span><?php echo $notice; ?></span>
    </form>
	<hr>
	<p><?php echo $notice; ?></p>
	
	
	
	
	
	//SELECT autod.numbrimark, autod.kiirus, autod.regioonid, regioonitabel.kiirusepiirang FROM autod INNER JOIN regioon ON autod.regioonid = regioonitabel.id
	
	<h1>Kiirust ületanud autod</h1>
	<hr>
	
	<h2>Määra makstuks:</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
    <p><?php echo $listcars; ?></p>
    <input type="radio" name="validation" value="0" checked><label>Maksmata</label><br>
    <input type="radio" name="validation" value="1"><label>Makstud</label><br>
    <input type="submit" value="Kinnita" name="submitValidation">
  </form>
  <hr>
	
	
	
	
	
	<hr>
	<h1>Lubatud kiirused</h1>
	<br>
	<h3>Euroopas </h3>
	<?php echo $lubatudEuroopas; ?>
	<br>
	<h3>Aasias </h3>
	<?php echo $lubatudAasias; ?>
	<br>
	<h3>Ameerikas </h3>
	<?php echo $lubatudAmeerikas; ?>
	<br>
	<h3>Austraalias</h3>
	<?php echo $lubatudAustraalias; ?>
	<br>
	<h3>Sindis</h3>
	<?php echo $lubatudSindis; ?>

</body>
</html>

<?php echo $listcars; ?>




