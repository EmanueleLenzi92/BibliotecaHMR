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

// for general html selects
$works= get_works($conn);
$workResponsability= get_responsability($conn, 'work');
$people= get_people($conn);
$institutions= get_institutions($conn);

// for update/delete
if(isset($_GET['idModify'])){
	
	$id= $_GET['idModify'];
	$WorkToModify= get_works($conn, $id);
	$peopleToModify= get_people_by_work($conn, $id);
	$institutionsToModify= get_institutions_by_work($conn, $id);
	
	$titleToModify= htmlspecialchars($WorkToModify[0]['title'], ENT_QUOTES);

} else $titleToModify= "";

?>

<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--For select searching-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
	<script>
	$(document).ready(function () {
		$('#People').selectize({
			sortField: 'text'
		});
		  
		$('#Institution').selectize({
			sortField: 'text'
		});
	});
	</script>
	
	<!--Style-->
	<link rel="stylesheet" href="../../HMR_Style.css">
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">
	
	<script src="../Assets/JS/peopleInstitution.js"></script>
	<script src="../Assets/JS/openDiv.js"></script>	
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
		echo '<form action="../Assets/apiDb/update_work.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idWorkModify" value="'.$WorkToModify[0]["id"].'">';
	} else echo '<form action="../Assets/apiDb/insert_work.php" method="post" enctype="multipart/form-data">';
