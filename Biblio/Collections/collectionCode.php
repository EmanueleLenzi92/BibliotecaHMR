<?php
$id= $_GET['id'];
$ord= $_GET['ord'];


echo "<body>";
echo "<small>Copia e incolla il codice nella pagina PHP di Template delle collezioni situata in <i>public_html/Asstes/Templates</i> sotto 
	il commento <i>INSERT CODE HERE</i>. La pagina della collezione deve stare in una cartella dedicata.</small></br></br>";
echo '
&lt;?php </br>
	// get id items of that collection </br>
	$itemsOfCollection= get_collection_by_idCollection($conn, '.$_GET['id'].' , '.$_GET['ord'].' ,$fileSecretPermission); </br>
?&gt; </br>
&lt;script&gt; </br>
	$(document).ready(function(){ </br>
		var collection= format_collection(&lt;?php echo json_encode($itemsOfCollection); ?&gt;) </br>
		$("#result").append(collection) </br>
	}) </br>
&lt;/script&gt; </br>
';
echo "</body>";

?>




