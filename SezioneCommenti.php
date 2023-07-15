<?php			$contenutoXML=""; /*Inizializzo la stringa che conterrà l'XML.*/
				foreach (file("../SpecificaDatiCommenti.xml") as $nodo)
							{$contenutoXML .= trim($nodo);} /*Mettiamo il file nel contenuto.*/
				$documentoXML = new DOMDocument();
				$documentoXML->loadXML($contenutoXML);
		
				if($documentoXML->schemaValidate("../SchemaCommenti.xsd"))
					{
					 echo "<tr><td colspan=\"2\" style=\"background-color:#FFDC00;\"><h1>Sezione commenti.</h1></td></tr>";
					 $i=0;
					 $elementi = $documentoXML->documentElement->childNodes;
					 while($i<$elementi->length)
							{
							 $objPuntato = $elementi->item($i); /*Singolo elemento (sezioneCommentiGioco) che deve essere lavorato.*/
							 if($_SESSION['idDaPassare']==$objPuntato->getAttribute("idGioco"))
									{
									 $Utente_e_commento=$objPuntato->getElementsByTagName("commento");/*Ottengo la lista dei commenti.*/
									 if($Utente_e_commento->length==0)/*Caso in cui non ci sono commenti.*/
										 {echo "<tr><td colspan=\"2\" class=\"ciano\"> Non ci sono ancora commenti.</td></tr>";}
									 
									 for($j=0; $j<$Utente_e_commento->length; $j++)/*Caso del commento */
										{
										 if($Utente_e_commento->item($j)->getAttribute('commentoCancellato')=='NO')
										 	{
												$Utente=$Utente_e_commento->item($j)->firstChild->textContent;
												$Commento=$Utente_e_commento->item($j)->firstChild->nextSibling->textContent;
												$Recensione=$Utente_e_commento->item($j)->lastChild->textContent;
												
												/*Effetto la query per ottenere l'immagine.*/
												$query="SELECT *
														FROM $NomeTabellaUtente
														WHERE nomeUtente=\"$Utente\"";
												/*Effettuo la query sopra.*/
												if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
												   {echo "Errore nell'esecuzione della query. <br />" . mysqli_error($CONNESSIONE); exit(); /*Termino lo script.*/}
												$riga = mysqli_fetch_array($risultatoQuery);
											
												switch(true) 
												   {/*Controllo il livello dell'utente.*/
													case $riga['expe']<100: $plv=0; break;
													case $riga['expe']<200: $plv=1; break;
													case $riga['expe']<300: $plv=2; break;
													case $riga['expe']<400: $plv=3; break;
													case $riga['expe']<500: $plv=4; break;
													case $riga['expe']<600: $plv=5; break;
													case $riga['expe']<700: $plv=6; break;
													case $riga['expe']<800: $plv=7; break;
													case $riga['expe']<900: $plv=8; break;
													case $riga['expe']<1000: $plv=9; break;
													case $riga['expe']>=1000: $plv=10; break;
												   }
					   
												/*Raccolgo i dati per il commento.*/
												$codiceCommento="<tr><td style=\"border-bottom: 1px solid #ccc;\"><h2 class=\"faqTitle\"><b>" . $Utente ."</b></h2>
												<img src=\"../". $riga['proPic'] ."\" alt=\"Profile Picture\" style=\"width:300px; height:300px;\"/>
												</br> <p class=\"ciano\">Livello ". $plv ."</p>";
	   
												/*Check sull'utente bannato.*/
												if($riga['BAN']=='Y')
												   {$codiceCommento.="<p style=\"color:#FF0000\">Utente bannato</p>";}

												if(isset($_SESSION['loginEffettuato']))
												{
												 include 'QueryUtente.php';
												 if($riga['GEST']=='Y' && $_SESSION['loginEffettuato']==TRUE) /*Caso del gestore che vede i commenti.*/
												   {$codiceCommento.="<p class=\"ciano\"><input type=\"checkbox\" name=\"daEliminare[]\" value=\"".$j."\" form=\"idElimina\"/> Cancella</p>";}
												}

												$codiceCommento.="</td>
												<td class=\"ciano\" style=\"text-align: left; border-bottom: 1px solid #ccc;\">". $Commento;
											   
												/*Aggiungo l'eventuale recensione.*/
												if($Recensione=='P')
												   {$codiceCommento.= "<img align=\"right\" src=\"../materials/img/tup.png\" alt=\"Recensione positiva\" style=\"width:15%;\"/>";} 
												else if($Recensione=='N') 
													{$codiceCommento.= "<img align=\"right\" src=\"../materials/img/tdown.png\" alt=\"Recensione negativa\" style=\"width:15%\"/>";}
												

												/*Termino e stampo il commento.*/
												$codiceCommento.="</td></tr>";
												echo $codiceCommento;
										 	} /*Fine if del commento non cancellato.*/

										} /*Fine for dell'utente e del commento.*/
									 break; /*Termino il for.*/
									}
							 else{$i++;}
							}/*Fine While*/
					}
				else /*Caso di documento non validato.*/
					{echo "<tr><td>Errore nella validazione del documento xml.</td></tr>";}

		

				/*Sezione per il commento dell'utente collegato.*/
				if(isset($_SESSION['loginEffettuato'])==FALSE) /*Caso in cui l'utente non sia collegato.*/
					{echo "<tr><td colspan=\"2\" class=\"ciano\" >Accedi per commentare.</td></tr>";}
				else
					{
					 include 'QueryUtente.php';
					 if($riga['BAN']=='Y')
						{echo "<tr><td colspan=\"2\" style=\"color:red;\">Sei stato bannato e non puoi pi&ugrave; commentare. Convinci un admin a farti sbannare.</td></tr>";}
					 else
						{
						 echo "<tr><td colspan=\"2\" class=\"ciano\">
						 		Commenta qui:<br/>
								<form id=\"idCommento\" action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\">
									<textarea rows=\"3\" cols=\"60\" name=\"boxCommento\"></textarea><br/>
									<input type=\"submit\" form=\"idCommento\" class=\"bottone\" name=\"sendCommento\" value=\"Invia commento\"/>
									<input type=\"radio\" id=\"RP\" name=\"recensione\" value=\"P\"/>
									<label for=\"RP\">Recensione positiva</label>
									<input type=\"radio\" id=\"RN\" name=\"recensione\" value=\"N\"/>
									<label for=\"RN\">Recensione negativa</label>	
									<input class=\"bottone\" type=\"reset\" name=\"ricompila\" value=\"Ricompila\"/>
								</form>
								</td></tr>";
						if($riga['GEST']=='Y')
							{
							 echo "<tr><td colspan=\"2\" style=\" border-top: 1px solid red;><form action=\"". $_SERVER['PHP_SELF']."\" id=\"idElimina\"  method=\"post\">
										<br />
										<input type=\"submit\" name=\"Rimuovi\" class=\"bottoneRosso\" value=\"Rimuovi Commenti\"/>
							 	  </form></td></tr>";
							}
					
				 		 /*Caso di invio del commento.*/
				 		 if(isset($_POST['sendCommento']) )
							{
							 if(empty($_POST['boxCommento']))
								{echo "<p style=\"color:red;\"> Scrivi un commento prima di inviare.</p>"; exit();}
								$contenutoXML="";
								foreach (file("../SpecificaDatiCommenti.xml") as $nodo)
											{$contenutoXML .= trim($nodo);} 
								$documentoXML = new DOMDocument(); $documentoXML->loadXML($contenutoXML);
								if(!$documentoXML->schemaValidate("../SchemaCommenti.xsd"))
									{echo "<p> Errore nella validazione del documento. </p>"; exit();}
								$elementi = $documentoXML->documentElement->childNodes;
								for($i=0; $i<$elementi->length; $i++)
									{
									$objPuntato = $elementi->item($i);
									if($_SESSION['idDaPassare']==$objPuntato->getAttribute("idGioco"))
										{
										 break;
										 $objPuntato = $objPuntato->lastChild;
										}
									}

							 $testoCommento = $_POST['boxCommento'];
							  
							 $TAG_commento = $documentoXML->createElement("commento"); /*Creo il tag del commento.*/
							 $TAG_commento_Attributo = $documentoXML->createAttribute("commentoCancellato"); /*Aggiungo l'attributo al commento.*/
							 $TAG_commento_Attributo->value="NO"; /*Setto l'attributo su NO.*/
							 $TAG_commento->appendChild($TAG_commento_Attributo); /*Inserisco l'attributo al tag commento.*/
								$TAG_utente = $documentoXML->createElement("utente", $_SESSION['userName']); /*Creo il tag dell'utente.*/
								$TAG_testo = $documentoXML->createElement("testo", $testoCommento); /*Creo il tag del testi.*/
							 
							 $objPuntato->appendChild($TAG_commento); /*Memorizzo il tag del commento.*/
							 $TAG_commento->appendChild($TAG_utente); // $objPuntato=$objPuntato->firstChild; /*Non va bene!*/
							 $TAG_commento->appendChild($TAG_testo);

							 if(isset($_POST['recensione'])) {$TAG_recensione = $documentoXML->createElement("recensione", $_POST['recensione']);}
							 else {$TAG_recensione = $documentoXML->createElement("recensione");}
							 $TAG_commento->appendChild($TAG_recensione);

							 $documentoXML->save("../SpecificaDatiCommenti.xml");

							 $query="UPDATE $NomeTabellaUtente
							 SET expe = expe+50
							 WHERE nomeUtente = \"{$_SESSION['userName']}\";";
							 if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
							   {echo "Errore nell'esecuzione della query per la memorizzazione dei punti exp." . mysqli_error($CONNESSIONE);}

							echo '<meta http-equiv="refresh" content="0">'; /*Refresh pagina dopo output.*/
							}/*Fine invio commento.*/
							
						 /*Caso di cancellazione del commento */
						 if(isset($_POST['Rimuovi']))
							{
							 if(empty($_POST['daEliminare']))
								{echo "<p style=\"color:red;\">Seleziona qualcosa da cancellare (se c'&egrave;).</p>";}
							 else
								{
								 $contenutoXML="";
								 foreach (file("../SpecificaDatiCommenti.xml") as $nodo) {$contenutoXML .= trim($nodo);}
								 $documentoXML = new DOMDocument(); $documentoXML->loadXML($contenutoXML);
								 foreach($_POST['daEliminare'] as $indice=>$indiceDaEliminare)
									{/*$i contiene la sezioneCommentiGIoco dell'ID del gioco.*/ /*$indiceDaEliminare-1 contiene l'indice del commento da eliminare.*/
									 $elementi = $documentoXML->documentElement->childNodes;
									 $objPuntato = $elementi->item($i); /*Punto alla sezioneCommentiGIoco dell'ID del gioco.*/
									 $objPuntato = $objPuntato->childNodes; /*Raccolgo i commenti.*/
									 $objPuntato = $objPuntato->item($indiceDaEliminare);
									 $objPuntato->setAttribute("commentoCancellato","SI");
									}
								$documentoXML->save("../SpecificaDatiCommenti.xml");
								 echo '<meta http-equiv="refresh" content="0">'; /*Refresh pagina dopo output.*/
								}
							}/*Fine caso di cancellazione del commento.*/
						}
					}?>