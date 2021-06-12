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



$collections = get_collections($conn);


?>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<!-- datatable -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function () {
        $('#table_id').dataTable(
			{
			"pageLength": 10,
			"order": [[ 0, "desc" ]]
			}
		);
    
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
	<ul>
		<li><a href="https://www.progettohmr.it/Biblio/biblioAdmin.php">Menù</a></li>
		<li><a href="https://www.progettohmr.it/Biblio/Collections/collection.php">Nuova collezione</a></li>
		<li><a href="https://www.progettohmr.it/Biblio/Collections/managementCollection.php">Gestisci collezioni</a></li>
	<ul>
</div>
	
	<?php

	if(isset($_GET['level']) && isset($_GET['id'])){
	 echo "<h2>Scegli la collezione in cui inserire il tuo riferimento selezionato</h2>";
	} else  echo "<h2>Gestisci collezione</h2>";
	
	?>
	
	<table id="table_id" class="display" cellspacing="0" width="100%">
			<thead>
				<th>ID</th>
				<th>Titolo</th>
				<th>Titolo breve</th>	
				<th>Ordinamento</th>
				<th></th>
			</thead>
			<tbody>
				<?php
				
				// if clicked button addOinCollection from library
				if(isset($_GET['level']) && isset($_GET['id'])){
					
					for($i=0; $i<sizeOf($collections); $i++){
						
						if($collections[$i]["ordering"]==0){
							$orderingName= "Personalizzato";
						} else if ($collections[$i]["ordering"]==1){
							$orderingName= "Data";
						} else $orderingName= "Autore";
						
						echo "<tr>";
						echo "<td >".$collections[$i]['id']."</td>";
						echo "<td >".$collections[$i]['name']."</td>";
						echo "<td>".$collections[$i]['brief']."</td>";
						echo "<td>".$orderingName."</td>";
						echo "<td valign='center'>";
						echo 	"<form method='get' action='addCollectionItems.php'>
									<input name='idCollection' type='hidden' value='".$collections[$i]['id']."'>
									<input name='nameCollection' type='hidden' value='".$collections[$i]['name']."'>
									<input name='level' type='hidden' value='".$_GET['level']."'>
									<input name='id' type='hidden' value='".$_GET['id']."'>
									<button type='submit' name='add_items_toCollection'><i class='fa fa-plus '></i></button> 
								</form>";
					
						
						echo "</td>";
						echo "</tr>";
					}
	

				} else{
					
					// if click managmentCollection.php
					for($i=0; $i<sizeOf($collections); $i++){
						
						if($collections[$i]["ordering"]==0){
							$orderingName= "Personalizzato";
						} else if ($collections[$i]["ordering"]==1){
							$orderingName= "Data";
						} else $orderingName= "Autore";
						
						echo "<tr>";

						echo "<td >".$collections[$i]['id']."</td>";
						echo "<td >".$collections[$i]['name']."</td>";
						echo "<td>".$collections[$i]['brief']."</td>";
						echo "<td>".$orderingName."</td>";
						echo "<td valign='center'>";
						echo 	"<form method='get' action='addCollectionItems.php'>
									<input name='idCollection' type='hidden' value='".$collections[$i]['id']."'>
									<input name='nameCollection' type='hidden' value='".$collections[$i]['name']."'>
									<button title='Aggiungi esemplari alla collezione' type='submit' name='add_items_toCollection'><i class='fa fa-plus '></i></button> 
								</form>";
						
						echo 	"<form method='get' action='collection.php'>
									<input name='idModify' type='hidden' value='".$collections[$i]['id']."'>
									<button title='Modifica collezione' type='submit' ><i class='fa fa-pencil '></i></button> 
								</form>";

						echo 	"<form method='get' action='indexCollection.php'>
									<input name='idCol' type='hidden' value='".$collections[$i]['id']."'>
									<input name='idOrd' type='hidden' value='".$collections[$i]['ordering']."'>
									<button title='Vedi collezione' type='submit' ><i class='fa fa-eye '></i></button> 
								</form>";									
						
						echo "<button title='Vedi il codice per la pagina dedicata alla collezione' type='button' onclick='window.open(&#39;collectionCode.php?id=".$collections[$i]['id']."&ord=".$collections[$i]['ordering']."&#39;, &#39; &#39;, &#39;top=10, left=10, width=550, height=300, status=no, menubar=no, toolbar=no scrollbars=no&#39;);' ><i class='fa fa-download '></i></button>"; 
						
						echo "</td>";
						echo "</tr>";

						
					
					}
					
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