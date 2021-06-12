<?php

								            //**************array of int**********************//
function insertWork($conn, $title, $idUser, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){
	
	
	// insert data
	$sql= "INSERT INTO work (title, iduser) VALUES ('".$title."', '".$idUser."')";;
	$result = mysqli_query($conn, $sql);
	
	// get id of this expression
	$this_id_work = mysqli_insert_id($conn);
	
	// insert people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO workresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$this_id_work','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);

	}

	// insert institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO workresponsability (idlevel, idinstitution, Idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$this_id_work','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}	


}



function insertExpression($conn, $idWork, $title, $type, $idUser, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){
	
	
	// insert data
	$sql= "INSERT INTO expression (idwork, title, type, iduser)
			VALUES ('".$idWork."', '".$title."', '".$type."', '".$idUser."')";
	$result = mysqli_query($conn, $sql);
	
	
	// get id of this expression
	$this_id_expression = mysqli_insert_id($conn);
	
	// insert people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO expressionresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$this_id_expression','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);
		
	}

	// insert institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO expressionresponsability (idlevel, idinstitution, Idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$this_id_expression','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}	
	

}


function insertExpressionType($conn, $name, $level){
		
	$sql= "INSERT INTO descriptionlevel (name, level) VALUES ('".$name."', '".$level."')";
	$result = mysqli_query($conn, $sql);

}



function insertManifestation($conn, $idUser, $idWork, $idExpression, $title, $form, $idItem, $type, $originalType, $field1, $field2, $field3, $field4, $field5, $field6, $field7, $field8, $field9, $field10, $day, $month, $year, $dayStart, $monthStart, $yearStart, $dayEnd, $monthEnd, $yearEnd, $dayScan, $monthScan, $yearScan, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){
	
	
	// insertmanifestation data
	$sql= "INSERT INTO manifestation (idwork, idexpression, title, form, iditem, type, iduser)
			VALUES ('".$idWork."', '".$idExpression."', '".$title."', '".$form."', '".$idItem."', '".$type."', '".$idUser."')";
	$result = mysqli_query($conn, $sql);
	
	// get id of this expression
	$this_id_manifestatio = mysqli_insert_id($conn);
	
	// insert manifestation field1
	$sql= "INSERT INTO manifestationfield (idmanifestation, iddescriptionlevel, iddescriptionleveloriginal, idform, field1, field2, field3, field4, field5, field6, field7, field8, field9, field10, day, month, year, daystart, monthstart, yearstart, dayend, monthend, yearend, dayscan, monthscan, yearscan)
			VALUES ('".$this_id_manifestatio."', '".$type."', '".$originalType."', '".$form."', '".$field1."', '".$field2."', '".$field3."', '".$field4."', '".$field5."', '".$field6."', '".$field7."', '".$field8."', '".$field9."', '".$field10."', '".$day."', '".$month."', '".$year."', '".$dayStart."','".$monthStart."','".$yearStart."','".$dayEnd."','".$monthEnd."','".$yearEnd."', '".$dayScan."', '".$monthScan."', '".$yearScan."')";
	$result = mysqli_query($conn, $sql);
	
	// insert people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO manifestationresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$this_id_manifestatio','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);

	}

	// insert institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO manifestationresponsability (idlevel, idinstitution, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$this_id_manifestatio','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}	


}


function insertItem($conn, $idUser, $idWork, $title, $fileurl, $fileName, $capability, $extLink, $idManifestation, $note, $dayvisited, $monthvisited, $yearvisited, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){

	
	// insert data
	$sql= "INSERT INTO item (idwork, title, fileurl, filename, capability, extlink, idmanifestation, note, dayvisited, monthvisited, yearvisited, iduser)
			VALUES ('".$idWork."', '".$title."', '".$fileurl."', '".$fileName."', '".$capability."', '".$extLink."', '".$idManifestation."', '".$note."', '".$dayvisited."', '".$monthvisited."', '".$yearvisited."', '".$idUser."')";
	$result = mysqli_query($conn, $sql);


	// get id of this item
	$this_id_item = mysqli_insert_id($conn);

	// insert people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO itemresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$this_id_item','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);

	}

	// insert institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO itemresponsability (idlevel, idinstitution, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$this_id_item','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}	

}


function insertPeople($conn, $name, $surname, $brief, $pseudonymOf){

		$sql= "INSERT INTO people (name, forname, brief, pseudonymOf) VALUES ('".$name."', '".$surname."', '".$brief."', '".$pseudonymOf."')";
		$result = mysqli_query($conn, $sql);

}

function insertInstitution($conn, $name, $link){

		$sql= "INSERT INTO institution (name, link) VALUES ('".$name."', '".$link."')";
		$result = mysqli_query($conn, $sql);
}

function insertResponsabilityType($conn, $name, $level){

		$sql= "INSERT INTO responsability (name, level) VALUES ('".$name."', '".$level."')";
		$result = mysqli_query($conn, $sql);
}

function insertPublication($conn, $name, $type){
	
		$sql= "INSERT INTO publications (name, idtype) VALUES ('".$name."', '".$type."')";
		$result = mysqli_query($conn, $sql);
	
}


//**********//
//COLLECTION//
//*********//

function insertCollection($conn, $name, $brief, $ordering, $idUser){

	$sql= "INSERT INTO collection (name, brief, ordering, iduser) VALUES ('".$name."', '".$brief."', '".$ordering."', '".$idUser."')";
	$result = mysqli_query($conn, $sql);


}

function insertItemsInCollection($conn, $idCollection, $idItems, $idManif, $positionItems, $positionManif, $ordering){
	
	//delete old items
	$sql="DELETE FROM collectionitems WHERE idcollection = " . $idCollection;
	$result = mysqli_query($conn, $sql);
	
	// insert news items
	if($idItems != "" ){
	$query_insertItems= "INSERT INTO collectionitems (idcollection, iditem, position) VALUES ";
	$valori= array();
	for($i= 0; $i < count($idItems); $i++){
		$valori[] = "('$idCollection','$idItems[$i]','$positionItems[$i]')";
	}
	$query_insertItems .= join(', ', $valori);
	$result = mysqli_query($conn, $query_insertItems);
	}
	
	// insert news Manif
	if($idManif != ""){
	$query_insertItems= "INSERT INTO collectionitems (idcollection, idmanifestation, position) VALUES ";
	$valori= array();
	for($i= 0; $i < count($idManif); $i++){
		$valori[] = "('$idCollection','$idManif[$i]','$positionManif[$i]')";
	}
	$query_insertItems .= join(', ', $valori);
	$result = mysqli_query($conn, $query_insertItems);
	}
	
	// insert order of collection
	$sql= "UPDATE collection SET ordering= '".$ordering."' where id = " . $idCollection;
	$result = mysqli_query($conn, $sql);

}

?>