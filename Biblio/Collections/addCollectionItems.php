<!DOCTYPE html>

<html>
<?php 
include('../../Administration/Assets/PHP/sessionSet.php');
include('../../Administration/Assets/PHP/controlLogged.php');

if($catalogerPermission == 0 ) {
	header('Location: https://www.progettohmr.it/Administration/Assets/PHP/autentication.php');
}

if(isset($_SESSION['fileSecretPermission'])){$fileSecretPermission = $_SESSION['fileSecretPermission'];} else {$fileSecretPermission= null;}
//$fileSecretPermission (1: connected people with permission; 0: connected people without permission (students); null: people not connected
	
require ('../../../Config/Biblio_config.php');
require ('../Assets/PHP/functions_get.php');
require ('../../OggiSTI/Assets/Api/creaSelect.php');


// get id and name collection
$idCollection= $_GET['idCollection'];
$nameCollection= $_GET['nameCollection'];

// get id items of that collection 
$itemsOfCollection= get_collection_by_idCollection($conn, $idCollection, 0,$fileSecretPermission);



// get data for filters
$people= get_people($conn);
$institutions= get_institutions($conn);
$responsability= get_allResponsability($conn);
$manifestationType= get_descriptionsType($conn, "manifestation");

?>
<head>
 <meta charset="UTF-8">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	
	<!--jquery ui for drag and drop-->
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!--For select searching-->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
	
	<!--Lib for trees-->
	<link rel="stylesheet" href="../Assets/libraries/vakata-jstree-6dce227/dist/themes/default/style.min.css" />
	<script src="../Assets/libraries/vakata-jstree-6dce227/dist/jstree.min.js"></script>

	<!--Style-->
	<link rel="stylesheet" href="../../HMR_Style.css">
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">


	
	<script src="../../Assets/JS/HMR_CreaHTML.js"></script>	
	<script src="../Assets/JS/barMenu.js"></script>	


	<!--Lib for search-->
	<script src="../Assets/JS/format_print_biblio2.0.js"></script>
	<script src="../Assets/JS/inputSearch.js"></script>
    <script src="../Assets/JS/search3.0json.js"></script>
	
	<link rel="stylesheet" href="../Assets/CSS/search3.0json_Style.css">
    <link rel="stylesheet" href="../Assets/CSS/jstree.css">
	
	
	<!-- Add icon library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	

	<script>
		$(document).ready(function() {
			var itemOfCollection= <?php echo json_encode($itemsOfCollection); ?>;
			
			var item="";
			for(var i=0; i<itemOfCollection.length; i++){
				item=format_item(itemOfCollection[i],0)
				
				if(itemOfCollection[i].level == "item"){
					var idObj= itemOfCollection[i].iditem
					var manifItem= "i"
					var nameInputId= "idItems[]"
					var nameInputPosition= "positionItems[]"
				} else {
					var idObj= itemOfCollection[i].idmanif
					var manifItem= "m"
					var nameInputId= "idManifestations[]"
					var nameInputPosition= "positionManifestations[]"
				}
				
				$('#mycollection').append("<li class='ui-state-default'><span>"+(i+1)+"</span> - " + item +   "<button type='button'  id='delete-"+manifItem+"-"+idObj+"' class='removeItemFromCollection'><i class='fa fa-minus'></i></button><input type='hidden' name='"+nameInputId+"' value='"+idObj+"'> <input type='hidden' class='inputPositionC' name='"+nameInputPosition+"' value='"+(i+1)+"'> </li>")
			}
			
			$('#mycollection').on('click', '.removeItemFromCollection', deleteFromCollection )

		})
	</script>
	
	<script>
	
	$(document).ready(function () {
        $(document).on("click", ".addColl", function(){

		var id = $(this).attr("id");
		// if flicked manifestation idManifItem[1]=m, 
		// if flicked item idManifItem[1]=i,
		// idManifItem[2] = id
		var idManifItem= id.split('-')
		
		
		 $.ajax({  
             type: "GET",
             url: '../Assets/apiDb/Collections/collection_api.php',
             dataType: "JSON",					
             data: {manifItem: idManifItem[1], id: idManifItem[2] },
             success: function(risposta) {
				 

				 // get biblio record and number of items collection
				 var numberOfItems= $('#mycollection li').length
				 var result= format_item(risposta.objectInCollection[0])
				 
				// if manifestation or if item
				if(risposta.manifItem == "i"){
					var nameInputId= "idItems[]"
					var nameInputPosition= "positionItems[]"
					var idObj= risposta.objectInCollection[0].iditem
				} else {
					var nameInputId= "idManifestations[]"
					var nameInputPosition= "positionManifestations[]"
					var idObj= risposta.objectInCollection[0].idmanif
				}
				 
				 $('#mycollection').append("<li> <span>"+(numberOfItems+1)+"</span> - " + result + "<button type='button'  id='delete-"+risposta.manifItem+"-"+idObj+"' class='removeItemFromCollection'><i class='fa fa-minus'></i></button><input type='hidden' name='"+nameInputId+"' value='"+idObj+"'> <input type='hidden' class='inputPositionC' name='"+nameInputPosition+"' value='"+(numberOfItems+1)+"'></li>").on('click', '.removeItemFromCollection', deleteFromCollection )
				 
				 
				 
			 
			 },
	         error: function(response){
                  var a= JSON.stringify(response)
                  alert(a)
                  
             }
		 })	

		})
	})		
		
	
	
	</script>
	
	<script>
	function deleteFromCollection(){
		
		$('.removeItemFromCollection').on('click', function() {
			
			// remove item,manifestation
			$(this).parent().remove();
			
			// compute new position
			$( "#mycollection li" ).each(function( index, element ) {
				$(this).find("span").html(index+1);
				$(this).find(".inputPositionC").val(index+1)
			})
		})
	}
	
	</script>
	
  <script>
  // drag and drop
  $( function() {
    $( ".sortable" ).sortable({
      revert: true,
	  opacity: 0.5,
	   stop: function(){
		   // compute new position after drop
			$( "#mycollection li" ).each(function( index, element ) {
				$(this).find("span").html(index+1);
				$(this).find(".inputPositionC").val(index+1)
			})
	   }
    });
    $( "#draggable" ).draggable({
      connectToSortable: ".sortable",
      helper: "clone",
      revert: "invalid"
    });
    $( "ul, li" ).disableSelection();
  

  } );
  </script>
  
  
  <?php
  // If add biblio from search bibliotetic
  if(isset($_GET['level']) && isset($_GET['id'])){

	$manifItem = $_GET['level'];
	$id= $_GET['id'];
	if($manifItem == "m"){

	$object= get_object_manifestations_by_idManifestation($conn, $id);

	} else {$object= get_object_items_by_idItem($conn, $id, $fileSecretPermission);}
	
	$html= "
	<script>
	$(document).ready(function() {
		// get biblio record and number of items collection
		var numberOfItems= $('#mycollection li').length
		var resultJson= " . json_encode($object) ."
		var result= format_item(resultJson[0])
				 
		// if manifestation or if item
		if('".$_GET['level']."' == 'i'){
			var nameInputId= 'idItems[]'
			var nameInputPosition= 'positionItems[]'
			var idObj= ".$object[0]['iditem'] ."
		} else {
			var nameInputId= 'idManifestations[]'
			var nameInputPosition= 'positionManifestations[]'
			var idObj= ".$object[0]['idmanif'] ."
		} ";
				 
		$html2= " $('#mycollection').append('<li> <span>'+(numberOfItems+1)+'</span> - ' + result + '<button type=&#39;button&#39;  id=&#39;delete-".$_GET['level']."-'+idObj+'&#39; class=&#39;removeItemFromCollection&#39;><i class=&#39;fa fa-minus&#39;></i></button><input type=&#39;hidden&#39; name=&#39;'+nameInputId+'&#39; value=&#39;'+idObj+'&#39;> <input type=&#39;hidden&#39; class=&#39;inputPositionC&#39; name=&#39;'+nameInputPosition+'&#39; value=&#39;'+(numberOfItems+1)+'&#39;></li>').on('click', '.removeItemFromCollection', deleteFromCollection );
		
		

				//script form popup
				$('.hover_bkgr_fricc').show();
				
				$('.hover_bkgr_fricc').click(function(){
					$('.hover_bkgr_fricc').hide();
				});
				$('.popupCloseButton').click(function(){
					$('.hover_bkgr_fricc').hide();
				});
			


			
		})
	</script>
		
	<!--Popup-->
	<div class='hover_bkgr_fricc'>
		<span class='helper'></span>
		<div>
			<div class='popupCloseButton'>&times;</div>
			<p style='color:green'>Riferimento bibliografico correttamente inserito </br> in fondo alla collezione</p>
		</div>
	</div>";

		$html2= str_replace("&#39;",'"',$html2);		 

	
	
	echo $html . $html2 ;
	
	

   }

  ?>
  
  


