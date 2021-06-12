<?php

//**************//
//***WORK*******//
//**************//


//Get all works. If pass id, get that work
function get_works($conn, $id=null){
	
	
	if(isset($id)) {
		$where= " where id = " . $id;
	} else $where= "";
	
	$work= [];
	$allWorks= [];
	$sql= "select * from work" . $where;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$work ['id'] = $row["id"];
		$work ['title'] = $row["title"];
		$work ['iduser'] = $row["iduser"];
		array_push($allWorks, $work);
		
	}
	
	return $allWorks;

}

// get works of a user
function get_works_by_user($conn, $idUser){
	
	
	$work= [];
	$allWorks= [];
	$sql= "select * from work where iduser =" . $idUser;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$work ['id'] = $row["id"];
		$work ['title'] = $row["title"];
		array_push($allWorks, $work);
		
	}
	
	return $allWorks;

}
                                                 

// get all works that have this idPeople or this idInstitution; ($id= array of ids; $peopleInstitucionString= string: people/insitution) 											
function get_work_by_responsability($conn, $id, $peopleInstitucionString= "people"){

	if($peopleInstitucionString == "people"){
		$Tosearch= "idpeople";
	} else if($peopleInstitucionString == "instituction"){
		$Tosearch= "idinstitution";
	}
	
	$work=[];
	$allworks= [];

	if (sizeOf($id) == 0){

		$sql= "
			SELECT people.brief as persBrief, institution.name as istitutEspr, work.title, work.id
           FROM work
		   LEFT JOIN workresponsability ON work.id = workresponsability.idlevel 
		   LEFT JOIN people ON workresponsability.idpeople = people.id
		   LEFT JOIN institution ON workresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = workresponsability.idresponsability
		   ";
	
	}


	if ((sizeOf($id) > 1) or (sizeOf($id) == 1)){
		
		$sql= "SELECT people.Brief as persBrief, institution.name as istitutEspr, work.title, work.id
           FROM work
		   LEFT JOIN workresponsability ON work.id = workresponsability.idlevel 
		   LEFT JOIN people ON workresponsability.idpeople = people.id
		   LEFT JOIN institution ON workresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = workresponsability.idresponsability
		   WHERE workresponsability.". $Tosearch. " in (";
		   
		$valori= array();
		for($i= 0; $i < count($id); $i++){
			$valori[] = $id[$i];
		}
		
		$sql .= join(', ', $valori) . ") group by work.title, work.id having count(*) = " . sizeOf($id);

		   
	}
	
	$result = mysqli_query($conn, $sql);

	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$work ['persBrief'] = $row["persBrief"];
		$work ['istitutEspr'] = $row["istitutEspr"];
		$work ['title'] = $row["title"];
		$work ['id'] = $row["id"];
		array_push($allworks, $work);
		
	}
	
	return $allworks;

}

// get all people and all institutions together of a work. ($id= work id)
function get_responsabilityWork($conn, $id, $oneRow=false){
	
	
	if($oneRow == true){
		$selectPeopleBrief= "GROUP_CONCAT(DISTINCT(people.Brief) SEPARATOR ', ')";
		$selectInstitutionName= "GROUP_CONCAT(DISTINCT(institution.name) SEPARATOR ', ')";
	} else {
		$selectPeopleBrief = "people.brief";
		$selectInstitutionName= "institution.name";
	}
	
	$resp= [];
	$allResp= [];
	$sql= "SELECT " . $selectPeopleBrief . " as persBrief, " . $selectInstitutionName . " as istitutEspr, responsability.name as resp, people.id as idPeople, institution.id as idInstitution
           FROM work
		   LEFT JOIN workresponsability ON work.id = workresponsability.idlevel 
		   LEFT JOIN people ON workresponsability.idpeople = people.id
		   LEFT JOIN institution ON workresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = workresponsability.idresponsability
		   WHERE work.id = " . $id;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$resp ['persBrief'] = $row["persBrief"];
		$resp ['persBrief'] = $row["persBrief"];
		$resp ['istitutEspr'] = $row["istitutEspr"];
		$resp ['resp'] = $row["resp"];
		array_push($allResp, $resp);
		
	}
	
	return $allResp;
}

// get only all people of a work
function get_people_by_work($conn, $idWork){
	
	$people= [];
	$allPeople= [];
	
	$sql= "SELECT people.brief as peopleBrief, people.name as peopleName, people.forname as peopleSurname, responsability.name as respName, 
			people.id as idPeople, responsability.id as idResp
           FROM work
		   JOIN workresponsability ON work.id = workresponsability.idlevel 
		   JOIN people ON workresponsability.idpeople = people.id
		   JOIN responsability ON responsability.id = workresponsability.idresponsability
		   WHERE work.id = " . $idWork;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$people ['peopleBrief'] = $row["peopleBrief"];
		$people ['peopleName'] = $row["peopleName"];
		$people ['peopleSurname'] = $row["peopleSurname"];
		$people ['respName'] = $row["respName"];
		$people ['idPeople'] = $row["idPeople"];
		$people ['idResp'] = $row["idResp"];
		array_push($allPeople, $people);
		
	}
	
	return $allPeople;

}

// get only all institutions of a work
function get_institutions_by_work($conn, $idWork){
	$institution=[];
	$allInstitution=[];
	
	$sql= "SELECT institution.name as istitutName, responsability.name as respName, institution.id as idInstitution, responsability.id as idResp
           FROM work
		   JOIN workresponsability ON work.id = workresponsability.idlevel 
		   JOIN institution ON workresponsability.idinstitution = institution.id
		   JOIN responsability ON responsability.id = workresponsability.idresponsability
		   WHERE work.id = " . $idWork;
	
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$institution ['istitutName'] = $row["istitutName"];
		$institution ['respName'] = $row["respName"];
		$institution ['idInstitution'] = $row["idInstitution"];
		$institution ['idResp'] = $row["idResp"];
		array_push($allInstitution, $institution);
		
	}
	
	return $allInstitution;
	
}


//**************//
//**EXPRESSION**//
//**************//

//Get all expressions. If pass id, get that expression
function get_expressions($conn, $id= null){
	
	
	if(isset($id)) {
		$where= " where e.id = " . $id;
	} else $where= "";
	
	$expression= [];
	$allExpressions= [];
	$sql= "select e.id, e.title, e.type, e.idwork, descriptionlevel.name as typeName
		   from expression as e
		   left join descriptionlevel ON descriptionlevel.id = e.type " . $where;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$expression ['id'] = $row["id"];
		$expression ['title'] = $row["title"];
		$expression ['type'] = $row["type"];
		$expression ['typeName'] = $row["typeName"];
		$expression ['idwork'] = $row["idwork"];
		array_push($allExpressions, $expression);
		
	}
	
	return $allExpressions;

}

//Get all expressions by id user
function get_expressions_by_user($conn, $idUser){
	
	
	$expression= [];
	$allExpressions= [];
	$sql= "select e.id, e.title, e.type, e.idwork, descriptionlevel.name as typeName
		   from expression as e
		   left join descriptionlevel ON descriptionlevel.id = e.type 
		   where e.iduser = " . $idUser;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$expression ['id'] = $row["id"];
		$expression ['title'] = $row["title"];
		$expression ['type'] = $row["type"];
		$expression ['typeName'] = $row["typeName"];
		$expression ['idwork'] = $row["idwork"];
		array_push($allExpressions, $expression);
		
	}
	
	return $allExpressions;

}

//Get all expressions by that idWork
function get_expressions_by_idWork($conn, $idWork){
	
	
	$expressionWithSameWork= [];
	$allExpressions= [];
	$sql= "select e.id, e.title, e.type, e.idwork, descriptionlevel.name as typeName, e.iduser
		   from expression as e
		   left join descriptionlevel ON descriptionlevel.id = e.type where e.idWork = " . $idWork;
	$result = mysqli_query($conn, $sql);

	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$expressionWithSameWork ['id'] = $row["id"];
		$expressionWithSameWork ['title'] = $row["title"];
		$expressionWithSameWork ['type'] = $row["type"];
		$expressionWithSameWork ['typeName'] = $row["typeName"];
		$expressionWithSameWork ['idwork'] = $row["idwork"];
		$expressionWithSameWork ['iduser'] = $row["iduser"];
		array_push($allExpressions, $expressionWithSameWork);
		
	}
	
	return $allExpressions;

}


// get all expressions that have this idPeople or this idInstitution; ($id= array of ids; $peopleInstitucionString= string: people/insitution) 
function get_expressions_by_responsability($conn, $id, $peopleInstitucionString= "people"){

	if($peopleInstitucionString == "people"){
		$Tosearch= "idpeople";
	} else if($peopleInstitucionString == "instituction"){
		$Tosearch= "idinstitution";
	}
	
	$expression=[];
	$allexpressions= [];

	if (sizeOf($id) == 0){

		$sql= "
			SELECT people.Brief as persBrief, institution.name as istitutEspr, responsability.name as resp, expression.title, expression.id, expression.idwork
           FROM expression
		   LEFT JOIN expressionresponsability ON expression.id = expressionresponsability.idlevel 
		   LEFT JOIN people ON expressionresponsability.idpeople = people.id
		   LEFT JOIN institution ON expressionresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = expressionresponsability.idresponsability
		   ";
	
	}


	if ((sizeOf($id) > 1) or (sizeOf($id) == 1)){
		
		$sql= "SELECT people.Brief as persBrief, institution.name as istitutEspr, responsability.name as resp, expression.title, expression.id, expression.idwork, descriptionlevel.name as typeName
           FROM expression
		   LEFT JOIN expressionresponsability ON expression.id = expressionresponsability.idlevel 
		   LEFT JOIN people ON expressionresponsability.idpeople = people.id
		   LEFT JOIN institution ON expressionresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = expressionresponsability.idresponsability
		   LEFT JOIN descriptionlevel ON descriptionlevel.id = expression.type
		   WHERE expressionresponsability.". $Tosearch. " in (";
		   
		$valori= array();
		for($i= 0; $i < count($id); $i++){
			$valori[] = $id[$i];
		}
		
		$sql .= join(', ', $valori) . ") group by expression.title, expression.id having count(*) = " . sizeOf($id);

		   
	}
	
	$result = mysqli_query($conn, $sql);

	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$expression ['persBrief'] = $row["persBrief"];
		$expression ['istitutEspr'] = $row["istitutEspr"];
		$expression ['title'] = $row["title"];
		$expression ['id'] = $row["id"];
		$expression ['idwork'] = $row["idwork"];
		$expression ['typeName'] = $row["typeName"];
		array_push($allexpressions, $expression);
		
	}
	
	return $allexpressions;

}


// get all people and all institutions together of a expression ($id= expr id)
function get_responsabilityExpression($conn, $id, $oneRow= false){
	
	
	if($oneRow == true){
		$selectPeopleBrief= "GROUP_CONCAT(DISTINCT(people.Brief) SEPARATOR ', ')";
		$selectInstitutionName= "GROUP_CONCAT(DISTINCT(institution.name) SEPARATOR ', ')";
	} else {
		$selectPeopleBrief = "people.brief";
		$selectInstitutionName= "institution.name";
	}
	
	$resp= [];
	$allResp= [];
	$sql= "SELECT " . $selectPeopleBrief . " as persBrief, " . $selectInstitutionName . " as istitutEspr, responsability.name as resp
           FROM expression
		   LEFT JOIN expressionresponsability ON expression.id = expressionresponsability.idlevel 
		   LEFT JOIN people ON expressionresponsability.idpeople = people.id
		   LEFT JOIN institution ON expressionresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = expressionresponsability.idresponsability
		   WHERE expression.id = " . $id;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$resp ['persBrief'] = $row["persBrief"];
		$resp ['istitutEspr'] = $row["istitutEspr"];
		$resp ['resp'] = $row["resp"];
		array_push($allResp, $resp);
		
	}
	
	return $allResp;

}


