<?php

require('../../../../Config/Biblio_config.php');
require('../PHP/functions_insert.php');


$level= mysqli_real_escape_string($conn,$_POST['level']);
$name= mysqli_real_escape_string($conn,$_POST['name']);

if ($level == "work"){
	$directory= "Work";
}
if ($level == "expression"){
	$directory= "Expression";
}
if ($level == "manifestation"){
	$directory= "Manifestation";
}
if ($level == "item"){
	$directory= "Item";
}



insertResponsabilityType($conn, $name, $level);

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


<p>Responsabilità inserita correttamente</p>
<p>Attendi qualche secondo o clicca <a href="../../<?php echo $directory; ?>/">qui</a> per tornare indietro.</p>

     <script>
         setTimeout(function(){
            window.location.href = "../../<?php echo $directory; ?>/";
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