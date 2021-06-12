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

// for general selects html
$works= get_works($conn);

$itemResp= get_responsability($conn, 'item');
$people= get_people($conn);
$institutions= get_institutions($conn);

// for update/delete
if(isset($_GET['idModify'])){
	
	$id= $_GET['idModify'];
	$itemToModify= get_items($conn, $id);
	$peopleToModify= get_people_by_item($conn, $id);
	$institutionsToModify= get_institutions_by_item($conn, $id);
	
	$idWorkToModify= $itemToModify[0]['idwork'];
	$idManToModify= $itemToModify[0]['idmanifestation'];
	$fileurlToModify= htmlspecialchars($itemToModify[0]['fileurl'], ENT_QUOTES);
	$filenameToModify= htmlspecialchars($itemToModify[0]['filename'], ENT_QUOTES);
	$capabilityToModify= $itemToModify[0]['capability'];
	$extLinkToModify= htmlspecialchars($itemToModify[0]['extlink'], ENT_QUOTES);
	$note= htmlspecialchars($itemToModify[0]['note'], ENT_QUOTES);
	$monthvisited= $itemToModify[0]['monthvisited'];
	$yearvisited= $itemToModify[0]['yearvisited'];
	$dayvisited= $itemToModify[0]['dayvisited'];
	
	$manifestation= get_manifestations($conn, $idManToModify);
	
} else {$fileurlToModify= ""; $filenameToModify= ""; $capabilityToModify= ""; $idWorkToModify=""; $idManToModify=""; $extLinkToModify=""; $note=""; $manifestation= "";$monthvisited=0; $yearvisited=0; $dayvisited=0;}

?>

<head>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!--For select searching-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
	<script>
	$(document).ready(function () {
		$('#People').selectize({
			sortField: 'text',
		});
		  
		$('#Institution').selectize({
			sortField: 'text'
		});
		
		$('#manifestationItem').selectize({
			sortField: 'text'
		});
		
		$('#People-filter').selectize({
	
		   plugins: ['remove_button'],
			delimiter: ',',
			persist: false,
		});
		
		
		
		$('#Institution-filter').selectize({

			plugins: ['remove_button'],
			delimiter: ',',
			persist: false,

		});
		
		$('#Work-filter').selectize({
			sortField: 'text',
		});

		
	});
	</script>
	
	<!--Style-->
	<link rel="stylesheet" href="../../HMR_Style.css">
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">
	
	
	<script src="../Assets/JS/peopleInstitution.js"></script>
	<script src="../Assets/JS/openDiv.js"></script>	
	<script src="../Assets/JS/openPopup.js"></script>
	<script src="../Assets/JS/itemFilter.js"></script>
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
		echo '<form action="../Assets/apiDb/update_item.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idItemModify" value="'.$itemToModify[0]["id"].'">';
	} else echo '<form action="../Assets/apiDb/insert_item.php" method="post" enctype="multipart/form-data">';
?>

