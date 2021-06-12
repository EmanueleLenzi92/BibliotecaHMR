<?php
session_start();
if(isset($_SESSION['fileSecretPermission'])){$fileSecretPermission = $_SESSION['fileSecretPermission'];} else {$fileSecretPermission= null;}
//$fileSecretPermission (1: connected people with permission; 0: connected people without permission (students); null: people not connected

if((isset($_SESSION['administratorPermission']) and $_SESSION['administratorPermission']==1) or  (isset($_SESSION['catalogerPermission']) and $_SESSION['catalogerPermission']==1)){
	$addToCollection = 1;
} else {$addToCollection= 0;}



require('../../../../../Config/Biblio_config.php');
require('../../PHP/functions_get.php');


if(isset($_GET['idPeople'])){
	$idPeople= $_GET['idPeople'];
}else {$idPeople=[];}
if(isset($_GET['idInstitution'])){
	$idInstitut= $_GET['idInstitution'];
}  else {$idInstitut=[];}

if(isset($_GET['idPeopleResponsability'])){
	$idPeopleResponsability= $_GET['idPeopleResponsability'];
} else {$idPeopleResponsability=[];}
if(isset($_GET['idInstitutionResponsability'])){
	$idInstitutionResponsability= $_GET['idInstitutionResponsability'];
} else {$idInstitutionResponsability=[];}

if(isset($_GET['title'])){
	$title= mysqli_real_escape_string($conn, $_GET['title']);
} 

if(isset($_GET['yearS'])){
	$yearS= $_GET['yearS'];
} 

if(isset($_GET['yearE'])){
	$yearE= $_GET['yearE'];
}

if(isset($_GET['pageNumbers'])){
	$pageNumbers= (explode("-",$_GET['pageNumbers']));   
} else $pageNumbers=[0,25];

// get all works from input search and all the idWorks (for compute total result of express,manif, and items)
$works= search_work_from_inputs ($conn, $idPeople, $idInstitut, $idPeopleResponsability, $idInstitutionResponsability, $title, $yearS, $yearE);
$allIdWorks= array_column($works, 'idwork');

$num_works= sizeOf($works);
$expressions=[];
$num_expressions= get_numRows_object_expression($conn, $allIdWorks);
$manifestations=[];
$num_manifestations=get_numRows_object_manifestation($conn, $allIdWorks);
$items=[];
$num_items=get_numRows_object_item($conn, $allIdWorks);

//$worksSliced= array_slice($works, $pageNumbers[0], $pageNumbers[1]);

// iter works from $pageNumbers[0] to $pageNumbers[1] or to the end of the array 
if($num_works < $pageNumbers[1]){
	$scorri= $num_works;
} else {$scorri= $pageNumbers[1];}
					

// get expr, manif, item from works serched before
for($i=$pageNumbers[0]; $i<$scorri; $i++){
	$expressions[$i] = get_expressions_by_idWork($conn, $works[$i]['idwork']);
	
	$manifestations[$i]= get_object_manifestations_by($conn, $works[$i]['idwork']);
	
	$items[$i]= get_object_items_by($conn, $works[$i]['idwork'], $fileSecretPermission);

}



// array json
$arrayJson= array( "works" => $works, "num_works" => $num_works, "expressions" => $expressions, "num_expressions" => $num_expressions, "manifestations" => $manifestations, "num_manifestations" => $num_manifestations, "items" => $items, "num_items" => $num_items, "pageNumbers" => $pageNumbers, "addToCollection" => $addToCollection );		
$data= json_encode($arrayJson);
echo $data; 




?>