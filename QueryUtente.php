<?php 
     /*Query che prende le informazioni dell'utente.*/
     $query="SELECT *
	 FROM $NomeTabellaUtente
     WHERE nomeUtente = \"{$_SESSION['userName']}\"";
	 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
        {
         echo "Errore nell'esecuzione della query per le impostazioni utente." . mysqli_error($CONNESSIONE);
         exit(); /*Termino lo script.*/
        }
         $riga = mysqli_fetch_array($risultatoQuery);
?> 