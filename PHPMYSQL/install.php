<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">

<head>
	<title>Creazione db e popolamento</title>
</head>

<body>
	<h1>Creazione e popolamento del database "Libreria"</h1>
	
<?php 

error_reporting(E_ALL &~E_NOTICE);

$db_name="libreria"; 
$tab_libro="libro"; 
$tab_autore="autore";
$tab_user="user";
$tab_acquisti="acquisti";

//Connessione al db (con lo stesso utente degli esempi per semplicità)
$mysqliConn=new mysqli("localhost","archer","archer");

//Controllo della connessione
if (mysqli_connect_errno()){
	printf("Impossibile connettersi al database\n");
	exit();
}

//CREAZIONE DEL DB
$queryCreateDB="CREATE DATABASE $db_name";
$result=mysqli_query($mysqliConn, $queryCreateDB);
if($result) {
	printf("Database %s creato\n",$db_name);
	echo "<hr />";
}
else {	
	printf("Impossibile creare il database %s\n",$db_name);
	exit();
	
}

//Chiusura della connessione
mysqli_close($mysqliConn);

//Riapertura della connessione
$mysqliConn=mysqli_connect("localhost","archer","archer",$db_name);

//Controllo della connessione
if (mysqli_connect_errno()){
	printf("Impossibile connettersi al database %s\n",$db_name);
	exit();
}

//CREAZIONE TABELLA AUTORE
$queryCreateTable="CREATE TABLE IF NOT EXISTS $tab_autore
				  (id INT NOT NULL AUTO_INCREMENT,
				  nome VARCHAR (30) NOT NULL,
				  cognome VARCHAR (30) NOT NULL,
				  biografia VARCHAR (1000),
				  PRIMARY KEY (id));";

echo "<p>$queryCreateTable</p>";

//Controllo esito queryCreateTable
if($result=mysqli_query($mysqliConn,$queryCreateTable)){
	printf("OK, tabella autore creata correttamente!\n");
	echo "<hr />";
}
else{
	printf("ERRORE, la tabella autore non è stata creata\n");
	exit();
}

//CREAZIONE TABELLA LIBRO
$queryCreateTable="CREATE TABLE IF NOT EXISTS $tab_libro 
				  (id INT NOT NULL AUTO_INCREMENT,
				   titolo VARCHAR (70) NOT NULL,
				   isbn BIGINT (13) NOT NULL,
				   anno_pub INT (4) NOT NULL,
				   trama VARCHAR(5000),
				   prezzo DOUBLE (5,2),
				   id_autore INT NOT NULL,
				   PRIMARY KEY(id),
				   FOREIGN KEY (id_autore) REFERENCES autore(id));";

echo "<p>$queryCreateTable</p>";

//Controllo esito queryCreateTable
if($result=mysqli_query($mysqliConn,$queryCreateTable)){
	printf("OK, tabella libro creata correttamente!\n");
	echo "<hr />";
}
else{
	printf("ERRORE, la tabella libro non è stata creata\n");
	exit();
}

//CREAZIONE TABELLA UTENTE
$queryCreateTable="CREATE TABLE IF NOT EXISTS $tab_user
			   (id INT NOT NULL AUTO_INCREMENT,
			   username VARCHAR (30) NOT NULL,
			   password VARCHAR (32) NOT NULL,
			   nome CHAR (32) NOT NULL,
			   cognome CHAR (32) NOT NULL,
			   tipologia VARCHAR(7) NOT NULL,
			   PRIMARY KEY (id));";
			   
echo "<p>$queryCreateTable</p>";

//Controllo esito queryCreateTable
if($result=mysqli_query($mysqliConn,$queryCreateTable)){
	printf("OK, tabella user creata correttamente!\n");
	echo "<hr />";
}
else{
	printf("ERRORE, la tabella user non è stata creata\n");
	exit();
}

