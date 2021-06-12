<?php 
include('../Administration/Assets/PHP/sessionSet.php');
include('../Administration/Assets/PHP/controlLogged.php');

if($catalogerPermission == 0 ) {
	header('Location: https://www.progettohmr.it/Administration/Assets/PHP/autentication.php');
}

require ('../../Config/Biblio_config.php');


?>
<html>
<head>
	<!--Style-->
	<link rel="stylesheet" href="../HMR_Style.css">
	<link rel="stylesheet" href="Assets/CSS/Bibliostyle.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="../Assets/JS/HMR_CreaHTML.js"></script>
	<script src="Assets/JS/barMenu.js"></script>	
	
	<style>

	
	#menuList{
	background: #eee;
	}


	.menuList li {
	  background: #fff;
	  margin: 5px;
	  padding: 5px;
	  border-radius: 25px;
	  list-style-type:none;
	}
	
	h3 {cursor: pointer}
	</style>
	
	<script>
	$(document).ready(function () {	
		$('#buttonCatalog').on('click', function() {
			$("#catal").toggle();
		})
		
		$('#buttonColl').on('click', function() {
			$("#coll").toggle();
		})
	})
	</script>


</head>
<body>

<div class="HMR_Banner">
	<script> creaHeader(3, 'HMR_2017g_GC-WebHeaderRite-270x105-1.png') </script>
</div>
	
<div id="HMR_Menu" class="HMR_Menu" >
	<script> creaMenu(3, 0) </script>
</div>
	

<div class="HMR_Content"><div class= "HMR_Text">



<div id="menuList">
<h3 id="buttonCatalog">Catalogazione</h3>
<span id="catal" style="display:none">
<ul class="menuList">
<li><a href="Work/">Aggiungi opera</a></li>
<li><a href="Expression/">Aggiungi espressione</a></li>
<li><a href="Manifestation/">Aggiungi manifestazione</a></li>
<li><a href="Item/">Aggiungi esemplare</a></li>
</ul>

<ul class="menuList">
<li><a href="LevelsList/?level=work">Lista opere</a></li>
<li><a href="LevelsList/?level=expression">Lista espressioni</a></li>
<li><a href="LevelsList/?level=manifestation">Lista manifestazioni</a></li>
<li><a href="LevelsList/?level=item">Lista esemplari</a></li>
</ul>

<ul class="menuList">
<li><a href="Responsability/people.php">Persone</a></li>
<li><a href="Responsability/institution.php">Istituzioni</a></li>
</ul>
</span>

<h3 id="buttonColl">Collezioni</h3>
<span id="coll" style="display:none">
<ul class="menuList">
<li><a href="Collections/collection.php">Crea collezione</a></li>
<li><a href="Collections/managementCollection.php">Gestisci collezioni</a></li>
</ul>
</span>


<ul class="menuList">
<li><a href="Assets/PHP/db_dump.php">Backup DB</a></li>
</ul>


</div>


</div></div> <!--end HMR contents-->

<div class="HMR_Footer">
	<script>
		creaFooter(1, "2014", "2017", "G.A. Cignoni", 
							 "2014/09/23", "2017/10/13 18:15")
	</script> 
</div>


</body>
</html>