<style>
li{list-style:none}
li:hover{cursor:move;}


/* Style for Popup */
.hover_bkgr_fricc{
    background:rgba(0,0,0,.4);
    cursor:pointer;
    display:none;
    height:100%;
    position:fixed;
    text-align:center;
    top:0;
    width:100%;
    z-index:10000;
}
.hover_bkgr_fricc .helper{
    display:inline-block;
    height:100%;
    vertical-align:middle;
}
.hover_bkgr_fricc > div {
    background-color: #fff;
    box-shadow: 10px 10px 60px #555;
    display: inline-block;
    height: auto;
    max-width: 551px;
    min-height: 100px;
    vertical-align: middle;
    width: 60%;
    position: relative;
    border-radius: 8px;
    padding: 15px 5%;
}
.popupCloseButton {
    background-color: #fff;
    border: 3px solid #999;
    border-radius: 50px;
    cursor: pointer;
    display: inline-block;
    font-family: arial;
    font-weight: bold;
    position: absolute;
    top: -20px;
    right: -20px;
    font-size: 25px;
    line-height: 30px;
    width: 30px;
    height: 30px;
    text-align: center;
}
.popupCloseButton:hover {
    background-color: #ccc;
}
.trigger_popup_fricc {
    cursor: pointer;
    font-size: 20px;
    margin: 20px;
    display: inline-block;
    font-weight: bold;
}

