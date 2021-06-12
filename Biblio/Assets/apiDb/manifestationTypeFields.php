<?php
require('../../../../Config/Biblio_config.php');
require('../PHP/functions_get.php');

//get data with ajax (manifestationType.js)
$id= $_GET['idType'];
$field1= $_GET['field1'];
$field2= $_GET['field2'];
$field3= $_GET['field3'];
$field4= $_GET['field4'];
$field5= $_GET['field5'];
$field9= $_GET['field9'];
$field10= $_GET['field10'];

$idForm= $_GET['idForm'];

//book
$field6= $_GET['field6'];
//series (collane)
$field7= $_GET['field7'];
// atti|riviste
$field8= $_GET['field8'];

$day= $_GET['day'];
$month= $_GET['month'];
$year= $_GET['year'];
$dayStart= $_GET['daystart'];
$monthStart= $_GET['monthstart'];
$yearStart= $_GET['yearstart'];
$dayEnd= $_GET['dayend'];
$monthEnd= $_GET['monthend'];
$yearEnd= $_GET['yearend'];
$dayScan= $_GET['dayscan'];
$monthScan= $_GET['monthscan'];
$yearScan= $_GET['yearscan'];

// html string to send by ajax
$html= "";


//************//
//***DATE****//
//***********//

//not required for year in "pagina web" manifestation
if($id==80){ $required="";}
 else {$required="required";}
 
$ddOption="<option value='0'>Seleziona giorno...</option>";
$ddOptionDaystart="<option value='0'>Seleziona giorno...</option>";
$ddOptionDayEnd="<option value='0'>Seleziona giorno...</option>";
$ddOptionDayScan="<option value='0'>Seleziona giorno...</option>";
for($i=1; $i<32; $i++){
	$selected=""; $selectedStart=""; $selectedEnd=""; $selectedScan="";
	if($day == $i) {$selected="selected";}
	$ddOption .= "<option value='".$i."' $selected>".$i."</option>";
	if($dayStart == $i) {$selectedStart="selected";}
	$ddOptionDaystart .= "<option value='".$i."' $selectedStart>".$i."</option>";
	if($dayEnd == $i) {$selectedEnd="selected";}
	$ddOptionDayEnd .= "<option value='".$i."' $selectedEnd>".$i."</option>";
	if($dayScan == $i) {$selectedScan="selected";}
	$ddOptionDayScan .= "<option value='".$i."' $selectedScan>".$i."</option>";
}
$mmOption="<option value='0'>Seleziona mese...</option>";
$mmOptionMonthStart="<option value='0'>Seleziona mese...</option>";
$mmOptionMonthEnd="<option value='0'>Seleziona mese...</option>";
$mmOptionMonthScan="<option value='0'>Seleziona mese...</option>";
$monts=['null', 'gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno', 'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'];
for($i=1; $i<13; $i++){
	$selected=""; $selectedStart=""; $selectedEnd=""; $selectedScan="";
	if($month == array_search($monts[$i], $monts)){$selected="selected";}
	$mmOption .= "<option value='".$i."' $selected>".$monts[$i]."</option>";
	if($monthStart == array_search($monts[$i], $monts)){$selectedStart="selected";}
	$mmOptionMonthStart .= "<option value='".$i."' $selectedStart>".$monts[$i]."</option>";
	if($monthEnd == array_search($monts[$i], $monts)){$selectedEnd="selected";}
	$mmOptionMonthEnd .= "<option value='".$i."' $selectedEnd>".$monts[$i]."</option>";
	if($monthScan == array_search($monts[$i], $monts)){$selectedScan="selected";}
	$mmOptionMonthScan .= "<option value='".$i."' $selectedScan>".$monts[$i]."</option>";
}
$yyOption="<option disabled selected value>Seleziona anno...</option>";
$yyOptionYearStart= "<option value='0'>Seleziona anno...</option>";
$yyOptionYearEnd= "<option value='0'>Seleziona anno...</option>";
$yyOptionYearScan= "<option value='0'>Seleziona anno...</option>";
for($i=1800; $i<date("Y")+1; $i++){
	$selected=""; $selectedStart=""; $selectedEnd=""; $selectedScan="";
	if($year == $i){$selected="selected";}
	$yyOption .= "<option value='".$i."' $selected>".$i."</option>";
	if($yearStart == $i){$selectedStart="selected";}
	$yyOptionYearStart .= "<option value='".$i."' $selectedStart>".$i."</option>";
	if($yearEnd == $i){$selectedEnd="selected";}
	$yyOptionYearEnd .= "<option value='".$i."' $selectedEnd>".$i."</option>";
	if($yearScan == $i){$selectedScan="selected";}
	$yyOptionYearScan .= "<option value='".$i."' $selectedScan>".$i."</option>";
}

