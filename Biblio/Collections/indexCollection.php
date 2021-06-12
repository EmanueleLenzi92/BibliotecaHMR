<!DOCTYPE html>
<html>

<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-111997111-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-111997111-1');
</script>
	<title>Collection HMR</title>
	

	<script type='text/javascript' src='../../EPICAC/JSwebsite/searchAndSharing.js'></script>
	<script type='text/javascript' src='../../Assets/JS/HMR_CreaHTML.js'></script>
	<!--<script type='text/javascript' src='../EPICAC/JSwebsite/listaRiferimentiNumerata.js'></script>-->
	<link rel="stylesheet" type="text/css" href="../../HMR_Style.css">
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">
	<link rel="icon" type="image/png" href="../../Assets/Images/HMR_2017g_GC-WebFavIcon16x16.png" />
	<meta charset="utf-8">
	
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">
	
	<!--Collection-->
	<?php  
	require ('../../../Config/Biblio_config.php');
	require ('../../Biblio/Assets/PHP/functions_get.php');
	include('../../Administration/Assets/PHP/sessionSet.php');
	include('../../Administration/Assets/PHP/controlLogged.php');
	
	$id= $_GET['idCol'];  
	$order= $_GET['idOrd'];
	?>
	<script  src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> 
	<script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script type='text/javascript' src='../Assets/JS/format_print_biblio2.0.js'></script>
	<script type='text/javascript' src='../Assets/JS/collections.js'></script>
	<!--Collection-->
	
	
		<!--Collection-->
		<?php
		// get id items of that collection 
		if(isset($_SESSION['fileSecretPermission'])){$fileSecretPermission = $_SESSION['fileSecretPermission'];} else {$fileSecretPermission= null;}
		$collection= get_collections($conn, $id);
		$itemsOfCollection= get_collection_by_idCollection($conn, $id, $order,$fileSecretPermission);
		?>
		<script>
		$(document).ready(function(){
			var collection= format_collection(<?php echo json_encode($itemsOfCollection); ?>)
			$("#result").append(collection)
		})
		</script>
		<!--Collection-->
		

		
			<?php
				
				// function for scrolling page at clicked link
				if(isset($_GET['id'])){
					
					echo "<script>
					$(document).ready(function(){ 
						
						//add class highlightedClickedLink to clicked link
						$('#".$_GET['id']."').addClass('highlightedClickedLink')
						
						//scroll to post
						
						$('html, body').animate({
							scrollTop: $('#".$_GET['id']."').offset().top
						}, );
						
						// hide class for clicked link
						$( '#".$_GET['id']."' ).switchClass( 'highlightedClickedLink', '', 2500 );
						
					});
					</script>";
				}
			?>
	
	


	<style>
		.highlightedClickedLink{background-color:rgba(255,0,255,0.3);}
		ol li{margin-top: -8px;}
	</style>
</head>

<body>
	<div class="HMR_Banner">
		<script> creaHeader(3, 'HMR_2017g_GC-WebHeaderRite-270x105-1.png') </script>
	</div>
	
	<div id="HMR_Menu" class="HMR_Menu" >
		<script> creaMenu(3,0) </script>
	</div>
	
	<div class="HMR_Content">
		
		
		<div class= "HMR_Text">
		
		<div id="barBiblioMenu">
			<ul>
				<li><a href="https://www.progettohmr.it/Biblio/biblioAdmin.php">Menù</a></li>
				<li><a href="https://www.progettohmr.it/Biblio/Collections/collection.php">Nuova collezione</a></li>
				<li><a href="https://www.progettohmr.it/Biblio/Collections/managementCollection.php">Gestisci collezioni</a></li>
			<ul>
		</div>
				
			
			<div id="result"></div>
		
		
		</div>
		
		
		
	</div>

	<div class="HMR_Footer">
		<?PHP
		include ('../../EPICAC/APIdb/HMR_EpicacDB.php');
	$queryultimaMod = 'SELECT Biblios FROM lastmod';
	$resultUltimaMod = mysqli_query($db, $queryultimaMod);
	while($row = mysqli_fetch_array($resultUltimaMod)){
		$ultimaMod=  $row['Biblios'];
	}
	
	echo '<div class="HMR_FooterTop">
		<img id="HMR_imgFooter" src="../../Assets/Images/CC_By-Nc-Nd-Eu-80x28.png" alt="">
		<div id="HMR_scrittaFooterUp">Copyright © 2009 - 2018 G.A.Cignoni</div>
		<div id="HMR_scrittaFooterBottom">Pagina creata: 03/21/2009; ultima modifica: '.$ultimaMod.'</div>
	</div>
	<div class="HMR_FooterBottom">
		<div id="HMR_SocialFooter"><a href="https://www.facebook.com/progettoHMR/" target="_blank">Segui HMR su Facebook</a></div>
		<a href="https://www.facebook.com/progettoHMR/" target="_blank"><img id="HMR_SocialFooterFb" src="../../Assets/Images/HMR_2017g_GC-FacebookIcon24x24.png"></a>
		
		<span id="lineaSocial"></span>
		
		<div id="HMR_contatti"><a href="mailto:info@progettohmr.it">Contatti</a> <br/> <a href="../../Persone/">Persone</a></div>
		<div id="HMR_login"><a href="../../Administration/Assets/PHP/autentication.php"><img src="../Assets/Images/HMR_2017g_GC-LoginIcon24x24.png" alt="Login"></a></div>
	</div>';
	?>
	</div>
</body>


</html>