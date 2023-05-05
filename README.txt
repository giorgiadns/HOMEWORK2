HOMEWORK 2 - PHP/MYSQL - DE NARDIS GIORGIA (1939804)
-----------------------------------------------------------------

REPOSITORY GITHUB: https://github.com/giorgiadns/HOMEWORK2

-----------------------------------------------------------------

IN COSA CONSISTE IL PROGETTO 

L'esercizio da cui ho preso spunto è il PHP-16 della lezione PHP2.
L'applicazione web gestisce una libreria, ma ogni user ha accesso ad
operazioni diverse in base alla tipologia (ossia viene visualizzato
un menù diverso per ogni tipologia): utente, gestore o admin.

OPERAZIONI UTENTE: l'user di tipo "utente" può visualizzare la lista
di libri disponibili, aggiungerne più di uno al carrello (contemporaneamente),
svuotare il carrello o procedere al pagamento ed infine, consultare 
la lista dei propri acquisti (sia relativi alla sessione corrente che a quelle 
precedenti).

OPERAZIONI GESTORE: il "gestore" può visualizzare il report del magazzino,
aggiungere libri e autori alla base di dati e visualizzare tutti gli 
acquisti di ogni utente.

OPERAZIONI ADMIN: l' "admin" può, come il gestore, visualizzare il 
report del magazzino, visualizzare l'elenco degli utenti, bannare gli
utenti e visualizzare la lista degli utenti attualmente bannati.

----------------------------------------------------------------

ISTRUZIONI PER L'USO

Dalla pagina di login si raggiungono tutte le altre, passando con il
puntatore sui pulsanti presenti in login.php si possono reperire tutte
le informazioni per accedere al sistema (user, username, password, etc.). 
Seguono alcune note:

1. Installazione e popolamento del DB: se ne occupa il file install.php;

2. Connessione al database: il file per la connessione al db connect.php
   utilizza l'account "archer" con password "archer", come negli esempi
   proposti a lezione, per evitare la creazione di un altro account;

3. Gli user: il db viene popolato con un totale di 6 user, di cui 1 gestore,
   1 admin e 4 utenti (per fare più prove con l'operazione di ban).
   Nella pagina di login sono elencati username e password in un tooltip,
   ma li riporto anche qui in caso di problemi:
		   a) username:"marcotemperini" password:"marcotemperini" tipologia:"admin"
		   b) username:"giorgiadns" password:"giorgiadns" tipologia:"gestore"
		   c) username:"topolino" password:"topolino" tipologia:"utente"
		   d) username:"qui" password:"qui" tipologia:"utente"
		   e) username:"quo" password:"quo" tipologia:"utente"
		   f) username:"qua" password:"qua" tipologia:"utente"



