<?php
session_start();
if(isset($_SESSION['fileSecretPermission'])){$fileSecretPermission = $_SESSION['fileSecretPermission'];} else {$fileSecretPermission= null;}
//$fileSecretPermission (1: connected people with permission; 0: connected people without permission (students); null: people not connected

require('../../../../Config/Biblio_config.php');
require('../PHP/functions_get.php');


if(isset($_GET['idPeople'])){
	$idPeople= $_GET['idPeople'];
} 
if(isset($_GET['idInstitution'])){
	$idInstitut= $_GET['idInstitution'];
} 

if(isset($_GET['idPeopleResponsability'])){
	$idPeopleResponsability= $_GET['idPeopleResponsability'];
} 
if(isset($_GET['idInstitutionResponsability'])){
	$idInstitutionResponsability= $_GET['idInstitutionResponsability'];
} 

if(isset($_GET['title'])){
	$title= $_GET['title'];
} 

if(isset($_GET['manifestationType'])){
	$manifestationType= $_GET['manifestationType'];
} 

if(isset($_GET['year'])){
	$year= $_GET['year'];
} 

if(isset($_GET['yearS'])){
	$yearS= $_GET['yearS'];
} 

if(isset($_GET['yearE'])){
	$yearE= $_GET['yearE'];
} 

if(isset($_GET['estremicompresi'])){
	$estremicompresi= $_GET['estremicompresi'];
} 


$items= get_object_by($conn, $fileSecretPermission, $idPeople, $idInstitut, $idPeopleResponsability, $idInstitutionResponsability, $title, $manifestationType, $year, $yearS, $yearE, $estremicompresi);



// array json
$arrayJson= array( "items" => $items );		
$data= json_encode($arrayJson);
echo $data;


// array json
//$arrayJson= array( "idPeople" => $idPeople,  "idInstitut" => $idInstitut, "idPeopleResponsability" => $idPeopleResponsability ,"idInstitutionResponsability" => $idInstitutionResponsability);		
//$data= json_encode($arrayJson);
//echo $data;

?>