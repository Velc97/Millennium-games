<?xml version="1.0" encoding="UTF-8"?>
<?php include 'connessione.php';?>
<!--Questo file serve a gestisce le impostazioni dell'utente.-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
	<title> Millennium Games </title> <!--Titolo della pagina.-->
	<link rel="stylesheet" type="text/css" href="main.css" /> <!--Style principale.-->
	<link rel="icon" href="materials/img/iconaSito.png" /> <!--Icona del sito-->
</head>
<body>
<?php include 'toolbar.php'; ?>
<?php include 'QueryUtente.php'; ?>

         <?php   if(isset($_POST['CancellaCarta']))
                {
                 $query="UPDATE $NomeTabellaUtente
                         SET nomePro = \"NULL\",
                             numeroCarta = \"NULL\",
                             codSic = \"NULL\",
                             dataScad = \"NULL\"
                         WHERE nomeUtente = \"{$_SESSION['userName']}\";";
                 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query)) /*Stampo un messaggio di errore e termino lo script.*/
                    {echo "Errore nell'esecuzione della query per la dememorizzazione della carta." . mysqli_error($CONNESSIONE); exit();}
                 echo "</tr><td class=\"ciano\">Carta cancellata</td></tr>";
                 header("Refresh:0");
                }?>
<?php 
    if(isset($_POST['invio']))
        {
         if(empty($_POST['nomeProp']) || empty($_POST['numeroCarta']) || empty($_POST['sicCode']) || empty($_POST['dataScad'])) 
            {echo "<tr><td class=\"ciano\"> Compilare tutti i campi </td></tr>";}
         else if(strlen($_POST['nomeProp'])>300 || strlen($_POST['numeroCarta'])!=12 || strlen($_POST['sicCode'])!=3)
            {echo "</tr><td class=\"ciano\">Compila i campi correttamente.</td></tr>";}
         else
            {
             $query="UPDATE $NomeTabellaUtente
                     SET nomePro = \"{$_POST['nomeProp']}\",
                         numeroCarta = \"{$_POST['numeroCarta']}\",
                         codSic = \"{$_POST['sicCode']}\",
                         dataScad = \"{$_POST['dataScad']}\"
                     WHERE nomeUtente = \"{$_SESSION['userName']}\";";
             if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
                {echo "Errore nell'esecuzione della query per la memorizzazione della carta." . mysqli_error($CONNESSIONE); exit();}
             header("Refresh:0");
            }
        }
