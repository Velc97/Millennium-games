<!--Questo file serve a gestire il negozio online e mostra ogni singolo titolo disponibile.-->
<?php include 'connessione.php';?>

<?php 
 if(isset($_POST['identificativoGioco']))
	 {
	  $_SESSION['idDaPassare'] = $_POST['identificativoGioco'];
	  header('Location:games/GamePage.php'); /*Lo metto prima che sennò mi da problemi.*/
	 }
?>

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
	<br />

	<table class="catalogo" style="margin: 0 auto; border: 3px solid #3D9970; border-collapse: collapse;">
		<tr style="background-color: #AAAAAA;"> <td colspan="5"><h1> Il nostro catalogo di videogiochi digitali. </h1></td></tr>
		<tr style="background-color: #5d6d7e;">	
			<td> <h3 style="font-family: Verdana, Geneva, sans-serif;"> ID </h3> </td> 
			<td> <h3 style="font-family: Verdana, Geneva, sans-serif;"> Titolo </h3> </td> 
			<td> <h3 style="font-family: Verdana, Geneva, sans-serif;"> Genere </h3> </td>
			<td> <h3 style="font-family: Verdana, Geneva, sans-serif;"> Prezzo </h3> </td> 
			<td> <h3 style="font-family: Verdana, Geneva, sans-serif;"> Disponibilit&agrave; </h3> </td>
		</tr>
		<?php 
			$contenutoXML=""; /*Inizializzo la stringa che conterrà l'XML.*/
			foreach (file("SpecificaDatiVideogiochi.xml") as $nodo)
						{$contenutoXML .= trim($nodo);} /*Mettiamo il file nel contenuto.*/
			$documentoXML = new DOMDocument();
			$documentoXML->loadXML($contenutoXML);

			/*Creo la lista degli elementi del documento XML.*/
			$elementi = $documentoXML->documentElement->childNodes;

			/*Validazione del documento XML.*/
			if($documentoXML->schemaValidate("SchemaGiochi.xsd"))
				{
				 /*Processo il catalogo.*/
				 $catalogo="";
				 for($i=0; $i<$elementi->length; $i++)
					{
					  $elemento = $elementi->item($i); /*singolo elemento (videogioco) che deve essere lavorato nel for.*/
					
					  $objPuntato=$elemento->firstChild;
					  $idGioco=$objPuntato->textContent;

					  $objPuntato=$objPuntato->nextSibling;
					  $nomeGioco=$objPuntato->textContent;

					  $objPuntato=$objPuntato->nextSibling;
					  $genereGioco=$objPuntato->textContent;

					  $objPuntato=$objPuntato->nextSibling->nextSibling;
					  $prezzoGioco=$objPuntato->textContent;

					  $objPuntato=$elemento->lastChild;
					  $dispoGioco=$objPuntato->textContent;
					  
					  $catalogo.= "<tr>
										<td>
											<input type=\"radio\" form=\"passaApagina\" id=\"{$idGioco}\" name=\"identificativoGioco\" value=\"{$idGioco}\"/>
											<label for=\"RN\">{$idGioco}</label>	
										</td>
										<td>{$nomeGioco}</td> <td>{$genereGioco}</td> <td>{$prezzoGioco}&euro;</td> <td>{$dispoGioco}</td>
								  </tr>";
					}
				 $catalogo .= "<tr><td colspan=\"5\">
									<form id=\"passaApagina\" action=\"". $_SERVER['PHP_SELF'] ."\" method=\"post\"> 
										<input type=\"submit\" form=\"passaApagina\" class=\"bottone\" name=\"sendCommento\" value=\"Visita pagina\"/>
									</form>
				 			   </td></tr>";
				 echo $catalogo; /*Stampa del catalogo.*/	 
				} 
			else {echo "Documento SchemaGiochi.xsd non valido.";}
		?>
	</table>
</body>
</html>

