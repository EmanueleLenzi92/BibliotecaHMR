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

$institutions= get_institutions($conn);

if(isset($_GET['idModify'])){
	$id= $_GET['idModify'];
	$institutToModify= get_institutions($conn, $id);
	
	$name= htmlspecialchars($institutToModify[0]['name'], ENT_QUOTES);
	$link= htmlspecialchars($institutToModify[0]['link'], ENT_QUOTES);

} else {$name=""; $link="";}
?>
<head>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<!-- datatable -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
	
	<script type="text/javascript">
	$(document).ready(function () {
        $('table').dataTable(
			{
			"pageLength": 25,
			"order": [[ 2, "asc" ]]
			}
		);
    });
	</script>
	
	<script>
	$(document).ready(function () {
		//open people list and change arrow
		$('.openDiv').on('click', function() {
			$("#content-table").toggle(100);
			$(".openDiv").find('i').toggleClass('fa-angle-up fa-angle-down')
		})
	})
	</script>
	
	<!--Style-->
	<link rel="stylesheet" href="../../HMR_Style.css">
	<link rel="stylesheet" href="../Assets/CSS/Bibliostyle.css">
	
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
		echo '<form action="../Assets/apiDb/update_institution.php" method="post" enctype="multipart/form-data">';
		echo '<input type="hidden" name="idInstitutModify" value="'.$institutToModify[0]["id"].'">';
	} else echo '<form action="../Assets/apiDb/insert_institution.php" method="post" enctype="multipart/form-data">';
?>
	
	<h1>Istituzione <?php if(isset($_GET['idModify'])){ echo "(id: ".$institutToModify[0]["id"] .")";} ?></h1>
	
	<label for="name">Nome:</label>
	<input value="<?php echo $name; ?>" type="text" id="name" name="name" size="50"> 
	
	<label for="name">Link alla pagina web:</label>
	<input value="<?php echo $link; ?>" type="text" id="link" name="link" size="50"> 
	
	
	</br></br>
	
	<button type="submit" class="submitLevel" id="institution-submit">Inserisci nel database</button>
	
	</form>
	
	</br>

	<h1 class="openDiv">Lista istituzioni <i class="fa fa-angle-down"></i></h1>
	
	<div id="content-table" style="display: none">
	
	<table id="table_id" class="display" cellspacing="0" width="100%">
			<thead>
				<th>ID</th>
				<th>Nome</th>
				<th></th>
			</thead>
			<tbody>
				<?php
					
					for( $i=0; $i < sizeOF($institutions); $i++ ){
						echo "<tr>";
						echo "<td >".$institutions[$i]['id']."</td>";
						echo "<td >".$institutions[$i]['name']."</td>";
						echo "<td valign='center'>";
						
						echo "<form method='get'>";
						echo 	"<input type='hidden' name='idModify' value='".$institutions[$i]['id']."'>";
						echo 	"<button type='submit'>Modifica</button>";
						echo "</form>";
						
						echo "<form method='post' action='../Assets/apiDb/delete_institution.php'>";
						echo 	"<input type='hidden' name='id' value='".$institutions[$i]['id']."'>";
						echo 	"<button onclick='return confirm(&#39;Vuoi eliminare ".$institutions[$i]['name']."&#39;)' type='submit'>Elimina</button>";
						echo "</form>";
						
						echo "</td>";
						echo "</tr>";
					}
					
				?>
			</tbody>
	</table>
	
	</div>
	
</div></div> <!--end HMR contents-->

<div class="HMR_Footer">
	<script>
		creaFooter(2, "2014", "2017", "G.A. Cignoni", 
							 "2014/09/23", "2017/10/13 18:15")
	</script> 
</div>

</body>
</html>