//CREAZIONE TABELLA ACQUISTI
$queryCreateTable="CREATE TABLE IF NOT EXISTS $tab_acquisti
			   (id INT NOT NULL AUTO_INCREMENT,
			   id_user INT NOT NULL,
			   id_libro INT,
			   current_data DATE,
			   PRIMARY KEY (id),
			   FOREIGN KEY (id_user) REFERENCES user(id),
			   FOREIGN KEY (id_libro) REFERENCES libro(id));";
			   
echo "<p>$queryCreateTable</p>";

//Controllo esito queryCreateTable
if($result=mysqli_query($mysqliConn,$queryCreateTable)){
	printf("OK, tabella acquisti creata correttamente!\n");
	echo "<hr />";
}
else{
	printf("ERRORE, la tabella acquisti non è stata creata\n");
	exit();
}

//POPOLAMENTO DEL DB
//POPOLAMENTO TABELLA AUTORE
$queryInsert="INSERT INTO $tab_autore (nome, cognome, biografia) VALUES
			 (\"Ken\", \"Follett\", \"All'anagrafe Kenneth Martin Follett (Cardiff, 5 giugno 1949), è uno scrittore britannico.
				Ha venduto più di 150 milioni di copie nel mondo, ed è uno dei più ricchi e famosi giallisti britannici della storia. 
				Nel 2018 è stato insignito dell'onorificenza di Comandante dell'Ordine dell'Impero Britannico per i suoi servizi alla letteratura.\"),
			 (\"Khaled\", \"Hosseini\", \" Nato a Kabul il 4 marzo 1965, è uno scrittore e medico afghano naturalizzato statunitense.
			    È noto globalmente per aver scritto il best seller internazionale Il cacciatore di aquiloni (2003), oltre che per i suoi successivi 
				romanzi Mille splendidi soli (2007) ed E l'eco rispose (2013).\"),
			 (\"James\", \"Clavell\", \" James Clavell (Sydney, 10 ottobre 1921 – Vevey, 7 settembre 1994) è stato uno scrittore, sceneggiatore e 
			 regista australiano naturalizzato statunitense.\"),
			 (\"Thomas\", \"Harris\", \" Thomas Harris (Jackson, 22 settembre 1940) è uno scrittore e giornalista statunitense, la cui opera più 
			 celebre è il romanzo Il silenzio degli innocenti.\");";

//Controllo esito queryInsert
if($result=mysqli_query($mysqliConn,$queryInsert)){
	echo "<p>OK, tabella autore popolata correttamente!</p>";
	echo "<p><table border='1'>
		  <tr>
		  <th>ID</th>
		  <th>Nome</th>
          <th>Cognome</th> 
		  <th>Biografia</th>
          </tr>";
	$querySelect="SELECT * FROM $tab_autore;";
	$resultSel=mysqli_query($mysqliConn,$querySelect);
	while ($row=mysqli_fetch_assoc($resultSel)){
	echo "<tr> \n";
	echo "<td>" .$row["id"]. "</td> \n";
	echo "<td>" .$row["nome"] . "</td> \n";
	echo "<td>" .$row["cognome"] . "</td> \n";
	echo "<td>" .$row["biografia"] . "</td> \n";
	echo "</tr>";
	}
	echo "</table>";
	echo "<hr />";
}
else{
	printf("ERRORE, la tabella autore non è stata popolata\n");
	exit();
}

//POPOLAMENTO TABELLA LIBRO		 
$queryInsert="INSERT INTO $tab_libro (titolo, isbn, anno_pub, trama, prezzo, id_autore) VALUES
			 (\"Un letto di leoni\", \"9788804679059\", \"1986\", \"Medio Oriente, 1981. 
			  Tra i monti dell'Afghanistan si trova la Valle dei Cinque Leoni, 
			  un luogo di antiche leggende ora rifugio di Masud e dei suoi 
			  guerriglieri che combattono gli invasori sovietici. È qui che 
			  trovano compimento i destini incrociati di tre personaggi: un 
			  americano e un francese che al tempo della Guerra fredda hanno 
			  combattuto su opposti fronti, e Jane, la donna che li unisce e 
			  li divide.\", \"12.35\", \"1\"),
			  (\"Mille splendidi soli\",\"9788868367312\", \"2007\", \"Mariam vorrebbe 
			  avere le ali per raggiungere la casa del padre, dove lui non la 
			  porterà mai perché Mariam è una harami, una bastarda, e sarebbe 
			  un'umiliazione per le sue tre mogli e i dieci figli legittimi 
			  ospitarla. Vorrebbe anche andare a scuola, ma sarebbe inutile, 
			  le dice sua madre, come lucidare una sputacchiera. L'unica cosa 
			  che deve imparare è la sopportazione. Laila è nata a Kabul la 
			  notte della rivoluzione, nell'aprile del 1978. Aveva solo due 
			  anni quando i suoi fratelli si sono arruolati nella jihad. 
			  Mariam e Laila non potrebbero essere più diverse, ma la guerra 
			  le farà incontrare in modo imprevedibile.\",  \"13.50\", \"2\"),
			 (\"Shogun\", \"9788845297588\", \"1975\", \"Partito alla volta dell'Oriente 
			 per il monopolio olandese del commercio con Cina e Giappone, 
			 John Blackthorne, comandante dell'Erasmus, si ritrova costretto 
			 da una tremenda tempesta al naufragio in un villaggio di pescatori 
			 nel Giappone feudale del XV secolo. In un mondo sconosciuto e lontano, 
			 Blackthorne deve trovare il modo di sopravvivere. Grazie al suo coraggio, 
			 che lo condurrà sulla via dei samurai, con il soprannome di Anjin (il navigatore) 
			 diventerà il fido aiutante dello Shogun e nella sua ascesa al potere conoscerà 
			 l'amore impossibile per la bella e ambigua Mariko.\",  \"15.20\", \"3\"),
			 (\"Hannibal\", \"9788804444466\", \"1999\", \"Clarice Starling, 7 anni dopo la vicenda 
			 Lecter (Silenzio degli innocenti), viene messa sotto accusa dagli organi interni 
			 dell'FBI per un intervento troppo energico durante una sparatoria. In questo 
			 delicato frangente riceve un messaggio da parte del latitante Lecter, che la 
			 incoraggia a tenere duro. Lecter, sparito da anni, vive relativamente tranquillo 
			 a Firenze. E' ricercato dall'FBI ma soprattutto da una delle sue vittime, 
			 il sadico Mason Vergier, costretto da anni su un letto e orrendamente sfigurato 
			 da Lecter stesso. Turbata dal richiamo di Lecter, Clarice decide di salvarlo dalla 
			 terribile morte a cui Lecter pare essere predestinato.\",  \"7.99\", \"4\"),
			  (\"Per niente al mondo\", \"9788804747529\", \"2021\", \"Nel cuore rovente del deserto del 
			  Sahara, due giovani e intraprendenti agenti segreti – l’americana Tamara Levit e il 
			  francese Tab Sadoul – sono sulle tracce di un pericoloso gruppo di terroristi islamici, 
			  mettendo così a rischio la loro vita. Quando si innamorano, le loro carriere arrivano 
			  inevitabilmente a un punto di svolta. Poco distante Kiah, una vedova coraggiosa e 
			  bellissima, decide di abbandonare il suo paese flagellato da carestia e rivolte e 
			  partire illegalmente per l’Europa con il suo bambino, nella speranza di cominciare 
			  una nuova vita. Nel corso del suo viaggio disperato viene aiutata da Abdul, un uomo 
			  misterioso che potrebbe non essere chi dice di essere. A Pechino la visione riformista 
			  e moderna di Chang Kai, l’ambizioso viceministro dei servizi segreti esteri, lo costringe 
			  a fare i conti con i vertici comunisti del potere politico che potrebbero portare la Cina 
			  e il suo alleato, la Corea del Nord, sulla via del non ritorno. Intanto Pauline Green, la
			  prima donna presidente degli Stati Uniti, deve gestire i rapporti sempre più tesi con i suoi 
			  oppositori, mentre l’intero pianeta è scosso da un vortice di ostilità politiche, attacchi 
			  terroristici e dure rappresaglie. La presidente farà tutto il possibile per evitare lo scoppio
			  di una guerra non necessaria.\",  \"25.65\", \"1\");";
			 
//Controllo esito queryInsert
if($result=mysqli_query($mysqliConn,$queryInsert)){
	echo "<p>OK, tabella libro popolata correttamente!</p>";
	echo "<table border='1'>
		  <tr>
		  <th>ID</th>
		  <th>Titolo</th>
          <th>ISBN</th> 
		  <th>Anno pubblicazione</th>
		  <th>Trama</th>
		  <th>Prezzo</th>
		  <th>Id autore</th>
          </tr>";
	$querySelect="SELECT * FROM $tab_libro;";
	$resultSel=mysqli_query($mysqliConn,$querySelect);
	while ($row=mysqli_fetch_assoc($resultSel)){
	echo "<tr> \n";
	echo "<td>" .$row["id"]. "</td> \n";
	echo "<td>" .$row["titolo"] . "</td> \n";
	echo "<td>" .$row["isbn"] . "</td> \n";
	echo "<td>" .$row["anno_pub"] . "</td> \n";
	echo "<td>" .$row["trama"] . "</td> \n";	
	echo "<td>" .$row["prezzo"] . "</td> \n";
	echo "<td>" .$row["id_autore"] . "</td> \n";
	echo "</tr>";
	}
	echo "</table>";
	echo "<hr />";
}
else{
	printf("ERRORE, la tabella libro non è stata popolata\n");
	exit();
}

//POPOLAMENTO TABELLA USER
$queryInsert="INSERT INTO user (username, password, nome, cognome, tipologia) VALUES
			 ('giorgiadns','giorgiadns','Giorgia','De Nardis','gestore'),
			 ('marcotemperini','marcotemperini','Marco','Temperini','admin'),
			 ('topolino','topolino','Mickey','Mouse','utente'),
			 ('qui','qui','Huey','Duck','utente'),
			 ('quo','quo','Dewey','Duck','utente'),
			 ('qua','qua','Louie','Duck','utente');";
			 
//Controllo esito queryInsert
if($result=mysqli_query($mysqliConn,$queryInsert)){
	echo "<p>OK, tabella user popolata correttamente!</p>";
	echo "<table border='1'>
		  <tr>
		  <th>ID</td>
		  <th>Username</th>
          <th>Password</th> 
		   <th>Nome</th> 
		   <th>Cognome</th> 
		  <th>Tipologia</th>
          </tr>";
	$querySelect="SELECT * FROM $tab_user;";
	$resultSel=mysqli_query($mysqliConn,$querySelect);
	while ($row=mysqli_fetch_assoc($resultSel)){
	echo "<tr> \n";
	echo "<td>" .$row["id"]. "</td> \n";
	echo "<td>" .$row["username"] . "</td> \n";
	echo "<td>" .$row["password"] . "</td> \n";
	echo "<td>" .$row["nome"] . "</td> \n";
	echo "<td>" .$row["cognome"] . "</td> \n";
	echo "<td>" .$row["tipologia"] . "</td> \n";
	echo "</tr>";
	}
	echo "</table>";
	echo "<hr />";
}
else{
	printf("ERRORE, la tabella user non è stata popolata\n");
	exit();
}

//LA TABELLA ACQUISTI RIMANE VUOTA, VERRÀ POPOLATA DURANTE L'UTILIZZO DELL'APPLICAZIONE

//CHIUSURA CONNESSIONE

mysqli_close($mysqliConn);

?>

</body>
</html>