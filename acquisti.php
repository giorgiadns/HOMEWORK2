<?php 

error_reporting(E_ALL &~E_NOTICE);

//CONNESSIONE
require_once("./connect.php");

session_start();

if (!isset($_SESSION['accessopermesso'])){
	header('Location:login.php');
}

//LA QUERY SELEZIONA GLI ACQUISTI (ANCHE PASSATI) EFFETUATI DALL'UTENTE 
//CONNESSO IN ORDINE DECRESCENTE (DAL PIU' RECENTE AL PIU' VECCHIO)
$querySelAcquisti="SELECT $tab_libro.titolo, $tab_libro.trama, $tab_libro.prezzo, $tab_acquisti.current_data
				   FROM $tab_user,$tab_libro,$tab_acquisti
				   WHERE $tab_user.username=\"{$_SESSION['username']}\"
				   AND $tab_user.id=$tab_acquisti.id_user
				   AND $tab_acquisti.id_libro=$tab_libro.id
				   ORDER BY $tab_acquisti.id DESC;";

if(!$resultSelAcquisti=mysqli_query($mysqliConn,$querySelAcquisti)){
	printf("ERRORE! Impossibile eseguire la querySelAcquisti\n");
	exit();
	}


?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Acquisti</title>
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
	<a href="start.php" style="width:50%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Indietro</button></a>
	<a href="logout.php" style='width:50%;'>
	<button class="button" style="width:100%;border-right:2px solid red;">Logout</button></a>
	</div>
	
	<div  style="width:100%;top:50%;border-radius:10px;background-image:url('./immagini/libreria.jpg');background-size:cover;align-items:center;padding-bottom:20%;">
	<div style="width:98%;background-color:white;border-radius:15px;">
	<h3 style="color:black;">Bentornato <?php echo $_SESSION['username'];?>, ecco i tuoi acquisti finora.</h3>
	<table style="width:95%;">
	<tr class="tab" height="50px">
	<th class="tab1" width="25%">Titolo</th>
	<th class="tab1" width="35%">Trama</th>
	<th class="tab1"width="20%">Prezzo</th>
	<th class="tab1"width="20%">Data</th>
	</tr>
<?php
while ($row=mysqli_fetch_assoc($resultSelAcquisti)){
echo "<tr class='tab2'> \n";
echo "<td class='tab2' width='25%'>" .$row["titolo"] . "</td> \n";
echo "<td class='tab2' width='35%'>" .$row["trama"] . "</td> \n";
echo "<td class='tab2' width='20%'>" .$row["prezzo"] . "</td> \n";
echo "<td class='tab2' width='20%'>" .$row["current_data"] . "</td> \n";

echo "</tr> \n";}

?>
	</table>
	</div>
</div>

</body>

</html>
