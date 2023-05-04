<?php 

error_reporting(E_ALL &~E_NOTICE);

//CONNESSIONE
require_once("./connect.php");

session_start();

if (!isset($_SESSION['accessopermesso'])){
	header('Location:login.php');
}
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Home</title>
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
	
<?php

$querySel="SELECT tipologia FROM $tab_user
		   WHERE username=\"{$_SESSION['username']}\"";
	
	
if(!$resultSel=mysqli_query($mysqliConn,$querySel)){
	printf("ERRORE!\n");
	exit();
	}
		
$row=mysqli_fetch_array($resultSel);
		
if($row){
	$_SESSION['tipologia']=$row['tipologia'];
	}

//OGNI USER VISUALIZZA UN MENU' DIVERSO IN BASE ALLA SUA TIPOLOGIA
if(strcmp($_SESSION['tipologia'],"utente")==0){
	echo "<div style='width:100%;padding:0px 0px 0px 0px;'>
	<a href='libri.php' style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Libri</button></a>
	<a href='acquisti.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Acquisti</button></a>
	<a href='carrello.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Carrello</button></a>
	<a href='logout.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Logout</button></a>
	</div> ";
}

if(strcmp($_SESSION['tipologia'],"gestore")==0){
	echo " <div style='width:100%;padding:0px 0px 0px 0px;'>
	<a href='insert.php' style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Aggiungi libri</button></a>
	<a href='reportacquisti.php' style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Visualizza acquisti degli utenti</button></a>
	<a href='reportmag.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Report magazzino</button></a>
	<a href='logout.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Logout</button></a>
	</div>";
}

if(strcmp($_SESSION['tipologia'],"admin")==0){
	echo " <div style='width:100%;padding:0px 0px 0px 0px;'>
	<a href='elencoutenti.php' style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Visualizza elenco utenti</button></a>
	<a href='ban.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Ban utente</button></a>
	<a href='reportmag.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Report magazzino</button></a>
	<a href='logout.php'style='width:25%;'>
	<button class='button' style='width:100%;border-right:2px solid red;'>Logout</button></a>
	</div>";
}

?>

<div  style="width:100%;top:50%;border-radius:10px;background-image:url('./immagini/libreria.jpg');background-size:cover;padding-bottom:30%;justify-content:left;padding-left:10px;">
	<h1 style="text-align:left;">Welcome <?php echo $_SESSION['username'];?>.</h1>
		<center>
		<div style="width:98%;background-color:white;">
			<h1 style="color:red;text-align:center;width:100%;">I NOSTRI BEST-SELLER</h1><br/>
			<img src="./immagini/millesplendidisoli.jpg" style="width:20%;margin:20px 50px 20px 10px;" />
			<img src="./immagini/shogun.jpg" style="width:22%;margin: 20px 50px 20px 0px;" />
			<img src="./immagini/pernientealmondo.jpg" style="width:20%;margin: 20px 50px 20px 0px;" />
			<img src="./immagini/hannibal.jpg" style="width:20%;margin: 20px 50px 20px 20px;" />
		</div>
		</center>
	
</div>
		
</body>

</html>
