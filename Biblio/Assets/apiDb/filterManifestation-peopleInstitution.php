<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_get.php');

// For expression
if(isset($_GET['level']) && $_GET['level'] == "Expression"){
	
	$itemByWork= get_items($conn);
	if($_GET['type'] == "People"){
		if(isset($_GET['idPeople'])){
			// get all id people passed from js
			$idPeople= $_GET['idPeople'];
			// get all works from arrey of idPeople
			$resposabilityWork= get_work_by_responsability($conn, $idPeople, "people");
			
			//get for first all expressions by all $idPeople passed with all expressions by $resposabilityWork
			$expressionByWork= get_expressions_by_responsability($conn, $idPeople, "people");
			
			// then merge all expressions by $idInstitut passed with all expressions by $resposabilityWork
			for($i=0; $i < sizeOf($resposabilityWork); $i++){
				
				$expressionByWork= array_merge($expressionByWork, get_expressions_by_idWork($conn, $resposabilityWork[$i]['id']));
				
			}

		} else {
			// if passed 0 people, finds all!
			$resposabilityWork= get_works($conn);
			$expressionByWork= get_expressions($conn);
		
		}
	}
	
	if($_GET['type'] == "Institution"){
		if(isset($_GET['idInstitution'])){
			$idInstitut= $_GET['idInstitution'];
			$resposabilityWork= get_work_by_responsability($conn, $idInstitut, "instituction");
			
			$expressionByWork= get_expressions_by_responsability($conn, $idInstitut, "instituction");
			//$expressionByWork= [];
			for($i=0; $i < sizeOf($resposabilityWork); $i++){
				
				$expressionByWork= array_merge($expressionByWork, get_expressions_by_idWork($conn, $resposabilityWork[$i]['id']));
				
			}
		} else {
			// if passed 0 institutions, finds all!
			$resposabilityWork= get_works($conn);
			$expressionByWork= get_expressions($conn);
		
		} 
	}

} else {


// For item
	if(isset($_GET['level']) && $_GET['level'] == "Item"){
		
		$expressionByWork= get_expressions($conn);


		if($_GET['type'] == "People"){
			if(isset($_GET['idPeople'])){
				// get all id people passed from js
				$idPeople= $_GET['idPeople'];
				// get all works from arrey of idPeople
				$resposabilityWork= get_work_by_responsability($conn, $idPeople, "people");
				
				//get for first all items by all $idPeople passed with all items by $resposabilityWork
				$itemByWork= get_item_by_responsability($conn, $idPeople, "people");
				
				// then merge all items by $idPeople passed with all items by $resposabilityWork
				for($i=0; $i < sizeOf($resposabilityWork); $i++){
					
					$itemByWork= array_merge($itemByWork, get_items_by_idWork($conn, $resposabilityWork[$i]['id']));
					
				}
				
				// get tha manifestation type for each item
				for($i=0; $i < sizeOf($itemByWork); $i++){
					$manifestation= get_manifestations($conn, $itemByWork[$i]['idmanifestation']);
					$itemByWork[$i]['maniType'] = $manifestation[0]["type"];
				}

			} else {
				// if passed 0 people, finds all!
				$resposabilityWork= get_works($conn);
				$itemByWork= get_items($conn);
				// with manifestation type for items
				for($i=0; $i < sizeOf($itemByWork); $i++){
					$manifestation= get_manifestations($conn, $itemByWork[$i]['idmanifestation']);
					$itemByWork[$i]['maniType'] = $manifestation[0]["type"];
				}
				
			}
		}
		
		if($_GET['type'] == "Institution"){
			if(isset($_GET['idInstitution'])){
				// get all id institution  passed from js
				$idInstitut= $_GET['idInstitution'];
				// get all works from arrey of idInstitution
				$resposabilityWork= get_work_by_responsability($conn, $idInstitut, "instituction");

				//get for first all items by all $idInstitut passed			
				$itemByWork= get_item_by_responsability($conn, $idInstitut, "instituction");
				
				// then merge all items by $idInstitut passed with all items by $resposabilityWork
				for($i=0; $i < sizeOf($resposabilityWork); $i++){
					
					$itemByWork= array_merge($itemByWork, get_items_by_idWork($conn, $resposabilityWork[$i]['id']));
					
				}
				
				// get tha manifestation type for each item
				for($i=0; $i < sizeOf($itemByWork); $i++){
					$manifestation= get_manifestations($conn, $itemByWork[$i]['idmanifestation']);
					$itemByWork[$i]['maniType'] = $manifestation[0]["type"];
				}
				
				
			}  else {
				// if passed 0 institutions, finds all!
				$resposabilityWork= get_works($conn);
				$itemByWork= get_items($conn);
				// get tha manifestation type for each item
				for($i=0; $i < sizeOf($itemByWork); $i++){
					$manifestation= get_manifestations($conn, $itemByWork[$i]['idmanifestation']);
					$itemByWork[$i]['maniType'] = $manifestation[0]["type"];
				}
				
			}

		}
	}
}


// array json
$arrayJson= array( "workByRespons" => $resposabilityWork, "expressionsByWorks" =>  $expressionByWork, "itemsByWork" => $itemByWork);		
$data= json_encode($arrayJson);
echo $data;

?>