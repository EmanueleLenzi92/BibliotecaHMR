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

$works= get_works($conn);
$manType= get_descriptionsType($conn, 'manifestation');

$people= get_people($conn);
$institutions= get_institutions($conn);
$manResponsability= get_responsability($conn, 'manifestation');

// for update/delete
if(isset($_GET['idModify'])){
	
	$id= $_GET['idModify'];
	$manifestationToModify= get_manifestations($conn, $id);
	$peopleToModify= get_people_by_manifestation($conn, $id);
	$institutionsToModify= get_institutions_by_manifestation($conn, $id);
	
	$idWorkToModify= $manifestationToModify[0]['idwork'];
	$idExpressToModify= $manifestationToModify[0]['idexpression'];
	$idManifToModify= $manifestationToModify[0]['iditem'];
	
	$idFormToModify= $manifestationToModify[0]['idForm'];
	$nameFormToModify= $manifestationToModify[0]['formName'];

	$typeNameToModify= $manifestationToModify[0]['type'];
	$typeIdToModify= $manifestationToModify[0]['idType'];
	
	$field1 = htmlspecialchars($manifestationToModify[0]['field1'], ENT_QUOTES);
	$field2 = htmlspecialchars($manifestationToModify[0]['field2'], ENT_QUOTES);
	$field3 = htmlspecialchars($manifestationToModify[0]['field3'], ENT_QUOTES);
	$field4 = htmlspecialchars($manifestationToModify[0]['field4'], ENT_QUOTES);
	$field5 = htmlspecialchars($manifestationToModify[0]['field5'], ENT_QUOTES);
	$field6 = htmlspecialchars($manifestationToModify[0]['field6'], ENT_QUOTES);
	$field7 = htmlspecialchars($manifestationToModify[0]['field7'], ENT_QUOTES);
	$field8 = htmlspecialchars($manifestationToModify[0]['field8'], ENT_QUOTES);
	$field9 = htmlspecialchars($manifestationToModify[0]['field9'], ENT_QUOTES);
	$field10 = htmlspecialchars($manifestationToModify[0]['field10'], ENT_QUOTES);
	
	$day = $manifestationToModify[0]['day'];
	$month = $manifestationToModify[0]['month'];
	$year = $manifestationToModify[0]['year'];
	
	$daystart = $manifestationToModify[0]['daystart'];
	$monthstart = $manifestationToModify[0]['monthstart'];
	$yearstart = $manifestationToModify[0]['yearstart'];
	
	$dayend = $manifestationToModify[0]['dayend'];
	$monthend = $manifestationToModify[0]['monthend'];
	$yearend = $manifestationToModify[0]['yearend'];
	
	$dayscan = $manifestationToModify[0]['dayscan'];
	$monthscan = $manifestationToModify[0]['monthscan'];
	$yearscan = $manifestationToModify[0]['yearscan'];
	
	$item = get_items($conn, $idManifToModify);
	$expression= get_expressions($conn, $idExpressToModify);
	
} else {
	
	$idFormToModify= "";
	$idWorkToModify= ""; $idExpressToModify= ""; $idManifToModify= ""; $typeNameToModify= ""; $typeIdToModify= "";
	$field1=""; $field2=""; $field3=""; $field4=""; $field5=""; $field6=""; $field7=""; $field8=""; $field9=""; $field10="";
	$day = ""; $month = ""; $year ="";
	$daystart = ""; $monthstart = ""; $yearstart = ""; $dayend =""; $monthend =""; $yearend = ""; $dayscan = ""; $monthscan = ""; $yearscan =""; 
	$expression=""; $item ="";
}


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
		
		$('#manifestationExpression').selectize({
			sortField: 'text',
		}); 
		
		$('#manifestationItem').selectize({
			sortField: 'text',
		});
	
	
		$('#People-filter-Expression').selectize({
	
		   plugins: ['remove_button'],
			delimiter: ',',
			persist: false,
		});
		
		
		
		$('#Institution-filter-Expression').selectize({

			plugins: ['remove_button'],
			delimiter: ',',
			persist: false,

		});
		
		$('#Work-filter-Expression').selectize({
			sortField: 'text',
		});
		
		$('#People-filter-Item').selectize({
	
		   plugins: ['remove_button'],
			delimiter: ',',
			persist: false,
		});
		
		
		
		$('#Institution-filter-Item').selectize({

			plugins: ['remove_button'],
			delimiter: ',',
			persist: false,

		});
		
		$('#Work-filter-Item').selectize({
			sortField: 'text',
		});

	});
	</script>
	
	<script>
	$(document).ready(function() {
			//hide copy type
			$('#maniftype'+17).hide();
	})
	
	function disableExpressionItemsInputsForUpdatePage(){
		
		if($('#openDiv-manifestationExpression-x').is(':visible')){
		
			$("#openDiv-manifestationItem-x :input").attr("disabled", true);
		}
		
		if($('#openDiv-manifestationItem-x').is(':visible')){
		
			$("#openDiv-manifestationExpression-x :input").attr("disabled", true);
		}	
		
	}
	</script>
	
	<?php 
	if(isset($_GET['idModify'])){
		echo "
		<script>
			$(document).ready(function() {
				disableExpressionItemsInputsForUpdatePage()
			})
		</script>
		";
	}
	?>
	
	<!--Style-->
	<link rel="stylesheet" href="../../HMR_Style.css">
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">

	<script src="../Assets/JS/peopleInstitution.js"></script>
	<script src="../Assets/JS/openDiv.js"></script>		
	<script src="../Assets/JS/openPopup.js"></script>
	<script src="../Assets/JS/manifestationType.js"></script>
	<script src="../Assets/JS/manifestationFilter.js"></script>
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
		echo '<form action="../Assets/apiDb/update_manifestation.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idManifModify" value="'.$manifestationToModify[0]["id"].'">';
	} else echo '<form action="../Assets/apiDb/insert_manifestation.php" method="post" enctype="multipart/form-data">';
