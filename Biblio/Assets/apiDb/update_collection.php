<?php
require('../connect.php');
require('../PHP/functions_update.php');


if(!empty($_POST['idItems'])){

	$idItems= $_POST['idItems'];

} else $idItems="";

$idcollection= $_POST['idCollection'];

$title= $_POST['title'];

$brief= $_POST['brief'];

$ordering= $_POST['ordering'];

updateCollection($conn, $idcollection, $title, $brief, $ordering, $idItems);
?>

<p>Collezione inserita</p>


     <script>
         setTimeout(function(){
            window.location.href = '../Collections/collectionsManagement.php';
         }, 4000);
	</script>