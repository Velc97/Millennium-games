<!--Pagina del carrello-->
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
    <?php include 'toolbar.php';?>

    <table class="backgroundTabella">
        <?php
             if (!($_SESSION['carrello'])) /*Se il carrello non presenta valori.*/
                {echo "<tr><td class=\"ciano\">Il carrello &egrave; attualmente vuoto.</td></tr>";} 
             else /*Caso di carrello con almeno un elemento.*/
                {
                 $contenutoXML=""; /*Inizializzo la stringa che conterrà l'XML.*/
                 foreach (file("SpecificaDatiVideogiochi.xml") as $nodo)
                            {$contenutoXML .= trim($nodo);} /*Mettiamo il file nel contenuto.*/
                 /*Creazione del documento da usare.*/
                 $documentoXML = new DOMDocument();
                 /*Mettiamo il contenuto nel documento.*/
                 $documentoXML->loadXML($contenutoXML);
                 /*Creo la lista degli elementi del documento XML.*/
                 $elementi = $documentoXML->documentElement->childNodes;

                 $_SESSION['spesaFinora']=0;
                 $listaCarrello="<tr><td class=\"ciano\" colspan=\"3\"><h3 class=\"faqTitle\"> Carrello</h3></td></tr>
                 <tr><td class=\"ciano\">ID</td> <td class=\"ciano\">Nome</td> <td class=\"ciano\">Prezzo</td></tr>";

                 foreach($_SESSION['carrello'] as $indice=>$valore)
                    {
                     for($i=0; $i<$elementi->length; $i++)
                            {
                             $elemento = $elementi->item($i); /*singolo elemento (videogioco) che deve essere lavorato nel for.*/
                             $objPuntato=$elemento->firstChild;
                             if($valore==$objPuntato->textContent)
                                {
                                 $objPuntato=$objPuntato->nextSibling;
                                 $nomeGioco=$objPuntato->textContent;
                                 $objPuntato=$objPuntato->nextSibling->nextSibling->nextSibling;
                                 $prezzoGioco=$objPuntato->textContent;
                                 $listaCarrello.= "<tr>
                                 <td class=\"ciano\">
                                 <input type=\"checkbox\" name=\"daEliminare[]\" value=\"".$indice."\" form=\"idElimina\"/>". $valore ."</td>
                                 <td class=\"ciano\">". $nomeGioco ."</td>
                                 <td class=\"ciano\">". $prezzoGioco ." &euro;</td>
                                 </tr>";
                                 $_SESSION['spesaFinora']+=$prezzoGioco;
                                 break;
                                }
                            }
                    }
                 $listaCarrello.="<tr><td colspan=\"3\" class=\"ciano\" style=\"text-align:center;\"><i>Prezzo totale: </i> ". $_SESSION['spesaFinora'] ."&euro;</td></tr>";

                 
                 $listaCarrello.="<tr>";
                 /*Form di azzeramento del carrello.*/
                 $listaCarrello.="<td> 
                                    <form action=\"" .$_SERVER['PHP_SELF']. "\"method=\"post\">
                                    <input type=\"submit\" name=\"ClearCarrello\" value=\"Svuota carrello\" />
                                    </form>
                                  </td>";
                 /*Form di rimozione di un elemento dal carrello.*/
                 $listaCarrello.="<td> 
                                    <form action=\"". $_SERVER['PHP_SELF']."\" id=\"idElimina\"  method=\"post\">
                                       <input type=\"submit\" name=\"Rimuovi\" value=\"Rimuovi dal carrello\"/>
                                    </form>
                                  </td>";
                 /*Form di conferma della compera.*/
                 $listaCarrello.="<td>
                                    <form action=\"".$_SERVER['PHP_SELF']."\" method=\"post\">
                                       <input type=\"submit\" name=\"confermaCompere\" value=\"Conferma\" />
                                    </form>
                                  </td>";
                                 
                 $listaCarrello.="</tr>";
                

                 echo $listaCarrello;
                }

        ?>
    </table>
</body>
</html>


<?php
   if(isset($_POST['ClearCarrello']))
         {$_SESSION['carrello']=array(); header("Refresh:0");}
   if(isset($_POST['Rimuovi']))
         {
          if(empty($_POST['daEliminare']))
            {echo "<p style=\"color:red;\">Seleziona qualcosa da cancellare.</p>";}
          else
            {foreach ($_POST['daEliminare'] as $indice=>$indiceDaEliminare)
               {unset($_SESSION['carrello'][$indiceDaEliminare]);}
             header("Refresh:0");
            }
         }
   if(isset($_POST['confermaCompere']))
         {
          include 'QueryUtente.php';
          if($riga['portafoglio']>=$_SESSION['spesaFinora'])
            {
             $punti=$_SESSION['spesaFinora']*2.5;
             $query="UPDATE $NomeTabellaUtente
             SET portafoglio = portafoglio-{$_SESSION['spesaFinora']},
                 expe = expe+{$punti}
             WHERE nomeUtente = \"{$_SESSION['userName']}\";";
             if (!$risultatoQuery = mysqli_query($CONNESSIONE, $query))
               {echo "Errore nell'esecuzione della query per la conferma delle compere" . mysqli_error($CONNESSIONE); exit();}

             /*Inserimento del videogioco nella libreria dell'utente.*/
             $contenutoXML="";
             foreach (file("SpecificaDatiLibrerie.xml") as $nodo)
                        {$contenutoXML .= trim($nodo);}
             $documentoXML = new DOMDocument();
             $documentoXML->loadXML($contenutoXML);
             $elementi = $documentoXML->documentElement->childNodes;             

             for($i=0; $i<$elementi->length; $i++)
               {
                $objPuntato = $elementi->item($i);
                if($_SESSION['userName']==$objPuntato->getAttribute("utenteAssociato"))
                  {
                   foreach($_SESSION['carrello'] as $indice=>$valore)
                     {
                      $TAG_id = $documentoXML->createElement("id", $valore);
                      $objPuntato->appendChild($TAG_id);
                     }
                   $i=$elementi->length+1;
                  }
               }
             $documentoXML->save("SpecificaDatiLibrerie.xml");
             $_SESSION['carrello']=array();
             header("Refresh:0");
            }
          else /*Caso di portafoglio insufficiente.*/
            {echo "<p style=\"color: red;\">Portafoglio insufficiente. Ricaricalo contattando un admin.</p>";}
         }

?>