?>

<div id="manifestation" class="marginBox typeOfLevel">
	
	<div id="man">
	
		<h1>Manifestazione <?php if(isset($_GET['idModify'])){ echo "(id: ".$manifestationToModify[0]["id"] .")";}  ?></h1>
		
			<h3 class="openDiv" id="openDiv-People">Persone <i class="fa fa-angle-down"></i></h3>
		
			<div id="People-x" <?php if(isset($_GET['idModify']) && !empty($peopleToModify)) {echo 'style';} else {echo 'style="display: none"';}?>>
			

				<select name="People-Responsability" id="People-Responsability" placeholder="Seleziona una responsabilità...">
				<option value="">Seleziona una responsabilità...</option>
				<?php
					for( $i=0; $i < sizeOF($manResponsability); $i++ ){
						echo "<option value='" . $manResponsability[$i]["id"] . "'>" . $manResponsability[$i]["name"] . "</option>";
					}
				?>
				</select> 	
				

				<select name="People" id="People" placeholder="Seleziona una persona...">
				<option value="">Seleziona una persona...</option>
				<?php
					$peopleList="";
					for( $i=0; $i < sizeOF($people); $i++ ){
						$peopleList .= "<option value='" . $people[$i]["id"] . "'>" . $people[$i]["forname"] . " " .  $people[$i]["name"] . " (" .  $people[$i]["brief"] . ")" . " (ID: " . $people[$i]["id"] .  ")</option>";
					}
					echo $peopleList;
				?>
				</select> 	
				
				<button type="button" class="confirmResp" id="People-confirm">Conferma</button> &nbsp;&nbsp;
				<small>Manca una persona o una responsabilità? &nbsp; <a href="../Responsability/people.php">Aggiungi persona</a> &nbsp;&nbsp; <a href="../Responsability/responsabilityType.php?level=manifestation">Aggiungi responsabilità</a></small>
				
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
										<button type="button" class="delete-responsab btn" id="delete-People-'.$peopleToModify[$i]["idPeople"].'-'.$peopleToModify[$i]["idResp"].'">
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
					for( $i=0; $i < sizeOF($manResponsability); $i++ ){
						echo "<option value='" . $manResponsability[$i]["id"] . "'>" . $manResponsability[$i]["name"] . "</option>";
					}
				?>
				</select> 
				

				<select name="Institution" id="Institution" placeholder="Seleziona un'istituzione...">
				<option value="">Seleziona un'istituzione...</option>
				<?php
					$institutList="";
					for( $i=0; $i < sizeOF($institutions); $i++ ){
						$institutList .= "<option value='" . $institutions[$i]["id"] . "'>" . $institutions[$i]["name"] . "</option>";
					}
					echo $institutList;
				?>
				</select> 	
				
				<button type="button" class="confirmResp" id="Institution-confirm">Conferma</button> &nbsp;&nbsp;
				<small>Manca un istituzione o una responsabilità? &nbsp; <a href="../Responsability/institution.php">Aggiungi istituzione</a> &nbsp;&nbsp; <a href="../Responsability/responsabilityType.php?level=manifestation">Aggiungi responsabilità</a></small>

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
			

		
		
		<h3 class="openDiv" id="openDiv-manifestationExpression">Lega a espressione <i class="fa fa-angle-down"></i></h3>	
	
		<div id="openDiv-manifestationExpression-x" <?php if(isset($_GET['idModify']) && $idExpressToModify != 0) {echo 'style';} else {echo 'style="display: none"';}?>>
			
				<div id="filterExp">
					
					<p><strong>Filtra espressione</strong></p>
					
					<select id="People-filter-Expression" class="filter" placeholder="Filtra per persona..." multiple>
					<option value="">Filtra per persona...</option>
					<?php
						echo $peopleList;
					?>
					</select> 
					
					<select id="Institution-filter-Expression" class="filter" placeholder="Filtra per istituzione..." multiple>
					<option value="">Filtra per istituzione...</option>
					<?php
						echo $institutList;
					?>
					</select> 	
					
					<select name="Work-filter" id="Work-filter-Expression" class="filter-work">
						<option value="">Filtra per opera...</option>
						<?php
						$workList="";
						for( $i=0; $i < sizeOF($works); $i++ ){
							//get responsability with concat distinc row, and append in text select
							$responsability= get_responsabilityWork($conn, $works[$i]["id"], $oneRow=true);
							//pass two values; value1= idwork, value2=idwork (split in php)
							$workList .= "<option value='" . $works[$i]["id"] . "-" . $works[$i]["id"] . "'>" . $responsability[0]['persBrief'] . $responsability[0]['istitutEspr'] . $works[$i]["title"] . "</span></option>";
						}
						echo $workList;
						?>
					</select>
			
				</div> <!--End filter-->
			

			<select name="manifestationExpression" id="manifestationExpression" class="selectTitle"  required>
			<option value="">Seleziona l'espressione a cui è collegata...</option>
			<?php

					//get expression of the manifestation if we're modifying a manifestation. else is a empty string
					$selected="";
					if(isset($_GET['idModify']) && $idExpressToModify != 0 ){

						//get responsability with concat distinc row, and append in text select
						$resp= get_responsabilityExpression($conn, $expression[$i]["id"], $oneRow= true);
						if($resp[0]['persBrief'] != null){$comma=", ";} else {$comma="";}
						if($resp[0]['istitutEspr'] != null){$comma1=", ";} else {$comma1="";}
						//pass two values; value1= idexpression, value2=idwork (split in php)
						echo "<option value='" . $expression[0]["id"] . "-" . $expression[0]["idwork"] . "' selected>" . $resp[0]['persBrief'] . $comma . $resp[0]['istitutEspr'] . $comma1 . $expression[0]["title"] . ", " . $expression[0]["typeName"] . "</option>";
					 

					}

			?>
			</select> <button type="button" <?php if(isset($_GET['idModify'])) {echo "id='../catalogCard.php?idWork=".$idWorkToModify."&idlevel=$idExpressToModify&levelName=manifestationExpression'";} else echo 'id="seeCatalogCard-work"'; ?> class="seeCatalogCard btn"><i class="fa fa-eye"></i></button> </br></br>

			
		</div> <!--end manifestationExpression -->
		
		<h3 class="openDiv" id="openDiv-manifestationItem">Lega a esemplare <i class="fa fa-angle-down"></i></h3>	
		
		<div id="openDiv-manifestationItem-x" <?php if(isset($_GET['idModify']) && $idManifToModify != 0) {echo 'style';} else {echo 'style="display: none"';}?>>
		
				<div id="filterItem">
					
					<p><strong>Filtra esemplare</strong></p>
					
					<select id="People-filter-Item" class="filter" placeholder="Filtra per persona..." multiple>
					<option value="">Filtra per persona...</option>
					<?php
						echo $peopleList;
					?>
					</select> 
					
					<select id="Institution-filter-Item" class="filter" placeholder="Filtra per istituzione..." multiple>
					<option value="">Filtra per istituzione...</option>
					<?php
						echo $institutList;
					?>
					</select> 	
					
					<select name="Work-filter" id="Work-filter-Item" class="filter-work">
						<option value="">Filtra per opera...</option>
						<?php
							echo $workList;
						?>
					</select>
			
				</div> <!--End filter-->
		

			<select name="manifestationItem" id="manifestationItem" class="selectTitle" required>
			<option value="">Seleziona l'esemplare a cui è collegata...</option>
			<?php
					//get item of the manifestation if we're modifying a manifestation. else is a empty string
					if(isset($_GET['idModify']) && $idManifToModify != 0){

						//get responsability with concat distinc row, and append in text select
						$resp= get_responsabilityItem($conn, $item[$i]["id"], $oneRow=true);
						if($resp[0]['persBrief'] != null){$comma=", ";} else {$comma="";}
						if($resp[0]['istitutEspr'] != null){$comma1=", ";} else {$comma1="";}
						//get manifestation, for type manif.
						$manifestation= get_manifestations($conn, $item[$i]["idmanifestation"]);
						//pass two values; value1= iditem, value2=idwork (split in php)
						echo "<option value='" . $item[0]["id"] . "-" . $item[0]["idwork"] . "' selected>" . $resp[0]['persBrief'] . $comma . $resp[0]['istitutEspr'] . $comma1 . $item[0]["title"] . ", " . $manifestation[0]['type'] . "</option>";


					}
					

				 
			?>
			</select> <button type="button" <?php if(isset($_GET['idModify'])) {echo "id='../catalogCard.php?idWork=".$idWorkToModify."&idlevel=$idManifToModify&levelName=manifestationItem'";} else echo 'id="seeCatalogCard-work"'; ?> class="seeCatalogCard btn"><i class="fa fa-eye"></i></button>  
			
		</div> <!--end manifestationItem -->
		
		</br></br></br>
	
		
		<select onchange="getManifestationField('','','','','','','','','','','','','','','','','','','','','','','')" name="manifestationType" id="manifestationType" required>
		<option value="">Seleziona il tipo di manifestazione...</option>
		<?php
		
			for( $i=0; $i < sizeOF($manType); $i++ ){
				//get item of the manifestation if we're modifying a manifestation. else is a empty string
				$selected=""; 
				if(isset($_GET['idModify'])){
					if($typeIdToModify == $manType[$i]["id"]){
						$selected= "selected";						
					}

				}
				echo "<option id='maniftype".$manType[$i]["id"]."' value='" . $manType[$i]["id"] . "' ".$selected." >" . $manType[$i]["name"] . "</option>";
			}
			
			//js that get data of fields (function in manifestationType.js)
			echo "<script>
			$(document).ready(function() { 
				getManifestationField('$idFormToModify', '$field1','$field2','$field3','$field4','$field5','$field6','$field7','$field8','$field9', '$field10', '$day', '$month', '$year', '$daystart', '$monthstart', '$yearstart', '$dayend', '$monthend', '$yearend', '$dayscan', '$monthscan', '$yearscan')
			});	
			</script>";
			
		
		?>
		</select> 
		
		
		
		<div id="manifestationTypeFields"></div> 
		
		</br></br></br>
	
		
		<button type="submit" class="submitLevel" id="manifestation-submit">Inserisci nel database</button>
		

		
	</div> <!--end man x-->
		
</div> 

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