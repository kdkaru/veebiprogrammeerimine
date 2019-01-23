<?php
  
  require("examfunctions.php");
  $notice = "";
  $firstname = "";
  $surname = "";
  $studentcode = "";
  $payment = "";
  $userslist = listusers();
  $paiduserslist = listpaidusers();
  $unpaiduserslist = listunpaidusers();

 

  $unpaiduserslist = listunpaidusers();
  
   if(isset($_GET["id"])){
	$unpaiduserslist = listunpaidusers($_GET["id"]);  
  }
  
  if(isset($_POST["submitValidation"])){
	setpayment(intval($_POST["id"]), intval($_POST["payment"]));
  }
  
  
?>
 
 <!DOCTYPE html>
<html>

<title>Administraatori leht</title>
<body>

<h1>registreerinud:</h1>
	<hr>
	<?php echo $userslist; ?>
	
	<h2>Määra maksnuks:</h2>
  <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <input name="id" type="hidden" value="<?php echo $_GET["id"]; ?>">
    <p><?php echo $unpaiduserslist; ?></p>
   
    <input type="radio" name="payment" value="1"><label>makstud</label><br>
    <input type="submit" value="Kinnita" name="submitValidation">
  </form>
<hr>
<h1>maksnud:</h1>
<?php echo $paiduserslist; ?>

 </body>
</html>