?>


          
<table class="backgroundTabella">
    <tr><td><h2 class="faqTitle">Dati utente.</h2></td></tr>
    <tr><td class="ciano" style="border: 6px solid black;">Nome utente: <?php echo $riga['nomeUtente'] ?></td></tr>
    <tr>
        <td class="ciano" style="border: 6px solid black;">Cambia password (max 15 caratteri).<br />
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <span style="color: #0074D9;">Vecchia password: </span><input type="text" name="oldpsw" size="30" /><br />
                <span style="color: #0074D9;">Nuova password: </span><input type="text" name="newpsw" size="30" /><br />
                <input type="submit" class="bottone" name="CambiaPassword" value="Cambia Password" alt="submit"/>
            </form>
            <?php
             if(isset($_POST['CambiaPassword']))
                {
                 if(empty($_POST['oldpsw']) || empty($_POST['newpsw']) || strlen($_POST['newpsw'])>=15)   
                   {echo "<span style=\"color:red\">Compilare tutti i campi correttamente</span>";}
                 else
                   {
                    $query="SELECT *
                    FROM $NomeTabellaUtente
                    WHERE nomeUtente = \"{$_SESSION['userName']}\"
                    AND password = \"{$_POST['oldpsw']}\";";
                    if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
                        {echo "Errore nell'esecuzione della query per la verifica della vecchia password." . mysqli_error($CONNESSIONE); exit();}
                        $riga2 = mysqli_fetch_array($risultatoQuery);
                    if($riga2)
                        {
                         $query="UPDATE $NomeTabellaUtente
                                 SET password = \"{$_POST['newpsw']}\"
                                 WHERE nomeUtente = \"{$_SESSION['userName']}\";";
                         if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
                                {echo "Errore nell'esecuzione della query per la memorizzazione della nuova password." . mysqli_error($CONNESSIONE); exit();}
                         echo "<span style=\"color:green\">Cambio password effettuato con successo!</span>";
                        }
                    else
                        {echo "<span style=\"color:red\">Vecchia password non coincidente.</span>";}
                   }
                }
            ?>
        </td>
    </tr>
    <tr>
        <td class="ciano" style="border: 6px solid black;">
            Immagine di profilo: <br/><img src=<?php echo "\"". $riga['proPic'] ."\""?> alt="Immagine di profilo" style="width:100px; height:100px; margin-left:auto; margin-right:auto; display:block;"/>
            <?php
                if($riga['proPic']=='profiles/default.png') /*Caso dell'immagine di default*/
                    {
                     echo "<form action=\"". $_SERVER['PHP_SELF']."\" method=\"post\" enctype=\"multipart/form-data\">
                                <input type=\"file\" name=\"fileToUpload\" id=\"fileToUpload\"/>
                                <input type=\"submit\" class=\"bottone\" name=\"submitUpload\" value=\"Carica .jpg\" alt=\"submit\"/>
                           </form>"; 
                    }
                else /*Caso dell'immagine caricata dall'utente.*/
                    {
                     echo "<form action=\"". $_SERVER['PHP_SELF']."\" method=\"post\">
                                <input type=\"submit\" class=\"bottone\" name=\"RimuoviImmagine\" value=\"Rimuovi Immagine\" alt=\"submit\"/>
                           </form>"; 
                    }
                   
            ?>

            <?php //Submit aggiunta immagine (caso dell'immagine di default).
                if(isset($_POST['submitUpload']))
                    {
                     $directory="profiles/". $_SESSION['userName'] ."/";
                     $file_bersaglio = $directory . basename($_FILES["fileToUpload"]["name"]);
                     $uploadPossibile=1;

                     /*Check sul formato del file.*/
                     $imageFileType = strtolower(pathinfo($file_bersaglio, PATHINFO_EXTENSION));
                     if($imageFileType != "jpg")
                        {echo "Il file deve essere in formato jpg"; $uploadPossibile=0;}
                    
                        
                     $file_bersaglio = $directory . "propic.jpg";
                     if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $file_bersaglio) && $uploadPossibile==1)
                        {
                         $query="UPDATE $NomeTabellaUtente
                                 SET proPic=\"profiles/{$_SESSION['userName']}/propic.jpg\" 
                                 WHERE nomeUtente = \"{$_SESSION['userName']}\";";
                         if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
                                {echo "Errore nell'esecuzione della query per la memorizzazione dell'immagine di profilo." . mysqli_error($CONNESSIONE); exit();}
                         header("Refresh:0");
                        }
                     else
                        {echo "errore upload file";}               
                    }

            ?>


            <?php //Submit rimozione immagine (caso dell'immagine caricata dall'utente).
             if(isset($_POST['RimuoviImmagine']))
                    {  
                     unlink($riga['proPic']);
                     $query="UPDATE $NomeTabellaUtente
                             SET proPic = 'profiles/default.png'
                             WHERE nomeUtente = \"{$_SESSION['userName']}\";";
                     if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
                            {echo "Errore nell'esecuzione della query per la cancellazione della propic." . mysqli_error($CONNESSIONE); exit();}
                     header("Refresh:0");
                    }
            ?>
        </td>
    </tr>
    <tr><td class="ciano" style="border: 6px solid black;">Portafoglio attuale: <?php echo $riga['portafoglio']; ?> &euro;</td> </tr>
    <tr><td class="ciano" style="border: 6px solid black;"> Ruoli:
        <ul>
            <li>Bannato: <?php echo $riga['BAN'];?></li>
            <li>Gestore: <?php echo $riga['GEST'];?></li>
            <li>Admin: <?php echo $riga['ADM'];?></li>
        </ul>
    </td></tr>
    <tr><td class="ciano" style="border: 6px solid black;">Esperienza attuale: <?php echo $riga['expe'];?> </td></tr>

 
</table>

<table class="backgroundTabella">
    <tr><td><h2 class="faqTitle">Dati carta.</h2></td></tr>
    <?php
     if($riga['numeroCarta']=='NULL')
        {include 'FormCarta.php';}
     else
        {
         echo "
            <tr><td class=\"ciano\">Nome proprietario: ". $riga['nomePro'] . "</td></tr>
            <tr><td class=\"ciano\">Numero carta: ". $riga['numeroCarta'] . "</td></tr>
            <tr><td class=\"ciano\">Cod Sicurezza: ". $riga['codSic'] . "</td></tr>
            <tr><td class=\"ciano\">Data scadenza: ". $riga['dataScad'] . "</td></tr>
            <tr><td>
                <form action=\"". $_SERVER['PHP_SELF']. "\"method=\"post\">
                    <input type=\"submit\" class=\"bottone\" name=\"CancellaCarta\" value=\"Cancella carta\" alt=\"submit\"/>
                </form>
            </td></tr>";

        }
    ?>
</table>

</body>
</html>