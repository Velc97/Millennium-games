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
			function vaiindietro() {window.history.back();}
	</script>
</head>
<body>
<?php include 'toolbar.php'?>
<?php include 'QueryUtente.php'; ?>
    <?php
        if($riga['GEST']=='N') 
            {
             echo "<table class=\"backgroundTabella\">
                        <tr><td class=\"ciano\">
                            Autorizzazione non consentita. Clicca sul pulsante per tornare indietro.</br>
                            <button class=\"bottone\" onclick=\"vaiindietro()\"> Vai. </button> 
                        </td></tr>
                   </table>";
            }
        else {include 'InserimentoGiocoForm.php';}
    ?>
</body>
</html>