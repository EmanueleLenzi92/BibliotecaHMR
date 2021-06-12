<?php
function updateWork($conn, $id, $title, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){

	// update data
	$sql= "UPDATE work SET title = '".$title."' WHERE id = " . $id;
	$result = mysqli_query($conn, $sql);
	
	// delete old people
	$sql="DELETE FROM workresponsability WHERE idlevel = " . $id . " and idinstitution = 0";
	$result = mysqli_query($conn, $sql);
	
	// delete old instit
	$sql="DELETE FROM workresponsability WHERE idlevel = " . $id . " and idpeople = 0";
	$result = mysqli_query($conn, $sql);
	
	// insert new people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO workresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$id','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);

	}

	// insert new institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO workresponsability (idlevel, idinstitution, Idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$id','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}	

}

function updateExpression($conn, $id, $idWork, $title, $type, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){
	
	// update data
	$sql= "UPDATE expression SET title = '".$title."', idwork = '".$idWork."', type = '".$type."' WHERE id = " . $id;
	$result = mysqli_query($conn, $sql);
	
	// delete old people
	$sql="DELETE FROM expressionresponsability WHERE idlevel = " . $id . " and idinstitution = 0";
	$result = mysqli_query($conn, $sql);
	
	// delete old instit
	$sql="DELETE FROM expressionresponsability WHERE idlevel = " . $id . " and idpeople = 0";
	$result = mysqli_query($conn, $sql);
	
	// insert new people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO expressionresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$id','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);
		
	}

	// insert new institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO expressionresponsability (idlevel, idinstitution, Idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$id','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}	

}

function updateExpressionType($conn, $id, $name, $level){

	$sql= "UPDATE descriptionlevel SET name = '".$name."', level = '".$level."' WHERE id = " . $id;
	$result = mysqli_query($conn, $sql);
}

function updateManifestation($conn, $id, $idWork, $idExpression, $title, $form, $idItem, $type, $originalType, $field1, $field2, $field3, $field4, $field5, $field6, $field7, $field8, $field9, $field10, $day, $month, $year, $dayStart, $monthStart, $yearStart, $dayEnd, $monthEnd, $yearEnd, $dayScan, $monthScan, $yearScan, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){

	// update data
	$sql= "UPDATE manifestation SET idwork = '".$idWork."', idexpression= '".$idExpression."', title= '".$title."', form= '".$form."', 
			iditem= '".$idItem."', type= '".$type."' WHERE id = " .$id;
	$result = mysqli_query($conn, $sql);
	
	// update field
	$sql= "UPDATE manifestationfield SET iddescriptionlevel= '".$type."', iddescriptionleveloriginal= '".$originalType."', idform= '".$form."', field1= '".$field1."', field2= '".$field2."', 
			field3= '".$field3."', field4= '".$field4."', field5= '".$field5."', field6= '".$field6."', field7= '".$field7."',
			field8= '".$field8."', field9= '".$field9."', field10= '".$field10."', day= '".$day."', month= '".$month."', year= '".$year."', 
			daystart= '".$dayStart."', monthstart= '".$monthStart."', yearstart= '".$yearStart."',
			dayend= '".$dayEnd."', monthend= '".$monthEnd."', yearend= '".$yearEnd."',
			dayscan= '".$dayScan."', monthscan= '".$monthScan."', yearscan= '".$yearScan."'
			WHERE idmanifestation = " .$id;
	$result = mysqli_query($conn, $sql);
	
	// delete old people
	$sql="DELETE FROM manifestationresponsability WHERE idlevel = " . $id . " and idinstitution = 0";
	$result = mysqli_query($conn, $sql);
	
	// delete old instit
	$sql="DELETE FROM manifestationresponsability WHERE idlevel = " . $id . " and idpeople = 0";
	$result = mysqli_query($conn, $sql);
	
	// insert new people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO manifestationresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$id','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);

	}

	// insert new institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO manifestationresponsability (idlevel, idinstitution, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$id','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}
	
}


function updateItem($conn, $id, $idWork, $title, $urlFile, $nameFile, $capability, $extLink, $idManifestation, $note, $dayvisited, $monthvisited, $yearvisited, $idPeople, $idRespPeople, $idInstitut, $idRespInstit){
	
	// update data
	$sql= "UPDATE item SET idwork= '".$idWork."', title= '".$title."', fileurl= '".$urlFile."', filename= '".$nameFile."', capability= '".$capability."', extlink= '".$extLink."', idmanifestation= '".$idManifestation."', note= '".$note."', dayvisited= '".$dayvisited."', monthvisited= '".$monthvisited."', yearvisited= '".$yearvisited."'   WHERE id = " . $id;
	$result = mysqli_query($conn, $sql);
	
	// delete old people
	$sql="DELETE FROM itemresponsability WHERE idlevel = " . $id . " and idinstitution = 0";
	$result = mysqli_query($conn, $sql);
	
	// delete old instit
	$sql="DELETE FROM itemresponsability WHERE idlevel = " . $id . " and idpeople = 0";
	$result = mysqli_query($conn, $sql);

	// insert new people
	if(!empty($idPeople)){
		$query_insertPeople= "INSERT INTO itemresponsability (idlevel, idpeople, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idPeople); $i++){
			$valori[] = "('$id','$idPeople[$i]','$idRespPeople[$i]')";
		}
		$query_insertPeople .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertPeople);

	}

	// insert new institutions
	if(!empty($idInstitut)){
		$query_insertInstit= "INSERT INTO itemresponsability (idlevel, idinstitution, idresponsability) VALUES ";
		$valori= array();
		for($i= 0; $i < count($idInstitut); $i++){
			$valori[] = "('$id','$idInstitut[$i]','$idRespInstit[$i]')";
		}
		$query_insertInstit .= join(', ', $valori);
		$result = mysqli_query($conn, $query_insertInstit);

	}

}


function updatePeople($conn, $id, $name, $surname, $brief, $pseudonymOf){

	$sql= "UPDATE people SET name = '".$name."', forname = '".$surname."', brief = '".$brief."', pseudonymOf = '".$pseudonymOf."' WHERE id = " . $id;
	$result = mysqli_query($conn, $sql);

}

function updateInstitution($conn, $id, $name, $link){

	$sql= "UPDATE institution SET name = '".$name."', link= '".$link."' WHERE id = " . $id;
	$result = mysqli_query($conn, $sql);

}

function updateResponsabilityType($conn, $id, $name, $level){

		$sql= "UPDATE responsability SET name = '".$name."', level = '".$level."' WHERE id = " . $id;
		$result = mysqli_query($conn, $sql);
}

function updatePublication($conn, $id, $name, $type){
	
		$sql= "UPDATE publications SET name= '".$name."', idtype= '".$type."' where id = " . $id;
		$result = mysqli_query($conn, $sql);
	
}

//*********//
//COLLECTION//
//*********//

function updateCollection($conn, $id, $name, $brief, $ordering, $idUser){
	
	$sql= "UPDATE collection SET name= '".$name."', brief= '".$brief."', ordering= '".$ordering."', iduser= '".$idUser."'  where id = " . $id;
	$result = mysqli_query($conn, $sql);
	
}

?>