<?php 

error_reporting(E_ALL &~E_NOTICE);

//CONNESSIONE
require_once("./connect.php");

session_start();

//QUI, PER SICUREZZA, CONTROLLO DI NUOVO CHE L'UTENTE
//CHE STA ACCEDENDO SIA UN ADMIN
if ( !(isset($_SESSION['accessopermesso'])) || strcmp($_SESSION['tipologia'],"admin")!==0){

	header('Location:login.php');
	
}

//LA QUERY SELEZIONA TUTTI GLI USER 
//DI TIPOLOGIA "utente"
$querySel="SELECT username,nome,cognome 
			FROM $tab_user
			WHERE tipologia='utente';";

if(!$resultSel=mysqli_query($mysqliConn,$querySel)){
	printf("ERRORE! Impossibile eseguire la querySel\n");
	exit();
	}
	
if (!isset($_POST['selezione']) && isset($_POST['ban']) ) {
		
	echo "<h3 style='color:red;';>Nessun utente selezionato.</h3>";
}
		
if (isset($_POST['selezione']) && isset($_POST['ban']) ) {
	
	foreach($_POST['selezione'] as $k=>$v) {
		
		$utentebannato=$_POST['selezione'][$k];
		
		//LA QUERY ELIMINA L'UTENTE O GLI UTENTI
		//SELEZIONATI DALL'ADMIN
		$queryDelete="DELETE FROM $tab_user
		WHERE username='$utentebannato';";
		
		if(!$resultDel=mysqli_query($mysqliConn,$queryDelete)){
			printf("ERRORE! Impossibile eseguire la queryDelete\n");
			exit();
		}
		
	  }
	 
	echo "<h3 style='color:red;';>Utenti bannati con successo!</h3>";
	header("Refresh:0");
	}

	  
?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Ban utente</title>
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
	
	<div style="border-radius:10px;background-image:url('./immagini/libreria.jpg');width:100%;justify-content:center;padding-left:10px;background-size:100%;">
	<div style="width:98%;background-color:white;border-radius:15px;">
	<h2 style="width:100%;color:red;">Ban utente</h2>
	<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
	<table style="width:80%;font-size:20px;">
	<tr class="tab">
	<th class="tab1">Nome</th>
	<th class="tab1">Cognome</th>
	<th class="tab1">Username</th>
	<th class="tab1">Elimina</th>
	</tr>
<?php
while ($row=mysqli_fetch_assoc($resultSel)){
echo "<tr> \n";
echo "<td class='tab2' style='border-radius:0;'>" .$row["nome"] . "</td> \n";
echo "<td class='tab2' style='border-radius:0;'>" .$row["cognome"] . "</td> \n";
echo "<td class='tab2' style='border-radius:0;'>" .$row["username"] . "</td> \n";
echo "<td class='tab2' style='border-radius:0;'><input type=\"checkbox\" name=\"selezione[]\" value=\"{$row['username']}\" /></td>\n";
echo "</tr> \n";}

?>
	</table>

	<input type="submit" name="ban" value="Banna utenti" class="button" style=" background-color:red;color:white;margin-top:10%;">
	</form>
	</div>
	</div>


</body>
</html>