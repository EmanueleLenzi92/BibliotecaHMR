<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_get.php');


	
	if($_GET['type'] == "People"){
		if(isset($_GET['idPeople'])){
			// get all id people passed from js
			$idPeople= $_GET['idPeople'];
			// get all works from arrey of idPeople
			$resposabilityWork= get_work_by_responsability($conn, $idPeople, "people");
			
			//get for first all expressions by all $idPeople passed with all expressions by $resposabilityWork
			$manifByWork= get_manifestations_by_responsability($conn, $idPeople, "people");
			
			// then merge all expressions by $idInstitut passed with all expressions by $resposabilityWork
			for($i=0; $i < sizeOf($resposabilityWork); $i++){
				
				$manifByWork= array_merge($manifByWork, get_manifestations_by_idWork($conn, $resposabilityWork[$i]['id']));
				
			}

		} else {
			// if passed 0 people, finds all!
			$resposabilityWork= get_works($conn);
			$manifByWork= get_manifestations($conn);
		
		}
	}
	
	if($_GET['type'] == "Institution"){
		if(isset($_GET['idInstitution'])){
			$idInstitut= $_GET['idInstitution'];
			$resposabilityWork= get_work_by_responsability($conn, $idInstitut, "instituction");
			
			$manifByWork= get_manifestations_by_responsability($conn, $idInstitut, "instituction");
			for($i=0; $i < sizeOf($resposabilityWork); $i++){
				
				$manifByWork= array_merge($manifByWork, get_manifestations_by_idWork($conn, $resposabilityWork[$i]['id']));
				
			}
		} else {
			// if passed 0 institutions, finds all!
			$resposabilityWork= get_works($conn);
			$manifByWork= get_manifestations($conn);
		
		} 
	}

 


// array json
$arrayJson= array( "workByRespons" => $resposabilityWork, "manifestationsByWorks" =>  $manifByWork);		
$data= json_encode($arrayJson);
echo $data;

?>