<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_get.php');



$idWork= $_GET['idWork'];

// for expression: If passed ids, search all expressions by ids. If id is empry, search all expressions
if($_GET['level'] == "Expression"){
	
	if (!empty($idWork)){
		
		$result= get_expressions_by_idWork($conn, $idWork);
	
	} else $result= get_expressions($conn);

} else {
	
	//for item
	if ($_GET['level'] == "Item"){
	
		if (!empty($idWork)){
		
			$result= get_items_by_idWork($conn, $idWork);
			// get tha manifestation type for each item
			for($i=0; $i < sizeOf($result); $i++){
				$manifestation= get_manifestations($conn, $result[$i]['idmanifestation']);
				$result[$i]['maniType'] = $manifestation[0]["type"];
			}
		
		} else {
			$result= get_items($conn);
			// get tha manifestation type for each item
			for($i=0; $i < sizeOf($result); $i++){
				$manifestation= get_manifestations($conn, $result[$i]['idmanifestation']);
				$result[$i]['maniType'] = $manifestation[0]["type"];
			}
		}
	
	}


	

}



// array json
$arrayJson= array( "ExpressionItem" => $result, "level" =>  $_GET['level']);		
$data= json_encode($arrayJson);
echo $data;

?>