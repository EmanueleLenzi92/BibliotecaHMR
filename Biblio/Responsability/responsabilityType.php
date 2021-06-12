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
require ('../Assets/PHP/functions_update.php');

$responsabilityType= get_allResponsability($conn);

// for modify a one responsability
if(isset($_GET['idModify'])){
	
	$id= $_GET['idModify'];
	$responsabilityToModify= get_allResponsability($conn, $id);
	
	$name= htmlspecialchars($responsabilityToModify[0]['name'], ENT_QUOTES);
	$type= htmlspecialchars($responsabilityToModify[0]['level'], ENT_QUOTES); 

} else {$name=""; $type="";}

// if add a responsability from a page (work, expression ecc.)
if(isset($_GET['level'])){
	$level= $_GET['level'];
	if ($level == "work"){
		$levelIta= "opera";
	}
	if ($level == "expression"){
		$levelIta= "espressione";
	}
	if ($level == "manifestation"){
		$levelIta= "manifestazione";
	}
	if ($level == "item"){
		$levelIta= "esemplare";
	}
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
		echo '<form action="../Assets/apiDb/update_responsabilityType.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idRespModify" value="'.$responsabilityToModify[0]["id"].'">';
	} else echo '<form action="../Assets/apiDb/insert_responsabilityType.php" method="post" enctype="multipart/form-data">';
?>

	<?php 
	if(isset($_GET['idModify'])){
		echo "<h1>Modifica responsabilità ($name)</h1>";
	} else {
		echo "<h1>Aggiungi responsabilità";
		if(isset($_GET['level'])){ echo " per " . $levelIta;}
		echo "</h1>";
	}
	?>
	
	<label for="name">Nome:</label>
	<input value="<?php echo $name; ?>" type="text" id="name" name="name" size="50"> 
	
	</br>
	
	<label for="level">Livello:</label>
	<select name="level" id="level">
		<?php
			if(isset($_GET['level'])){
			echo "<option value='" . $level . "' selected>" . $levelIta . "</option>";
		} else {
				
				$selected="";
				if(isset($_GET['idModify']) && $type=='work') {$selected="selected";}
				echo "<option value='work' $selected>Opera</option>";
				$selected="";
				if(isset($_GET['idModify']) && $type=='expression') {$selected="selected";}
				echo "<option value='expression' $selected>Espressione</option>";
				$selected="";
				if(isset($_GET['idModify']) && $type=='manifestation') {$selected="selected";}
				echo "<option value='manifestation' $selected>Manifestazione</option>";
				$selected="";
				if(isset($_GET['idModify']) && $type=='item') {$selected="selected";}
				echo "<option value='item' $selected>Esemplare</option>";
					
		}
			
		?>
	
	</select> 	
	
	
	</br></br>
	
	<button type="submit" class="submitLevel" id="publication-submit">Inserisci nel database</button>
	
	</form>
	
	</br>
	
	<h1 class="openDiv">Lista responsabilità <i class="fa fa-angle-down"></i></h1>
	
	<div id="content-table" style="display: none">
	
	<table id="table_id" class="display" cellspacing="0" width="100%">
			<thead>
				<th>ID</th>
				<th>Nome</th>
				<th>Livello</th>

				<th></th>
			</thead>
			<tbody>
				<?php
					
					for( $i=0; $i < sizeOF($responsabilityType); $i++ ){
						echo "<tr>";
						echo "<form method='get'>";
						echo "<input type='hidden' name='idModify' value='".$responsabilityType[$i]['id']."'>";
						echo "<td >".$responsabilityType[$i]['id']."</td>";
						echo "<td >".$responsabilityType[$i]['name']."</td>";
						echo "<td >".$responsabilityType[$i]['level']."</td>";
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