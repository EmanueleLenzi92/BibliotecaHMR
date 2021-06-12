<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_insert.php');



if (empty($_POST['name'])){ 
	$name = "";
} else $name = mysqli_real_escape_string($conn,$_POST['name']);

if (empty($_POST['surname'])){ 
	$surname = "";
} else $surname = mysqli_real_escape_string($conn,$_POST['surname']);

if (empty($_POST['brief'])){ 
	$brief = "";
} else $brief = mysqli_real_escape_string($conn,$_POST['brief']);

if (empty($_POST['pseudonymOf'])){ 
	$pseudonymOf = "";
} else $pseudonymOf = $_POST['pseudonymOf'];


insertPeople($conn, $name, $surname, $brief, $pseudonymOf);

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


<p>Persona inserita correttamente</p>
<p>Attendi qualche secondo o clicca <a href="../../Responsability/people.php">qui</a> per tornare indietro.</p>

     <script>
         setTimeout(function(){
            window.location.href = '../../Responsability/people.php';
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