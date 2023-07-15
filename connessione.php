<?php 
session_start(); /*Inizio della sessione.*/
include 'DatiDB.php'; /*Carico i dati relativi al DB dal file.*/
include 'install.php';/*Carico i dati per popolare le tabelle.*/

/*Effettuo la connessione al fine di poter svolgere il login.*/
$CONNESSIONE = mysqli_connect($nome, $username, $password); 
/*Effettuo un check sulla connessione.*/
if(!$CONNESSIONE) /*Riscontro negativo.*/
	{die("Connessione fallita".mysqli_connect_error());} /*Termino la connessione e stampo un messaggio di errore.*/
/*Seleziono il database.*/
mysqli_select_db($CONNESSIONE,$NomeDB);
?>