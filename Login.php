<!--Pagina di login.-->

<?php include 'connessione.php'?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
	<title> Mlilennium Games </title> <!--Titolo della pagina.-->
	<link rel="stylesheet" type="text/css" href="main.css" /> <!--Style principale.-->
	<link rel="icon" href="materials/img/iconaSito.png" /> <!--Icona del sito.-->
</head>
<body>
	<?php include 'toolbar.php'?>
	<br /> <br /> <br /> <br />
	<table style="border:3px solid black; background-color: #001f3f; margin: 0 auto;">
		<tr>
			<td style="vertical-align:middle;"> <!--Prima cella contenente il video.-->
				<div style="display: inline;">
				<video autoplay loop muted playsinline width="800px" height="400px" src="materials/videos/banner.mp4">
					Il tuo browser non supporta le funzionalit&agrave; per video. Usa un altro browser, dai! <!--Messaggio di "errore" del browser.-->
				</video>
				</div>
			</td>
			
			<td style="vertical-align:top;"> <!--Seconda cella della tabella.-->
				<p class="ciano"> Entra nella community di videogiochi online pi&ugrave; grande del mondo: </p>
				<p style="font-style: italic; color: #0074D9; font-size: 35px;"> Compra, Gioca, Condividi. </p>
				<p class="ciano"> Tutto senza i tempi di attesa delle copie fisiche.</p>
				
				<!--Form per il login-->
				<form id="idLogin" action="<?php $_SERVER['PHP_SELF']?>" method="post" style="text-align: left; border: 3px solid;">
					<span style="color: #0074D9;">Nome utente:&ensp;&ensp;</span><input type="text" name="userName" size="30" /><br />
					<span style="color: #0074D9;">Password:&ensp;&ensp;&ensp;&nbsp;&ensp;</span><input type="password" name="password" size="30" /><br />
				</form>    <br />&ensp;&ensp;&ensp;&ensp;&ensp;&emsp;&emsp;&emsp;&emsp;
				
				<!--Bottone del login.-->
				<input type="submit" id="bottoneLogin" form="idLogin" name="invio" alt="submit" value="Login" style="display: none;" />
				<img onclick="document.getElementById('bottoneLogin').click()" src="materials/img/login.png" 
					width="50" height="50" alt="Login" title="Login" />&ensp;
					
				<!--Bottone del reset.-->
				<input type="reset" id="bottoneReset" form="idLogin" name="ricompila" value="Ricompila" style="display: none;" />
				<img onclick="document.getElementById('bottoneReset').click()" src="materials/img/reset.png" 
					width="50" height="50" alt="Ricompila" title="Ricompila" />
				
				<!--Controlli sul form di login-->
				<?php 
					if (isset($_POST['invio']))/*Determina se una variabile è stata dichiarata ed è differente da NULL.*/
					{
					 /*Controllo che nessuno dei due form siano vuoti.*/
					 if (empty($_POST['userName']) || empty($_POST['password']))
						{echo "<br /><span style=\"color: red;\">Si prega di compilare tutti i campi.</span><br />";}
					 else /*Procedo al login.*/
						{
						 echo "<br /><span style=\"ciano;\">Login in corso...</span><br />";
						 /*Effettuo la query.*/
						 $query="SELECT *
								FROM $NomeTabellaUtente
								WHERE nomeUtente = \"{$_POST['userName']}\" 
								AND password = \"{$_POST['password']}\" ";
						 /*Effettuo la query sopra.*/
						 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
							{
							 echo "Errore nell'esecuzione della query per il login. <br />" . mysqli_error($CONNESSIONE);
							 exit(); /*Termino lo script.*/
							}
						
						  /*Giunti a questo punto, devo controllare i dati inseriti dall'utente con quelli del DB.*/
						  $riga = mysqli_fetch_array($risultatoQuery);
						  if ($riga) /*Se la riga ottenuta non è vuota, do inizio alla sessione.*/
							{   
							 session_start(); /*Inizio la sessione*/
							 /*Memorizzo tutti i parametri necessari alla sessione.*/
							 $_SESSION['carrello'] = array(); /*Memorizza il carrello degli acquisti*/
							 $_SESSION['userName'] = $_POST['userName']; /*Memorizzo il nome utente.*/
							 $_SESSION['spesaFinora']=0; 
							 $_SESSION['loginEffettuato']=TRUE; /*Stabilisce il diritto di accesso dell'utente.*/
							 
							 /*Passo alla pagina principale.*/
							 header('Location: index.php'); /*"Location:" reindirizza il browser all'indirizzo a destra.*/   
							 exit(); /*Termino lo script, in quanto ho finito il login.*/
							}
						  else /*Caso di inserimento dati errato.*/
							{echo "<span style=\"color: red;\">Errore: nome utente e/o password errati.</span><br />";}
						}/*Fine else del login.*/
					}?> <!--Fine controlli form.-->
				<br /><br />
				
				<!--"ask" del form di registrazione.-->
				<span class="ciano"> Non possiedi un account? </span>
				<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
					<input type="submit" class="bottone" name="Registrazione" value="Registrati"/>
				</form> 
				
			</td>
		</tr>
	<!--Attivazione del form per la registrazione.-->
	<?php if (isset($_POST['Registrazione']))
			{echo include 'AggiungiRegistrazione.php';}?>
			
			<?php 
		 if(isset($_POST['ConfermaReg']))/*Check sul submit.*/
			{
			 if(empty($_POST['userNameReg']) || empty($_POST['pass1']) || empty($_POST['pass2'])) /*Check sull'inserimento di tutti i dati.*/
				{echo "<span style=\"color: red;\"> Inserire tutti i campi per la registrazione. </span>";} /*Fine check sull'inserimento dei dati.*/
			 else /*Caso di compilazione dei 3 campi.*/
				{
				  $queryReg = "SELECT *
							 FROM $NomeTabellaUtente
							 WHERE nomeUtente = \"{$_POST['userNameReg']}\" ";
					
				  /*Check sulla query.*/
				  if (!$risultatoQuery = mysqli_query($CONNESSIONE, $queryReg))
					{
					 echo "Errore nell'esecuzione della query per la registrazione (1). <br />" . mysqli_error($CONNESSIONE);
					 exit(); /*Termino lo script.*/
					}
				 
				 $riga = mysqli_fetch_array($risultatoQuery);
				 if($riga) /*Riscontro di un username già esistente.*/
					{echo "<span style=\"color: red;\"> Nome utente gia esistente: inserirne un'altro. </span>";}
				 elseif (strcmp($_POST['pass1'], $_POST['pass2']) != 0) /*Se password e conferma password sono uguali*/
					{echo "<span style=\"color: red;\"> Le password non coincidono. </span>";}
				 elseif(strlen($_POST['userNameReg'])>20)
					{echo "<span style=\"color: red;\"> Il nome utente deve essere al massimo di 20 caratteri. </span>";}
				 elseif(strlen($_POST['pass1'])>15)
					{echo "<span style=\"color: red;\"> La password deve essere al massimo di 15 caratteri. </span>";}
				 else /*Dopo tutti i controlli, procedo ad inserire l'utente nel DB.*/
				    {
					 $queryReg = "INSERT INTO $NomeTabellaUtente (nomeUtente, password, proPic, BAN, GEST, ADM, portafoglio, expe, nomePro, numeroCarta, codSic, dataScad)
							  VALUES ('" .$_POST['userNameReg']. "','" .$_POST['pass1']. " ', \"profiles/default.png\", \"N\", \"N\", \"N\", \"0.00\", \"0\",\"NULL\",\"NULL\",\"NULL\",\"NULL\"); ";
					 
					 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $queryReg))
						{
						 echo "Errore nell'esecuzione della query per la registrazione (2). <br />" . mysqli_error($CONNESSIONE);
						 exit(); /*Termino lo script.*/
						}
					
					 /*Inserimento della nuova libreria per l'utente appena registrato.*/
					 $contenutoXML="";
					 foreach (file("SpecificaDatiLibrerie.xml") as $nodo)
								{$contenutoXML .= trim($nodo);}
					 $documentoXML = new DOMDocument();
					 $documentoXML->loadXML($contenutoXML);

					 $TAG_Libreria = $documentoXML->createElement("Libreria");
					 $TAG_Libreria_Attributo = $documentoXML->createAttribute("utenteAssociato"); 
					 $TAG_Libreria_Attributo->value=$_POST['userNameReg'];
					 $TAG_Libreria->appendChild($TAG_Libreria_Attributo);

					 $radice= $documentoXML->getElementsByTagName("LIBRERIE")->item(0);
					 $radice->appendChild($TAG_Libreria);
					 $documentoXML->save("SpecificaDatiLibrerie.xml");
					 
					 /*Creazione della cartella dell'utente.*/
					 $dir = "profiles/". $_POST['userNameReg'];
					 mkdir($dir, 0700, true);

					 echo "<span style=\"color: green;\"> Registrazione compiuta! Esegui l'accesso. </span>";
					 exit();
					}
				}
			} /*Fine check submit.*/
		?>	
	</table>
	
</body>
</html>