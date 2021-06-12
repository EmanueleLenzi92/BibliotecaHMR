<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_update.php');
require('../PHP/functions_insert.php');

$id= $_POST['idPublModify'];


if (empty($_POST['name'])){ 
	$name = "";
} else $name = mysqli_real_escape_string($conn,$_POST['name']);

if (empty($_POST['type'])){ 
	$type = "";
} else $type = mysqli_real_escape_string($conn,$_POST['type']);


updatePublication($conn, $id, $name, $type);

?>
	
<html>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


	<!--Style-->
	<link rel="stylesheet" href="../../../HMR_Style.css">
	<link rel="stylesheet" href="../CSS/Bibliostyle.css">
	
	<script src="../../../Assets/JS/HMR_CreaHTML.js"></script>	
	<script src="../JS/barMenu.js"></script>	

</head>

<body>

<div class="HMR_Banner">
	<script> creaHeader(3, 'HMR_2017g_GC-WebHeaderRite-270x105-1.png') </script>
</div>
	
<div id="HMR_Menu" class="HMR_Menu" >
	<script> creaMenu(3, 0) </script>
</div>
	

<div class="HMR_Content"><div class= "HMR_Text">

<div id="barBiblioMenu">
	<script> appendBiblioMenu(2, 1) </script>
</div>


<p>Pubblicazione modificata correttamente</p>
<p>Attendi qualche secondo o clicca <a href="../../Manifestation/publications.php">qui</a> per tornare indietro.</p>

     <script>
         setTimeout(function(){
            window.location.href = '../../Manifestation/publications.php';
         }, 3000);
	</script>

	

</div></div> <!--end HMR contents-->

<div class="HMR_Footer">
	<script>
		creaFooter(2, "2014", "2017", "G.A. Cignoni", 
							 "2014/09/23", "2017/10/13 18:15")
	</script> 
</div>

</body>
</html>