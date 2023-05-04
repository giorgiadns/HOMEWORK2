<?php

error_reporting(E_ALL &~E_NOTICE);

//CONNESSIONE
require_once("./connect.php");

if(isset($_POST['invio'])){
	
	//CONTROLLO CHE I DATI INSERITI NON SIANO NULLI
	if(empty($_POST['username']) || empty($_POST['password'])){
	
		echo "<h3 style='color:red;'>Dati mancanti!</h3>";
	}
	else {
		//VERIFICO CHE L'UTENTE ESISTA NEL DB
		$querySel="SELECT * FROM $tab_user
				  WHERE username=\"{$_POST['username']}\"
				  AND password =\"{$_POST['password']}\"";
				  
		if(!$resultSel=mysqli_query($mysqliConn,$querySel)){
			printf("ERRORE, utente inesistente!\n");
			exit();
		}
		
		$row=mysqli_fetch_array($resultSel);
		
		if($row){
			
			session_start();
			$_SESSION['username']=$_POST['username'];
			$_SESSION['dataLogin']=time();
			$_SESSION['idUser']=$row['id'];
			$_SESSION['accessopermesso']=1000;
			header('Location: start.php');
			exit();
			
		}
		else {
			echo "<h3 style='color:red;'>Accesso negato!</h3>";
		}
	}
}

?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Login libreria</title>
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
	
	<div style="width:100%;padding:0px 0px 0px 0px;">
	<a href="#" class="tooltip" style="width:25%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Operazioni possibili</button>
	<span class="tooltiptext">Operazioni possbili, in base all'account usato:
	<table>
	<tr>
		<th>TIPOLOGIA</th>
		<th>OPERAZIONI POSSIBILI</th>
	</tr>
	<tr>
		<td>utente</td>
		<td>Visualizzare la lista dei libri disponibili,
			aggiungere libri al carrello, 
			pagare o svuotare il carrello, consultare gli acquisti (anche 
			quelli non effettuati nella sessione corrente).</td>
		
	</tr>
	<tr>
		<td>admin</td>
		<td>Visualizzare l'elenco degli utenti, 
			bannare un utente, visualizzare il report del magazzino.</td>

	</tr>
	<tr>
		<td>gestore</td>
		<td>Aggiungere libri e autori al DB,
			visualizzare gli acquisti effettuati dai clienti (utenti),
			visualizzare il report del magazzino.</td>
	
	</tr>
	</table></span></a>
	<a href="#" class="tooltip" style="width:25%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Accounts</button>
	<span class="tooltiptext">Gli account utilizzabili sono:
	<table>
	<tr>
		<th>USERNAME</th>
		<th>PASSWORD</th>
		<th>TIPOLOGIA</th>
	</tr>
	<tr>
		<td>giorgiadns</td>
		<td>giorgiadns</td>
		<td>gestore</td>
	</tr>
	<tr>
		<td>marcotemperini</td>
		<td>marcotemperini</td>
		<td>admin</td>
	</tr>
	<tr>
		<td>topolino</td>
		<td>topolino</td>
		<td>utente</td>
	</tr>
	<tr>
		<td>qui</td>
		<td>qui</td>
		<td>utente</td>
	</tr>
	<tr>
		<td>quo</td>
		<td>quo</td>
		<td>utente</td>
	</tr>
	<tr>
		<td>qua</td>
		<td>qua</td>
		<td>utente</td>
	</tr>
	</table></span></a>
	<a href="#" class="tooltip" style="width:25%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Altre informazioni</button>
	<span class="tooltiptext">L'esercizio è il PHP-16 delle slide lezione-PHP2, con qualche operazione in più rispetto a quelle suggerite.</span></a>
	<a href="#" class="tooltip" style="width:25%;">
	<button class="button" style="width:100%;border-right:2px solid red;">Chi siamo</button>
	<span class="tooltiptext">Giorgia De Nardis - 1939804</span></a>
	</div>
	
	<center>

	<div  style="width:100%;top:50%;border-radius:10px;background-image:url('./immagini/libreria.jpg');background-size:cover;align-items:center;padding-bottom:20%;">
		<div  style="width:33%;top:50%;border:3px solid white;border-radius:10px;background-color:firebrick;align-items:center;text-align:center;">
			<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
			<h1>Login</h1>
			<h3>Username:</label> <input type="text" name="username" size="30" /></h3>
			<h3>Password: <input type="password" name="password" size="30" /></h3>
			<input type="submit" name="invio" value="Accedi" class="button">
			<input type="reset" name="reset" value="Reset" class="button">
			</form>
		
	</div>

	</center>
</body>

</html>
