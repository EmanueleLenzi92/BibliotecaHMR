<?php
ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");
error_log( date("l jS \of F Y h:i:s A") . PHP_EOL, 3, "php-error.log" );
error_log( "INIZIO" . PHP_EOL, 3, "php-error.log" );

include('../../../Administration/Assets/PHP/sessionSet.php');

require('../../../../Config/Biblio_config.php');
require('../PHP/functions_insert.php');
require('../PHP/functions_get.php');

//generic data
if(isset($_POST['manifestationExpression'])){
	$findIdExp= explode('-', $_POST ['manifestationExpression']);
	$idExpression = $findIdExp[0];
} else $idExpression= "";


if(isset($_POST['manifestationItem'])){
	$findIdItem= explode('-', $_POST ['manifestationItem']);
	$idItem= $findIdItem[0];
} else $idItem= "";

$form= $_POST['digitalOrNot'];


$type = mysqli_real_escape_string($conn, $_POST['manifestationType']);
$fisicalTypeForCopy = mysqli_real_escape_string($conn, $_POST['manifestationType']);

error_log( "Tipo di manifestazione (id) $type\n" . PHP_EOL, 3, "php-error.log" );
	
// get title
if ($idExpression != ""){
	
	$expression= get_expressions($conn, $idExpression);
	$idWork= $findIdExp[1];
	$title = mysqli_real_escape_string($conn, $expression[0]["title"]);


} else if ($idItem != ""){

	$item= get_items($conn, $idItem);
	$title = mysqli_real_escape_string($conn, $item[0]["title"]);
	$idWork= $findIdItem[1];
	
}

error_log( "$title\n" . PHP_EOL, 3, "php-error.log" );



//publications data
if(isset($_POST['field1'])){
	$field1= mysqli_real_escape_string($conn, $_POST['field1']);
} else $field1= "";

if(isset($_POST['field2'])){
	$field2= mysqli_real_escape_string($conn, $_POST['field2']);
} else $field2= "";

if(isset($_POST['field3'])){
	$field3= mysqli_real_escape_string($conn, $_POST['field3']);
} else $field3= "";

if(isset($_POST['field4'])){
	$field4= mysqli_real_escape_string($conn, $_POST['field4']);
} else $field4= "";

if(isset($_POST['field5'])){
	$field5= mysqli_real_escape_string($conn, $_POST['field5']);
} else $field5= "";

if(isset($_POST['field9'])){
	$field9= mysqli_real_escape_string($conn, $_POST['field9']);
} else $field9= "";

if(isset($_POST['field10'])){
	$field10= mysqli_real_escape_string($conn, $_POST['field10']);
} else $field10= "";

error_log( "valore field1 $field1\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field2 $field2\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field3 $field3\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field4 $field4\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field5 $field5\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field9 $field9\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field10 $field10\n" . PHP_EOL, 3, "php-error.log" );

// libro
if(isset($_POST['field6'])){
	$field6= $_POST['field6'];
} else $field6= "";
// collana
if(isset($_POST['field7'])){
	$field7= $_POST['field7'];
} else $field7= "";
// rivista, atto
if(isset($_POST['field8'])){
	$field8= $_POST['field8'];
} else $field8= "";

error_log( "valore field6(libro) $field6\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field7(collana) $field7\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore field8(attojourn) $field8\n" . PHP_EOL, 3, "php-error.log" );

if(isset($_POST['day'])){
	$day= $_POST['day'];
} else $day= 0;
if(isset($_POST['month'])){
	$month= $_POST['month'];
} else $month= 0;
if(isset($_POST['year'])){
	$year= $_POST['year'];
} else $year= 0;

error_log( "valore day $day\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore month $month\n" . PHP_EOL, 3, "php-error.log" );
error_log( "valore year $year\n" . PHP_EOL, 3, "php-error.log" );

if(isset($_POST['daystart'])){
	$dayStart= $_POST['daystart'];
} else $dayStart= 0;
if(isset($_POST['monthstart'])){
	$monthStart= $_POST['monthstart'];
} else $monthStart= 0;
if(isset($_POST['yearstart'])){
	$yearStart= $_POST['yearstart'];
} else $yearStart= 0;

if(isset($_POST['dayend'])){
	$dayEnd= $_POST['dayend'];
} else $dayEnd= 0;
if(isset($_POST['monthend'])){
	$monthEnd= $_POST['monthend'];
} else $monthEnd= 0;
if(isset($_POST['yearend'])){
	$yearEnd= $_POST['yearend'];
} else $yearEnd= 0;

if(isset($_POST['dayscan'])){
	$dayScan= $_POST['dayscan'];
} else $dayScan= 0;
if(isset($_POST['monthscan'])){
	$monthScan= $_POST['monthscan'];
} else $monthScan= 0;
if(isset($_POST['yearscan'])){
	$yearScan= $_POST['yearscan'];
} else $yearScan= 0;


