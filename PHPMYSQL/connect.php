<?php

//DATI DB
$db_name="libreria"; 
$tab_libro="libro"; 
$tab_autore="autore";
$tab_user="user";
$tab_acquisti="acquisti";
$tab_ban_user="ban_user";

//CONNESSIONE (STESSO UTENTE DEGLI ESEMPI FORNITI, PER SEMPLICITA')
$mysqliConn=mysqli_connect("localhost","archer","archer",$db_name);

//CONTROLLO CONNESSIONE
if(mysqli_connect_errno()){
	printf("ERRORE, impossibile connettersi al database\n", mysqli_connect_error($mysqliConn));
	exit();
	}
?>
