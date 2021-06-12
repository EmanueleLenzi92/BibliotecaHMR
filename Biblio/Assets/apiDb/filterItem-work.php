<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_get.php');



$idWork= $_GET['idWork'];

	
if (!empty($idWork)){
		
	$result= get_manifestations_by_idWork($conn, $idWork);
	
} else $result= get_manifestations($conn);





// array json
$arrayJson= array( "manifestations" => $result);		
$data= json_encode($arrayJson);
echo $data;

?>