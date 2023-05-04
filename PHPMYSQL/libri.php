<?php
error_reporting(E_ALL &~E_NOTICE);

//CONNESSIONE
require_once("./connect.php");

session_start();

//QUI GESTISCO LE PREFERENZE DI ORDINAMENTO DELL'UTENTE
if (isset($_POST['ordinamento'])){
	switch ($_POST['ordine']){
    
		case "titolo": $querySelLibri="SELECT * FROM $tab_libro,$tab_autore
						WHERE $tab_libro.id_autore=$tab_autore.id
						ORDER BY $tab_libro.titolo;";
						break;
	
		case "autore": $querySelLibri="SELECT * FROM $tab_libro,$tab_autore
						WHERE $tab_libro.id_autore=$tab_autore.id
						ORDER BY $tab_autore.cognome;";
						break;
					
	}
} else {
	
	//SE L'UTENTE NON SELEZIONA NULLA, QUESTO SARA' L'ORDINE DI DEFAULT (IN BASE AL TITOLO)
	$querySelLibri="SELECT * FROM $tab_libro,$tab_autore
					WHERE $tab_libro.id_autore=$tab_autore.id
					ORDER BY $tab_libro.titolo;";
				
}

if(!$resultSelLibri=mysqli_query($mysqliConn,$querySelLibri)){
	echo "<h3 style='color:red;'>ERRORE! Non &egrave; stato possibile eseguire la querySel.</h3>\n";
	exit();
}


if ((!isset($_SESSION['carrello']) && !$_POST)) {
	
   $_SESSION['carrello']=array();
   echo "<h3 style='color:red;';>Il carrello &egrave; vuoto </h3>";
   
} else {
	
   if ( isset($_POST['selezione']) && isset($_POST['aggiungi']) ) {
	   
	   //INSERISCO TUTTI I LIBRI SELEZIONATI NEL CARRELLO
	  foreach($_POST['selezione'] as $k=>$v) {
     $_SESSION['carrello'][$k] = $_POST['selezione'][$k];
	 
	  }
	  
	 echo "<h3 style='color:red;';>Elementi aggiunti al carrello!</h3>";
   }
  

}

?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Libri</title>
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
	<a href="start.php" style="width:33%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Indietro</button></a>
		<a href="carrello.php" style="width:33%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Carrello</button></a>
	<a href="logout.php" style='width:33%;'>
	<button class="button" style="width:100%;border-right:2px solid red;">Logout</button></a>
	</div>
<?php
$lista="";
while ($row = mysqli_fetch_array($resultSelLibri)){
$lista.="<tr>
		<td>{$row['titolo']}</td>
		<td>{$row['isbn']}</td>
		<td>{$row['trama']}</td>
		<td>{$row['anno_pub']}</td>
		<td>(&euro; {$row['prezzo']})</td>
		<td>{$row['nome']}</td>
		<td>{$row['cognome']} </td>
		<td>{$row['biografia']} </td>
		<td>
		<input type=\"checkbox\" name=\"selezione[]\" value=\"{$row['titolo']}\" /></td>
		</tr>\n";
}

 
?>

<div  style="width:100%;top:50%;border-radius:10px;background-image:url('./immagini/libreria.jpg');background-size:cover;align-items:center;padding-bottom:20%;">
<div style="width:90%;background-color:white;border-radius:15px;display:table;">
	
<h1 style="color:red;">Libri disponibili</h1>

<center>
<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
<div style="width:25%;margin-bottom:25px;background-color:white;border:2px solid firebrick;border-radius:15px;">
<h4 style="color:black;">Ordina per:</h4>
<input type="radio" name="ordine" value="titolo" />
<label style="color:black;">titolo</label>
<input type="radio" name="ordine" value="autore" />
<label style="color:black;padding-right:25px;">autore</label>
<input type="submit" name="ordinamento" value="Ordina" class="button" style="background-color:firebrick;color:white;width:25%;font-size:15px;">
</div>
</form>

<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
<?php
echo "
<table style='width:90%;border:0px;'>
<tr>
<th>Titolo</th>
<th>ISBN</th>
<th>Trama</th>
<th>Anno di pubblicazione</th>
<th>Prezzo</th>
<th>Nome autore</th>
<th>Cognome autore</th>
<th>Biografia</th>
<th>Selezione</th>
</tr>";
 echo $lista; 
 echo "</table></center>";
 ?>
	<br />
	<input type="submit" name="aggiungi" value="Aggiungi al carrello" class="button" style=" background-color:red;color:white;">
	</form>
	</div>
	</div>
</body>

</html>
