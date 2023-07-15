<?php include '../connessione.php';?>
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
	<title> Mlilennium Games </title> <!--Titolo della pagina.-->
	<link rel="stylesheet" type="text/css" href="../main.css" /> <!--Style principale.-->
	<link rel="icon" href="../materials/img/iconaSito.png" /> <!--Icona del sito.-->
</head>

<?php
	$contenutoXML=""; 
	foreach (file("../SpecificaDatiVideogiochi.xml") as $nodo)
				{$contenutoXML .= trim($nodo);}
	$documentoXML = new DOMDocument();
	$documentoXML->loadXML($contenutoXML);
	$elementi = $documentoXML->documentElement->childNodes;

	for($i=0; $i<$elementi->length; $i++)
		{
		 $elemento = $elementi->item($i);

		 $objPuntato=$elemento->firstChild;
		 if($_SESSION['idDaPassare'] == $objPuntato->textContent)
			{
			 $idGioco=$objPuntato->textContent;

			 $objPuntato=$objPuntato->nextSibling;
			 $nomeGioco=$objPuntato->textContent;

			 $objPuntato=$objPuntato->nextSibling;
			 $genereGioco=$objPuntato->textContent;

			 $objPuntato=$objPuntato->nextSibling;
			 $descrizione=$objPuntato->textContent;

			 $objPuntato=$objPuntato->nextSibling;
			 $prezzoGioco=$objPuntato->textContent;
			 
			 /*Conto i file nella cartella .*/
			 $directory=$idGioco;
			 $files2 = glob( $directory ."/*" ); 
			 if($files2) 
			 	{
				 $filecount = count($files2);
				 for($i=0; $i<$filecount; $i++)
					{
					 $objPuntato=$objPuntato->nextSibling;
					 $arrayIMG[$i]=$objPuntato->textContent;
					}
				}
			 else $filecount=0;
			 

			 $objPuntato=$elemento->lastChild;
			 $dispoGioco=$objPuntato->textContent;

			 $i=$elementi->length; /*termino il loop.*/
			}
		}
?>



<body>
	<table class="backgroundTabella" style="margin-left:auto; margin-right:auto; text-align:center;">
		<tr><td style="background-color:#FFDC00;"><h1> <?php echo $nomeGioco;?></h1></td></tr>
		<?php
			for($i=0; $i<$filecount; $i++)
				{echo "<tr><td><img src=\"".$idGioco."/". $arrayIMG[$i]. "\"style=\"width:1280px;\"/></td></tr>";}
		?>
		<tr>
			<td style="text-align:left;">
				<ul class="ciano">
					<li>Genere: <?php echo $genereGioco?></li>
					<li>Descrizione: <?php echo $descrizione;?></li>
					<li>Prezzo: <?php echo $prezzoGioco; ?>&euro;</li>
					<li>Data di disponibliit&agrave;: <?php echo $dispoGioco; ?></li>
				</ul>	
				<?php include '../AggiuntaCarrello.php'?>
			</td>
		</tr>
	</table></br>

<table class="backgroundTabella" style="margin-left:auto; margin-right:auto; text-align:center;">
	<?php include '../SezioneCommenti.php'?>
</table>


</body>
</html>