<!DOCTYPE html>

<html>
<?php 
include('../../Administration/Assets/PHP/sessionSet.php');
include('../../Administration/Assets/PHP/controlLogged.php');

if($catalogerPermission == 0 ) {
	header('Location: https://www.progettohmr.it/Administration/Assets/PHP/autentication.php');
}

require ('../../../Config/Biblio_config.php');
require ('../Assets/PHP/functions_get.php');


$level= $_GET['level'];


if($level== "work"){
	
	// get works with responsability concat
	$result= get_works($conn);
	for( $i=0; $i < sizeOF($result); $i++ ){
		
		$responsability= get_responsabilityWork($conn, $result[$i]["id"], $oneRow=true);
					
		$result[$i]["peopl/inst"] =  $responsability[0]['persBrief'] . $responsability[0]['istitutEspr'];
	
	}
	
	// write page to send data
	$sendTopage= "../Work/";
	
	// for trees
	$levelString= "work";
	
	// for delete
	$linkdelete = "../Assets/apiDb/delete_work.php";

} else if($level== "expression"){
	
	$result= get_expressions($conn);
	for( $i=0; $i < sizeOF($result); $i++ ){
		
		$responsability= get_responsabilityExpression($conn, $result[$i]["id"], $oneRow=true);
					
		$result[$i]["peopl/inst"] =  $responsability[0]['persBrief'] . $responsability[0]['istitutEspr'];
	
	}
	
	$sendTopage= "../Expression/";
	
	// for trees
	$levelString= "manifestationExpression";
	
	// for delete
	$linkdelete = "../Assets/apiDb/delete_expression.php";


} else if($level== "manifestation"){

	$result= get_manifestations($conn);
	for( $i=0; $i < sizeOF($result); $i++ ){
		
		$responsability= get_responsabilityManifestation($conn, $result[$i]["id"], $oneRow=true);
					
		$result[$i]["peopl/inst"] =  $responsability[0]['persBrief'] . $responsability[0]['istitutEspr'];
	
	}
	
	$sendTopage= "../Manifestation/";
	
	// for trees
	$levelString= "manifestationItem";
	
	// for delete
	$linkdelete = "../Assets/apiDb/delete_manifestation.php";


} else if($level== "item"){
	
	$result= get_items($conn);
	for( $i=0; $i < sizeOF($result); $i++ ){
		
		//get manifestation type too of each item
		$manif= get_manifestations($conn, $result[$i]["idmanifestation"]);
		$manifestationType = $manif[0]["type"];
		
		$responsability= get_responsabilityitem($conn, $result[$i]["id"], $oneRow=true);
		
		
		$result[$i]["peopl/inst"] =  $responsability[0]['persBrief'] . $responsability[0]['istitutEspr'];
		$result[$i]["type"]= $manif[0]["type"];
	
	}
	
	$sendTopage= "../Item/";

	// for trees
	$levelString= "manifestationItem";	
	
	// for delete
	$linkdelete = "../Assets/apiDb/delete_item.php";
	
}


?>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- datatable -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function () {
		//define datatable
		$('table').dataTable(
			{
			"pageLength": 25,
			"order": [[ 0, "desc" ]]
			}
		);
    
		
		// open popup trees (for seconds pages of datatable too)
		$('#table_id tbody').on('click', '.seeCatalogCard', function () {
				
			var url= $(this).attr('id')
			window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
		
		});

	});
	</script>
	
	<!--Style-->
	<link rel="stylesheet" href="../../HMR_Style.css">
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">
	
	<script src="../../Assets/JS/HMR_CreaHTML.js"></script>
	<script src="../Assets/JS/barMenu.js"></script>	
	
	<!-- Add icon library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	


</head>

<body>

<div class="HMR_Banner">
	<script> creaHeader(3, 'HMR_2017g_GC-WebHeaderRite-270x105-1.png') </script>
</div>
	
<div id="HMR_Menu" class="HMR_Menu" >
	<script> creaMenu(3, 0) </script>
</div>
	

<div class="HMR_Content"><div class= "HMR_Text">

		<div id="barBiblioMenu">
			<script> appendBiblioMenu(1, 1) </script>
		</div>

		<table id="table_id" class="display" cellspacing="0" width="100%">
			<thead>
				<th>ID</th>
				<th>Responsabilità</th>
				<th>Titolo</th>
				<?php if($sendTopage== "../Expression/" or $sendTopage== "../Manifestation/" or $sendTopage== "../Item/") echo "<th>Tipo</th>";  ?>
			
				<th></th>
			</thead>
			<tbody>
				<?php
					
					for($i=0; $i<sizeOf($result); $i++){
						
						echo "<tr>";
						echo "<form method='get' action='".$sendTopage."'>";
						echo "<input type='hidden' name='idModify' value='".$result[$i]['id']."'>";
						echo "<td >".$result[$i]['id']."</td>";
						echo "<td >".$result[$i]['peopl/inst']."</td>";
						echo "<td>".$result[$i]['title']."</td>";
						//type name for expressions
						if($sendTopage== "../Expression/") echo "<td>".$result[$i]['typeName']."</td>";
						//type name for manifestation
						if($sendTopage== "../Manifestation/" or $sendTopage== "../Item/") echo "<td>".$result[$i]['type']."</td>";

						echo "<td valign='center'>";
						
						echo "<form method='get' action='".$sendTopage."'>";
						echo "<input type='hidden' name='idModify' value='".$result[$i]['id']."'>";
						echo "<button type='submit'><i class='fa fa-pencil'></i></button>";
						echo "</form>";
						
						// for id/idwork printing (button eye)
						if($sendTopage== "../Work/"){	
							echo "<button type='button' id='../catalogCard.php?idWork=".$result[$i]['id']."&idlevel=".$result[$i]['id']."&levelName=$levelString' class='seeCatalogCard btn'><i class='fa fa-eye'></i></button>";
						} else {echo "<button type='button' id='../catalogCard.php?idWork=".$result[$i]['idwork']."&idlevel=".$result[$i]['id']."&levelName=$levelString' class='seeCatalogCard btn'><i class='fa fa-eye'></i></button>";}
						
						echo "<form method='post' action='".$linkdelete."'>";
						echo 	"<input type='hidden' name='id' value='".$result[$i]['id']."'>";
						echo 	"<button onclick='return confirm(&#39;Vuoi eliminare ".$result[$i]['title']."&#39;)' type='submit'><i class='fa fa-trash'></i></button>";
						echo "</form>";
						
						echo "</td>";
						echo "</tr>";

						
					
					}
					
				?>
			</tbody>
		</table>
		
</div></div> <!--end HMR contents-->

<div class="HMR_Footer">
	<script>
		creaFooter(2, "2014", "2017", "G.A. Cignoni", 
							 "2014/09/23", "2017/10/13 18:15")
	</script> 
</div>


</body>





</html>