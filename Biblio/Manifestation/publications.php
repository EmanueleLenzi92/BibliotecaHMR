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
require ('../Assets/PHP/functions_insert.php');

$publications= get_publications($conn);
$publicationsType= get_publicationsType($conn);

if(isset($_GET['idModify'])){
	
	$id= $_GET['idModify'];
	$publicationToModify= get_publications($conn, $id);
	
	$name= htmlspecialchars($publicationToModify[0]['name'], ENT_QUOTES);
	$idType= $publicationToModify[0]['idType'];  
	$typeName= $publicationToModify[0]['typeName'];
} else {$name=""; $idType=""; $typeName="";}

// if passed new publication by manifestation page
if(isset($_GET['publicationType']) && isset($_GET['publicationTypeId'])){
	$publicationType= $_GET['publicationType'];
	$publicationTypeId= $_GET['publicationTypeId'];
}

?>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- datatable -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function () {
        $('table').dataTable(
			{
			"pageLength": 25
			}
		);
    });
	</script>
	
	<script>
	$(document).ready(function () {
		//open people list and change arrow
		$('.openDiv').on('click', function() {
			$("#content-table").toggle(100);
			$(".openDiv").find('i').toggleClass('fa-angle-up fa-angle-down')
		})
	})
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

<?php   
	if(isset($_GET['idModify'])){
		echo '<form action="../Assets/apiDb/update_publication.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idPublModify" value="'.$publicationToModify[0]["id"].'">';
	} else echo '<form action="../Assets/apiDb/insert_publication.php" method="post" enctype="multipart/form-data">';
?>
	
	<h1>Pubblicazione <?php if(isset($_GET['idModify'])){ echo "(".$name.")";} ?></h1>
	
	<label for="name">Nome:</label>
	<input value="<?php echo $name; ?>" type="text" id="name" name="name" size="50"> 
	
	</br>
	
	<label for="type">Tipo:</label>
	<select name="type" id="type">
	
	<?php
		
		if(isset($_GET['publicationType']) && isset($_GET['publicationTypeId'])){
			echo "<option value='" . $publicationTypeId . "' selected>" . $publicationType . "</option>";
		} else {
	
			echo "<option value=''>Seleziona un tipo</option>";
			
			for( $i=0; $i < sizeOF($publicationsType); $i++ ){
				
				$selected="";
				if(isset($_GET['idModify'])){
					if($idType == $publicationsType[$i]["id"]){
						$selected= "selected";
					}
				}
				
				echo "<option value='" . $publicationsType[$i]["id"] . "' ".$selected.">" . $publicationsType[$i]["type"] . "</option>";
			}
		
		}
	?>
	</select> 	
	
	
	</br></br>
	
	<button type="submit" class="submitLevel" id="publication-submit">Inserisci nel database</button>
	
	</form>
	
	</br>

	<h1 class="openDiv">Lista pubblicazioni <i class="fa fa-angle-down"></i></h1>
	
	<div id="content-table" style="display: none">
	
	<table id="table_id" class="display" cellspacing="0" width="100%">
			<thead>
				<th>ID</th>
				<th>Nome</th>
				<th>Tipo</th>

				<th></th>
			</thead>
			<tbody>
				<?php
					
					for( $i=0; $i < sizeOF($publications); $i++ ){
						echo "<tr>";
						echo "<form method='get'>";
						echo "<input type='hidden' name='idModify' value='".$publications[$i]['id']."'>";
						echo "<td >".$publications[$i]['id']."</td>";
						echo "<td >".$publications[$i]['name']."</td>";
						echo "<td >".$publications[$i]['typeName']."</td>";
						echo "<td valign='center'><button type='submit'>Modifica</button></td>";
						echo "</form>";
						echo "</tr>";
					}
					
				?>
			</tbody>
	</table>
	
	</div>

</div></div> <!--end HMR contents-->

<div class="HMR_Footer">
	<script>
		creaFooter(2, "2014", "2017", "G.A. Cignoni", 
							 "2014/09/23", "2017/10/13 18:15")
	</script> 
</div>

</body>
</html>