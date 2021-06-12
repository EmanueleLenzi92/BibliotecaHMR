<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_insert.php');
require('../PHP/functions_get.php');
require('../PHP/functions_update.php');


// get id item to modify
$id= $_POST['idItemModify'];

//generic data
$findIdManifestation= explode('-', $_POST ['manifestationItem']);
$idManifestation = $findIdManifestation[0];
$idWork= $findIdManifestation[1];
$extLink= $_POST['extLink'];
$note= mysqli_real_escape_string($conn,$_POST['note']);
$monthvisited= $_POST['month'];
$yearvisited= $_POST['year'];
$dayvisited= $_POST['day'];

// get title
$manifestation= get_manifestations($conn, $idManifestation);
$title = mysqli_real_escape_string($conn, $manifestation[0]["title"]);
$year= mysqli_real_escape_string($conn, $manifestation[0]["year"]);

$capability= $_POST['capability'];


// upload file
if (file_exists($_FILES['localFile']['tmp_name']) || is_uploaded_file($_FILES['localFile']['tmp_name'])){
	$path= "../../" . $year;
	
	if (!file_exists($path)) {
		mkdir($path, 0777, true);
	}
	
	$urlFile= $year . "/" . $_FILES['localFile']['name'];
	
	move_uploaded_file($_FILES['localFile']['tmp_name'], $path . "/" . $_FILES['localFile']['name']);
	//echo 'Received file' . $_FILES['localFile']['name'];

	$nameFile= $_FILES['localFile']['name'];
} else {
	
	// get old url and namefile if don't upload a new file (can be empty string)
	$nameFile = $_POST['filename'];
	$urlFile= $_POST['fileurl'];
	
}



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



updateItem($conn, $id, $idWork, $title, $urlFile, $nameFile, $capability, $extLink, $idManifestation, $note, $dayvisited, $monthvisited, $yearvisited, $idPeople, $idRespPeople, $idInstitut, $idRespInstit);
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


<p>Esemplare modificato correttamente</p>
<p>Attendi qualche secondo o clicca <a href="../../Item/">qui</a> per tornare indietro.</p>
     <script>
         setTimeout(function(){
            window.location.href = '../../Item/';
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