// strings date for some manifestations
$sringaScansioneData2=""; $sringaScansioneData1="inizio";
if($id == 17){
	$sringaScansioneData2= "manifestazione cartacea";
}
if($id == 82){
	$sringaScansioneData2= "di concessione";
	$sringaScansioneData1="di sottomissione";
}

$date=	'<label for="day">Data '.$sringaScansioneData2.':</label></br>
		<select name="day" class="date-day">
		'.$ddOption.'
		</select>
		<select name="month" class="date-month">
		'.$mmOption.'
		</select>
		<select name="year" class="date-year" '.$required.'>
		'.$yyOption.'
		</select></br></br>';
		
// date starts events

$dateStart=	'<label for="day">Data '.$sringaScansioneData1.':</label></br>
		<select name="daystart" class="date-day">
		'.$ddOptionDaystart.'
		</select>
		<select name="monthstart" class="date-month">
		'.$mmOptionMonthStart.'
		</select>
		<select name="yearstart" class="date-year">
		'.$yyOptionYearStart.'
		</select></br></br>';

// date ends events

$dateEnd=	'<label for="day">Data fine:</label></br>
		<select name="dayend" class="date-day">
		'.$ddOptionDayEnd.'
		</select>
		<select name="monthend" class="date-month">
		'.$mmOptionMonthEnd.'
		</select>
		<select name="yearend" class="date-year">
		'.$yyOptionYearEnd.'
		</select></br></br>';
		
// date copy scan
$dateScan=	'<label for="day">Data scansione:</label></br>
		<select name="dayscan" class="date-day">
		'.$ddOptionDayScan.'
		</select>
		<select name="monthscan" class="date-month">
		'.$mmOptionMonthScan.'
		</select>
		<select name="yearscan" class="date-year">
		'.$yyOptionYearScan.'
		</select></br></br>';

		
		
		
//************//
//***FORM****//
//***********//
$formCamp= "<label for='form'>Forma:</label>
			<select name='digitalOrNot' id='digitalOrNot' required>
			<option disabled selected value> -- Seleziona -- </option>";
$forms= get_formDescriptionsType($conn, $id);
$selected="";
for( $i=0; $i < sizeOF($forms); $i++ ){
	if($forms[$i]['id'] == $idForm) {$selected="selected";}
	$formCamp .= "<option value='" . $forms[$i]['id'] . "' $selected>" . $forms[$i]['name'] . "</option>";
	$selected="";
}
$formCamp .= "</select> </br></br>";



//***********************//
//***GET TYPE OF FIELDS**//
//***********************//


