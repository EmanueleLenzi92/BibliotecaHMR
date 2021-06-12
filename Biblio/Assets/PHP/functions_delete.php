<?php

function deleteInstitution($conn, $id){

	$sql= "DELETE FROM institution WHERE id= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM workresponsability WHERE idinstitution= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM expressionresponsability WHERE idinstitution= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM manifestationresponsability WHERE idinstitution= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM itemresponsability WHERE idinstitution= " . $id;
	$result = mysqli_query($conn, $sql);
	
	
}

function deletePeople($conn, $id){

	$sql= "DELETE FROM people WHERE id= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM workresponsability WHERE idpeople= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM expressionresponsability WHERE idpeople= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM manifestationresponsability WHERE idpeople= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM itemresponsability WHERE idpeople= " . $id;
	$result = mysqli_query($conn, $sql);
	
	
}

function deleteWork($conn, $id){

	$sql= "DELETE FROM work WHERE id= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM workresponsability WHERE idlevel= " . $id;
	$result = mysqli_query($conn, $sql);
		
}

function deleteExpression($conn, $id){

	$sql= "DELETE FROM expression WHERE id= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM expressionresponsability WHERE idlevel= " . $id;
	$result = mysqli_query($conn, $sql);
		
}

function deleteManifestation($conn, $id){

	$sql= "DELETE FROM manifestation WHERE id= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM manifestationresponsability WHERE idlevel= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM manifestationfield WHERE idmanifestation= " . $id;
	$result = mysqli_query($conn, $sql);
		
}

function deleteItem($conn, $id){

	$sql= "DELETE FROM item WHERE id= " . $id;
	$result = mysqli_query($conn, $sql);
	
	$sql= "DELETE FROM itemresponsability WHERE idlevel= " . $id;
	$result = mysqli_query($conn, $sql);
		
}

?>