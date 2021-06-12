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

$people= get_people($conn);

if(isset($_GET['idModify'])){
	$id= $_GET['idModify'];
	$peopleToModify= get_people($conn, $id);
	
	$name= htmlspecialchars($peopleToModify[0]['name'], ENT_QUOTES);
	$surname= htmlspecialchars($peopleToModify[0]['forname'], ENT_QUOTES);
	$brief= htmlspecialchars($peopleToModify[0]['brief'], ENT_QUOTES);
	$pseudonymOf= $peopleToModify[0]['pseudonymOf'];
} else {$name=""; $surname=""; $brief=""; $pseudonymOf="";}
?>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- datatable -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript">
	//data table
	$(document).ready(function () {
        $('table').dataTable(
			{
			"pageLength": 25,
			"order": [[ 2, "asc" ]]
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
		echo '<form action="../Assets/apiDb/update_people.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idpeopleModify" value="'.$peopleToModify[0]["id"].'">';
	} else echo '<form action="../Assets/apiDb/insert_people.php" method="post" enctype="multipart/form-data">';
?>
	
	<h1>Persona <?php if(isset($_GET['idModify'])){ echo "(id: ".$peopleToModify[0]["id"] .")";} ?></h1>
	
	<label for="name">Nome:</label>
	<input value="<?php echo $name; ?>" type="text" id="name" name="name" size="50"> 
	
	</br>
	
	<label for="surname">Cognome:</label>
	<input value="<?php echo $surname; ?>" type="text" id="surname" name="surname" size="50"> 
	
	</br>
	
	<label for="brief">Forma breve:</label>
	<input value="<?php echo $brief; ?>" type="text" id="brief" name="brief" size="50"> 
	
	</br>
	
	<label for="pseudonymOf">Pseudonimo di:</label>
	<select name="pseudonymOf">
	<option value="0" selected>Nessuno pseudonimo</option>
	<?php
	for($i=0; $i < sizeOf($people); $i++){
		if($pseudonymOf == $people[$i]['id']){
			$selected= "selected";
		} else $selected = "";
		
		echo "<option value='".$people[$i]['id']."' $selected>" . $people[$i]["forname"] . " " .  $people[$i]["name"] . " (" .  $people[$i]["brief"] . ")" . " (ID: " . $people[$i]["id"] .  ")</option>";
	}
	
	?>
	</select>
	
	</br></br>
	
	<button type="submit" class="submitLevel" id="people-submit">Inserisci nel database</button>
	
	</form>
	
	</br>

	<h1 class="openDiv">Lista persone <i class="fa fa-angle-down"></i></h1>
	
	<div id="content-table" style="display: none">
	
	<table id="table_id" class="display" cellspacing="0" width="100%">
			<thead>
				<th>ID</th>
				<th>Nome</th>
				<th>Cognome</th>
				<th>Forma breve</th>
				<th></th>
			</thead>
			<tbody>
				<?php
					
					for( $i=0; $i < sizeOF($people); $i++ ){
						echo "<tr>";
						echo "<form method='get'>";
						echo "<input type='hidden' name='idModify' value='".$people[$i]['id']."'>";
						echo "<td >".$people[$i]['id']."</td>";
						echo "<td >".$people[$i]['name']."</td>";
						echo "<td>".$people[$i]['forname']."</td>";
						echo "<td>".$people[$i]['brief']."</td>";
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