// pubblicazione su rivista scientifica
if($id == 6){
	
	$html .= "<h2>Pubblicazione su rivista scientifica</h2>";
	
	$html .= $formCamp;

	$html .= "<label for='publicationTypeName'>Rivista:</label>
			<select name='field8' id='field8' required>
			<option disabled selected value> -- Seleziona -- </option>";

	// get all publications
	$publications= get_publications_by_levels($conn, "rivista");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field8) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca una rivista? &nbsp; <a href='../Manifestation/publications.php?publicationType=rivista&publicationTypeId=1'>Aggiungi rivista</a></small>
				
				
				</br></br>";
				
	$html .= "<label for='series'>Collana:</label>
				<select name='field7' id='field7'>
			<option disabled selected value> -- Seleziona -- </option>";
			
	// get all publications series (collane)
	$publications= get_publications_by_levels($conn, "collana");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field7) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca una collana? &nbsp; <a href='../Manifestation/publications.php?publicationType=collana&publicationTypeId=2'>Aggiungi collana</a></small>
				
				
				</br></br>";
	
	$html .= '
			<label for="journalNumber">Titolo:</label>
			<input value="'.$field1.'" type="text" id="titleR" name="field1"> </br></br>
	
			<label for="journalNumber">Numero:</label>
			<input value="'.$field2.'" type="text" id="journalNumber" name="field2"> </br></br>
			
			<label for="journalNumber">Volume:</label>
			<input value="'.$field3.'" type="text" id="volume" name="field3"> </br></br>
						
			<label for="pageNumber">Pagine:</label>
			<input value="'.$field4.'" type="text" id="pageNumber" name="field4"> </br></br>
			
			<label for="isbn">ISBN:</label>
			<input value="'.$field9.'" type="text" id="isbn" name="field9" > </br></br>
			
			'.$date.'
						
			<label for="pageNumber">Note:</label>
			<input value="'.$field5.'" type="text" id="note" name="field5"> </br></br>	
	';
			
}

// pubblicazione su periodico
if($id == 41){
	
	$html .= "<h2>Pubblicazione su periodico</h2>";
	
	$html .= $formCamp;

	$html .= "<label for='publicationTypeName'>Periodico:</label>
			<select name='field8' id='field8' required>
			<option disabled selected value> -- Seleziona -- </option>";

	// get all publications
	$publications= get_publications_by_levels($conn, "periodico");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field8) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca un periodico? &nbsp; <a href='../Manifestation/publications.php?publicationType=periodico&publicationTypeId=5'>Aggiungi periodico</a></small>
				
				
				</br></br>";
				
	$html .= "<label for='series'>Collana:</label>
				<select name='field7' id='field7'>
			<option disabled selected value> -- Seleziona -- </option>";
			
	// get all publications series (collane)
	$publications= get_publications_by_levels($conn, "collana");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field7) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca una collana? &nbsp; <a href='../Manifestation/publications.php?publicationType=collana&publicationTypeId=2'>Aggiungi collana</a></small>
				
				
				</br></br>";
	
	$html .= '
			<label for="journalNumber">Titolo:</label>
			<input value="'.$field1.'" type="text" id="titleR" name="field1"> </br></br>
	
			<label for="journalNumber">Numero:</label>
			<input value="'.$field2.'" type="text" id="journalNumber" name="field2"> </br></br>
			
			<label for="journalNumber">Volume:</label>
			<input value="'.$field3.'" type="text" id="volume" name="field3"> </br></br>
						
			<label for="pageNumber">Pagine:</label>
			<input value="'.$field4.'" type="text" id="pageNumber" name="field4"> </br></br>
			
			<label for="isbn">ISBN:</label>
			<input value="'.$field9.'" type="text" id="isbn" name="field9" > </br></br>
			
			'.$date.'
						
			<label for="pageNumber">Note:</label>
			<input value="'.$field5.'" type="text" id="note" name="field5"> </br></br>	
	';
			
}

