<!DOCTYPE html>

<html>
<?php 
include('../../Administration/Assets/PHP/sessionSet.php');
include('../../Administration/Assets/PHP/controlLogged.php');
	
if($catalogerPermission == 0 ) {
	header('Location: https://www.progettohmr.it/Administration/Assets/PHP/autentication.php');
}	
	
require ('../../../Config/Biblio_config.php');
require ('../Assets/PHP/functions_insert.php');
require ('../Assets/PHP/functions_get.php');
require ('../Assets/PHP/functions_update.php');


// for update/delete
if(isset($_GET['idModify'])){
	
	$id= $_GET['idModify'];
	$collectionToModify= get_collections($conn, $id);
	$CollectionName= htmlspecialchars($collectionToModify[0]['name'], ENT_QUOTES);
	$CollectionBrief= htmlspecialchars($collectionToModify[0]['brief'], ENT_QUOTES);
	$CollectionOrdering= $collectionToModify[0]['ordering'];
	
	
} else {$CollectionName= ""; $CollectionBrief= ""; $CollectionOrdering="";}


?>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<!--Style-->
	<link rel="stylesheet" href="../../HMR_Style.css">
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">

	
	<script src="../../Assets/JS/HMR_CreaHTML.js"></script>	
	<script src="../Assets/JS/barMenu.js"></script>	
	


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
	<ul>
		<li><a href="https://www.progettohmr.it/Biblio/biblioAdmin.php">Menù</a></li>
		<li><a href="https://www.progettohmr.it/Biblio/Collections/collection.php">Nuova collezione</a></li>
		<li><a href="https://www.progettohmr.it/Biblio/Collections/managementCollection.php">Gestisci collezioni</a></li>
	<ul>
</div>



<?php   
	if(isset($_GET['idModify'])){
		echo '<form action="../Assets/apiDb/Collections/update_collection.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idCollectionModify" value="'.$collectionToModify[0]["id"].'">';
		echo '<h1>Modifica:' . $CollectionName . '</h1>';
	
	} else {
		echo '<form action="../Assets/apiDb/Collections/insert_collection.php" method="post" enctype="multipart/form-data">';
		echo '<h1>Nuova collezione</h1>';
	}
?>

		
		<label>Titolo</label>
		<input value="<?php echo $CollectionName; ?>" type="text" name="title"/>
		
		</br>
		
		<label>Titolo breve</label>
		<input value="<?php echo $CollectionBrief; ?>" type="text" name="brief"/>
		
		<?php
		if($CollectionOrdering==0){$selected0="selected";} else{$selected0="";}
		if($CollectionOrdering==1){$selected1="selected";} else{$selected1="";}
		if($CollectionOrdering==2){$selected2="selected";} else{$selected2="";}
		?>
		<label>Ordinamento</label>
		<select name="ordering">
			<option value="0" <?php echo $selected0; ?>>Personalizzato</option>
			<option value="1" <?php echo $selected1; ?>>Data</option>
			<option value="2" <?php echo $selected2; ?>>Autore</option>
		</select>
		
		
		</br></br>
		
		
		<button type="submit" class="submitLevel" id="collection-submit">Inserisci nel database</button>

		
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