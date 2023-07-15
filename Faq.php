<!--Pagina delle Faq.-->
<?php session_start(); ?><!--Inizio della sessione.-->

<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
	<title> Millennium Games </title> <!--Titolo della pagina.-->
	<link rel="stylesheet" type="text/css" href="main.css" /> <!--Style principale.-->
	<link rel="icon" href="materials/img/iconaSito.png" /> <!--Icona del sito-->
	<style> /*!--Stile per la lista ordinata della pagina.*/
		ol {list-style: none; counter-reset: item;}
		li {counter-increment: item;}
		li:before 
			{
			 content: counter(item); /*L'oggetto della lista è un contatore.*/
			 background: lightblue; /*Sfondo del cerchietto.*/
			 border-radius: 100%; /*Raggio del cerchietto*/
			 color: black; /*Colore del numero della lista.*/
			 width: 15px; /*Apiezza del cerchietto.*/
			 text-align: center; /*Allineamento del testo nel cerchietto.*/
			 display: inline-block; /*Disposizione sulla linea e sul blocco del cerchietto.*/
			} 
	</style>
</head>



<body>
	<span id="inizioPagina"></span>
	<?php include 'toolbar.php';?>

	<table class="backgroundTabella" style="margin-left:auto; margin-right:auto;">
		<tr> <!--Prima riga della tabella.--> 
			<td colspan="3" style="text-align: center;"><h1 class="faqTitle"> Pagina informativa </h1></td>
		</tr>

		<tr> <!--Seconda riga della tabella.-->
			<td colspan="3" style="text-align: center;"> 
				<h2 class="faqTitle"> Cos'&egrave; questo sito.</h2>
				<p class="ciano">
					Millennium Games &egrave; una piattaforma online dove puoi comprare e giocare i tuoi videogames preferiti. <br />
					Perch&egrave; aspettare inutilmente i tempi di attesa delle copie fisiche, occupando inoltre spazio ed inquinando ulteriormente attraverso cd e confezioni di plastica? <br />
					Registrati, accedi, aggiungi alla tua libreria personale, gioca, e se vuoi condividi con gli amici le tue emozioni su una vasta gamma di titoli.
				</p>
			</td>
		</tr>
		
		<tr> <!--Terza riga della tabella.-->
			<td colspan="3" style="text-align: center;"> <h2 class="faqTitle"> Chi siamo. </h2></td>
		</tr>
		
		<tr> <!--Quarta riga della tabella.-->
			<td>
				<img src="materials/img/businnessCat1.png" height="300" width="400" alt="Stephen Catwking" style="display:block" /> 
				<h3 class="faqTitle"> Stephen Catwking </h3>
				<p class="ciano"> 
					Dopo essersi disintossicato dall'erba gatta, <br />
					Stephen Catwking decise di ricominciare da zero diventando CEO di Millennium Games.
				</p>
			</td> 
			
			<td>
				<img src="materials/img/businnessCat2.jpg" height="400" width="300" alt="Albert Catstein" /> 
				<br />
				<h3 class="faqTitle"> Albert Catstein </h3>
				<p class="ciano"> 
					Progammatore web, &egrave; gestore del sito Millennium Games. <br /> 
					Basa il proprio lavoro sul suo emblematico motto <br />
					<span style="font-style: italic;">"Non so cosa stia facendo, ma funziona quindi va bene."</span> 
				</p>			
			</td> 
				
			<td>
				<img src="materials/img/businnessCat3.jpg" height="300" width="500" alt="Linus Catvalds" /> 
				<br />
				<h3 class="faqTitle"> Linus Catvalds </h3>
				<p class="ciano">
					Responsabile delle risorse umane, &egrave; a tutti gli effetti dedito a<br />
					abolire ogni abuso su animali, a partire dal gatto nella scatola di Schr&ouml;dinger.
				</p>			
			</td>
		</tr>
		
		<tr> <!--Quinta riga della tabella.-->
			<td colspan="3" style="text-align: center;">
				<h2 class="faqTitle"> Dove siamo. </h2>
				<p class="ciano"> Il nostro ufficio &egrave; situato in <span style="font-weight: bold;"> Qaanaaq, Groenlandia, </span> come riportato nella mappa sottostante </p> 
				<img src="materials/img/Qaanaaq.png" alt="Mappa della zona"/>
			</td>
		</tr>
		
		<tr> <!--Sesta riga della tabella.-->
			<td colspan="3" style="text-align: center;">
				<h2 class="faqTitle"> Contatti. </h2>
				<p class="ciano"> Scrivici una mail a <a href="mailto:indirizzoFasullo123@email.com">  gattoBello@libero.it</a> </p>
			</td>
		</tr>
		
		<tr> <!--Settima riga della tabella.-->
			<td colspan="3">
				<h2 class="faqTitle">Frequently Asked Question</h2>
				<ol>
					<li> 
						<h3 class="faqTitle">Come ci si registra?</h3>
						<p class="ciano">Dalla pagina principale, cliccando su "Accedi" e poi "registrazione".</p>
					</li>
					<li>
						<h3 class="faqTitle"> Qual &egrave; la garanzia dei vostri prodotti?</h3> 
						<p class="ciano">Tutti i nostri prodotti sono funzionanti al 100&percnt;
						e sono soggetti agli aggiornamenti dei produttori.</p>
					</li>
					<li>
						<h3 class="faqTitle"> Come funzionano e cosa sono i punti esperienza? </h3>
						<p class="ciano"> I punti esperienza sono dei punti associati ad ogni utente, e indicano
						l'attivit&agrave; dell'utente stesso sul sito.<br />
						Ogni acquisto conferisce un certo quantitativo di punti pari al prezzo di acquisto moltiplicato per 2.5,
						ogni commento ne conferisce 50.</p>
					</li>
					<li>
						<h3 class="faqTitle">Effettuate rimborsi?</h3>
						<p class="ciano">Assolutamente no, siamo tirchi.</p>
					</li>
				</ol>
			</td>
		</tr>
		
		<tr> <!--Ottava riga della tabella.-->
			<td colspan="3" style="text-align: right;"><a href="#inizioPagina" style="background-color: #FF851B;">Torna all'inizio.</a></td>
		</tr>
	</table>


</body>
</html>