// get only all people of a expression
function get_people_by_expression($conn, $idExpr){
	
	$people= [];
	$allPeople= [];
	
	$sql= "SELECT people.brief as peopleBrief, people.name as peopleName, people.forname as peopleSurname, responsability.name as respName, 
			people.id as idPeople, responsability.id as idResp
           FROM expression
		   JOIN expressionresponsability ON expression.id = expressionresponsability.idlevel 
		   JOIN people ON expressionresponsability.idpeople = people.id
		   JOIN responsability ON responsability.id = expressionresponsability.idresponsability
		   WHERE expression.id = " . $idExpr;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$people ['peopleBrief'] = $row["peopleBrief"];
		$people ['peopleName'] = $row["peopleName"];
		$people ['peopleSurname'] = $row["peopleSurname"];
		$people ['respName'] = $row["respName"];
		$people ['idPeople'] = $row["idPeople"];
		$people ['idResp'] = $row["idResp"];
		array_push($allPeople, $people);
		
	}
	
	return $allPeople;

}

// get only all institutions of a expression
function get_institutions_by_expression($conn, $idExpr){
	$institution=[];
	$allInstitution=[];
	
	$sql= "SELECT institution.name as istitutName, responsability.name as respName, institution.id as idInstitution, responsability.id as idResp
           FROM expression
		   JOIN expressionresponsability ON expression.id = expressionresponsability.idlevel 
		   JOIN institution ON expressionresponsability.idinstitution = institution.id
		   JOIN responsability ON responsability.id = expressionresponsability.idresponsability
		   WHERE expression.id = " . $idExpr;
	
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$institution ['istitutName'] = $row["istitutName"];
		$institution ['respName'] = $row["respName"];
		$institution ['idInstitution'] = $row["idInstitution"];
		$institution ['idResp'] = $row["idResp"];
		array_push($allInstitution, $institution);
		
	}
	
	return $allInstitution;
	
}


//****************//
//*****ITEM******//
//***************//

function get_items($conn, $id=null){
	
	
	if(isset($id)) {
		$where= " where id = " . $id;
	} else $where= "";
	
	$item= [];
	$allitems= [];
	$sql= "select * from item" . $where;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$item ['id'] = $row["id"];
		$item ['idmanifestation'] = $row["idmanifestation"];
		$item ['idwork'] = $row["idwork"];
		$item ['title'] = $row["title"];
		$item ['fileurl'] = $row["fileurl"];
		$item ['filename'] = $row["filename"];
		$item ['capability'] = $row["capability"];
		$item ['extlink'] = $row["extlink"];
		$item ['note'] = $row["note"];
		$item ['monthvisited'] = $row["monthvisited"];
		$item ['yearvisited'] = $row["yearvisited"];
		$item ['dayvisited'] = $row["dayvisited"];
		array_push($allitems, $item);
		
	}
	
	return $allitems;
}


function get_items_by_user($conn, $idUser){
	

	$item= [];
	$allitems= [];
	$sql= "select * from item where iduser = " . $idUser;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$item ['id'] = $row["id"];
		$item ['idmanifestation'] = $row["idmanifestation"];
		$item ['idwork'] = $row["idwork"];
		$item ['title'] = $row["title"];
		$item ['fileurl'] = $row["fileurl"];
		$item ['filename'] = $row["filename"];
		$item ['capability'] = $row["capability"];
		$item ['extlink'] = $row["extlink"];
		$item ['note'] = $row["note"];
		$item ['monthvisited'] = $row["monthvisited"];
		$item ['yearvisited'] = $row["yearvisited"];
		$item ['dayvisited'] = $row["dayvisited"];
		array_push($allitems, $item);
		
	}
	
	return $allitems;
}


function get_items_by_idWork($conn, $idWork){
	
	
	$item= [];
	$allitems= [];
	$sql= "select * from item where idwork = " . $idWork;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$item ['id'] = $row["id"];
		$item ['idwork'] = $row["idwork"];
		$item ['idmanifestation'] = $row["idmanifestation"];
		$item ['title'] = $row["title"];
		$item ['fileurl'] = $row["fileurl"];
		$item ['filename'] = $row["filename"];
		$item ['capability'] = $row["capability"];
		$item ['extlink'] = $row["extlink"];
		$item ['note'] = $row["note"];
		$item ['iduser'] = $row["iduser"];
		array_push($allitems, $item);
		
	}
	
	return $allitems;
}


function get_item_by_responsability($conn, $id, $peopleInstitucionString= "people"){

	if($peopleInstitucionString == "people"){
		$Tosearch= "idpeople";
	} else if($peopleInstitucionString == "instituction"){
		$Tosearch= "idinstitution";
	}
	
	$item=[];
	$allitems= [];

	if (sizeOf($id) == 0){

		$sql= "
			SELECT people.Brief as persBrief, institution.name as istitutEspr, responsability.name as resp, item.title, item.id, item.filename, item.capability, item.extlink
           FROM item
		   LEFT JOIN itemresponsability ON item.id = itemresponsability.idlevel 
		   LEFT JOIN people ON itemresponsability.idpeople = people.id
		   LEFT JOIN institution ON itemresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = itemresponsability.idresponsability
		   ";
	
	}


	if ((sizeOf($id) > 1) or (sizeOf($id) == 1)){
		
		$sql= "SELECT people.Brief as persBrief, institution.name as istitutEspr, responsability.name as resp, item.title, item.id, item.idwork, item.idmanifestation,
				item.filename, item.capability, item.extlink
           FROM item
		   LEFT JOIN itemresponsability ON item.id = itemresponsability.idlevel 
		   LEFT JOIN people ON itemresponsability.idpeople = people.id
		   LEFT JOIN institution ON itemresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = itemresponsability.idresponsability
		   WHERE itemresponsability.". $Tosearch. " in (";
		   
		$valori= array();
		for($i= 0; $i < count($id); $i++){
			$valori[] = $id[$i];
		}
		
		$sql .= join(', ', $valori) . ") group by item.title, item.id having count(*) = " . sizeOf($id);

		   
	}
	
	$result = mysqli_query($conn, $sql);

	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$item ['persBrief'] = $row["persBrief"];
		$item ['istitutEspr'] = $row["istitutEspr"];
		$item ['title'] = $row["title"];
		$item ['id'] = $row["id"];
		$item ['idwork'] = $row["idwork"];
		$item ['idmanifestation'] = $row["idmanifestation"];
		$item ['filename'] = $row["filename"];
		$item ['capability'] = $row["capability"];
		$item ['extlink'] = $row["extlink"];
		array_push($allitems, $item);
		
	}
	
	return $allitems;

}


function get_responsabilityItem($conn, $id, $oneRow=false){
	
	
	if($oneRow == true){
		$selectPeopleBrief= "GROUP_CONCAT(DISTINCT(people.Brief) SEPARATOR ', ')";
		$selectInstitutionName= "GROUP_CONCAT(DISTINCT(institution.name) SEPARATOR ', ')";
	} else {
		$selectPeopleBrief = "people.brief";
		$selectInstitutionName= "institution.name";
	}
	
	$resp= [];
	$allResp= [];
	$sql= "SELECT " . $selectPeopleBrief . " as persBrief, " . $selectInstitutionName . " as istitutEspr, responsability.name as resp
           FROM item
		   LEFT JOIN itemresponsability ON item.id = itemresponsability.idlevel 
		   LEFT JOIN people ON itemresponsability.idpeople = people.id
		   LEFT JOIN institution ON itemresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = itemresponsability.idresponsability
		   WHERE item.id = " . $id;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$resp ['persBrief'] = $row["persBrief"];
		$resp ['istitutEspr'] = $row["istitutEspr"];
		$resp ['resp'] = $row["resp"];
		array_push($allResp, $resp);
	
	}
	
	return $allResp;

}


// get only all people of a item
function get_people_by_item($conn, $idItem){
	
	$people= [];
	$allPeople= [];
	
	$sql= "SELECT people.brief as peopleBrief, people.name as peopleName, people.forname as peopleSurname, responsability.name as respName, 
			people.id as idPeople, responsability.id as idResp
           FROM item
		   JOIN itemresponsability ON item.id = itemresponsability.idlevel 
		   JOIN people ON itemresponsability.idpeople = people.id
		   JOIN responsability ON responsability.id = itemresponsability.idresponsability
		   WHERE item.id = " . $idItem;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$people ['peopleBrief'] = $row["peopleBrief"];
		$people ['peopleName'] = $row["peopleName"];
		$people ['peopleSurname'] = $row["peopleSurname"];
		$people ['respName'] = $row["respName"];
		$people ['idPeople'] = $row["idPeople"];
		$people ['idResp'] = $row["idResp"];
		array_push($allPeople, $people);
		
	}
	
	return $allPeople;

}

// get only all institutions of a item
function get_institutions_by_item($conn, $idItem){
	$institution=[];
	$allInstitution=[];
	
	$sql= "SELECT institution.name as istitutName, responsability.name as respName, institution.id as idInstitution, responsability.id as idResp
           FROM item
		   JOIN itemresponsability ON item.id = itemresponsability.idlevel 
		   JOIN institution ON itemresponsability.idinstitution = institution.id
		   JOIN responsability ON responsability.id = itemresponsability.idresponsability
		   WHERE item.id = " . $idItem;
	
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$institution ['istitutName'] = $row["istitutName"];
		$institution ['respName'] = $row["respName"];
		$institution ['idInstitution'] = $row["idInstitution"];
		$institution ['idResp'] = $row["idResp"];
		array_push($allInstitution, $institution);
		
	}
	
	return $allInstitution;
	
}

//****************//
//**MANIFESTATION****//
//***************//

function get_manifestations($conn, $id= null){

	if(isset($id)) {
		$where= " where m.id = " . $id;
	} else $where= "";

	$manifestation= [];
	$allmanifestations= [];
	$sql= "select m.id, m.idwork, m.title, m.idexpression, m.iditem, journalActs.name as journalActs, serie.name as serie, book.name as book, descriptionlevel.name as type, m.type as idType, m.form as idForm, descriptionlevelmanifestation.name as formName,
			manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field6,
			manifestationfield.field7, manifestationfield.field8, manifestationfield.field9, manifestationfield.field10, manifestationfield.day, manifestationfield.month, manifestationfield.year, manifestationfield.daystart, manifestationfield.monthstart, manifestationfield.yearstart, manifestationfield.dayend, manifestationfield.monthend, manifestationfield.yearend,
			manifestationfield.iddescriptionleveloriginal as idOriginalType, manifestationfield.dayscan, manifestationfield.monthscan, manifestationfield.yearscan
			from manifestation as m
			LEFT JOIN manifestationfield ON m.id = manifestationfield.idmanifestation
			LEFT JOIN descriptionlevel ON descriptionlevel.id = m.type
			LEFT JOIN descriptionlevelmanifestation ON descriptionlevelmanifestation.id = m.form
			LEFT JOIN publications journalActs ON journalActs.id = manifestationfield.field8 
            LEFT JOIN publications serie ON serie.id = manifestationfield.field7
            LEFT JOIN publications book ON book.id = manifestationfield.field6 " . $where;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$manifestation ['id'] = $row["id"];
		$manifestation ['title'] = $row["title"];
		$manifestation ['idForm'] = $row["idForm"];
		$manifestation ['formName'] = $row["formName"];
		$manifestation ['idexpression'] = $row["idexpression"];
		$manifestation ['iditem'] = $row["iditem"];
		$manifestation ['idwork'] = $row["idwork"];
		$manifestation ['journalActs'] = $row["journalActs"];
		$manifestation ['serie'] = $row["serie"];
		$manifestation ['book'] = $row["book"];
		$manifestation ['type'] = $row["type"];
		$manifestation ['idType'] = $row["idType"];
		$manifestation ['idOriginalType'] = $row["idOriginalType"];		
		$manifestation ['field1'] = $row["field1"];
		$manifestation ['field2'] = $row["field2"];
		$manifestation ['field3'] = $row["field3"];
		$manifestation ['field4'] = $row["field4"];
		$manifestation ['field5'] = $row["field5"];
		$manifestation ['field6'] = $row["field6"];
		$manifestation ['field7'] = $row["field7"];
		$manifestation ['field8'] = $row["field8"];
		$manifestation ['field9'] = $row["field9"];
		$manifestation ['field10'] = $row["field10"];
		
		$manifestation ['day'] = $row["day"];
		$manifestation ['month'] = $row["month"];
		$manifestation ['year'] = $row["year"];
		$manifestation ['daystart'] = $row["daystart"];
		$manifestation ['monthstart'] = $row["monthstart"];
		$manifestation ['yearstart'] = $row["yearstart"];
		$manifestation ['dayend'] = $row["dayend"];
		$manifestation ['monthend'] = $row["monthend"];
		$manifestation ['yearend'] = $row["yearend"];
		$manifestation ['dayscan'] = $row["dayscan"];
		$manifestation ['monthscan'] = $row["monthscan"];
		$manifestation ['yearscan'] = $row["yearscan"];

		array_push($allmanifestations, $manifestation);
		
	}

	return $allmanifestations;

}