// pubblicazione in atti di congresso
if($id == 7) {

	$html .= "<h2>Pubblicazione in atti di congresso</h2>";
	
	$html .= $formCamp;

	$html .= "<label for='atti'>Atti di congresso:</label>
			<select name='field8' id='field8' required>
			<option disabled selected value> -- Seleziona -- </option>";

	// get all publications acts
	$publications= get_publications_by_levels($conn, "atti");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field8) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Mancano degli atti di congresso? &nbsp; <a href='../Manifestation/publications.php?publicationType=atti&publicationTypeId=4'>Aggiungi atti</a></small>
				
				
				</br></br>";
				
	$html .= "<label for='series'>Collana:</label>
				<select name='field7' id='field7'>
			<option disabled selected value> -- Seleziona -- </option>";
			
	// get all publications series (collane)
	$publications= get_publications_by_levels($conn, "collana");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field7) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca una collana? &nbsp; <a href='../Manifestation/publications.php?publicationType=collana&publicationTypeId=2'>Aggiungi collana</a></small>
				
				
				</br></br>";
	
	$html .= '
			<label for="title">Titolo:</label>
			<input value="'.$field4.'" type="text" id="title" name="field4"> </br></br>
			
			<label for="Luogo">Luogo:</label>
			<input value="'.$field5.'" type="text" id="luogo" name="field5"> </br></br>
			
			<label for="numbercong">Numero congresso:</label>
			<input value="'.$field10.'" type="text" id="numbercong" name="field10"> </br></br>
			
			<label for="journalNumber">Volume:</label>
			<input value="'.$field1.'" type="text" id="volume" name="field1"> </br></br>
						
			<label for="pageNumber">Pagine:</label>
			<input value="'.$field2.'" type="text" id="pageNumber" name="field2"> </br></br>
			
			<label for="isbn">ISBN:</label>
			<input value="'.$field9.'" type="text" id="isbn" name="field9"> </br></br>
			
			'.$date.'
			'.$dateStart.'
			'.$dateEnd.'
						
			<label for="pageNumber">Note:</label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>			
	';



}


// Poster in congresso
if($id == 35) {

	$html .= "<h2>Poster in congresso</h2>";
	
	$html .= $formCamp;

	$html .= "<label for='atti'>Atto di congresso:</label>
			<select name='field8' id='field8' required>
			<option disabled selected value> -- Seleziona -- </option>";

	// get all publications acts
	$publications= get_publications_by_levels($conn, "atti");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field8) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca un atto di congresso? &nbsp; <a href='../Manifestation/publications.php?publicationType=atti&publicationTypeId=4'>Aggiungi atto</a></small>
				
				
				</br></br>";
				
	$html .= "<label for='series'>Collana:</label>
				<select name='field7' id='field7'>
			<option disabled selected value> -- Seleziona -- </option>";
			
	// get all publications series (collane)
	$publications= get_publications_by_levels($conn, "collana");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field7) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca una collana? &nbsp; <a href='../Manifestation/publications.php?publicationType=collana&publicationTypeId=2'>Aggiungi collana</a></small>
				
				
				</br></br>";
	
	$html .= '
			<label for="title">Titolo:</label>
			<input value="'.$field4.'" type="text" id="title" name="field4"> </br></br>
			
			<label for="Luogo">Luogo:</label>
			<input value="'.$field5.'" type="text" id="luogo" name="field5"> </br></br>
			
			<label for="numbercong">Numero congresso:</label>
			<input value="'.$field10.'" type="text" id="numbercong" name="field10"> </br></br>
			
			<label for="journalNumber">Volume:</label>
			<input value="'.$field1.'" type="text" id="volume" name="field1"> </br></br>
						
			<label for="pageNumber">Pagine:</label>
			<input value="'.$field2.'" type="text" id="pageNumber" name="field2"> </br></br>
			
			<label for="isbn">ISBN:</label>
			<input value="'.$field9.'" type="text" id="isbn" name="field9"> </br></br>
			
			'.$date.'
			'.$dateStart.'
			'.$dateEnd.'
						
			<label for="pageNumber">Note:</label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>			
	';



}



// intervento a congresso (partecipation congress)

if($id == 10){
	
	$html .= "<h2>Intervento a congresso</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			<label for="congressNumber">Numero congresso:</label>
			<input value="'.$field1.'" type="text" id="congressNumber" name="field1"> </br></br>
			
			<label for="participationPlace">Luogo intervento:</label>
			<input value="'.$field2.'" type="text" id="participationPlace" name="field2"> </br></br>
			
			
			<label for="isbn">Titolo congresso:</label>
			<input value="'.$field3.'" type="text" id="field3" name="field3"> </br></br>
			
			'.$date.'
			'.$dateStart.'
			'.$dateEnd.'
			
			<label for="pageNumber">Note:</label>
			<input value="'.$field4.'" type="text" id="note" name="field4"> </br></br>			
	
	';
	
}