?>

	<div id="work" class="marginBox typeOfLevel">
	
		<div id="work">
			
			<h1>Opera <?php if(isset($_GET['idModify'])){ echo "(id: ".$WorkToModify[0]["id"] .")";}  ?></h1>
			
			
			<h3 class="openDiv" id="openDiv-People">Persone <i class="fa fa-angle-down"></i></h3>
		
			<div id="People-x" <?php if(isset($_GET['idModify']) && !empty($peopleToModify)) {echo 'style';} else {echo 'style="display: none"';}?>>
			

				<select name="People-Responsability" id="People-Responsability">
				<option value="">Seleziona una responsabilità...</option>
				<?php
					for( $i=0; $i < sizeOF($workResponsability); $i++ ){
						echo "<option value='" . $workResponsability[$i]["id"] . "'>" . $workResponsability[$i]["name"] . "</option>";
					}
				?>
				</select> 	
				

				<select name="People" id="People" placeholder="Seleziona una persona...">
				<option value="">Seleziona una persona...</option>
				<?php
					for( $i=0; $i < sizeOF($people); $i++ ){
						echo "<option value='" . $people[$i]["id"] . "'>" . $people[$i]["forname"] . " " .  $people[$i]["name"] . " (" .  $people[$i]["brief"] . ")" . " (ID: " . $people[$i]["id"] .  ")</option>";
					}
				?>
				</select> 	
				
				<button type="button" class="confirmResp" id="People-confirm">Conferma</button> &nbsp;&nbsp;
				<small>Manca una persona o una responsabilità? &nbsp; <a href="../Responsability/people.php">Aggiungi persona</a> &nbsp;&nbsp; <a href="../Responsability/responsabilityType.php?level=work">Aggiungi responsabilità</a></small>
				
				<div id="People-table">
					<table <?php if(isset($_GET['idModify']) && !empty($peopleToModify)) {echo 'style';} else {echo 'style="display: none"';}?>>
						<tr>
							<th>Id</th>
							<th>Autore</th>
							<th>Responsabilità</th>
							<th></th>
						</tr>
						<?php 
						if(isset($_GET['idModify']) && !empty($peopleToModify)){
							for($i=0; $i<sizeOF($peopleToModify); $i++){
								echo '
								<tr id="riga-People-'.$peopleToModify[$i]["idPeople"].'-'.$peopleToModify[$i]["idResp"].'">
									<td>'.$peopleToModify[$i]["idPeople"].'</td>
									<td>'.$peopleToModify[$i]["peopleBrief"].'</td>
									<td>'.$peopleToModify[$i]["respName"].'</td>
									<td>
										<button onclik="deletResp()" type="button" class="delete-responsab btn" id="delete-People-'.$peopleToModify[$i]["idPeople"].'-'.$peopleToModify[$i]["idResp"].'">
										<i class="fa fa-trash"></i>
										</button>
									</td>
								</tr>';
							}
						}
						?>
					</table>
				</div>
				<div id="People-Data">
				<?php 
				if(isset($_GET['idModify']) && !empty($peopleToModify)){
					for($i=0; $i<sizeOF($peopleToModify); $i++){
						echo '
						<span id="data-People-'.$peopleToModify[$i]["idPeople"].'-'.$peopleToModify[$i]["idResp"].'">
							<input type="hidden" name="inputIdPeople[]" value="'.$peopleToModify[$i]["idPeople"].'">
							<input type="hidden" name="inputIdPeopleResponsability[]" value="'.$peopleToModify[$i]["idResp"].'">
						</span>';		
					}
				}	
				?>		
				</div>	

			
			</div>	<!--end responsability people-x -->
			
			
			<h3 class="openDiv" id="openDiv-Institution">Istituzioni <i class="fa fa-angle-down"></i></h3>
			
			<div id="Institution-x" <?php if(isset($_GET['idModify']) && !empty($institutionsToModify)) {echo 'style';} else {echo 'style="display: none"';}?>>
			

				<select name="Institution-Responsability" id="Institution-Responsability">
				<option value="">Seleziona una responsabilità...</option>
				<?php
					for( $i=0; $i < sizeOF($workResponsability); $i++ ){
						echo "<option value='" . $workResponsability[$i]["id"] . "'>" . $workResponsability[$i]["name"] . "</option>";
					}
				?>
				</select> 
				

				<select name="Institution" id="Institution" placeholder="Seleziona un'istituzione...">
				<option value="">Seleziona un'istituzione...</option>
				<?php
					for( $i=0; $i < sizeOF($institutions); $i++ ){
						echo "<option value='" . $institutions[$i]["id"] . "'>" . $institutions[$i]["name"] . "</option>";
					}
				?>
				</select> 	
				
				<button type="button" class="confirmResp" id="Institution-confirm">Conferma</button> &nbsp;&nbsp;
				<small>Manca un istituzione o una responsabilità? &nbsp; <a href="../Responsability/institution.php">Aggiungi istituzione</a> &nbsp;&nbsp; <a href="../Responsability/responsabilityType.php?level=work">Aggiungi responsabilità</a></small>

				<div id="Institution-table">
					<table <?php if(isset($_GET['idModify']) && !empty($institutionsToModify)) {echo 'style';} else {echo 'style="display: none"';}?>>
						<tr>
							<th>Id</th>
							<th>Istituzione</th>
							<th>Responsabilità</th>
							<th></th>
						</tr>
						<?php 
						if(isset($_GET['idModify']) && !empty($institutionsToModify)){
							for($i=0; $i<sizeOF($institutionsToModify); $i++){
								echo '
								<tr id="riga-Institution-'.$institutionsToModify[$i]["idInstitution"].'-'.$institutionsToModify[$i]["idResp"].'">
									<td>'.$institutionsToModify[$i]["idInstitution"].'</td>
									<td>'.$institutionsToModify[$i]["istitutName"].'</td>
									<td>'.$institutionsToModify[$i]["respName"].'</td>
									<td>
										<button type="button" class="delete-responsab btn" id="delete-Institution-'.$institutionsToModify[$i]["idInstitution"].'-'.$institutionsToModify[$i]["idResp"].'">
										<i class="fa fa-trash"></i>
										</button>
									</td>
								</tr>';
							}
						}
						?>
					</table>
				</div>		
				<div id="Institution-Data">
				<?php 
				if(isset($_GET['idModify']) && !empty($institutionsToModify)){
					for($i=0; $i<sizeOF($institutionsToModify); $i++){
						echo '
						<span id="data-Institution-'.$institutionsToModify[$i]["idInstitution"].'-'.$institutionsToModify[$i]["idResp"].'">
							<input type="hidden" name="inputIdInstitution[]" value="'.$institutionsToModify[$i]["idInstitution"].'">
							<input type="hidden" name="inputIdInstitutionResponsability[]" value="'.$institutionsToModify[$i]["idResp"].'">
						</span>';		
					}
				}	
				?>
				</div>	


			</div>	<!--end responsability institution-x -->



			<h3>Titolo:</h3>
			<input value='<?php echo $titleToModify; ?>' type="text" id="workTitle" name="workTitle" size="80" placeholder="Inserisci titolo..." required> 
					
			
			</br></br></br>

			
			<button type="submit" class="submitLevel" id="work-submit">Inserisci nel database</button>
		 
		</div> <!--end work x-->
	
	</div><!--end work-->

</form>

</div></div> <!--end HMR contents-->

<div class="HMR_Footer">
	<script>
		creaFooter(2, "2014", "2017", "G.A. Cignoni", 
							 "2014/09/23", "2017/10/13 18:15")
	</script> 
</div>

</body>

</html>