function get_manifestations_by_user($conn, $idUser){

	$manifestation= [];
	$allmanifestations= [];
	$sql= "select m.id, m.idwork, m.title, m.idexpression, m.iditem, journalActs.name as journalActs, serie.name as serie, book.name as book, descriptionlevel.name as type, m.type as idType, m.form as idForm, descriptionlevelmanifestation.name as formName,
			manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field6,
			manifestationfield.field7, manifestationfield.field8, manifestationfield.field9, manifestationfield.field10, manifestationfield.day, manifestationfield.month, manifestationfield.year, manifestationfield.daystart, manifestationfield.monthstart, manifestationfield.yearstart, manifestationfield.dayend, manifestationfield.monthend, manifestationfield.yearend,
			manifestationfield.iddescriptionleveloriginal as idOriginalType, manifestationfield.dayscan, manifestationfield.monthscan, manifestationfield.yearscan
			from manifestation as m
			LEFT JOIN manifestationfield ON m.id = manifestationfield.idmanifestation
			LEFT JOIN descriptionlevel ON descriptionlevel.id = m.type
			LEFT JOIN descriptionlevelmanifestation ON descriptionlevelmanifestation.id = m.form
			LEFT JOIN publications journalActs ON journalActs.id = manifestationfield.field8 
            LEFT JOIN publications serie ON serie.id = manifestationfield.field7
            LEFT JOIN publications book ON book.id = manifestationfield.field6 
			WHERE m.iduser = " . $idUser;
	
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$manifestation ['id'] = $row["id"];
		$manifestation ['title'] = $row["title"];
		$manifestation ['idForm'] = $row["idForm"];
		$manifestation ['formName'] = $row["formName"];
		$manifestation ['idexpression'] = $row["idexpression"];
		$manifestation ['iditem'] = $row["iditem"];
		$manifestation ['idwork'] = $row["idwork"];
		$manifestation ['journalActs'] = $row["journalActs"];
		$manifestation ['serie'] = $row["serie"];
		$manifestation ['book'] = $row["book"];
		$manifestation ['type'] = $row["type"];
		$manifestation ['idType'] = $row["idType"];
		$manifestation ['idOriginalType'] = $row["idOriginalType"];		
		$manifestation ['field1'] = $row["field1"];
		$manifestation ['field2'] = $row["field2"];
		$manifestation ['field3'] = $row["field3"];
		$manifestation ['field4'] = $row["field4"];
		$manifestation ['field5'] = $row["field5"];
		$manifestation ['field6'] = $row["field6"];
		$manifestation ['field7'] = $row["field7"];
		$manifestation ['field8'] = $row["field8"];
		$manifestation ['field9'] = $row["field9"];
		$manifestation ['field10'] = $row["field10"];
		
		$manifestation ['day'] = $row["day"];
		$manifestation ['month'] = $row["month"];
		$manifestation ['year'] = $row["year"];
		$manifestation ['daystart'] = $row["daystart"];
		$manifestation ['monthstart'] = $row["monthstart"];
		$manifestation ['yearstart'] = $row["yearstart"];
		$manifestation ['dayend'] = $row["dayend"];
		$manifestation ['monthend'] = $row["monthend"];
		$manifestation ['yearend'] = $row["yearend"];
		$manifestation ['dayscan'] = $row["dayscan"];
		$manifestation ['monthscan'] = $row["monthscan"];
		$manifestation ['yearscan'] = $row["yearscan"];

		array_push($allmanifestations, $manifestation);
		
	}

	return $allmanifestations;

}

function get_manifestations_by_idWork($conn, $idWork){

	$manifestation= [];
	$allmanifestations= [];
	$sql= "select m.id, m.idwork, m.title, m.idexpression, m.iditem, journalActs.name as journalActs, serie.name as serie, book.name as book, descriptionlevel.name as type, m.type as idType, m.form as idForm, descriptionlevelmanifestation.name as formName, m.iduser,
			manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field6,
			manifestationfield.field7, manifestationfield.field8, manifestationfield.field9, manifestationfield.field10, manifestationfield.day, manifestationfield.month, manifestationfield.year, manifestationfield.daystart, manifestationfield.monthstart, manifestationfield.yearstart, manifestationfield.dayend, manifestationfield.monthend, manifestationfield.yearend
			from manifestation as m
			LEFT JOIN manifestationfield ON m.id = manifestationfield.idmanifestation
			LEFT JOIN descriptionlevel ON descriptionlevel.id = m.type
			LEFT JOIN descriptionlevelmanifestation ON descriptionlevelmanifestation.id = m.form
			LEFT JOIN publications journalActs ON journalActs.id = manifestationfield.field8 
            LEFT JOIN publications serie ON serie.id = manifestationfield.field7
            LEFT JOIN publications book ON book.id = manifestationfield.field6 where m.idwork = " . $idWork;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$manifestation ['id'] = $row["id"];
		$manifestation ['idwork'] = $row["idwork"];
		$manifestation ['iduser'] = $row["iduser"];
		$manifestation ['title'] = $row["title"];
		$manifestation ['idForm'] = $row["idForm"];
		$manifestation ['formName'] = $row["formName"];
		$manifestation ['idexpression'] = $row["idexpression"];
		$manifestation ['iditem'] = $row["iditem"];
		$manifestation ['type'] = $row["type"];
		$manifestation ['idType'] = $row["idType"];
		$manifestation ['journalActs'] = $row["journalActs"];
		$manifestation ['serie'] = $row["serie"];
		$manifestation ['book'] = $row["book"];
		$manifestation ['field1'] = $row["field1"];
		$manifestation ['field2'] = $row["field2"];
		$manifestation ['field3'] = $row["field3"];
		$manifestation ['field4'] = $row["field4"];
		$manifestation ['field5'] = $row["field5"];
		$manifestation ['field6'] = $row["field6"];
		$manifestation ['field7'] = $row["field7"];
		$manifestation ['field8'] = $row["field8"];
		$manifestation ['field9'] = $row["field9"];
		$manifestation ['field10'] = $row["field10"];
		
		$manifestation ['day'] = $row["day"];
		$manifestation ['month'] = $row["month"];
		$manifestation ['year'] = $row["year"];
		$manifestation ['daystart'] = $row["daystart"];
		$manifestation ['monthstart'] = $row["monthstart"];
		$manifestation ['yearstart'] = $row["yearstart"];
		$manifestation ['dayend'] = $row["dayend"];
		$manifestation ['monthend'] = $row["monthend"];
		$manifestation ['yearend'] = $row["yearend"];
		array_push($allmanifestations, $manifestation);
		
	}

	return $allmanifestations;

}


function get_manifestations_by_responsability($conn, $id, $peopleInstitucionString= "people"){

	if($peopleInstitucionString == "people"){
		$Tosearch= "idpeople";
	} else if($peopleInstitucionString == "instituction"){
		$Tosearch= "idinstitution";
	}
	
	$manif=[];
	$allmanif= [];

	if (sizeOf($id) == 0){

		$sql= "
			SELECT people.Brief as persBrief, institution.name as istitutEspr, responsability.name as resp, manifestation.title, manifestation.id, manifestation.idwork, descriptionlevel.name as type
           FROM manifestation
		   LEFT JOIN manifestationresponsability ON manifestation.id = manifestationresponsability.idlevel 
		   LEFT JOIN people ON manifestationresponsability.idpeople = people.id
		   LEFT JOIN institution ON manifestationresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = manifestationresponsability.idresponsability
			LEFT JOIN descriptionlevel ON descriptionlevel.id = manifestation.type
		   ";
	
	}


	if ((sizeOf($id) > 1) or (sizeOf($id) == 1)){
		
		$sql= "SELECT people.Brief as persBrief, institution.name as istitutEspr, responsability.name as resp, manifestation.title, manifestation.id, manifestation.idwork, descriptionlevel.name as type
           FROM manifestation
		   LEFT JOIN manifestationresponsability ON manifestation.id = manifestationresponsability.idlevel 
		   LEFT JOIN people ON manifestationresponsability.idpeople = people.id
		   LEFT JOIN institution ON manifestationresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = manifestationresponsability.idresponsability
			LEFT JOIN descriptionlevel ON descriptionlevel.id = manifestation.type
		   WHERE manifestationresponsability.". $Tosearch. " in (";
		   
		$valori= array();
		for($i= 0; $i < count($id); $i++){
			$valori[] = $id[$i];
		}
		
		$sql .= join(', ', $valori) . ") group by manifestation.title, manifestation.id having count(*) = " . sizeOf($id);

		   
	}
	
	$result = mysqli_query($conn, $sql);

	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$manif ['persBrief'] = $row["persBrief"];
		$manif ['istitutEspr'] = $row["istitutEspr"];
		$manif ['title'] = $row["title"];
		$manif ['id'] = $row["id"];
		$manif ['idwork'] = $row["idwork"];
		$manif ['type'] = $row["type"];

		array_push($allmanif, $manif);
		
	}
	
	return $allmanif;

}


function get_responsabilityManifestation($conn, $id, $oneRow=false){
	
	
	if($oneRow == true){
		$selectPeopleBrief= "GROUP_CONCAT(DISTINCT(people.Brief) SEPARATOR ', ')";
		$selectInstitutionName= "GROUP_CONCAT(DISTINCT(institution.name) SEPARATOR ', ')";
	} else {
		$selectPeopleBrief = "people.brief";
		$selectInstitutionName= "institution.name";
	}
	
	$resp= [];
	$allResp= [];
	$sql= "SELECT ". $selectPeopleBrief ." as persBrief, ". $selectInstitutionName ." as istitutEspr, responsability.name as resp
           FROM manifestation
		   LEFT JOIN manifestationresponsability ON manifestation.id = manifestationresponsability.idlevel 
		   LEFT JOIN people ON manifestationresponsability.idpeople = people.id
		   LEFT JOIN institution ON manifestationresponsability.idinstitution = institution.id
		   LEFT JOIN responsability ON responsability.id = manifestationresponsability.idresponsability
		   WHERE manifestation.id = " . $id;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$resp ['persBrief'] = $row["persBrief"];
		$resp ['istitutEspr'] = $row["istitutEspr"];
		$resp ['resp'] = $row["resp"];
		array_push($allResp, $resp);
		
	}
	
	return $allResp;

}


// get only all people of a manifest
function get_people_by_manifestation($conn, $idManif){
	
	$people= [];
	$allPeople= [];
	
	$sql= "SELECT people.brief as peopleBrief, people.name as peopleName, people.forname as peopleSurname, responsability.name as respName, 
			people.id as idPeople, responsability.id as idResp
           FROM manifestation
		   JOIN manifestationresponsability ON manifestation.id = manifestationresponsability.idlevel 
		   JOIN people ON manifestationresponsability.idpeople = people.id
		   JOIN responsability ON responsability.id = manifestationresponsability.idresponsability
		   WHERE manifestation.id = " . $idManif;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$people ['peopleBrief'] = $row["peopleBrief"];
		$people ['peopleName'] = $row["peopleName"];
		$people ['peopleSurname'] = $row["peopleSurname"];
		$people ['respName'] = $row["respName"];
		$people ['idPeople'] = $row["idPeople"];
		$people ['idResp'] = $row["idResp"];
		array_push($allPeople, $people);
		
	}
	
	return $allPeople;

}

