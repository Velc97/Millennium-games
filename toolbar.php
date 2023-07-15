<!--Questo file contiene la toolbar del sito.-->

<table border="1" style="background: url(materials/background/tableBack.jpg); border-style: double; border: 7px solid black; border-collapse: collapse;" >
		<tr>
			<td style="padding: 8px;"><a href="index.php"><img src="materials/img/Logo.png" alt="Logo del sito" height="100" width="200" /></a> </td>
			<td style="padding: 8px;"> 
				<?php /*Se l'utente non è ancora connesso, metto "Login".*/
				 if(isset($_SESSION['loginEffettuato'])==FALSE)
					 {echo "<a href=\"Login.php\"> Accedi </a>";}
				 else /*Se l'utente è già connesso, metto  le impostazioni.*/
					 {echo "Benvenuto <br /> <span style=\"font-weight: bold;\">" . $_SESSION['userName'] . "</span>";}
				?>
			</td>
			<td style="padding: 8px;"> <a href="Negozio.php"> Negozio</a> </td>
			<td style="padding: 8px;"> <a href="Faq.php"> F.A.Q. e informazioni </a> </td>
			
			<!--Mostro delle celle aggiuntive con logout, libreria, carrello, impostazioni; Quando l'utente ha effettuato il login.-->
			<?php 
			/*Come per sopra, if($_SESSION['loginEffettuato']==TRUE) non va bene perchè la variabile la creo solo dopo il login.*/
			if(isset($_SESSION['loginEffettuato'])==TRUE) /*isset infatti determina se una variabile è dichiarata e differente da NULL.*/
				{
				 echo "<td style=\"padding: 8px;\"> <a href=\"Libreria.php\"> Libreria </a></td>";
				 echo "<td style=\"padding: 8px;\"> <a href=\"ImpostazioniUtente.php\"> Impostazioni </a></td>";
				 echo "<td style=\"padding: 8px;\"> <a href=\"Carrello.php\"> Carrello  </a></td>";
				 echo "<td style=\"padding: 8px;\"> <a href=\"Logout.php\"> Logout </a></td>";
				 echo "<td style=\"padding: 8px;\"> <a href=\"InserimentoGioco.php\"> Inserisci Videogioco </a> </td>"; 
				 echo "<td style=\"padding: 8px;\"> <a href=\"cancDB.php\"> Cancella database </a> </td>";
				 echo "<td style=\"padding: 8px;\"> <a href=\"Utenti.php\"> Gestione utenti </a> </td>";
				}
			?>
		</tr>   <!--Fine della riga.-->
	</table> <!--Fine della tabella.-->