<?php
error_reporting(E_ALL &~E_NOTICE);

require_once("./connect.php");

session_start();

if (!isset($_SESSION['accessopermesso'])) header('Location:login.php');

if ((!isset($_SESSION['carrello']) && !$_POST) || isset($_POST['svuota'])) {
   $_SESSION['carrello']=array();
   $msg=1;
} else {
   if ( isset($_POST['paga']) ) {
	   
	 $msg=2;
	  
	  foreach ($_SESSION['carrello'] as $k=>$v) {
	  
	  $querySelLibri="SELECT $tab_libro.id FROM $tab_libro
				WHERE titolo=\"{$_SESSION['carrello'][$k]}\";";
	  $querySelUser="SELECT $tab_user.id FROM $tab_user
				WHERE username=\"{$_SESSION['username']}\";";
		
	  if(!$resultSelLibri=mysqli_query($mysqliConn,$querySelLibri)){
			printf("ERRORE! Impossibile eseguire la querySelLibri\n");
			exit();
		}
	  if(!$resultSelUser=mysqli_query($mysqliConn,$querySelUser)){
			printf("ERRORE! Impossibile eseguire la querySelUser\n");
			exit();
		}
	
		$row=mysqli_fetch_array($resultSelLibri);
		$row2=mysqli_fetch_array($resultSelUser);
	
		if($row && $row2) {
			$IDlibro=$row['id'];
			$IDuser=$row2['id'];
			$queryInsertAcquisto="INSERT INTO $tab_acquisti (id_user,id_libro) VALUES
					  ('$IDuser','$IDlibro');";
					  
			if(!$resultInsertAcquisto=mysqli_query($mysqliConn,$queryInsertAcquisto)){
				 echo "<h3 style='color:red;'>Impossibile inserire l'acquisto!</h3>\n";
				exit();
			}
			
		}
	}
	 $_SESSION['carrello']=array(); 
 }
}
 ?>
 
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Pagamento</title>
	<link rel="stylesheet" href="cssesterno.css" type="text/css" />
</head>

<body style="background-color:white;">

	<div style="border-radius:10px;background-color:white;height:5%;width:100%;justify-content:center;padding:0px 0px 0px 0px;">
	<img src="./immagini/carrello.png" width="1%"/>
	<p style="color:red;font-size:13px;">&nbsp;Consegna gratuita in negozio</p>
	</div>
	
	<div style="border-radius:10px;background-image:url('./immagini/libreria.jpg');height:30%;width:100%;justify-content:left;padding-left:10px;background-size:100%;">
		<p style="text-align:left;font-size:40px;font-family:georgia,serif;color:white;">
		<img src="./immagini/logo.png" width="10%" align="left"/>
		&nbsp;Libreria</p>
	</div>
	
	<div style='width:100%;padding:0px 0px 0px 0px;'>
	<a href="carrello.php" style="width:33%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Indietro</button></a>
	<a href="acquisti.php" style='width:33%;'>
	<button class="button" style="width:100%;border-right:2px solid red;">Acquisti</button></a>
	<a href="logout.php" style='width:33%;'>
	<button class="button" style="width:100%;border-right:2px solid red;">Logout</button></a>
	</div>
	
	
	<div  style="width:100%;top:50%;border-radius:10px;background-image:url('./immagini/libreria.jpg');background-size:cover;align-items:center;padding-bottom:20%;">
	<div  style="width:95%;top:50%;border:3px solid white;border-radius:10px;background-color:white;align-items:center;text-align:center;">
	<?php
	 if($msg==1){
		  echo "<h3 style='color:red;'>Il tuo carrello &egrave; vuoto!</h3>";
	 }
	 if($msg==2) {
	 echo "<h3 style='color:red;'>Pagamento effettuato! Grazie!</h3>";
	 echo "<h2 style='color:black;'>Puoi controllare i tuoi acquisti nella sezione 'Acquisti'</h2>";
	 }
	?>
	</div>
	</div>
	
</body>
</html>