// get only all institutions of a manifest
function get_institutions_by_manifestation($conn, $idManif){
	$institution=[];
	$allInstitution=[];
	
	$sql= "SELECT institution.name as istitutName, responsability.name as respName, institution.id as idInstitution, responsability.id as idResp
           FROM manifestation
		   JOIN manifestationresponsability ON manifestation.id = manifestationresponsability.idlevel 
		   JOIN institution ON manifestationresponsability.idinstitution = institution.id
		   JOIN responsability ON responsability.id = manifestationresponsability.idresponsability
		   WHERE manifestation.id = " . $idManif;
	
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {
		$institution ['istitutName'] = $row["istitutName"];
		$institution ['respName'] = $row["respName"];
		$institution ['idInstitution'] = $row["idInstitution"];
		$institution ['idResp'] = $row["idResp"];
		array_push($allInstitution, $institution);
		
	}
	
	return $allInstitution;
	
}

//**********************//
//description levels functions//
//**********************//

function get_descriptionsType($conn, $level){
	
	$descType= [];
	$allDescType= [];
	$sql= "select * from descriptionlevel where level = '$level' ORDER BY name";
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$descType ['id'] = $row["id"];
		$descType ['name'] = $row["name"];
		$descType ['level'] = $row["level"];
		array_push($allDescType, $descType);
		
	}

	return $allDescType;

}

function get_allDescriptionsType($conn, $id=null){
		
	if(isset($id)) {
		$where= "where id = " . $id;
	} else $where= "";
	
	$descType= [];
	$allDescType= [];
	$sql= "select * from descriptionlevel " . $where;
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$descType ['id'] = $row["id"];
		$descType ['name'] = $row["name"];
		$descType ['level'] = $row["level"];
		array_push($allDescType, $descType);
		
	}

	return $allDescType;

}

function get_formDescriptionsType($conn, $idDescriptionType){

	$formDescType= [];
	$allFormDescType= [];
	$sql="SELECT id, name FROM descriptionlevelmanifestation WHERE find_in_set($idDescriptionType, idmanifestationtype) > 0";
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$formDescType ['id'] = $row["id"];
		$formDescType ['name'] = $row["name"];
		array_push($allFormDescType, $formDescType);
		
	}
	
	return $allFormDescType;

}


//**************************//
//publications functions//
//******************************//


function get_publications($conn, $id=null){
	
	if(isset($id)) {
		$where= "where p.id = " . $id;
	} else $where= "";
	
	$publication= [];
	$allpublications= [];
	$sql= "select p.id, p.name, p.idType, publicationstype.type as typeName from publications as p Join publicationstype on p.idtype = publicationstype.id " . $where;
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$publication ['id'] = $row["id"];
		$publication ['name'] = $row["name"];
		$publication ['idType'] = $row["idType"];
		$publication ['typeName'] = $row["typeName"];
		array_push($allpublications, $publication);
		
	}

	return $allpublications;

}

function get_publications_by_levels($conn, $level){
	

	$publication= [];
	$allpublications= [];
	$sql= "select p.id, p.name, p.idType, publicationstype.type as typeName from publications as p Join publicationstype on p.idtype = publicationstype.id WHERE publicationstype.type = '$level' order by p.name";
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$publication ['id'] = $row["id"];
		$publication ['name'] = $row["name"];
		$publication ['idType'] = $row["idType"];
		$publication ['typeName'] = $row["typeName"];
		array_push($allpublications, $publication);
		
	}

	return $allpublications;

}

function get_publicationsType($conn){
	
	$type= [];
	$allType= [];
	$sql= "select * from publicationstype";
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$type ['id'] = $row["id"];
		$type ['type'] = $row["type"];
		array_push($allType, $type);
		
	}

	return $allType;

}

//*****************************************//
//People/Intitutions Responsability functions//
//****************************************//

function get_people($conn, $id=null){

	if(isset($id)) {
		$where= " where id = " . $id;
	} else $where= "";
	
	$people= [];
	$allpeople= [];
	$sql= "select * from people " . $where . " order by forname";
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$people ['id'] = $row["id"];
		$people ['name'] = $row["name"];
		$people ['forname'] = $row["forname"];
		$people ['brief'] = $row["brief"];
		$people ['pseudonymOf'] = $row["pseudonymOf"];
		array_push($allpeople, $people);
		
	}

	return $allpeople;	

}


function get_institutions($conn, $id=null){
	
	if(isset($id)) {
		$where= " where id = " . $id;
	} else $where= "";
	
	$institutions= [];
	$allInstitutions= [];
	$sql= "select * from institution " . $where;
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$institutions ['id'] = $row["id"];
		$institutions ['name'] = $row["name"];
		$institutions ['link'] = $row["link"];
		array_push($allInstitutions, $institutions);
		
	}

	return $allInstitutions;	

}


function get_responsability($conn, $level){
	

	$responability= [];
	$allResponability= [];
	$sql= "select * from responsability where level = '$level'";
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$responability ['id'] = $row["id"];
		$responability ['name'] = $row["name"];
		array_push($allResponability, $responability);
		
	}

	return $allResponability;	

}

function get_allResponsability($conn, $id=null){

	if(isset($id)) {
		$where= " where id = " . $id;
	} else $where= "";

	$responability= [];
	$allResponability= [];
	$sql= "select * from responsability " . $where;
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$responability ['id'] = $row["id"];
		$responability ['name'] = $row["name"];
		$responability ['level'] = $row["level"];
		array_push($allResponability, $responability);
		
	}

	return $allResponability;	

}


//*****************************************//
//*******COLLECTIONS FUNCTIONS*************//
//****************************************//

// get only collection (without items)
function get_collections($conn, $id=null){

	if(isset($id)) {
		$where= " where id = " . $id;
	} else $where= "";
	
	$collection= [];
	$allcollections= [];
	$sql= "select * from collection " . $where;
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$collection ['id'] = $row["id"];
		$collection ['name'] = $row["name"];
		$collection ['brief'] = $row["brief"];
		$collection ['ordering'] = $row["ordering"];
		array_push($allcollections, $collection);
		
	}

	return $allcollections;

}

// get only collection (without items) by user
function get_collections_by_user($conn, $idUser){
	
	$collection= [];
	$allcollections= [];
	$sql= "select * from collection where iduser = " . $idUser;
	$result = mysqli_query($conn, $sql);
		
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$collection ['id'] = $row["id"];
		$collection ['name'] = $row["name"];
		$collection ['brief'] = $row["brief"];
		$collection ['ordering'] = $row["ordering"];
		array_push($allcollections, $collection);
		
	}

	return $allcollections;

}

// get all items and manifestationf froma a collection
function get_collection_by_idCollection($conn, $idCollection, $ordering, $fileSecretPermission){
	
	if($ordering == 1){
		$ordering=" order by year desc, month desc, day desc;";
		} else if($ordering == 2){
			$ordering=" order by surnameOrder";
		} else {$ordering= " order by positionCollection";}
	
	$idItem= [];
	$allIdItems= [];
	
$sql= "select 'item' as level, work.title, work.id as idwork, manifestation.idexpression as idexpr,  manifestationfield.idmanifestation as idmanif, item.id as iditem, item.fileurl as localFile, item.extlink as extLink, item.capability as capability, item.dayvisited as dayItemVisited, item.monthvisited as monthItemVisited, item.yearvisited as yearItemVisited,
exprDescriptionLevel.name as exprType, manifDescriptionLevel.name as manifType,
manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field9, manifestationfield.field10,
journalActs.name as journalActs, series.name as series, book.name as book,
manifestationfield.year, manifestationfield.month, manifestationfield.day,
manifestationfield.yearstart, manifestationfield.monthstart, manifestationfield.daystart,
manifestationfield.yearend, manifestationfield.monthend, manifestationfield.dayend,
manifestationfield.yearscan,  
manifestationfield.iddescriptionlevel as idManifestationType, 
manifestationfield.iddescriptionleveloriginal as idManifestationTypeOriginal,
collectionitems.position as positionCollection, collection.name as collectionName,

GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab, GROUP_CONCAT(distinct(peopleWork.forname) ORDER BY workresponsability.id) as surnameOrder,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab,

GROUP_CONCAT(distinct( concat(itemresponsability.idpeople, '*', peopleItem.brief) ) order by itemresponsability.id) as peopleItemBrief,  GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.name) ) order by itemresponsability.id) as peopleItemName, GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.forname) ) order by itemresponsability.id) as peopleItemForname, GROUP_CONCAT(distinct(itemresponsability.idpeople) order by itemresponsability.id) as idPeopleItem, GROUP_CONCAT(distinct(concat(itemresponsability.idpeople, '*', itemresponsability.idresponsability)) order by itemresponsability.id) as idItemPeopleResponsab,
GROUP_CONCAT(distinct(institutionItem.name)) as institutionItemName, GROUP_CONCAT(distinct(itemresponsability.idinstitution)) as idInstitutionItem, GROUP_CONCAT(distinct(concat(itemresponsability.idinstitution,'*',itemresponsability.idresponsability))) as idItemInstitutionResponsab



from item

left join manifestation on manifestation.id = item.idmanifestation
left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id
left join descriptionlevel manifDescriptionLevel on manifDescriptionLevel.id= manifestationfield.iddescriptionlevel


left join work on work.id = manifestation.idwork
left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution

left join expression on expression.idwork = work.id
left join expression exp2 on exp2.id = manifestation.idexpression
left join descriptionlevel exprDescriptionLevel on exprDescriptionLevel.id = exp2.type
left join expressionresponsability on expressionresponsability.idlevel = exp2.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution

left join itemresponsability on itemresponsability.idlevel = item.id
left join people peopleItem on peopleItem.id = itemresponsability.idpeople
left join institution institutionItem on institutionItem.id = itemresponsability.idinstitution
left join responsability respItem on respItem.id= itemresponsability.idresponsability

Left join collectionitems on item.id=collectionitems.iditem
left join collection on collection.id=collectionitems.idcollection
	
where collectionitems.idcollection=$idCollection

group by item.id



UNION ALL



select 'manifestation' as level, work.title, work.id as idwork, manifestation.idexpression as idexpr, manifestationfield.idmanifestation as idmanif, item.id as iditem, '' as localFile, '' as extLink, '' as capability, '' as dayItemVisited, '' as monthItemVisited, '' as yearItemVisited,
exprDescriptionLevel.name as exprType, manifDescriptionLevel.name as manifType,
manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field9, manifestationfield.field10,
journalActs.name as journalActs, series.name as series, book.name as book,
manifestationfield.year, manifestationfield.month, manifestationfield.day,
manifestationfield.yearstart, manifestationfield.monthstart, manifestationfield.daystart,
manifestationfield.yearend, manifestationfield.monthend, manifestationfield.dayend,
manifestationfield.yearscan,  
manifestationfield.iddescriptionlevel as idManifestationType, 
manifestationfield.iddescriptionleveloriginal as idManifestationTypeOriginal,
collectionitems.position as positionCollection, collection.name as collectionName,

GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab, GROUP_CONCAT(distinct(peopleWork.forname) ORDER BY workresponsability.id) as surnameOrder,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab,

GROUP_CONCAT(distinct( concat(itemresponsability.idpeople, '*', peopleItem.brief) ) order by itemresponsability.id) as peopleItemBrief,  GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.name) ) order by itemresponsability.id) as peopleItemName, GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.forname) ) order by itemresponsability.id) as peopleItemForname, GROUP_CONCAT(distinct(itemresponsability.idpeople) order by itemresponsability.id) as idPeopleItem, GROUP_CONCAT(distinct(concat(itemresponsability.idpeople, '*', itemresponsability.idresponsability)) order by itemresponsability.id) as idItemPeopleResponsab,
GROUP_CONCAT(distinct(institutionItem.name)) as institutionItemName, GROUP_CONCAT(distinct(itemresponsability.idinstitution)) as idInstitutionItem, GROUP_CONCAT(distinct(concat(itemresponsability.idinstitution,'*',itemresponsability.idresponsability))) as idItemInstitutionResponsab



from manifestation

left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id
left join descriptionlevel manifDescriptionLevel on manifDescriptionLevel.id= manifestationfield.iddescriptionlevel


