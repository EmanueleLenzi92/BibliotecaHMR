<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_update.php');
require('../PHP/functions_get.php');

// get id work to modify
$id= $_POST['idExprModify'];


//generic data
$findIdWork= explode('-', $_POST ['expressionWorks']);
$idWork = $findIdWork[0];
$type = $_POST ['expressionType'];

// get title of expression; if is empty, get title of work
if(empty($_POST['expressionTitle'])){
	$work= get_works($conn, $idWork);
	$title = mysqli_real_escape_string($conn, $work[0]["title"]);
} else $title = mysqli_real_escape_string($conn, $_POST ['expressionTitle']);


//responsability data
if (empty($_POST['inputIdPeople'])){ 
	$idPeople = "";
} else $idPeople = $_POST['inputIdPeople'];

if (empty($_POST['inputIdPeopleResponsability'])){ 
	$idRespPeople = "";
} else $idRespPeople = $_POST['inputIdPeopleResponsability'];

if (empty($_POST['inputIdInstitution'])){ 
	$idInstitut = "";
} else $idInstitut = $_POST['inputIdInstitution'];

if (empty($_POST['inputIdInstitutionResponsability'])){ 
	$idRespInstit = "";
} else $idRespInstit = $_POST['inputIdInstitutionResponsability'];



updateExpression($conn, $id, $idWork, $title, $type, $idPeople, $idRespPeople, $idInstitut, $idRespInstit);

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


<p>Espressione modificata correttamente</p>
<p>Attendi qualche secondo o clicca <a href="../../Expression/">qui</a> per tornare indietro.</p>

     <script>
         setTimeout(function(){
            window.location.href = '../../Expression/';
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