// get fisic manifestation field if is a copy
if($type == 17){
	$sql3= "SELECT idmanifestation FROM item WHERE id = " . $idItem;
	$result3 = mysqli_query($conn, $sql3);
			
	while($row3 = mysqli_fetch_assoc($result3)) {
				
		$idManifFisica = $row3['idmanifestation'];
				
	}
		
	$sql4= "select m.id, m.idwork, m.title, m.idexpression, m.iditem, journalActs.name as journalActs, serie.name as serie, book.name as book, descriptionlevel.name as type, m.type as idType, m.form as idForm, descriptionlevelmanifestation.name as formName,
		manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field6,
		manifestationfield.field7, manifestationfield.field8, manifestationfield.field9, manifestationfield.field10, manifestationfield.day, manifestationfield.month, manifestationfield.year, manifestationfield.daystart, manifestationfield.monthstart, manifestationfield.yearstart, manifestationfield.dayend, manifestationfield.monthend, manifestationfield.yearend
		from manifestation as m
		LEFT JOIN manifestationfield ON m.id = manifestationfield.idmanifestation
		LEFT JOIN descriptionlevel ON descriptionlevel.id = m.type
		LEFT JOIN descriptionlevelmanifestation ON descriptionlevelmanifestation.id = m.form
		LEFT JOIN publications journalActs ON journalActs.id = manifestationfield.field8 
		LEFT JOIN publications serie ON serie.id = manifestationfield.field7
		LEFT JOIN publications book ON book.id = manifestationfield.field6 where m.id= " . $idManifFisica;	
	$result4= mysqli_query($conn, $sql4);
	
	
	$allmanifestations=[];
	$manifestation=[];		

	while($row4 = mysqli_fetch_assoc($result4)) {


		$manifestation ['idType']  = $row4["idType"];
		$manifestation ['field1'] = $row4["field1"];
		$manifestation ['field2'] = $row4["field2"];
		$manifestation ['field3']  = $row4["field3"];
		$manifestation ['field4']  = $row4["field4"];
		$manifestation ['field5']  = $row4["field5"];
		$manifestation ['field6']  = $row4["field6"];
		$manifestation ['field7']  = $row4["field7"];
		$manifestation ['field8']  = $row4["field8"];
		$manifestation ['field9']  = $row4["field9"];
		$manifestation ['field10']  = $row4["field10"];
			

		$manifestation ['daystart']  = $row4["daystart"];
		$manifestation ['monthstart']  = $row4["monthstart"];
		$manifestation ['yearstart']  = $row4["yearstart"];
		$manifestation ['dayend']  = $row4["dayend"];
		$manifestation ['monthend']  = $row4["monthend"];
		$manifestation ['yearend']  = $row4["yearend"];

		array_push($allmanifestations, $manifestation);
			
	}
	
		$fisicalTypeForCopy  = $allmanifestations[0]['idType'];
		$field1 = htmlspecialchars($allmanifestations[0]['field1'], ENT_QUOTES);
		$field2  = htmlspecialchars($allmanifestations[0]['field2'], ENT_QUOTES);
		$field3  = htmlspecialchars($allmanifestations[0]['field3'], ENT_QUOTES);
		$field4  = htmlspecialchars($allmanifestations[0]['field4'], ENT_QUOTES);
		$field5  = htmlspecialchars($allmanifestations[0]['field5'], ENT_QUOTES);
		$field6  = htmlspecialchars($allmanifestations[0]['field6'], ENT_QUOTES);
		$field7  = htmlspecialchars($allmanifestations[0]['field7'], ENT_QUOTES);
		$field8  = htmlspecialchars($allmanifestations[0]['field8'], ENT_QUOTES);
		$field9  = htmlspecialchars($allmanifestations[0]['field9'], ENT_QUOTES);
		$field10  = htmlspecialchars($allmanifestations[0]['field10'], ENT_QUOTES);
		
		$field1 = mysqli_real_escape_string($conn, $field1);
		$field2  = mysqli_real_escape_string($conn, $field2);
		$field3  = mysqli_real_escape_string($conn, $field3);
		$field4  = mysqli_real_escape_string($conn, $field4);
		$field5  = mysqli_real_escape_string($conn, $field5);
		$field6  = mysqli_real_escape_string($conn, $field6);
		$field7  = mysqli_real_escape_string($conn, $field7);
		$field8  = mysqli_real_escape_string($conn, $field8);
		$field9  = mysqli_real_escape_string($conn, $field9);
		$field10  = mysqli_real_escape_string($conn, $field10);
			

		$dayStart  = $allmanifestations[0]['daystart'];
		$monthStart  = $allmanifestations[0]['monthstart'];
		$yearStart  = $allmanifestations[0]['yearstart'];
		$dayEnd  = $allmanifestations[0]['dayend'];
		$monthEnd  = $allmanifestations[0]['monthend'];
		$yearEnd  = $allmanifestations[0]['yearend'];

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

error_log( "Adesso parte la funzione per inserire\n" . PHP_EOL, 3, "php-error.log" );

insertManifestation($conn, $userId, $idWork, $idExpression, $title, $form, $idItem, $type, $fisicalTypeForCopy, $field1, $field2, $field3, $field4, $field5, $field6, $field7, $field8, $field9, $field10, $day, $month, $year, $dayStart, $monthStart, $yearStart, $dayEnd, $monthEnd, $yearEnd, $dayScan, $monthScan, $yearScan, $idPeople, $idRespPeople, $idInstitut, $idRespInstit);

error_log( "Funzione finita. manifestazione inserita\n" . PHP_EOL, 3, "php-error.log" );

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


<p>Manifestazione inserita correttamente</p>
<p>Attendi qualche secondo o clicca <a href="../../Manifestation/">qui</a> per tornare indietro.</p>
     <script>
         setTimeout(function(){
            window.location.href = '../../Manifestation/';
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