// capitolo libro
if($id == 9){
	
	$html .= "<h2>Capitolo di un libro</h2>";
	
	$html .= $formCamp;
	
	$html .= "<label for='publicationTypeName'>Libro:</label>
			<select name='field6' id='field6'>
			<option disabled selected value> -- Seleziona -- </option>";

	// get all publications
	$publications= get_publications_by_levels($conn, "libro");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field6) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			 <small>Manca un libro? &nbsp; <a href='../Manifestation/publications.php?publicationType=libro&publicationTypeId=3'>Aggiungi libro</a></small>
			
			</br></br>";
	
	$html .= '
						
			<label for="chapter">Titolo capitolo:</label>
			<input value="'.$field1.'" type="text" id="chapter" name="field1"> </br></br>
			'.$date.'
			<label for="note">Note:</label>
			<input value="'.$field5.'" type="text" id="note" name="field5"> </br></br>
			
	
	';
	
}

// libro
if($id == 27){
	
	$html .= "<h2>Libro</h2>";
	
	$html .= $formCamp;
	
	$html .= '<label for="titolo">Titolo:</label>
			<input value="'.$field1.'" type="text" id="titolo" name="field1"> </br></br>';
	

	$html .= "<label for='series'>Collana:</label>
				<select name='field7' id='field7'>
			<option disabled selected value> -- Seleziona -- </option>";
			
	// get all publications series (collane)
	$publications= get_publications_by_levels($conn, "collana");
	$selected="";
	for( $i=0; $i < sizeOF($publications); $i++ ){
		if($publications[$i]["id"] == $field7) {$selected="selected";}
		$html .= "<option value='" . $publications[$i]["id"] . "' $selected>" . $publications[$i]["name"] . "</option>";
		$selected="";
	}
	
	$html .= "</select> 
			  <small>Manca una collana? &nbsp; <a href='../Manifestation/publications.php?publicationType=collana&publicationTypeId=2'>Aggiungi collana</a></small>
				
				
				</br></br>";
	
	$html .= '
			
			<label for="volume">Volume:</label>
			<input value="'.$field2.'" type="text" id="volume" name="field2"> </br></br>
			
			<label for="address">Luogo:</label>
			<input value="'.$field3.'" type="text" id="address" name="field3"> </br></br>
			
			<label for="edition">Edizione:</label>
			<input value="'.$field4.'" type="text" id="edition" name="field4"> </br></br>
			
			<label for="isbn">ISBN:</label>
			<input value="'.$field9.'" type="text" id="isbn" name="field9"> </br></br>
			
			'.$date.'
			
			<label for="note">Note:</label>
			<input value="'.$field5.'" type="text" id="note" name="field5"> </br></br>
	
	';
	
}

// Intervento evento
if($id == 11){
	
	
	$html .= "<h2>Intervento a evento</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="publicationPlace">Luogo evento:</label>
			<input value="'.$field1.'" type="text" id="field1" name="field1"> </br></br>
			
			<label for="isbn">Titolo evento:</label>
			<input value="'.$field2.'" type="text" id="field2" name="field2"> </br></br>
			
			'.$date.'
			'.$dateStart.'
			'.$dateEnd.'
			
			<label for="note">Note:</label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>

	
	';
		
	
}

// Intervento in seminario
if($id == 67){
	
	
	$html .= "<h2>Intervento in Seminario</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="publicationPlace">Luogo:</label>
			<input value="'.$field1.'" type="text" id="field1" name="field1"> </br></br>
			
			<label for="isbn">Titolo:</label>
			<input value="'.$field2.'" type="text" id="field2" name="field2"> </br></br>
			
			'.$date.'
			
			<label for="note">Note:</label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>

	
	';
		
	
}

// Lezione
if($id == 79){
	
	
	$html .= "<h2>Lezione</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="publicationPlace">Luogo:</label>
			<input value="'.$field1.'" type="text" id="field1" name="field1"> </br></br>
			
			<label for="isbn">Titolo:</label>
			<input value="'.$field2.'" type="text" id="field2" name="field2"> </br></br>
			
			<label for="isbn">Corso:</label>
			<input value="'.$field4.'" type="text" id="field4" name="field4"> </br></br>
			
			'.$date.'
			
			<label for="note">Note:</label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>

	
	';
		
	
}

