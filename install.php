<!--File che serve a inizializzare le tabelle del progetto con dei dati di esempio.-->

<?php 

/*Effettuo la connessione.*/
/*Creo la connessione*/
$CONNESSIONE = mysqli_connect($nome, $username, $password);
/*Effettuo un controllo sulla connessione.*/
if(!$CONNESSIONE) /*Riscontro negativo.*/
	{die("Connessione fallita" . mysqli_connect_error());} /*Termino la connessione e stampo un messaggio di errore.*/




/*Creo il database*/
$query = "CREATE DATABASE IF NOT EXISTS $NomeDB"; /*Memorizzo la query per la creazione del DB.*/
if(mysqli_query($CONNESSIONE, $query)) {}/*Caso di creazione effettuata con successo*/
else /*Caso di creazione effettuata con insuccesso*/
	{echo "Errore nella creazione del database:" . mysqli_error($CONNESSIONE);}
	
/*Seleziono il database.*/
mysqli_select_db($CONNESSIONE,$NomeDB);

/*Creo la tabella relativa all'utente.*/
$query = "CREATE TABLE IF NOT EXISTS $NomeTabellaUtente 
			(
			 nomeUtente VARCHAR(20) NOT NULL PRIMARY KEY, 
			 password VARCHAR(15) NOT NULL,
			 proPic VARCHAR(300),
			 BAN CHAR(1) NOT NULL DEFAULT 'N',
			 GEST CHAR(1) NOT NULL DEFAULT 'N',
			 ADM CHAR(1) NOT NULL DEFAULT 'N',
			 portafoglio FLOAT,
			 expe INT,
			 nomePro VARCHAR(300),
			 numeroCarta CHAR(12),
			 codSic CHAR(3),
			 dataScad DATE
			)";
/*Check sulla creazione della tabella.*/
if(mysqli_query($CONNESSIONE, $query)) {}/*Caso di creazione effettuata con successo*/
else /*Caso di creazione effettuata con insuccesso*/
	{echo "Errore nella creazione della tabella $NomeTabellaUtente:" . mysqli_error($CONNESSIONE);}

/*Passo a popolare la tabella*/
/*Tabella relativa agli utenti.*/
$query = "INSERT IGNORE INTO $NomeTabellaUtente 
		(nomeUtente, password, proPic, BAN, GEST, ADM, portafoglio, expe, nomePro, numeroCarta, codSic, dataScad)
		VALUES
		(\"CosmoVellucci\",\"CosmoVellucci\",\"profiles/default.png\", \"N\", \"Y\", \"N\", \"30.00\", \"100\",  \"Cosmo Vellucci\", \"000000000000\", \"115\", \"01-01-20\"),
		(\"Manigoldo\", \"Manigoldo\", \"profiles/Manigoldo/propic.jpg\", \"Y\", \"N\", \"N\", \"0.0\", \"100\", \"Manigoldo Manigoldini\", \"123456789012\", \"100\", \"10-10-25\"),
		(\"Arturo\", \"Arturo\", \"profiles/Arturo/propic.jpg\",\"Y\", \"N\", \"Y\", \"700.0\", \"500\", \"NULL\",\"NULL\",\"NULL\",\"NULL\"),
		(\"Bramante\", \"Bramante\", \"profiles/default.png\", \"N\", \"N\", \"N\", \"0.0\", \"0\", \"NULL\",\"NULL\",\"NULL\",\"NULL\");";
if(!mysqli_query($CONNESSIONE, $query)) /*Check sul popolamento.*/
	{echo "Errore nell'inserimento dati di ". $NomeTabellaUtente . mysqli_error($CONNESSIONE);}

/*Chiudo la connessione.*/
mysqli_close($CONNESSIONE);
?>