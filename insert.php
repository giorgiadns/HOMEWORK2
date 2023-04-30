<?php
error_reporting(E_ALL &~E_NOTICE);

require_once("./connect.php");

session_start();

if ( !(isset($_SESSION['accessopermesso'])) || strcmp($_SESSION['tipologia'],"gestore")!==0){

	header('Location:login.php');
	
}

//Questa query serve ad estrarre i nomi degli autori già presenti
//nella base di dati e stamparli nel tooltip
$querySel="SELECT nome,cognome FROM $tab_autore;";

if(!$resultSel=mysqli_query($mysqliConn,$querySel)){
	printf("ERRORE! Impossibile eseguire la querySel\n");
	exit();
	}

if(isset($_POST['inserisci'])){
	
	//Controllo che ci siano tutti i dati
	if(empty($_POST['titolo']) || empty($_POST['isbn']) || empty($_POST['anno']) || empty($_POST['trama']) ||empty($_POST['prezzo']) || empty($_POST['nomeaut']) ||empty($_POST['cognomeaut']) ||empty($_POST['biog'])) {
		echo "<h3 style='color:red;'>ERRORE! Non sono stati inseriti tutti i dati necessari.</h3>\n";
	} 
	else{
		
		//Se i dati sono tutti, verifico se l'autore indicato è già registrato
		$querySelID="SELECT id FROM $tab_autore
					WHERE nome='{$_POST['nomeaut']}'
					AND cognome='{$_POST['cognomeaut']}';";

		if(!$resultSelID=mysqli_query($mysqliConn,$querySelID)){
			printf("ERRORE! Impossibile eseguire la querySelID\n");
			exit();
		}
		
		$row1=mysqli_fetch_array($resultSelID);
		
		//Se l'autore è già presente, il libro verrà inserito comunque (si salta solo l'inserimento dell'autore)
		if($row1){
			
			printf("L'autore già esiste nella base dati, il libro verrà inserito lo stesso!\n");
		
			$IDaut=$row1['id'];
					
			$queryInsertLibro="INSERT INTO $tab_libro (titolo,isbn,anno_pub,trama,prezzo,id_autore) VALUES
					  ('{$_POST['titolo']}','{$_POST['isbn']}','{$_POST['anno']}','{$_POST['trama']}','{$_POST['prezzo']}','$IDaut');";
					  
			if(!$resultInsertLibro=mysqli_query($mysqliConn,$queryInsertLibro)){
				 echo "<h3 style='color:red;'>Impossibile inserire il libro!</h3>\n";
				exit();
			}
			
			  echo "<h3 style='color:red;'>Libro inserito correttamente!</h3>\n";

		} else {
	
		//Se l'autore non è già presente, si procede all'inserimento di tutti i dati
			$queryInsertAutore="INSERT INTO $tab_autore (nome,cognome,biografia) VALUES
					  ('{$_POST['nomeaut']}','{$_POST['cognomeaut']}','{$_POST['biog']}');";
			
			if(!$resultInsertAutore=mysqli_query($mysqliConn,$queryInsertAutore)){
				echo "<h3 style='color:red;'>Impossibile inserire il libro!</h3>\n";
				exit();
			}
			
			$querySelID="SELECT id FROM $tab_autore
					WHERE nome='{$_POST['nomeaut']}'
					AND cognome='{$_POST['cognomeaut']}';";

			if(!$resultSelID=mysqli_query($mysqliConn,$querySelID)){
				printf("ERRORE! Impossibile eseguire la querySelID\n");
				exit();
			}
		
			$row2=mysqli_fetch_array($resultSelID);
			$row2=mysqli_fetch_assoc($resultSelID);
			$IDaut=$row2['id'];
					
			$queryInsertLibro="INSERT INTO $tab_libro (titolo,isbn,anno_pub,trama,prezzo,id_autore) VALUES
					  ('{$_POST['titolo']}','{$_POST['isbn']}','{$_POST['anno']}','{$_POST['trama']}','{$_POST['prezzo']}'.'$IDaut');";
					  
			if(!$resultInsertLibro=mysqli_query($mysqliConn,$queryInsertLibro)){
				echo "<h3>Impossibile inserire il libro!</h3>\n";
				exit();
			}
			 
			 echo "<h3 style='color:red;'>Libro e autore inseriti correttamente!</h3>\n";
		}
	}
}

?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Aggiunta libri</title>
	<link rel="stylesheet" href="cssesterno.css" type="text/css" />
	
<style>
td,table{
	border:0px;
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
	
	<center>

	<div  style="width:100%;top:50%;border-radius:10px;background-image:url('./immagini/libreria.jpg');background-size:cover;align-items:center;padding-bottom:20%;">
		<div  style="width:90%;top:50%;border:3px solid white;border-radius:10px;background-color:firebrick;justify-content:center;">
			<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">
			<h1>Aggiunta libri</h1>
			
			<table>
			<tr>
			<td><h3 style="text-align:left;">Titolo:</h3></td>
			<td><input type="text" name="titolo" size="50" /></td>
			<td rowspan="6" style="vertical-align:bottom;">	
				<a href="#" class="tooltip2">
				<button class="button" style="width:100%;border-right:2px solid red;">?</button>
				<span class="tooltiptext2">
				Autori gi&agrave; presenti nella base dati:
					<table style="width:95%;">
						<tr class="tab">
						<th class="tab2">Nome</th>
						<th class="tab2">Cognome</th>
						</tr>
						<?php
						while ($row=mysqli_fetch_assoc($resultSel)){
						echo "<tr class='tab2'> \n";
						echo "<td class='tab2'>" .$row["nome"] . "</td> \n";
						echo "<td class='tab2'>" .$row["cognome"] . "</td> \n";
						echo "</tr> \n";}
						?>	
						</table>
				</span></a>
			</td>
			</tr>
			
			<tr>
			<td><h3 style="text-align:left;">ISBN:</h3></td>
			<td><input type="text" name="isbn" size="50" /></td>
			</tr>
			
			<tr>
			<td><h3 style="text-align:left;">Anno pubblicazione:</h3></td>
			<td><input type="text" name="anno" size="50" /></td>
			</tr>
			
			<tr>
			<td><h3 style="text-align:left;">Trama:</h3></td>
			<td><input type="text" name="trama" size="50" /></td>
			</tr>
			
			<tr>
			<td><h3 style="text-align:left;">Prezzo:</h3></td>
			<td><input type="text" name="prezzo" size="50" /></td>
			</tr>
			
			<tr>
			<td><h3 style="text-align:left;">Nome autore:</h3></td>
			<td><input type="text" name="nomeaut" size="50" /></td>
			</tr>
			
			<tr>
			<td><h3 style="text-align:left;">Cognome autore:</h3></td>
			<td><input type="text" name="cognomeaut" size="50" /></td>
			</tr>
			
			<tr>
			<td><h3 style="text-align:left;">Breve biografia:</h3></td>
			<td><input type="text" name="biog" size="50" /></td>
			</tr>
			
			</table>
			<input type="submit" name="inserisci" value="Inserisci" class="button">
			<input type="reset" name="reset" value="Reset" class="button">
			</form>
		</div>
	</div>

	</center>
</body>
</html>