left join work on work.id = manifestation.idwork
left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution

left join expression on expression.idwork = work.id
left join expression exp2 on exp2.id = manifestation.idexpression
left join descriptionlevel exprDescriptionLevel on exprDescriptionLevel.id = exp2.type
left join expressionresponsability on expressionresponsability.idlevel = exp2.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution

left join item on item.idmanifestation = manifestation.id
left join itemresponsability on itemresponsability.idlevel = item.id
left join people peopleItem on peopleItem.id = itemresponsability.idpeople
left join institution institutionItem on institutionItem.id = itemresponsability.idinstitution

Left join collectionitems on manifestation.id=collectionitems.idmanifestation
left join collection on collection.id=collectionitems.idcollection
	
where collectionitems.idcollection=$idCollection

group by manifestation.id 

$ordering" ;

	
	
	$result= mysqli_query($conn, $sql);
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$idItem ['idManifestationType'] = $row["idManifestationType"]; 
 		$idItem ['idManifestationTypeOriginal'] = $row["idManifestationTypeOriginal"];
		
		$idItem ['idwork'] = $row["idwork"];
		$idItem ['idmanif'] = $row["idmanif"];
		$idItem ['idexpr'] = $row["idexpr"];
		$idItem ['iditem'] = $row["iditem"];
		$idItem ['title'] = $row["title"]; 
		
		$idItem ['exprType'] = $row["exprType"];
		$idItem ['manifType'] = $row["manifType"];



		$idItem ['idPeopleWork'] = $row["idPeopleWork"];
		$idItem ['workPeopleBrief'] = $row["workPeopleBrief"];
		$idItem ['workPeopleSurname'] = $row["workPeopleSurname"];	
		$idItem ['workPeopleName'] = $row["workPeopleName"];		
		$idItem ['idWorkPeopleResponsab'] = $row["idWorkPeopleResponsab"];
		$idItem ['idInstitutionWork'] = $row["idInstitutionWork"];
		$idItem ['workInstitutionName'] = $row["workInstitutionName"];
		$idItem ['idWorkInstitutionResponsab'] = $row["idWorkInstitutionResponsab"];
		
		$idItem ['idPeopleExpression'] = $row["idPeopleExpression"];
		$idItem ['peopleExpressionBrief'] = $row["peopleExpressionBrief"];
		$idItem ['peopleExpressionForname'] = $row["peopleExpressionForname"];
		$idItem ['peopleExpressionName'] = $row["peopleExpressionName"];
		$idItem ['idExpressionPeopleResponsab'] = $row["idExpressionPeopleResponsab"];
		$idItem ['idInstitutionExpression'] = $row["idInstitutionExpression"];
		$idItem ['institutionExpressionName'] = $row["institutionExpressionName"];		
		$idItem ['idExpressionInstitutionResponsab'] = $row["idExpressionInstitutionResponsab"];
		
		$idItem ['idPeopleManifestation'] = $row["idPeopleManifestation"];
		$idItem ['peopleManifestationBrief'] = $row["peopleManifestationBrief"];	
		$idItem ['peopleManifestationName'] = $row["peopleManifestationName"];
		$idItem ['peopleManifestationForname'] = $row["peopleManifestationForname"];		
		$idItem ['idManifPeopleResponsab'] = $row["idManifPeopleResponsab"];
		$idItem ['idInstitutionManifestation'] = $row["idInstitutionManifestation"];
		$idItem ['institutionManifestationName'] = $row["institutionManifestationName"];
		$idItem ['idManifInstitutionResponsab'] = $row["idManifInstitutionResponsab"];
		
		$idItem ['idPeopleItem'] = $row["idPeopleItem"];
		$idItem ['peopleItemBrief'] = $row["peopleItemBrief"];
		$idItem ['idItemPeopleResponsab'] = $row["idItemPeopleResponsab"];
		$idItem ['idInstitutionItem'] = $row["idInstitutionItem"];
		$idItem ['institutionItemName'] = $row["institutionItemName"];
		$idItem ['idItemInstitutionResponsab'] = $row["idItemInstitutionResponsab"];


		
		$idItem ['field1'] = $row["field1"];
		$idItem ['field2'] = $row["field2"];
		$idItem ['field3'] = $row["field3"];
		$idItem ['field4'] = $row["field4"];
		$idItem ['field5'] = $row["field5"];
		$idItem ['field9'] = $row["field9"];
		$idItem ['field10'] = $row["field10"];
		$idItem ['journalActs'] = $row["journalActs"];
		$idItem ['series'] = $row["series"];
		$idItem ['book'] = $row["book"];
		
		$idItem ['day'] = $row["day"];
		$idItem ['month'] = $row["month"];
		$idItem ['year'] = $row["year"];
		$idItem ['daystart'] = $row["daystart"];
		$idItem ['monthstart'] = $row["monthstart"];
		$idItem ['yearstart'] = $row["yearstart"];
		$idItem ['dayend'] = $row["dayend"];
		$idItem ['monthend'] = $row["monthend"];
		$idItem ['yearend'] = $row["yearend"];
		$idItem ['yearscan'] = $row["yearscan"]; 
		
		$idItem ['localFile'] = $row["localFile"];
		$idItem ['extLink'] = $row["extLink"];
		$idItem ['capability'] = $row["capability"]; 
		$idItem ['dayItemVisited'] = $row["dayItemVisited"];
		$idItem ['monthItemVisited'] = $row["monthItemVisited"];
		$idItem ['yearItemVisited'] = $row["yearItemVisited"];
		$idItem ['fileSecretPermission'] = $fileSecretPermission; 

		$idItem ['level'] = $row["level"]; 
		$idItem ['collectionName'] = $row["collectionName"];

		array_push($allIdItems, $idItem);
		
	}
	
	
	return $allIdItems;
}





function get_object_items_by_idItem($conn, $idItemm, $fileSecretPermission){
	

	$idItem= [];
	$allIdItems= [];
	
$sql= "select work.title, work.id as idwork, manifestation.idexpression as idexpr, item.id as iditem,  
manifestationfield.idmanifestation as idmanif, item.id as itemid, exprDescriptionLevel.name as exprType, manifDescriptionLevel.name as manifType,
item.extlink as extLink, item.fileurl as localFile, item.capability, item.dayvisited as dayItemVisited, item.monthvisited as monthItemVisited, item.yearvisited as yearItemVisited,
manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field9, manifestationfield.field10,
journalActs.name as journalActs, series.name as series, book.name as book,
manifestationfield.year, manifestationfield.month, manifestationfield.day,
manifestationfield.yearstart, manifestationfield.monthstart, manifestationfield.daystart,
manifestationfield.yearend, manifestationfield.monthend, manifestationfield.dayend,
manifestationfield.yearscan,
manifestationfield.iddescriptionlevel as idManifestationType, 
manifestationfield.iddescriptionleveloriginal as idManifestationTypeOriginal, 

GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab,

GROUP_CONCAT(distinct( concat(itemresponsability.idpeople, '*', peopleItem.brief) ) order by itemresponsability.id) as peopleItemBrief,  GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.name) ) order by itemresponsability.id) as peopleItemName, GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.forname) ) order by itemresponsability.id) as peopleItemForname, GROUP_CONCAT(distinct(itemresponsability.idpeople) order by itemresponsability.id) as idPeopleItem, GROUP_CONCAT(distinct(concat(itemresponsability.idpeople, '*', itemresponsability.idresponsability)) order by itemresponsability.id) as idItemPeopleResponsab,
GROUP_CONCAT(distinct(institutionItem.name)) as institutionItemName, GROUP_CONCAT(distinct(itemresponsability.idinstitution)) as idInstitutionItem, GROUP_CONCAT(distinct(concat(itemresponsability.idinstitution,'*',itemresponsability.idresponsability))) as idItemInstitutionResponsab,
respItem.name as itemRespName



from item

left join manifestation on manifestation.id = item.idmanifestation
left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id
left join descriptionlevel manifDescriptionLevel on manifDescriptionLevel.id= manifestationfield.iddescriptionlevel


left join work on work.id = manifestation.idwork
left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution

left join expression on expression.idwork = work.id
left join expression exp2 on exp2.id = manifestation.idexpression
left join descriptionlevel exprDescriptionLevel on exprDescriptionLevel.id = exp2.type
left join expressionresponsability on expressionresponsability.idlevel = exp2.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution


left join itemresponsability on itemresponsability.idlevel = item.id
left join people peopleItem on peopleItem.id = itemresponsability.idpeople
left join institution institutionItem on institutionItem.id = itemresponsability.idinstitution
left join responsability respItem on respItem.id= itemresponsability.idresponsability

where item.id= $idItemm

group by item.id" ;

	
	
	$result= mysqli_query($conn, $sql);
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$idItem ['idManifestationType'] = $row["idManifestationType"]; 
 		$idItem ['idManifestationTypeOriginal'] = $row["idManifestationTypeOriginal"];
		
		$idItem ['idwork'] = $row["idwork"];
		$idItem ['idmanif'] = $row["idmanif"];
		$idItem ['idexpr'] = $row["idexpr"];
		$idItem ['iditem'] = $row["iditem"];
		$idItem ['capability'] = $row["capability"];
		$idItem ['dayItemVisited'] = $row["dayItemVisited"];
		$idItem ['monthItemVisited'] = $row["monthItemVisited"];
		$idItem ['yearItemVisited'] = $row["yearItemVisited"];
		$idItem ['fileSecretPermission'] = $fileSecretPermission; 
		$idItem ['localFile'] = $row["localFile"];
		$idItem ['extLink'] = $row["extLink"];
		$idItem ['title'] = $row["title"]; 
		
		$idItem ['exprType'] = $row["exprType"];
		$idItem ['manifType'] = $row["manifType"];



		$idItem ['idPeopleWork'] = $row["idPeopleWork"];
		$idItem ['workPeopleBrief'] = $row["workPeopleBrief"];
		$idItem ['workPeopleSurname'] = $row["workPeopleSurname"];	
		$idItem ['workPeopleName'] = $row["workPeopleName"];		
		$idItem ['idWorkPeopleResponsab'] = $row["idWorkPeopleResponsab"];
		$idItem ['idInstitutionWork'] = $row["idInstitutionWork"];
		$idItem ['workInstitutionName'] = $row["workInstitutionName"];
		$idItem ['idWorkInstitutionResponsab'] = $row["idWorkInstitutionResponsab"];
		
		$idItem ['idPeopleExpression'] = $row["idPeopleExpression"];
		$idItem ['peopleExpressionBrief'] = $row["peopleExpressionBrief"];
		$idItem ['peopleExpressionForname'] = $row["peopleExpressionForname"];
		$idItem ['peopleExpressionName'] = $row["peopleExpressionName"];
		$idItem ['idExpressionPeopleResponsab'] = $row["idExpressionPeopleResponsab"];
		$idItem ['idInstitutionExpression'] = $row["idInstitutionExpression"];
		$idItem ['institutionExpressionName'] = $row["institutionExpressionName"];		
		$idItem ['idExpressionInstitutionResponsab'] = $row["idExpressionInstitutionResponsab"];
		
		$idItem ['idPeopleManifestation'] = $row["idPeopleManifestation"];
		$idItem ['peopleManifestationBrief'] = $row["peopleManifestationBrief"];	
		$idItem ['peopleManifestationName'] = $row["peopleManifestationName"];
		$idItem ['peopleManifestationForname'] = $row["peopleManifestationForname"];		
		$idItem ['idManifPeopleResponsab'] = $row["idManifPeopleResponsab"];
		$idItem ['idInstitutionManifestation'] = $row["idInstitutionManifestation"];
		$idItem ['institutionManifestationName'] = $row["institutionManifestationName"];
		$idItem ['idManifInstitutionResponsab'] = $row["idManifInstitutionResponsab"];
		
		$idItem ['idPeopleItem'] = $row["idPeopleItem"];
		$idItem ['peopleItemBrief'] = $row["peopleItemBrief"];
		$idItem ['idItemPeopleResponsab'] = $row["idItemPeopleResponsab"];
		$idItem ['idInstitutionItem'] = $row["idInstitutionItem"];
		$idItem ['institutionItemName'] = $row["institutionItemName"];
		$idItem ['idItemInstitutionResponsab'] = $row["idItemInstitutionResponsab"];
		$idItem ['itemRespName'] = $row["itemRespName"];

		
		$idItem ['field1'] = $row["field1"];
		$idItem ['field2'] = $row["field2"];
		$idItem ['field3'] = $row["field3"];
		$idItem ['field4'] = $row["field4"];
		$idItem ['field5'] = $row["field5"];
		$idItem ['field9'] = $row["field9"];
		$idItem ['field10'] = $row["field10"];
		$idItem ['journalActs'] = $row["journalActs"];
		$idItem ['series'] = $row["series"];
		$idItem ['book'] = $row["book"];
		
		$idItem ['day'] = $row["day"];
		$idItem ['month'] = $row["month"];
		$idItem ['year'] = $row["year"]; 
		$idItem ['daystart'] = $row["daystart"];
		$idItem ['monthstart'] = $row["monthstart"];
		$idItem ['yearstart'] = $row["yearstart"];
		$idItem ['dayend'] = $row["dayend"];
		$idItem ['monthend'] = $row["monthend"];
		$idItem ['yearend'] = $row["yearend"];
		$idItem ['yearscan'] = $row["yearscan"];

		
		$idItem ['sql'] = $sql;

		array_push($allIdItems, $idItem);
		
	}
	
	
	return $allIdItems;
}





