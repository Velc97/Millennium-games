<!--Cosmo Vellucci 1760067 Latina 2018-2019-->
<!--Tesina. Per ulteriori informazioni guardare il file README oppure il pdf della relazione.-->
<!-- http://lweb.dis.uniroma1.it/~lweb33 -->

<?php include 'connessione.php'?>


<!--Intestazione Del documento xml.-->
<?xml version="1.0" encoding="UTF-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head> 
	<title> Millennium Games </title> <!--Titolo della pagina.-->
	<link rel="stylesheet" type="text/css" href="main.css" /> <!--Style principale.-->
	<link rel="icon" href="materials/img/iconaSito.png" /> <!--Icona del sito-->
</head>
<body>
	<?php include 'toolbar.php';?> <!--Carico la toolbar principale del sito.-->
	
	<!--Script relativo al banner gigante.-->
	<?php $n = rand(1, 3); ?>
	<br />
	<!--Banner "Coming Soon"-->
	<div class="bannerMP">
		<div class="bannerMP_CS"> COMING SOON  </div>
		<img src="materials/img/metro<?php echo $n;?>.jpg" alt="In arrivo" style="width:1500px; height:1000px;" />
	</div>
</body>
</html>