// Tesi
if($id == 18){
	
	
	$html .= "<h2>Tesi</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>
			
			<label for="school">Scuola: </label>
			<input value="'.$field2.'" type="text" id="school" name="field2"> </br></br>
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>

	
	';
		
	
}


// Rapporto tecnico
if($id == 19){
	
	
	$html .= "<h2>Rapporto tecnico</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>
			
			<label for="title">Numero:</label>
			<input value="'.$field3.'" type="text" id="title" name="field3"> </br></br>
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Documentazione
if($id == 20){
	
	
	$html .= "<h2>Documentazione</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Inedito
if($id == 25){
	
	
	$html .= "<h2>Inedito</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Altro
if($id == 26){
	
	
	$html .= "<h2>Altro</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Immagine
if($id == 23){
	
	
	$html .= "<h2>Immagine</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>
			
			<label for="title">Risoluzione:</label>
			<input value="'.$field2.'" type="text" id="title" name="field2"> </br></br>
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>

	
	';
		
	
}

// Foto
if($id == 24){
	
	
	$html .= "<h2>Foto</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>
			
			<label for="title">Risoluzione:</label>
			<input value="'.$field2.'" type="text" id="title" name="field2"> </br></br>
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>

	
	';
		
	
}

// Lettera
if($id == 22){
	
	
	$html .= "<h2>Lettera</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Trascrizione
/* if($id == 21){
	
	
	$html .= "<h2>Trascrizione</h2>";
	
	$html .= '
			
			<label for="title">Nome:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
} */

// Copia
if($id == 17){
	
	
	$html .= "<h2>Copia</h2>";
	
	$html .= $formCamp;
	
/* 	$html .= '
			
			<label for="title">Nome:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			'.$dateScan.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	'; */
	
	$html .= '

			
			'.$date.'
			'.$dateScan.'
			


	
	';
		
	
}

// Archiviazione pubblica
if($id == 37){
	
	
	$html .= "<h2>Archiviazione pubblica</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Installazione
if($id == 38){
	
	
	$html .= "<h2>Installazione</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Luogo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			'.$dateStart.'
			'.$dateEnd.'
			
			<label for="note">Materiale: </label>
			<input value="'.$field3.'" type="text" id="note" name="field3"> </br></br>
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// White paper (Edito in proprio)
if($id == 51){
	
	
	$html .= "<h2>Edito in proprio</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Social
if($id == 42){
	
	
	$html .= "<h2>Social</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Blog
if($id == 43){
	
	
	$html .= "<h2>Blog</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Forum
if($id == 44){
	
	
	$html .= "<h2>Forum</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Video
if($id == 59){
	
	
	$html .= "<h2>Forum</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="title">Durata:</label>
			<input value="'.$field3.'" type="text" id="duration" name="field3"> </br></br>
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// pagina web
if($id == 80){
	
	
	$html .= "<h2>Pagina web</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="title">Ambito:</label>
			<input value="'.$field3.'" type="text" id="duration" name="field3"> </br></br>
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}

// Certificato
if($id == 82){
	
	
	$html .= "<h2>Certificato</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			
			<label for="title">Numero:</label>
			<input value="'.$field2.'" type="text" id="duration" name="field2"> </br></br>
			
			'.$date.'
			'.$dateStart.'
			
			
			<label for="note">Note: </label>
			<input value="'.$field5.'" type="text" id="note" name="field5"> </br></br>

	
	';
		
	
}

// audio
if($id == 91){
	
	
	$html .= "<h2>Audio</h2>";
	
	$html .= $formCamp;
	
	$html .= '
			
			<label for="title">Titolo:</label>
			<input value="'.$field1.'" type="text" id="title" name="field1"> </br></br>	
			
			'.$date.'
			
			<label for="title">Durata:</label>
			<input value="'.$field3.'" type="text" id="duration" name="field3"> </br></br>
			
			<label for="note">Note: </label>
			<input value="'.$field2.'" type="text" id="note" name="field2"> </br></br>

	
	';
		
	
}



// array json
$arrayJson= array( "html" => $html );		
$data= json_encode($arrayJson);
echo $data;




?>