function get_object_manifestations_by_idManifestation($conn, $idManifestation){
	

	$idItem= [];
	$allIdItems= [];
	
$sql= "select work.title, work.id as idwork, manifestation.idexpression as idexpr, manifestation.iditem as iditem,  manifestationfield.idmanifestation as idmanif, item.id as itemid, exprDescriptionLevel.name as exprType, manifDescriptionLevel.name as manifType,
item.extlink as extLink, item.fileurl as localFile, item.capability, 
manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field9, manifestationfield.field10,
journalActs.name as journalActs, series.name as series, book.name as book,
manifestationfield.year, manifestationfield.month, manifestationfield.day,
manifestationfield.yearstart, manifestationfield.monthstart, manifestationfield.daystart,
manifestationfield.yearend, manifestationfield.monthend, manifestationfield.dayend,
manifestationfield.yearscan,  
manifestationfield.iddescriptionlevel as idManifestationType, 
manifestationfield.iddescriptionleveloriginal as idManifestationTypeOriginal, 

GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab,

GROUP_CONCAT(distinct( concat(itemresponsability.idpeople, '*', peopleItem.brief) ) order by itemresponsability.id) as peopleItemBrief,  GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.name) ) order by itemresponsability.id) as peopleItemName, GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.forname) ) order by itemresponsability.id) as peopleItemForname, GROUP_CONCAT(distinct(itemresponsability.idpeople) order by itemresponsability.id) as idPeopleItem, GROUP_CONCAT(distinct(concat(itemresponsability.idpeople, '*', itemresponsability.idresponsability)) order by itemresponsability.id) as idItemPeopleResponsab,
GROUP_CONCAT(distinct(institutionItem.name)) as institutionItemName, GROUP_CONCAT(distinct(itemresponsability.idinstitution)) as idInstitutionItem, GROUP_CONCAT(distinct(concat(itemresponsability.idinstitution,'*',itemresponsability.idresponsability))) as idItemInstitutionResponsab



from manifestation

left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id
left join descriptionlevel manifDescriptionLevel on manifDescriptionLevel.id= manifestationfield.iddescriptionlevel


left join work on work.id = manifestation.idwork
left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution

left join expression on expression.idwork = work.id
left join expressionresponsability on expressionresponsability.idlevel = expression.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution
left join expression exp2 on exp2.id = manifestation.idexpression
left join descriptionlevel exprDescriptionLevel on exprDescriptionLevel.id = exp2.type

left join item on item.idmanifestation = manifestation.id
left join itemresponsability on itemresponsability.idlevel = item.id
left join people peopleItem on peopleItem.id = itemresponsability.idpeople
left join institution institutionItem on institutionItem.id = itemresponsability.idinstitution

where manifestation.id=$idManifestation

group by manifestation.id" ;

	
	
	$result= mysqli_query($conn, $sql);
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$idItem ['idManifestationType'] = $row["idManifestationType"]; 
 		$idItem ['idManifestationTypeOriginal'] = $row["idManifestationTypeOriginal"];
		
		$idItem ['idwork'] = $row["idwork"];
		$idItem ['idmanif'] = $row["idmanif"];
		$idItem ['idexpr'] = $row["idexpr"];
		$idItem ['iditem'] = $row["iditem"];
		$idItem ['title'] = $row["title"]; 
		
		$idItem ['exprType'] = $row["exprType"];
		$idItem ['manifType'] = $row["manifType"];



		$idItem ['idPeopleWork'] = $row["idPeopleWork"];
		$idItem ['workPeopleBrief'] = $row["workPeopleBrief"];
		$idItem ['workPeopleSurname'] = $row["workPeopleSurname"];	
		$idItem ['workPeopleName'] = $row["workPeopleName"];		
		$idItem ['idWorkPeopleResponsab'] = $row["idWorkPeopleResponsab"];
		$idItem ['idInstitutionWork'] = $row["idInstitutionWork"];
		$idItem ['workInstitutionName'] = $row["workInstitutionName"];
		$idItem ['idWorkInstitutionResponsab'] = $row["idWorkInstitutionResponsab"];
		
		$idItem ['idPeopleExpression'] = $row["idPeopleExpression"];
		$idItem ['peopleExpressionBrief'] = $row["peopleExpressionBrief"];
		$idItem ['peopleExpressionForname'] = $row["peopleExpressionForname"];
		$idItem ['peopleExpressionName'] = $row["peopleExpressionName"];
		$idItem ['idExpressionPeopleResponsab'] = $row["idExpressionPeopleResponsab"];
		$idItem ['idInstitutionExpression'] = $row["idInstitutionExpression"];
		$idItem ['institutionExpressionName'] = $row["institutionExpressionName"];		
		$idItem ['idExpressionInstitutionResponsab'] = $row["idExpressionInstitutionResponsab"];
		
		$idItem ['idPeopleManifestation'] = $row["idPeopleManifestation"];
		$idItem ['peopleManifestationBrief'] = $row["peopleManifestationBrief"];	
		$idItem ['peopleManifestationName'] = $row["peopleManifestationName"];
		$idItem ['peopleManifestationForname'] = $row["peopleManifestationForname"];		
		$idItem ['idManifPeopleResponsab'] = $row["idManifPeopleResponsab"];
		$idItem ['idInstitutionManifestation'] = $row["idInstitutionManifestation"];
		$idItem ['institutionManifestationName'] = $row["institutionManifestationName"];
		$idItem ['idManifInstitutionResponsab'] = $row["idManifInstitutionResponsab"];

		
		$idItem ['field1'] = $row["field1"];
		$idItem ['field2'] = $row["field2"];
		$idItem ['field3'] = $row["field3"];
		$idItem ['field4'] = $row["field4"];
		$idItem ['field5'] = $row["field5"];
		$idItem ['field9'] = $row["field9"];
		$idItem ['field10'] = $row["field10"];
		$idItem ['journalActs'] = $row["journalActs"];
		$idItem ['series'] = $row["series"];
		$idItem ['book'] = $row["book"];
		
		$idItem ['day'] = $row["day"];
		$idItem ['month'] = $row["month"];
		$idItem ['year'] = $row["year"]; 
		$idItem ['daystart'] = $row["daystart"];
		$idItem ['monthstart'] = $row["monthstart"];
		$idItem ['yearstart'] = $row["yearstart"];
		$idItem ['dayend'] = $row["dayend"];
		$idItem ['monthend'] = $row["monthend"];
		$idItem ['yearend'] = $row["yearend"];
		$idItem ['yearscan'] = $row["yearscan"];
		

		array_push($allIdItems, $idItem);
		
	}
	
	
	return $allIdItems;
}

//ELIMINARE QUESTA?
// get id of items of a collection (use get_item_by_id for get items)
function get_idItems_of_collection($conn, $idCollection){
	
	$idItem= [];
	$allIdItem= [];
	
	$sql= "select iditem from collectionitems where idcollection= " . $idCollection;
	$result = mysqli_query($conn, $sql);
	
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$idItem ['iditem'] = $row["iditem"];
		array_push($allIdItem, $idItem);
		
	}

	return $allIdItem;

}

//*****************************************//
//*********SEARCH FUNCTIONS*************//
//****************************************//


/////////////////////search3.0json.php

function search_work_from_inputs($conn, $idPeople, $idInstitutions, $idPeopleResponsability ,$idInstitutionResponsability, $title, $yearS, $yearE){
	
	$where="";
	$titleArray= array(); $intervalYear= array();

	if($title != ""){
		$title = mysqli_real_escape_string($conn, $title);
		$words = explode(' ', $title);
  		$sql_title=" work.title COLLATE UTF8_GENERAL_CI LIKE '%".$words[0]."%' ";
		foreach($words as $word) {
			$sql_title .= " AND work.title COLLATE UTF8_GENERAL_CI LIKE '%".$word."%' ";
		}
		//$where .= " where item.title LIKE '%$title%' ";
		//$titleArray[]= " work.title COLLATE UTF8_GENERAL_CI LIKE '%$title%' ";
		$titleArray[]= " " . $sql_title . " ";
	}
	if($yearS != "" || $yearE != ""){
			$intervalYear[]= " manifestationfield.year >= ". $yearS ." ";
			$intervalYear[]= " manifestationfield.year <= ". $yearE ." "; 
	}

	
	if($title != "" || $yearS != "" || $yearE != ""){
		$whereArray = array_merge($titleArray, $intervalYear);
		$where .= " where " . join(' and ', $whereArray);
	}	
	
	$objectwork= [];
	$allObjectWorks= [];
	
$sql= "select work.title, work.id as idwork, 
GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab,

GROUP_CONCAT(distinct( concat(itemresponsability.idpeople, '*', peopleItem.brief) ) order by itemresponsability.id) as peopleItemBrief,  GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.name) ) order by itemresponsability.id) as peopleItemName, GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.forname) ) order by itemresponsability.id) as peopleItemForname, GROUP_CONCAT(distinct(itemresponsability.idpeople) order by itemresponsability.id) as idPeopleItem, GROUP_CONCAT(distinct(concat(itemresponsability.idpeople, '*', itemresponsability.idresponsability)) order by itemresponsability.id) as idItemPeopleResponsab,
GROUP_CONCAT(distinct(institutionItem.name)) as institutionItemName, GROUP_CONCAT(distinct(itemresponsability.idinstitution)) as idInstitutionItem, GROUP_CONCAT(distinct(concat(itemresponsability.idinstitution,'*',itemresponsability.idresponsability))) as idItemInstitutionResponsab

from work

left join item on item.idwork = work.id
left join itemresponsability on itemresponsability.idlevel = item.id
left join people peopleItem on peopleItem.id = itemresponsability.idpeople
left join institution institutionItem on institutionItem.id = itemresponsability.idinstitution

left join manifestation on manifestation.idwork = work.id
left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id


left join expression on expression.idwork = work.id
left join expressionresponsability on expressionresponsability.idlevel = expression.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution


left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution " . $where .



" group by work.id ";