<div id="item" class="marginBox typeOfLevel">
	
	<div id="itm">
		<h1>Esemplare <?php if(isset($_GET['idModify'])){ echo "(id: ".$itemToModify[0]["id"] .")";}  ?></h1>
		
			<h3 class="openDiv" id="openDiv-People">Persone <i class="fa fa-angle-down"></i></h3>
		
			<div id="People-x" <?php if(isset($_GET['idModify']) && !empty($peopleToModify)) {echo 'style';} else {echo 'style="display: none"';}?>>
		

				<select name="People-Responsability" id="People-Responsability">
				<option value="">Seleziona una responsabilità...</option>
				<?php
					for( $i=0; $i < sizeOF($itemResp); $i++ ){
						echo "<option value='" . $itemResp[$i]["id"] . "'>" . $itemResp[$i]["name"] . "</option>";
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
				<small>Manca una persona o una responsabilità? &nbsp; <a href="../Responsability/people.php">Aggiungi persona</a> &nbsp;&nbsp; <a href="../Responsability/responsabilityType.php?level=item">Aggiungi responsabilità</a></small>
				
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
					for( $i=0; $i < sizeOF($itemResp); $i++ ){
						echo "<option value='" . $itemResp[$i]["id"] . "'>" . $itemResp[$i]["name"] . "</option>";
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
				<small>Manca un istituzione o una responsabilità? &nbsp; <a href="../Responsability/institution.php">Aggiungi istituzione</a> &nbsp;&nbsp; <a href="../Responsability/responsabilityType.php?level=item">Aggiungi responsabilità</a></small>

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
		
		
		
		
			<div id="filterMani">
					
					<p><strong>Filtra manifestazione collegata</strong></p>
					
					<select id="People-filter" class="filter" placeholder="Filtra per persona..." multiple>
					<option value="">Filtra per persona...</option>
					<?php
						echo $peopleList;
					?>
					</select> 
					
					<select id="Institution-filter" class="filter" placeholder="Filtra per istituzione..." multiple>
					<option value="">Filtra per istituzione...</option>
					<?php
						echo $institutList;
					?>
					</select> 	
					
					<select name="Work-filter" id="Work-filter" class="filter-work">
						<option value="">Filtra per opera...</option>
						<?php
						for( $i=0; $i < sizeOF($works); $i++ ){
							//get responsability with concat distinc row, and append in text select
							$responsability= get_responsabilityWork($conn, $works[$i]["id"], $oneRow=true);
							//pass two values; value1= idwork, value2=idwork (split in php)
							echo "<option value='" . $works[$i]["id"] . "-" . $works[$i]["id"] . "'>" . $responsability[0]['persBrief'] . $responsability[0]['istitutEspr'] . $works[$i]["title"] . "</span></option>";
						}
						?>
					</select>
			
		</div> <!--End filter-->

		<select name="manifestationItem" id="manifestationItem" class="selectTitle" required>
		<option value="">Seleziona la manifestazione a cui è collegata...</option>
		<?php


				if(isset($_GET['idModify'])){
					
					//get responsability with concat distinc row, and append in text select
					$resp= get_responsabilityManifestation($conn, $manifestation[$i]["id"], $oneRow=true);
					if($resp[0]['persBrief'] != null){$comma=", ";} else {$comma="";}
					if($resp[0]['istitutEspr'] != null){$comma1=", ";} else {$comma1="";}
					//get expression, for type expr.
					//$expression= get_expressions($conn, $manifestations[$i]["idexpression"]);
					//pass two values; value1= idmanifestation, value2=idwork (split in php)
					echo "<option value='" . $manifestation[0]["id"] . "-" . $manifestation[0]["idwork"] . "' selected>"  . $resp[0]['persBrief'] . $comma . $resp[0]['istitutEspr'] . $comma1 . $manifestation[0]["title"] . ", " .$manifestation[0]["type"] . "</option>";

				}

		?>
		</select> <button type="button" <?php if(isset($_GET['idModify'])) {echo "id='../catalogCard.php?idWork=".$idWorkToModify."&idlevel=$idManToModify&levelName=manifestationItem''";} else echo 'id="seeCatalogCard-work"'; ?> class="seeCatalogCard btn"><i class="fa fa-eye"></i></button> 
		
		
		</br></br></br>
		
		<h3 class="openDiv" id="openDiv-extLink">Aggiungi link esterno <i class="fa fa-angle-down"></i></h3>	
		<div id="openDiv-extLink-x" <?php if(isset($_GET['idModify']) && $extLinkToModify != "") {echo 'style';} else {echo 'style="display: none"';}?>>		
		
		<label for="extLink">Link esterno:</label>
		<input value='<?php echo $extLinkToModify; ?>' type="text" id="extLink" name="extLink" size="80"> 
		
		</br></br>
		
		<?php
		$ddOption="<option value='0'>Seleziona giorno...</option>";
		for($i=1; $i<32; $i++){
			$selected="";
			if($dayvisited == $i) {$selected="selected";}
			$ddOption .= "<option value='".$i."' $selected>".$i."</option>";
		}
		$mmOption="<option value='0'>Seleziona mese</option>";
		$monts=['null', 'gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno', 'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'];
		for($i=1; $i<13; $i++){
			$selected=""; 
			if($monthvisited == array_search($monts[$i], $monts)){$selected="selected";}
			$mmOption .= "<option value='".$i."' $selected>".$monts[$i]."</option>";
		}
		$yyOption="<option value='0'>Seleziona anno</option>";
		for($i=1800; $i<date("Y")+1; $i++){
			$selected=""; 
			if($yearvisited == $i){$selected="selected";}
			$yyOption .= "<option value='".$i."' $selected>".$i."</option>";
		}
		
		$date=	'<label for="day">Data ultima visita</label></br>
				<select name="day" class="date-day">
				'.$ddOption.'
				</select>
				<select name="month" class="date-day">
				'.$mmOption.'
				</select>
				<select name="year" class="date-month">
				'.$yyOption.'
				</select>';
				
		echo $date;
		
		?>
		
		</div>
		
		
		</br>
		
		
		<h3 class="openDiv" id="openDiv-localFile">Aggiungi file locale <i class="fa fa-angle-down"></i></h3>	
		<div id="openDiv-localFile-x" <?php if(isset($_GET['idModify']) && $filenameToModify != "") {echo 'style';} else {echo 'style="display: none"';}?>>
		
		<label for="localFile">File locale:</label>
		<input type="file" id="localFile" name="localFile">
		<?php
		if(isset($_GET['idModify'])){
			echo '<input value="'.$filenameToModify.'" type="hidden" id="filename" name="filename">';
			echo '<input value="'.$fileurlToModify.'" type="hidden" id="fileurl" name="fileurl">';
			if($filenameToModify != ""){
				echo "<a href='../".$fileurlToModify."' target='_BLANK'><p>File: ".$filenameToModify."</p></a>";
			}
		
		}
		?>
		
		
		
		</br>
		
		<label for="capability">Riservatezza:</label> </br>
		<?php
		for($i=1; $i<4; $i++){
			$selected="";
			if(isset($_GET['idModify'])){
				if($capabilityToModify == $i){
					$selected= "checked";
				}
			}
			
			echo '<input type="radio" id="'.$i.'" name="capability" value="'.$i.'" '.$selected.'>' . $i;
		
		}
		?>
		</div>
		
		</br></br></br>
		

		<input value='<?php echo $note; ?>' type="text" id="note" name="note" size="80" placeholder="Note"> 

		</br></br></br>
		
		
		<button type="submit" class="submitLevel" id="item-submit">Inserisci nel database</button>
		
	</div> <!--end exp x-->
		
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