<?php
session_start();
if(isset($_SESSION['fileSecretPermission'])){$fileSecretPermission = $_SESSION['fileSecretPermission'];} else {$fileSecretPermission= null;}
//$fileSecretPermission (1: connected people with permission; 0: connected people without permission (students); null: people not connected

if((isset($_SESSION['administratorPermission']) and $_SESSION['administratorPermission']==1) or  (isset($_SESSION['catalogerPermission']) and $_SESSION['catalogerPermission']==1)){
	$addToCollection = 1;
} else {$addToCollection= 0;}

require('../../../../../Config/Biblio_config.php');
require('../../PHP/functions_get.php');


$idWork= $_GET["idWork"];
$idItem= $_GET["idItem"];
$idManif= $_GET["idManif"];


$work= get_object_work_by($conn, $idWork);

$allIdWorks= [$idWork];

$num_expressions= get_numRows_object_expression($conn, $allIdWorks);
$num_manifestations=get_numRows_object_manifestation($conn, $allIdWorks);
$num_items=get_numRows_object_item($conn, $allIdWorks);

$expressions = get_expressions_by_idWork($conn, $idWork);
$manifestations= get_object_manifestations_by($conn, $idWork);
$items= get_object_items_by($conn, $idWork, $fileSecretPermission);





// array json
$arrayJson= array( "work" => $work, "num_works" => 1, "expressions" => $expressions, "num_expressions" => $num_expressions, "manifestations" => $manifestations, "num_manifestations" => $num_manifestations, "items" => $items, "num_items" => $num_items, "addToCollection" => $addToCollection, "idItem" => $idItem , "idManif" => $idManif);		
$data= json_encode($arrayJson);
echo $data; 




?>