<?php
include('../../../../Administration/Assets/PHP/sessionSet.php');

require('../../../../../Config/Biblio_config.php');
require('../../PHP/functions_insert.php');


$title= mysqli_real_escape_string($conn, $_POST['title']); 

$brief= mysqli_real_escape_string($conn, $_POST['brief']);

$ordering= mysqli_real_escape_string($conn, $_POST['ordering']);



insertCollection($conn, $title, $brief, $ordering, $userId);
?>

<html>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


	<!--Style-->
	<link rel="stylesheet" href="../../../../HMR_Style.css">
	<link rel="stylesheet" href="../../CSS/Bibliostyle.css">
	
	
	<script src="../../../../Assets/JS/HMR_CreaHTML.js"></script>	
	<script src="../../JS/barMenu.js"></script>		

</head>

<body>

<div class="HMR_Banner">
	<script> creaHeader(4, 'HMR_2017g_GC-WebHeaderRite-270x105-1.png') </script>
</div>
	
<div id="HMR_Menu" class="HMR_Menu" >
	<script> creaMenu(4, 0) </script>
</div>
	

<div class="HMR_Content"><div class= "HMR_Text">

<div id="barBiblioMenu">
	<script> appendBiblioMenu(3, 1) </script>
</div>

<p>Collezione creata correttamente</p>
<p>Attendi qualche secondo o clicca <a href="../../../Collections/managementCollection.php">qui</a> per vedere le collezioni.</p>

     <script>
         setTimeout(function(){
            window.location.href = '../../../Collections/managementCollection.php';
         }, 3000);
	</script>

	

</div></div> <!--end HMR contents-->

<div class="HMR_Footer">
	<script>
		creaFooter(3, "2014", "2017", "G.A. Cignoni", 
							 "2014/09/23", "2017/10/13 18:15")
	</script> 
</div>

</body>
</html>