if(!empty($idPeople) || !empty($idInstitutions)){
	$having= " having ";
	$valoriP= array();
	$valoriI= array();
	if(!empty($idPeople)){
		for($i= 0; $i < count($idPeople); $i++){
			if($idPeopleResponsability[$i] != ""){
				$valoriP[] = " (Find_In_Set('$idPeople[$i]*$idPeopleResponsability[$i]', idWorkPeopleResponsab)>0 or Find_In_Set('$idPeople[$i]*$idPeopleResponsability[$i]', idExpressionPeopleResponsab)>0 or Find_In_Set('$idPeople[$i]*$idPeopleResponsability[$i]', idManifPeopleResponsab)>0) ";
			}else {$valoriP[] = " (Find_In_Set('$idPeople[$i]', idPeopleWork)>0 or Find_In_Set('$idPeople[$i]', idPeopleExpression)>0 or Find_In_Set('$idPeople[$i]', idPeopleManifestation)>0) ";}
		}	
	}
	if(!empty($idInstitutions)){
		for($i= 0; $i < count($idInstitutions); $i++){
			if($idInstitutionResponsability[$i] != ""){
				$valoriI[] = " (Find_In_Set('$idInstitutions[$i]*$idInstitutionResponsability[$i]', idWorkInstitutionResponsab)>0 or Find_In_Set('$idInstitutions[$i]*$idInstitutionResponsability[$i]', idExpressionInstitutionResponsab)>0 or Find_In_Set('$idInstitutions[$i]*$idInstitutionResponsability[$i]', idManifInstitutionResponsab)>0 or Find_In_Set('$idInstitutions[$i]*$idInstitutionResponsability[$i]', idItemInstitutionResponsab)>0)  ";
			} else $valoriI[] = " (Find_In_Set('$idInstitutions[$i]', idInstitutionWork)>0 or Find_In_Set('$idInstitutions[$i]', idInstitutionExpression)>0 or Find_In_Set('$idInstitutions[$i]', idInstitutionManifestation)>0 or Find_In_Set('$idInstitutions[$i]', idInstitutionItem)>0) ";
		}
	}
	$idInstidPeople = array_merge($valoriP, $valoriI);
	$having .= join(' and ', $idInstidPeople);
} else $having="";
	
	
	$result= mysqli_query($conn, $sql . $having);

	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$objectwork ['idwork'] = $row["idwork"];
		$objectwork ['title'] = $row["title"]; 

		$objectwork ['idPeopleWork'] = $row["idPeopleWork"];
		$objectwork ['workPeopleBrief'] = $row["workPeopleBrief"];
		$objectwork ['workPeopleSurname'] = $row["workPeopleSurname"];	
		$objectwork ['workPeopleName'] = $row["workPeopleName"];		
		$objectwork ['idWorkPeopleResponsab'] = $row["idWorkPeopleResponsab"];
		$objectwork ['idInstitutionWork'] = $row["idInstitutionWork"];
		$objectwork ['workInstitutionName'] = $row["workInstitutionName"];
		$objectwork ['idWorkInstitutionResponsab'] = $row["idWorkInstitutionResponsab"];


		array_push($allObjectWorks, $objectwork);
		
	}
	
	
	return $allObjectWorks;
}





function get_object_manifestations_by($conn, $idWork){
	

	$idItem= [];
	$allIdItems= [];
	
$sql= "select work.title, work.id as idwork, manifestation.idexpression as idexpr, manifestation.iditem as iditem,  manifestationfield.idmanifestation as idmanif, item.id as itemid, exprDescriptionLevel.name as exprType, manifDescriptionLevel.name as manifType,
item.extlink as extLink, item.fileurl as localFile, item.capability,
manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field9, manifestationfield.field10,
journalActs.name as journalActs, series.name as series, book.name as book,
manifestationfield.year, manifestationfield.month, manifestationfield.day,
manifestationfield.yearstart, manifestationfield.monthstart, manifestationfield.daystart,
manifestationfield.yearend, manifestationfield.monthend, manifestationfield.dayend,
manifestationfield.yearscan,  
manifestationfield.iddescriptionlevel as idManifestationType, 
manifestationfield.iddescriptionleveloriginal as idManifestationTypeOriginal, 

GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab,

GROUP_CONCAT(distinct( concat(itemresponsability.idpeople, '*', peopleItem.brief) ) order by itemresponsability.id) as peopleItemBrief,  GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.name) ) order by itemresponsability.id) as peopleItemName, GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.forname) ) order by itemresponsability.id) as peopleItemForname, GROUP_CONCAT(distinct(itemresponsability.idpeople) order by itemresponsability.id) as idPeopleItem, GROUP_CONCAT(distinct(concat(itemresponsability.idpeople, '*', itemresponsability.idresponsability)) order by itemresponsability.id) as idItemPeopleResponsab,
GROUP_CONCAT(distinct(institutionItem.name)) as institutionItemName, GROUP_CONCAT(distinct(itemresponsability.idinstitution)) as idInstitutionItem, GROUP_CONCAT(distinct(concat(itemresponsability.idinstitution,'*',itemresponsability.idresponsability))) as idItemInstitutionResponsab


from manifestation

left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id
left join descriptionlevel manifDescriptionLevel on manifDescriptionLevel.id= manifestationfield.iddescriptionlevel


left join work on work.id = manifestation.idwork
left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution

left join expression on expression.idwork = work.id
left join expressionresponsability on expressionresponsability.idlevel = expression.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution
left join expression exp2 on exp2.id = manifestation.idexpression
left join descriptionlevel exprDescriptionLevel on exprDescriptionLevel.id = exp2.type

left join item on item.idmanifestation = manifestation.id
left join itemresponsability on itemresponsability.idlevel = item.id
left join people peopleItem on peopleItem.id = itemresponsability.idpeople
left join institution institutionItem on institutionItem.id = itemresponsability.idinstitution

where manifestation.idwork=$idWork

group by manifestation.id" ;

	
	
	$result= mysqli_query($conn, $sql);
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$idItem ['idManifestationType'] = $row["idManifestationType"]; 
 		$idItem ['idManifestationTypeOriginal'] = $row["idManifestationTypeOriginal"];
		
		$idItem ['idwork'] = $row["idwork"];
		$idItem ['idmanif'] = $row["idmanif"];
		$idItem ['idexpr'] = $row["idexpr"];
		$idItem ['iditem'] = $row["iditem"];
		$idItem ['title'] = $row["title"]; 
		
		$idItem ['exprType'] = $row["exprType"];
		$idItem ['manifType'] = $row["manifType"];



		$idItem ['idPeopleWork'] = $row["idPeopleWork"];
		$idItem ['workPeopleBrief'] = $row["workPeopleBrief"];
		$idItem ['workPeopleSurname'] = $row["workPeopleSurname"];	
		$idItem ['workPeopleName'] = $row["workPeopleName"];		
		$idItem ['idWorkPeopleResponsab'] = $row["idWorkPeopleResponsab"];
		$idItem ['idInstitutionWork'] = $row["idInstitutionWork"];
		$idItem ['workInstitutionName'] = $row["workInstitutionName"];
		$idItem ['idWorkInstitutionResponsab'] = $row["idWorkInstitutionResponsab"];
		
		$idItem ['idPeopleExpression'] = $row["idPeopleExpression"];
		$idItem ['peopleExpressionBrief'] = $row["peopleExpressionBrief"];
		$idItem ['peopleExpressionForname'] = $row["peopleExpressionForname"];
		$idItem ['peopleExpressionName'] = $row["peopleExpressionName"];
		$idItem ['idExpressionPeopleResponsab'] = $row["idExpressionPeopleResponsab"];
		$idItem ['idInstitutionExpression'] = $row["idInstitutionExpression"];
		$idItem ['institutionExpressionName'] = $row["institutionExpressionName"];		
		$idItem ['idExpressionInstitutionResponsab'] = $row["idExpressionInstitutionResponsab"];
		
		$idItem ['idPeopleManifestation'] = $row["idPeopleManifestation"];
		$idItem ['peopleManifestationBrief'] = $row["peopleManifestationBrief"];	
		$idItem ['peopleManifestationName'] = $row["peopleManifestationName"];
		$idItem ['peopleManifestationForname'] = $row["peopleManifestationForname"];		
		$idItem ['idManifPeopleResponsab'] = $row["idManifPeopleResponsab"];
		$idItem ['idInstitutionManifestation'] = $row["idInstitutionManifestation"];
		$idItem ['institutionManifestationName'] = $row["institutionManifestationName"];
		$idItem ['idManifInstitutionResponsab'] = $row["idManifInstitutionResponsab"];

		
		$idItem ['field1'] = $row["field1"];
		$idItem ['field2'] = $row["field2"];
		$idItem ['field3'] = $row["field3"];
		$idItem ['field4'] = $row["field4"];
		$idItem ['field5'] = $row["field5"];
		$idItem ['field9'] = $row["field9"];
		$idItem ['field10'] = $row["field10"];
		$idItem ['journalActs'] = $row["journalActs"];
		$idItem ['series'] = $row["series"];
		$idItem ['book'] = $row["book"];
		
		$idItem ['day'] = $row["day"];
		$idItem ['month'] = $row["month"];
		$idItem ['year'] = $row["year"];
		$idItem ['daystart'] = $row["daystart"];
		$idItem ['monthstart'] = $row["monthstart"];
		$idItem ['yearstart'] = $row["yearstart"];
		$idItem ['dayend'] = $row["dayend"];
		$idItem ['monthend'] = $row["monthend"];
		$idItem ['yearend'] = $row["yearend"];
		$idItem ['yearscan'] = $row["yearscan"];
		

		array_push($allIdItems, $idItem);
		
	}
	
	
	return $allIdItems;
}




function get_object_items_by($conn, $idWork, $fileSecretPermission){
	

	$idItem= [];
	$allIdItems= [];
	
$sql= "select work.title, work.id as idwork, manifestation.idexpression as idexpr, item.id as iditem,  
manifestationfield.idmanifestation as idmanif, item.id as itemid, exprDescriptionLevel.name as exprType, manifDescriptionLevel.name as manifType,
item.extlink as extLink, item.fileurl as localFile, item.capability, item.dayvisited as dayItemVisited, item.monthvisited as monthItemVisited, item.yearvisited as yearItemVisited,
manifestationfield.field1, manifestationfield.field2, manifestationfield.field3, manifestationfield.field4, manifestationfield.field5, manifestationfield.field9, manifestationfield.field10,
journalActs.name as journalActs, series.name as series, book.name as book,
manifestationfield.year, manifestationfield.month, manifestationfield.day,
manifestationfield.yearstart, manifestationfield.monthstart, manifestationfield.daystart,
manifestationfield.yearend, manifestationfield.monthend, manifestationfield.dayend,
manifestationfield.iddescriptionlevel as idManifestationType, 
manifestationfield.iddescriptionleveloriginal as idManifestationTypeOriginal, 

GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab,

GROUP_CONCAT(distinct( concat(itemresponsability.idpeople, '*', peopleItem.brief) ) order by itemresponsability.id) as peopleItemBrief,  GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.name) ) order by itemresponsability.id) as peopleItemName, GROUP_CONCAT(distinct(  concat(itemresponsability.idpeople, '*', peopleItem.forname) ) order by itemresponsability.id) as peopleItemForname, GROUP_CONCAT(distinct(itemresponsability.idpeople) order by itemresponsability.id) as idPeopleItem, GROUP_CONCAT(distinct(concat(itemresponsability.idpeople, '*', itemresponsability.idresponsability)) order by itemresponsability.id) as idItemPeopleResponsab,
GROUP_CONCAT(distinct(institutionItem.name)) as institutionItemName, GROUP_CONCAT(distinct(itemresponsability.idinstitution)) as idInstitutionItem, GROUP_CONCAT(distinct(concat(itemresponsability.idinstitution,'*',itemresponsability.idresponsability))) as idItemInstitutionResponsab,
respItem.name as itemRespName



from item

left join manifestation on manifestation.id = item.idmanifestation
left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id
left join descriptionlevel manifDescriptionLevel on manifDescriptionLevel.id= manifestationfield.iddescriptionlevel


left join work on work.id = manifestation.idwork
left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution

left join expression on expression.idwork = work.id
left join expression exp2 on exp2.id = manifestation.idexpression
left join descriptionlevel exprDescriptionLevel on exprDescriptionLevel.id = exp2.type
left join expressionresponsability on expressionresponsability.idlevel = exp2.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution


left join itemresponsability on itemresponsability.idlevel = item.id
left join people peopleItem on peopleItem.id = itemresponsability.idpeople
left join institution institutionItem on institutionItem.id = itemresponsability.idinstitution
left join responsability respItem on respItem.id= itemresponsability.idresponsability

where manifestation.idwork=$idWork

