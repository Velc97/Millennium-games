<!--Questo script serve ad effettuare il logout.-->

<?php
 session_start(); /*Inizio la sessione.*/
 unset($_SESSION); /*Pulisco le variabili della sessione, come se fosse $_SESSION=Array;*/
 session_destroy(); /*distruggo i dati registrati alla sessione, come i file di sessione nel file system.*/
?>


<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head> 
		<title> Millennium Games </title> <!--Titolo della pagina.-->
		<link rel="stylesheet" type="text/css" href="main.css"> <!--Style principale.-->
		<link rel="icon" href="materials/img/iconaSito.png"> <!--Icona del sito-->
	</head>
	<body>
		<p align="center">Logout in corso, verrai reindirizzato alla pagina di login...</p>
		<?php header("Location: index.php"); ?>
	</body>
</html>