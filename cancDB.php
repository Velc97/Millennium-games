<?xml version="1.0" encoding="UTF-8"?>
<?php include 'connessione.php';?>
<!--Questo file serve a cancellare e quindi ripristinare il database.-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
	<title> Millennium Games </title> <!--Titolo della pagina.-->
	<link rel="stylesheet" type="text/css" href="main.css" /> <!--Style principale.-->
	<link rel="icon" href="materials/img/iconaSito.png" /> <!--Icona del sito-->
    <script>
			function TornaIndietro() {window.history.back();}
	</script>
</head>
<body>
    <?php include 'toolbar.php';?>
    <?php include 'QueryUtente.php'; ?>

    <?php
        if($riga['ADM']=='N') 
            {
             echo "<table class=\"backgroundTabella\">
                        <tr><td class=\"ciano\">
                            Autorizzazione non consentita. Clicca sul pulsante per tornare indietro.<br/>
                            <button class=\"bottone\" onclick=\"TornaIndietro()\"> Vai. </button> 
                        </td></tr>
                   </table>";
            }
        else 
            {
             echo "<table class=\"backgroundTabella\">
                        <tr><td class=\"ciano\"> Premi per ripristinare il database:
                            <form action=\"". $_SERVER['PHP_SELF']."\" method=\"post\">
                                <input type=\"submit\" class=\"bottone\" name=\"cancellaDB\" value=\"cancella DB\" alt=\"submit\"/>
                            </form>
                        </td></tr>
                   </table>";
            }
    ?>

    <?php
        if(isset($_POST['cancellaDB']))
            {
             $query = "DROP DATABASE lweb33;";
             if(mysqli_query($CONNESSIONE, $query)) {}
             else
                {echo "Errore nella cancellazione del database:" . mysqli_error($CONNESSIONE); exit();}
             echo "Database ripristinato con successo!";
             header('Location: index.php');
            }
    ?>
</body>
</html>