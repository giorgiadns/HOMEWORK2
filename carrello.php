<?php
error_reporting(E_ALL &~E_NOTICE);

require_once("./connect.php");

session_start();

if (!isset($_SESSION['accessopermesso'])) header('Location:login.php');

$totale=0;
$outputTable="";

if (!isset($_SESSION['carrello'])) {
   $outputTable.= "<h3 style='color:red;'>Il tuo carrello è vuoto!</h3>";
} else {
	
	$outputTable.="<h3 style='color:red;'>Gli articoli nel tuo carrello: </h3>\n";
	
    $outputTable.="<table style='border:0px;width:80%;'>
					<tr><th style='width:75%;'>Titolo</th>
					<th style='width:25%;'>Prezzo</th></tr>";
	
	//Elenco dei libri nel carrello con il relativo prezzo
    foreach ($_SESSION['carrello'] as $k=>$v) {
	  
	  $querySelPrezzi="SELECT $tab_libro.prezzo FROM $tab_libro
				WHERE titolo=\"{$_SESSION['carrello'][$k]}\";";
		
	  if(!$resultSelPrezzi=mysqli_query($mysqliConn,$querySelPrezzi)){
			printf("ERRORE! Impossibile eseguire la querySelPrezzi\n");
			exit();
		}
	
		$row=mysqli_fetch_array($resultSelPrezzi);
	
		if($row) {
			$prezzo=$row['prezzo'];
			$totale=$totale+$row['prezzo'];
		}

		$outputTable.="<tr><td style='width:75%;text-align:left;'>$v</td>
					<td style='width:25%;'>$prezzo</td></tr>\n";
	}
}
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Carrello</title>
	<link rel="stylesheet" href="cssesterno.css" type="text/css" />
	
<style>
td{
	border:1px solid gray;
	border-radius:5px;
}
th{
background-color:firebrick;
border:2px solid white;
color:white;
border-radius:5px;
}
</style>
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
	<a href="start.php" style="width:50%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Indietro</button></a>
	<a href="logout.php" style='width:50%;'>
	<button class="button" style="width:100%;border-right:2px solid red;">Logout</button></a>
	</div>
	
	<div  style="width:100%;top:50%;border-radius:10px;background-image:url('./immagini/libreria.jpg');background-size:cover;align-items:center;padding-bottom:20%;">
	<div style="width:77%;background-color:white;border-top-left-radius:15px;border-top-right-radius:15px;">

<?php

	$outputTable.="</table>\n";
	echo $outputTable;
	echo "<table style='border:0px;width:80%;'>\n
		  <tr>
		  <td style='width:75%;'>Totale da pagare: </td>
		  <td style='width:25%;'> $totale </td>
		  </tr>
		  </table>";

?>
	</div>
	<div style="width:77%;background-color:white;border-bottom-right-radius:15px;border-bottom-left-radius:15px;">
	<form action="pagamento.php" method="POST">
	<input type="submit" name="paga" value="Procedi al pagamento" class="button" style=" background-color:red;color:white;">
	<input type="submit" name="svuota" value="Svuota il carrello" class="button" style=" background-color:red;color:white;">
	<input type="hidden" name="totale" value="<?php echo $totale; ?>">
	</form>
	</div>
	</div>
	
</body>
</html>