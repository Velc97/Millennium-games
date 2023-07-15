<form action="<?php $_SERVER['PHP_SELF']?>" method="post">
	<input type="submit" class="bottone" name="AggGioco" value="Aggiungi al carrello"/>
</form> 


<?php if(isset($_POST['AggGioco']))
			{
			 if($dispoGioco>date("Y-m-d")) /*Caso in cui il gioco non sia ancora uscito.*/
                {echo "<p style=\"color:red;\">Il gioco non &egrave; ancora disponibile.</p>";}
             else if(isset($_SESSION['loginEffettuato'])==FALSE) /*Verifica che l'utente sia collegato.*/
                {echo "<p style=\"color:red\";\">Effettua l'accesso per comprare il gioco.</p>";}
             else /*Controllo che il gioco non sia presente prima nella libreria e poi nel carrello.*/
                {/*###Prima nella libreria###*/
                 $contenutoXML=""; /*Inizializzo la stringa che conterrà l'XML.*/
                 foreach (file("../SpecificaDatiLibrerie.xml") as $nodo)
                            {$contenutoXML .= trim($nodo);} /*Mettiamo il file nel contenuto.*/           
                 $documentoXML = new DOMDocument();
                 $documentoXML->loadXML($contenutoXML);
                 if($documentoXML->schemaValidate("../SchemaLibrerie.xsd"))
                    {
                     $arrayLibreria=array();
                     $elementi = $documentoXML->documentElement->childNodes; 
                     for($i=0; $i<$elementi->length; $i++)
                        {
                         $objPuntato = $elementi->item($i);
                         if($_SESSION['userName']==$objPuntato->getAttribute("utenteAssociato"))
                            {
                             $listaGiochi=$objPuntato->getElementsByTagName("id");
                             for($j=0; $j<$listaGiochi->length; $j++)/*Ricavo gli ID del gioco.*/
                                {$arrayLibreria[$j]=$listaGiochi->item($j)->textContent;}
                            }
                        }/*A questo punto si ha l'array della libreria dell'utente.*/
                     $trovato=0;
                     foreach ($arrayLibreria as $indice=>$valore)
                        {
                         if($valore==$idGioco)
                            {echo "<p style=\"color:red\">Il gioco &egrave; gi&agrave; nella tua libreria.</p>"; $trovato=1; break;}                            
                        }
                     $trovato2=0; /*###Poi nel carrello.###*/
                     foreach ($_SESSION['carrello'] as $indice=>$valore)
                            {
                            if($valore==$idGioco)
                                {
                                 echo "<p style=\"color:red;\">Il gioco &egrave; gi&agrave; nel carrello.</p>"; 
                                 $trovato2=1;
                                 break;
                                }
                            } /*Fine del for.*/
                     if($trovato==0 && $trovato2==0)/*Altrimenti lo aggiungo */
                            {
                             $_SESSION['carrello'][] =$idGioco;
                             echo "<p style=\"color:green;\">Il gioco &egrave; stato aggiunto nel carrello.</p>"; 
                            }                     
                    } 
                 else/*Caso di errore della validazione del documento.*/
                    {echo "<p style=\"color:red>Errore nella validazione del documento xml.</p>"; exit();}            
                } /*Fine controllo sull'oggetto già presente nella libreria e nel carrello.*/
         } /*Fine if del form di aggiunta al gioco.*/?>

