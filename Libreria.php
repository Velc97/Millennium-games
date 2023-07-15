<!--Questa pagina gestisce la libreria dell'utente.-->
<?php include 'connessione.php';?>

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
	<title> Millennium Games </title> <!--Titolo della pagina.-->
	<link rel="stylesheet" type="text/css" href="main.css" /> <!--Style principale.-->
	<link rel="icon" href="materials/img/iconaSito.png" /> <!--Icona del sito-->
</head>
<body>
	<?php include 'toolbar.php'; ?>
	</br >
	<table class="backgroundTabella" style="margin-left:auto; margin-right:auto;">
		<tr>
			<td colspan="2"> <h1 class="faqTitle"> La tua libreria. </h1> </td>
		</tr>
			<?php
				$contenutoXML=""; /*Inizializzo la stringa che conterrà l'XML.*/
				foreach (file("SpecificaDatiLibrerie.xml") as $nodo) {$contenutoXML .= trim($nodo);} /*Mettiamo il file nel contenuto.*/
				$documentoXML = new DOMDocument(); /*Creazione del documento da usare.*/
				$documentoXML->loadXML($contenutoXML); /*Mettiamo il contenuto nel documento.*/

					if($documentoXML->schemaValidate("SchemaLibrerie.xsd")) /*Validazione del documento contenente le librerie.*/
						{
						 $arrayLibreria=array(); $i=0;
						 $elementi = $documentoXML->documentElement->childNodes;
						 while($i<$elementi->length) /*Trovo la libreria giusta.*/
								{
								 $objPuntato = $elementi->item($i); 
								 if($_SESSION['userName']==$objPuntato->getAttribute("utenteAssociato"))
									{
									 $listaGiochi=$objPuntato->getElementsByTagName("id");
									 for($j=0; $j<$listaGiochi->length; $j++)
										{/*Ricavo gli ID del gioco.*/
										 $arrayLibreria[$j]=$listaGiochi->item($j)->textContent; 
										 
										 $contenutoXML2=""; /*Inizializzo la stringa che conterrà l'XML.*/
										 foreach (file("SpecificaDatiVideogiochi.xml") as $nodo2)
													 {$contenutoXML2 .= trim($nodo2);} /*Mettiamo il file nel contenuto.*/
										 $documentoXML2 = new DOMDocument();/*Creazione del documento da usare.*/
										 $documentoXML2->loadXML($contenutoXML2);	/*Mettiamo il contenuto nel documento.*/									 

										 if($documentoXML2->schemaValidate("SchemaGiochi.xsd"))
											{
											 $elementi2 = $documentoXML2->documentElement->childNodes;
											 for($k=0; ; $k++)
												{
												 $idGioco=$elementi2->item($k)->firstChild->textContent;
												 if($idGioco==$arrayLibreria[$j])
												 	{
													 $nomeGioco = $elementi2->item($k)->firstChild->nextSibling->textContent;			  
													echo 
													"<tr> <td style=\"text-aling: left;\" class=\"ciano\">". $arrayLibreria[$j]."-".$nomeGioco ."</td>
														<td><form action=\"". $_SERVER['PHP_SELF']."\" method=\"post\">
																<input type=\"submit\" class=\"bottone\" name=\"Gioca\" value=\"Gioca\"/>
															</form> </td></tr>";/*Stampo la libreria.*/
													 break;
													}
												}
											}
										 else 
											{echo"<tr><td>Errore nella validazione del documento Videogiochi.</td></tr>";}
										}
									 break;
									}
								 $i++;
								}
						}
				else	{echo "<tr><td>Errore nella validazione del documento libreria.</td></tr>";}?>
	</table>
</body>
</html>
<!--{}-->