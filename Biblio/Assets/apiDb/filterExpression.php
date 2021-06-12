<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_get.php');


if(isset($_GET['idPeople'])){
	$idPeople= $_GET['idPeople'];
	$resposabilityWork= get_work_by_responsability($conn, $idPeople, "people");
} 
if(isset($_GET['idInstitution'])){
	$idInstitut= $_GET['idInstitution'];
	$resposabilityWork= get_work_by_responsability($conn, $idInstitut, "instituction");
} 

if(!isset($_GET['idPeople']) && !isset($_GET['idInstitution'])){
	$resposabilityWork= get_works($conn);

}






// array json
$arrayJson= array( "workByRespons" => $resposabilityWork );		
$data= json_encode($arrayJson);
echo $data;

?>