group by item.id" ;

	
	
	$result= mysqli_query($conn, $sql);
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$idItem ['idManifestationType'] = $row["idManifestationType"]; 
 		$idItem ['idManifestationTypeOriginal'] = $row["idManifestationTypeOriginal"];
		
		$idItem ['idwork'] = $row["idwork"];
		$idItem ['idmanif'] = $row["idmanif"];
		$idItem ['idexpr'] = $row["idexpr"];
		$idItem ['iditem'] = $row["iditem"];
		$idItem ['capability'] = $row["capability"];
		$idItem ['dayItemVisited'] = $row["dayItemVisited"];
		$idItem ['monthItemVisited'] = $row["monthItemVisited"];
		$idItem ['yearItemVisited'] = $row["yearItemVisited"];
		$idItem ['fileSecretPermission'] = $fileSecretPermission; 
		$idItem ['localFile'] = $row["localFile"];
		$idItem ['extLink'] = $row["extLink"];
		$idItem ['title'] = $row["title"]; 
		
		$idItem ['exprType'] = $row["exprType"];
		$idItem ['manifType'] = $row["manifType"];



		$idItem ['idPeopleWork'] = $row["idPeopleWork"];
		$idItem ['workPeopleBrief'] = $row["workPeopleBrief"];
		$idItem ['workPeopleSurname'] = $row["workPeopleSurname"];	
		$idItem ['workPeopleName'] = $row["workPeopleName"];		
		$idItem ['idWorkPeopleResponsab'] = $row["idWorkPeopleResponsab"];
		$idItem ['idInstitutionWork'] = $row["idInstitutionWork"];
		$idItem ['workInstitutionName'] = $row["workInstitutionName"];
		$idItem ['idWorkInstitutionResponsab'] = $row["idWorkInstitutionResponsab"];
		
		$idItem ['idPeopleExpression'] = $row["idPeopleExpression"];
		$idItem ['peopleExpressionBrief'] = $row["peopleExpressionBrief"];
		$idItem ['peopleExpressionForname'] = $row["peopleExpressionForname"];
		$idItem ['peopleExpressionName'] = $row["peopleExpressionName"];
		$idItem ['idExpressionPeopleResponsab'] = $row["idExpressionPeopleResponsab"];
		$idItem ['idInstitutionExpression'] = $row["idInstitutionExpression"];
		$idItem ['institutionExpressionName'] = $row["institutionExpressionName"];		
		$idItem ['idExpressionInstitutionResponsab'] = $row["idExpressionInstitutionResponsab"];
		
		$idItem ['idPeopleManifestation'] = $row["idPeopleManifestation"];
		$idItem ['peopleManifestationBrief'] = $row["peopleManifestationBrief"];	
		$idItem ['peopleManifestationName'] = $row["peopleManifestationName"];
		$idItem ['peopleManifestationForname'] = $row["peopleManifestationForname"];		
		$idItem ['idManifPeopleResponsab'] = $row["idManifPeopleResponsab"];
		$idItem ['idInstitutionManifestation'] = $row["idInstitutionManifestation"];
		$idItem ['institutionManifestationName'] = $row["institutionManifestationName"];
		$idItem ['idManifInstitutionResponsab'] = $row["idManifInstitutionResponsab"];
		
		$idItem ['idPeopleItem'] = $row["idPeopleItem"];
		$idItem ['peopleItemBrief'] = $row["peopleItemBrief"];
		$idItem ['idItemPeopleResponsab'] = $row["idItemPeopleResponsab"];
		$idItem ['idInstitutionItem'] = $row["idInstitutionItem"];
		$idItem ['institutionItemName'] = $row["institutionItemName"];
		$idItem ['idItemInstitutionResponsab'] = $row["idItemInstitutionResponsab"];
		$idItem ['itemRespName'] = $row["itemRespName"];

		
		$idItem ['field1'] = $row["field1"];
		$idItem ['field2'] = $row["field2"];
		$idItem ['field3'] = $row["field3"];
		$idItem ['field4'] = $row["field4"];
		$idItem ['field5'] = $row["field5"];
		$idItem ['field9'] = $row["field9"];
		$idItem ['field10'] = $row["field10"];
		$idItem ['journalActs'] = $row["journalActs"];
		$idItem ['series'] = $row["series"];
		$idItem ['book'] = $row["book"];
		
		$idItem ['day'] = $row["day"];
		$idItem ['month'] = $row["month"];
		$idItem ['year'] = $row["year"];
		$idItem ['daystart'] = $row["daystart"];
		$idItem ['monthstart'] = $row["monthstart"];
		$idItem ['yearstart'] = $row["yearstart"];
		$idItem ['dayend'] = $row["dayend"];
		$idItem ['monthend'] = $row["monthend"];
		$idItem ['yearend'] = $row["yearend"];		

		
		$idItem ['sql'] = $sql;

		array_push($allIdItems, $idItem);
		
	}
	
	
	return $allIdItems;
}

//use for search this work from url of a collection
function get_object_work_by($conn, $idWork){
	

	$idItem= [];
	$allIdItems= [];
	
$sql= "select work.title, work.id as idwork, 
GROUP_CONCAT(distinct( concat(workresponsability.idpeople, '*', peopleWork.brief) ) order by workresponsability.id) as workPeopleBrief, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.name)) order by workresponsability.id) as workPeopleName, GROUP_CONCAT(distinct(  concat(workresponsability.idpeople, '*', peopleWork.forname) ) order by workresponsability.id) as workPeopleSurname, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, workresponsability.idpeople,null) ) order by workresponsability.id) as idPeopleWork, GROUP_CONCAT(distinct( if (workresponsability.idpeople>0, concat(workresponsability.idpeople, '*', workresponsability.idresponsability),null) ) order by workresponsability.id) as idWorkPeopleResponsab,
GROUP_CONCAT(distinct(institutionWork.name)) as workInstitutionName, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0, workresponsability.idinstitution,null))) as idInstitutionWork, GROUP_CONCAT(distinct(if (workresponsability.idinstitution>0,concat(workresponsability.idinstitution,'*',workresponsability.idresponsability),null))) as idWorkInstitutionResponsab, 

GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.brief) ) order by expressionresponsability.id) as peopleExpressionBrief, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.name) ) order by expressionresponsability.id) as peopleExpressionName, GROUP_CONCAT(distinct( concat(expressionresponsability.idpeople, '*', peopleExpression.forname) ) order by expressionresponsability.id) as peopleExpressionForname, GROUP_CONCAT(distinct( if (Expressionresponsability.idpeople>0, Expressionresponsability.idpeople,null ) ) order by expressionresponsability.id) as idPeopleExpression, GROUP_CONCAT(distinct(if (expressionresponsability.idpeople>0, concat(expressionresponsability.idpeople, '*', expressionresponsability.idresponsability),null)) order by expressionresponsability.id) as idExpressionPeopleResponsab,
GROUP_CONCAT(distinct(institutionExpression.name)) as institutionExpressionName, GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, expressionresponsability.idinstitution,null) )) as idInstitutionExpression,  GROUP_CONCAT(distinct(if (expressionresponsability.idinstitution>0, concat(expressionresponsability.idinstitution,'*',Expressionresponsability.idresponsability),null))) as idExpressionInstitutionResponsab,

GROUP_CONCAT(distinct( concat(manifestationresponsability.idpeople, '*', peopleManifestation.brief) ) order by manifestationresponsability.id) as peopleManifestationBrief, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.name) ) order by manifestationresponsability.id) as peopleManifestationName, GROUP_CONCAT(distinct(  concat(manifestationresponsability.idpeople, '*', peopleManifestation.forname) ) order by manifestationresponsability.id) as peopleManifestationForname, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, manifestationresponsability.idpeople,null)) order by manifestationresponsability.id) as idPeopleManifestation, GROUP_CONCAT(distinct(if (manifestationresponsability.idpeople>0, concat(manifestationresponsability.idpeople, '*' , manifestationresponsability.idresponsability),null)) order by manifestationresponsability.id) as idManifPeopleResponsab,
GROUP_CONCAT(distinct(institutionManifestation.name)) as institutionManifestationName, GROUP_CONCAT(distinct(if (manifestationresponsability.idinstitution>0, manifestationresponsability.idinstitution,null))) as idInstitutionManifestation, GROUP_CONCAT(distinct( if (manifestationresponsability.idinstitution>0, concat(manifestationresponsability.idinstitution,'*',manifestationresponsability.idresponsability),null) )) as idManifInstitutionResponsab



from work

left join manifestation on manifestation.idwork = work.id
left join manifestationresponsability on manifestationresponsability.idlevel = manifestation.id
left join people peopleManifestation on peopleManifestation.id = manifestationresponsability.idpeople
left join institution institutionManifestation on institutionManifestation.id = manifestationresponsability.idinstitution
left join manifestationfield on manifestationfield.idmanifestation = manifestation.id
left join publications journalActs on manifestationfield.field8 = journalActs.id
left join publications series on manifestationfield.field7 = series.id
left join publications book on manifestationfield.field6 = book.id


left join expression on expression.idwork = work.id
left join expressionresponsability on expressionresponsability.idlevel = expression.id
left join people peopleExpression on peopleExpression.id = expressionresponsability.idpeople
left join institution institutionExpression on institutionExpression.id = expressionresponsability.idinstitution


left join workresponsability on workresponsability.idlevel = work.id
left join people peopleWork on peopleWork.id = workresponsability.idpeople
left join institution institutionWork on institutionWork.id = workresponsability.idinstitution 

where work.id=$idWork

group by work.id ";

	
	
	$result= mysqli_query($conn, $sql);
	// output data of each row
	while($row = mysqli_fetch_assoc($result)) {

		$idItem ['idwork'] = $row["idwork"];
		$idItem ['title'] = $row["title"]; 

		$idItem ['idPeopleWork'] = $row["idPeopleWork"];
		$idItem ['workPeopleBrief'] = $row["workPeopleBrief"];
		$idItem ['workPeopleSurname'] = $row["workPeopleSurname"];	
		$idItem ['workPeopleName'] = $row["workPeopleName"];		
		$idItem ['idWorkPeopleResponsab'] = $row["idWorkPeopleResponsab"];
		$idItem ['idInstitutionWork'] = $row["idInstitutionWork"];
		$idItem ['workInstitutionName'] = $row["workInstitutionName"];
		$idItem ['idWorkInstitutionResponsab'] = $row["idWorkInstitutionResponsab"];


		array_push($allIdItems, $idItem);
		
	}
	
	
	return $allIdItems;
}




function get_numRows_object_expression($conn, $arrayIdWorks){
	if(!empty($arrayIdWorks)){
		$num_rows=0;
		$sql="select count(*) as num_rows
		from expression as e
		left join descriptionlevel ON descriptionlevel.id = e.type where e.idWork = ";
		$sql .= join(' or e.idWork = ', $arrayIdWorks);
		$result= mysqli_query($conn, $sql );
		while($row = mysqli_fetch_assoc($result)) {
			$num_rows = $row['num_rows'];
		}
	} else {$num_rows=0;}
	return $num_rows;
}

function get_numRows_object_manifestation($conn, $arrayIdWorks){
	
	if(!empty($arrayIdWorks)){
		$num_rows=0;
		$sql="select count(*) as num_rows
		from manifestation
		left join work on work.id = manifestation.idwork
		where manifestation.idwork= ";
		$sql .= join(' or manifestation.idwork = ', $arrayIdWorks);
		
		$result= mysqli_query($conn, $sql );
		while($row = mysqli_fetch_assoc($result)) {
			$num_rows = $row['num_rows'];
		}
	} else {$num_rows=0;}
	return $num_rows;

}

function get_numRows_object_item($conn, $arrayIdWorks){

	if(!empty($arrayIdWorks)){
		$num_rows=0;
		$sql="select count(*) as num_rows
		from item
		left join work on work.id = item.idwork
		where work.id= ";
		$sql .= join(' or work.id = ', $arrayIdWorks);
		$result= mysqli_query($conn, $sql );
		while($row = mysqli_fetch_assoc($result)) {
			$num_rows = $row['num_rows'];
		}
	} else {$num_rows=0;}
	return $num_rows;
}



// ///////////////////////////////////////////////////////






?>