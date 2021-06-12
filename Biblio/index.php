<!DOCTYPE html>

<html>
<?php 

// Load libs only if we are in biblio
if (strpos($_SERVER['REQUEST_URI'], "Biblio") !== false) {
    require ('../../Config/Biblio_config.php');
    require ('Assets/PHP/functions_get.php');
    require ('../OggiSTI/Assets/Api/creaSelect.php');
}

$people= get_people($conn);
$institutions= get_institutions($conn);
$responsability= get_allResponsability($conn);
$manifestationType= get_descriptionsType($conn, "manifestation");

?>

<head>
	
    <?php // Different paths based on request uri
    if (strpos($_SERVER['REQUEST_URI'], "Biblio") !== false) : ?>
		<title>Biblioteca HMR</title>
		
		<meta name="description" content="La Biblioteca raccoglie tutto il materiale documentale recuperato o prodotto da HMR, catalagato secondo un estensione del modello FRBR e consultabile per tutti nel rispetto dei diritti di proprietà intelletuale.">

		<meta name="keywords" content="hackerando hacker hacking macchina ridotta calcolatrice elettronica pisana CEP biblioteca FRBR" />	

		<link rel="icon" type="image/png" href="../../Assets/Images/HMR_2017g_GC-WebFavIcon16x16.png" />
	
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <!--Lib for trees-->
        <link rel="stylesheet" href="Assets/libraries/vakata-jstree-6dce227/dist/themes/default/style.min.css" />
        <script src="Assets/libraries/vakata-jstree-6dce227/dist/jstree.min.js"></script>
        <!--For select searching-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
        <script src="Assets/JS/format_print_biblio2.0.js"></script>
        <script src="Assets/JS/inputSearch.js"></script>
        <script src="Assets/JS/search3.0json.js"></script>

        <!--Style-->
        <link rel="stylesheet" href="../HMR_Style.css">
        <link rel="stylesheet" href="Assets/CSS/Bibliostyle.css">
        <link rel="stylesheet" href="Assets/CSS/search3.0json_Style.css">
        <link rel="stylesheet" href="Assets/CSS/jstree.css">

        <script src="../Assets/JS/HMR_CreaHTML.js"></script>
		<script type='text/javascript' src='../EPICAC/JSwebsite/searchAndSharing.js'></script>
        <script src="Assets/JS/barMenu.js"></script>

        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script>
            $(document).ready(function () {
                $(document).on("click", ".addColl", function(){
                    var id = $(this).attr("id");
                    var idSplit= id.split('-');
                    var link= "Collections/managementCollection.php?level="+idSplit[1]+"&id="+idSplit[2];
                    window.open(link);
                });
            });
        </script>
		
		<?php
		if(isset($_GET["idWork"]) && isset($_GET["idItem"])){
			
			echo '<script src="Assets/JS/search_from_collectionLink.js"></script>';
		
		} else if (isset($_GET["idWork"]) && isset($_GET["idManif"])) {
			
			echo '<script src="Assets/JS/search_from_collectionLink.js"></script>';
		
		}
		?>
		
		
    <?php else : ?>
        <link rel="stylesheet" href="../../../Biblio/Assets/libraries/vakata-jstree-6dce227/dist/themes/default/style.min.css" />
        <script src="../../../Biblio/Assets/libraries/vakata-jstree-6dce227/dist/jstree.min.js"></script>
        <!--For select searching-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />
        <script src="../../../Biblio/Assets/JS/format_print_biblio2.0.js"></script>
        <script src="../../../Biblio/Assets/JS/inputSearch.js"></script>
        <script src="../../../Biblio/Assets/JS/search3.0json.js"></script>

        <!--Style-->
        <link rel="stylesheet" href="../../../HMR_Style.css">
        <link rel="stylesheet" href="../../../Biblio/Assets/CSS/Bibliostyle.css">
        <link rel="stylesheet" href="../../../Biblio/Assets/CSS/search3.0json_Style.css">
        <link rel="stylesheet" href="../../../Biblio/Assets/CSS/jstree.css">

        <!-- Add icon library -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php endif; ?>
	
</head>

<body>

 <form  method="get">
    
<?php // Only if we are in biblio
    if (strpos($_SERVER['REQUEST_URI'], "Biblio") !== false) : ?>
        <div class="HMR_Banner">
            <script> creaHeader(3, 'HMR_2017g_GC-WebHeaderRite-270x105-1.png') </script>
        </div>
        <div id="HMR_Menu" class="HMR_Menu" >
            <script> creaMenu(3, 8) </script>
        </div>
    <div class="HMR_Content"><div class= "HMR_Text">
	
	<h1>La Biblioteca di HMR</h1>

	<p>
	La Biblioteca raccoglie tutto il materiale documentale recuperato o prodotto da HMR, catalagato secondo un'estensione del 
	modello FRBR e consultabile per tutti nel rispetto dei diritti di proprietà intelletuale.
	</p>
	

	<h2 style="display: inline">Cerca nella biblioteca</h2>
		<div id="AffinaRicerca" style="display: inline">
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
<?php else : ?>
		<div id="AffinaRicerca" style="display: inline">
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
	
<?php endif; ?>
		

    
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
                <button class="button button4" type='button' id="search" title="Ricerca"><i class="fa fa-search" id="fa-search"></i></button>
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
		
		
        <?php // Different paths based on request uri
            if (strpos($_SERVER['REQUEST_URI'], "Biblio") !== false) : ?>
                <div id="resultHead-container">
                    <h4 id="Risultati">Risultati:</h4>
                    <div id="numberResults" style="text-align: center;"></div>
                    <button type="button" id="azzeraRisultati" class="button button4">Azzera risultati</button>
                </div>
                <br/><br/>
                <div id="result"></div>
                <div style="text-align:center"><img class="loadingGif" id="loadingGif" src="Assets/Img/Loading.gif" style="display: none;"></div>
                <br/>
                <div id="pageNumbers" style="text-align: center;"></div>
				
				</br></br></br>
				<p>La Biblioteca di HMR è stata sviluppata nella tesi magistrale di Emanuele Lenzi. <a href="lineeGuida.php#result">La bibliografia</a> della tesi è una collezione della Biblioteca.
				Il modello Functional Requirements for Bibliographic Records è stato esteso per soddisfare i requisiti di HMR: caratteristiche e modalità d’uso sono descritte nelle <a href="lineeGuida.php">linee guida</a> per i catalogatori.</p>
               
			   </div></div> <!--end HMR contents-->
        <?php else : ?>
                <div id="addedRef">
                    <h4 id="addedRef-title">Riferimenti selezionati</h4>
                    <div id="addedRef-list"></div>
                </div>
                <h4 id="Risultati">Risultati:</h4>
                <div id="numberResults" style="text-align: center;"></div>
                <button type="button" id="azzeraRisultati" class="button button4">Azzera risultati</button>
                <br/><br/>
                <div id="result"></div>
                <div style="text-align:center"><img class="loadingGif" id="loadingGif" src="../../../Biblio/Assets/Img/Loading.gif" style="display: none;"></div>
                <br/>
                <div id="pageNumbers" style="text-align: center;"></div>
        <?php endif; ?>

<?php // Only if we are in biblio
    if (strpos($_SERVER['REQUEST_URI'], "Biblio") !== false) : ?>
	
        <div class="HMR_Footer">
            <script>
                creaFooter(1, "2020", "2021", "E. Lenzi", 
                                     "2021/01/20", "2021/05/11 18:15")
            </script> 
        </div>
<?php endif; ?>

</form></body>

</html>