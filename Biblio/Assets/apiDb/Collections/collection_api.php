<?php
session_start();
if(isset($_SESSION['fileSecretPermission'])){$fileSecretPermission = $_SESSION['fileSecretPermission'];} else {$fileSecretPermission= null;}
//$fileSecretPermission (1: connected people with permission; 0: connected people without permission (students); null: people not connected


require('../../../../../Config/Biblio_config.php');
require('../../PHP/functions_get.php');

$manifItem = $_GET['manifItem'];
$id= $_GET['id'];
if($manifItem == "m"){

$object= get_object_manifestations_by_idManifestation($conn, $id);

} else {$object= get_object_items_by_idItem($conn, $id, $fileSecretPermission);}


// array json
$arrayJson= array( "objectInCollection" => $object,  "manifItem" => $manifItem);		
$data= json_encode($arrayJson);
echo $data; 




?>