</style>
	
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
		
		<div id="AffinaRicerca" style="text-align: center;">
            <input type="checkbox" id="checkboxTitle" class="checkboxFilter" name="checkboxTitle"  value="filtersearch-title" checked>
            <label for="checkboxTitle"> Titolo </label>
            <input type="checkbox" id="checkboxIterval" class="checkboxFilter" name="checkboxIterval"  value="filtersearch-intervalyear" checked>
            <label for="checkboxIterval"> Data </label>
            <input type="checkbox" id="checkboxAdvanced" class="checkboxFilter" name="checkboxAdvanced"  value="filtersearch-advanced">
            <label for="checkboxAdvanced"> Avanzate </label>
            <!-- <input type="checkbox" id="checkboxPeople" class="checkboxFilter" name="checkboxPeople"  value="filtersearch-people">
            <label for="checkboxPeople"> Autori </label>
            <input type="checkbox" id="checkboxInstitution" class="checkboxFilter" name="checkboxInstitution"  value="filtersearch-institution">
            <label for="checkboxInstitution"> Istituzioni </label> -->
		</div>
    
        <div id="filterHead-container">
        
            <!--Title-->
            <div id="filtersearch-title" style="display: none" class="filtersearch" >
                <p id="TitolOpera">Filtro titolo</p>
                <input type="text" id="title"  placeholder="Scrivi un titolo o parte di un titolo" />
            </div>

            <!--Interval Year-->
            <div id="filtersearch-intervalyear" style="display: none" class="filtersearch">
                <p id="IntervalloTempo">Filtro intervallo di tempo</p>
                <select id="intervalyear-start">
                    <option value="">Dall’anno...</option>
                    <?php creaSelect($conn); ?>
                </select>

                <select id="intervalyear-end">
                    <option value="">All’anno...</option>
                    <?php creaReverseSelect($conn); ?>
                    <script type="text/javascript">
                        var arrayEnd = $("#intervalyear-end").children();
                    </script>
                </select>

            </div>

            <div id="search-inline">
                <button class="button button4" type='button' id="search"><i class="fa fa-search" id="fa-search"></i></button>
                <button type="button" id="azzeraCampi" class="button button4">Azzera campi</button>
            </div>
        
        </div>
        
		<!--People-->
		<div id="filtersearch-people" style="display: none" class="filtersearch">
				<p id="Persone">Filtri persone</p><button id="addPeople" type="button" class="button button4"><i class="fa fa-plus" id="fa-addPeople"></i></button> 
				<br/>
				
				<div class="selectPeople">
	
					<select class="idPeople" name="idPeople[]"  placeholder="Seleziona un’autore..." >
					<option value="">Seleziona un’autore...</option>
					<?php
						for( $i=0; $i < sizeOF($people); $i++ ){
							echo "<option value='" . $people[$i]["id"] . "'>" . $people[$i]["forname"] . " " .  $people[$i]["name"] . " (" .  $people[$i]["brief"] . ")" . " (ID: " . $people[$i]["id"] .  ")</option>";
						}
					?>
					</select> 
					
					<select class="idPeopleResponsability" name="idPeopleResponsability[]"  placeholder="Seleziona la responsabilità..." >
					<option value="">Seleziona la responsabilità...</option>
					<?php
						for( $i=0; $i < sizeOF($responsability); $i++ ){
							echo "<option value='" . $responsability[$i]["id"] . "'>" . $responsability[$i]["name"] . "</option>";
						}
					?>
					</select> 
                    <button type="button" class="button button4 deletePeople"><i class="fa fa-minus" id="fa-delPeople"></i></button>
					
				
				</div>
				
		</div>
		<!--Institutions-->
		<div id="filtersearch-institution" style="display: none" class="filtersearch">
		        <p id="Istituzioni">Filtri istituzioni</p><button id="addInstitution" type="button" class="button button4"><i class="fa fa-plus" id="fa-addInst"></i></button> 
				<br/>
				
				<div class="selectInstitution">
				
					<select class="idInstitution" name="idInstitution[]" class="filter" placeholder="Seleziona un’istituzione..." >
					<option value="">Seleziona un’istituzione...</option>
					<?php
						for( $i=0; $i < sizeOF($institutions); $i++ ){
							echo "<option value='" . $institutions[$i]["id"] . "'>" . $institutions[$i]["name"] . "</option>";
						}
					?>
					</select> 

					<select class="idInstitutionResponsability" name="idInstitutionResponsability[]" class="filter" placeholder="Seleziona la responsabilità..." >
					<option value="">Seleziona la responsabilità...</option>
					<?php
						for( $i=0; $i < sizeOF($responsability); $i++ ){
							echo "<option value='" . $responsability[$i]["id"] . "'>" . $responsability[$i]["name"] . "</option>";
						}
					?>
					</select> 	
                    <button type="button" class="button button4 deleteInstitution"><i class="fa fa-minus" id="fa-delInst"></i></button>
                    
				</div>
		
		</div>
		

                <div id="resultHead-container">
                    <h4 id="Risultati">Risultati:</h4>
                    <div id="numberResults" style="text-align: center;"></div>
                    <button type="button" id="azzeraRisultati" class="button button4">Azzera risultati</button>
                </div>
                <br/><br/>
                <div id="result"></div>
                <div style="text-align:center"><img class="loadingGif" id="loadingGif" src="../Assets/Img/Loading.gif" style="display: none;"></div>
                <br/>
                <div id="pageNumbers" style="text-align: center;"></div>

		

	
		</br> <!-- END FILTERS-->
		

	
		<form action="../Assets/apiDb/Collections/insert_items_inCollection.php" method="post">
		<input type='hidden' name='idCollection' value='<?php echo $idCollection; ?>'>
		
		<div style='text-align:center'><h2><?php echo $nameCollection; ?></h2></div>
		
		
		<ul id="mycollection" class="sortable"></ul>


		
		<br/><br/>
		

		
		
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