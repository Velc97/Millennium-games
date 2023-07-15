<?php
 $query = "SELECT *
           FROM $NomeTabellaUtente;";
 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
 {echo "Errore nell'esecuzione della query per il recupero delle info degli utenti." . mysqli_error($CONNESSIONE); exit();}
 
 $lista ="";
 while($riga = mysqli_fetch_array($risultatoQuery))
    {
     
     $lista .= "<tr><td class=\"ciano\" style=\"border: 5px solid black;\">";
     $lista .= "<strong>Nome utente:</strong> {$riga['nomeUtente']} <br />";
     
     $valoreCheckbox = $riga['nomeUtente']. ":BAN";
     $lista .=" <strong>Ban:</strong> {$riga['BAN']} <input type=\"checkbox\" name=\"daModificare[]\" value=\"{$valoreCheckbox}\" form=\"idModifica\"/> <br />";
     
     $valoreCheckbox = $riga['nomeUtente']. ":GEST";
     $lista .="<strong>Gestore:</strong> {$riga['GEST']} <input type=\"checkbox\" name=\"daModificare[]\" value=\"{$valoreCheckbox}\" form=\"idModifica\"/> <br />";
     
     $valoreCheckbox = $riga['nomeUtente']. ":ADM";
     $lista .="<strong>Amministratore:</strong> {$riga['ADM']} <input type=\"checkbox\" name=\"daModificare[]\" value=\"{$valoreCheckbox}\" form=\"idModifica\"/> <br />";

     $lista .= "</td></tr>";
    }
 $lista .="<tr><td><form action=\"{$_SERVER['PHP_SELF']}\" method=\"post\" id=\"idModifica\">
 <input type=\"submit\" class=\"bottone\" name=\"confermaModifica\" value=\"Conferma\" alt=\"submit\"/>
 </form></td></tr>";
?>

<table class="backgroundTabella" style="border: 5 px solid black;">
    <?php echo $lista; ?>
</table>

<?php
if(isset($_POST['confermaModifica']))
    {
     if(empty($_POST['daModificare']) /*&& portafoglio*/)
        {echo "<p style=\"color:red\"> Selezionare qualcosa da modificare </p>";}
     else
        {
         if(!empty($_POST['daModificare']))
            {
             foreach($_POST['daModificare'] as $indice=>$indiceDaModificare)
                {
                 list($utente, $ruolo) = explode(":", $indiceDaModificare);
                 $query = "SELECT * 
                        FROM $NomeTabellaUtente
                        WHERE nomeUtente =\"{$utente}\";";
                 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
                    {echo "Errore nell'esecuzione della query per la ricerca dell'utente" . mysqli_error($CONNESSIONE); exit();}
                 $riga = mysqli_fetch_array($risultatoQuery);

                 if($riga[$ruolo]=='Y') {$valoreDaSettare = 'N';}
                 else {$valoreDaSettare = 'Y';}

                 $query = "UPDATE $NomeTabellaUtente
                        SET $ruolo = \"{$valoreDaSettare}\"
                        WHERE nomeUtente = \"{$utente}\";";
                 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
                    {echo "Errore nell'esecuzione della query per il cambio del ruolo {$ruolo} per l'utente {$utente}" . mysqli_error($CONNESSIONE); exit();}
                 echo '<meta http-equiv="refresh" content="0">';
                }
            }
         /*if empty portafoglio. */
        }
    }





?>