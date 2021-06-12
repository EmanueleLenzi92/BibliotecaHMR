<?php 
session_start();

if(isset($_SESSION['fileSecretPermission'])){
	$administratorPermission = $_SESSION['administratorPermission'];
	$catalogerPermission = $_SESSION['catalogerPermission'];
	$fileSecretPermission = $_SESSION['fileSecretPermission'];
	} else {
		$administratorPermission= null;
		$catalogerPermission= null;
		//for user not logged
		$fileSecretPermission= 10;
	}

require ('../../Config/Biblio_config.php');
require ('Assets/PHP/functions_get.php');


if($administratorPermission== 1){
	$treeModify= 2;
} else if ($catalogerPermission == 1) {
	$treeModify= 1;
} else {$treeModify= 0;}






// id work passed by ajax (taked with php_get in ajax call passed from openPopup.js). (ajax call starts in automatic)
if(isset($_GET['idwork'])){
	
	
	if(isset($_SESSION['authId'])){
		$userId = $_SESSION['authId'];
	} else $userId = null;
	

	//get permission for modification in tree
	$modifyTree= $_GET['modifyTree'];
	
	
	$idWork= $_GET['idwork'];
	$idlevel= $_GET['idlevel'];
	$levelstring= $_GET['levelName'];


	$work= get_works($conn, $idWork);
	$respWork= get_responsabilityWork($conn, $idWork);
	$work[0]['resp'] = $respWork;


	// get all expressions 
	$expression= get_expressions_by_idWork($conn, $idWork);

	for( $i=0; $i < sizeOF($expression); $i++ ){

		$resp= get_responsabilityExpression($conn, $expression[$i]["id"]);
		if($resp[0]['istitutEspr'] == null && $resp[0]['persBrief']== null){$resp=[];}
		$expression[$i]['resp'] = $resp;

	}

	// same for manifestations
	$manifestation= get_manifestations_by_idWork($conn, $idWork);
	for( $i=0; $i < sizeOF($manifestation); $i++ ){

		$resp= get_responsabilityManifestation($conn, $manifestation[$i]["id"]);
		if($resp[0]['istitutEspr'] == null && $resp[0]['persBrief']== null){$resp=[];}
		$manifestation[$i]['resp'] = $resp;

	}



	//same for items
	$item= get_items_by_idWork($conn, $idWork);
	for( $i=0; $i < sizeOF($item); $i++ ){

		$resp= get_responsabilityItem($conn, $item[$i]["id"]);
		if($resp[0]['istitutEspr'] == null && $resp[0]['persBrief']== null){$resp=[];}
		$item[$i]['resp'] = $resp;

	}


	// array json
	$arrayJson= array("work" => $work,  "expression" => $expression,  "manifestation" => $manifestation,  "item" => $item, "idLevel" => $idlevel, "stringLevel" => $levelstring, "modifyTree" => $modifyTree, "fileSecretPermission" => $fileSecretPermission, "userId" => $userId);		
	$data= json_encode($arrayJson);
	echo $data;
	exit;
}

?>
<html>
<head>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<link rel="stylesheet" href="Assets/libraries/vakata-jstree-6dce227/dist/themes/default/style.min.css" />
<script src="Assets/libraries/vakata-jstree-6dce227/dist/jstree.min.js"></script>

<!-- Add icon library -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<style>
@import url('https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i&subset=latin-ext');
body,html{font-family: "Source Sans Pro";}

.jstree-default a { 
    white-space:normal !important; height: auto; 
}

.jstree-default li > ins { 
    vertical-align:top; 
}
.jstree-leaf {
    height: auto;
}
.jstree-leaf a{
    height: auto !important;
}

.jstree-anchor { 
	height:auto !important; 
	white-space:normal !important; 
	
	/*delete to previus grafic*/
	line-height: 24px !important;
	padding: 2px !important;
	
}

.jstree b {}
.levell {color: #d81a68}
a {color: #d81a68;}
</style>

<script>
//format the manifestationfields of a manifestation. Call in ajax (in manifestation section)
function formatManifestationForTrees(manifestation){
	var result="";
	// Intervento in evento
	if(manifestation["idType"] == 11){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field2"] + "</br>" +
				"Luogo: " + manifestation["field1"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: " + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field3"] + "</br>" +
				"</div>"
	
	}

		
	// Intervento a congresso
	if(manifestation["idType"] == 10){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field3"] + "</br>" +
				"Luogo: " + manifestation["field2"] + "</br>" +
				"Numero: " + manifestation["field1"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: " + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field4"] + "</br>" +
				"</div>"
	
	}
	
	// Intervento in seminario
	if(manifestation["idType"] == 67){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field2"] + "</br>" +
				"Luogo: " + manifestation["field1"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: " + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field3"] + "</br>" +
				"</div>"
	
	}
	
	// Pubblicazione su rivista
	if(manifestation["idType"] == 6){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field1"] + "</br>" +
				"Rivista: " + manifestation["journalActs"] + "</br>" +
				"Numero: " + manifestation["field2"] + "</br>" +
				"Volume: " + manifestation["field3"] + "</br>" +
				"Pagine: " + manifestation["field4"] + "</br>" +
				"ISBN: " + manifestation["field9"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: " + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field5"] + "</br>" +
				"</div>"
	
	}
	
	// Pubblicazione su periodico
	if(manifestation["idType"] == 41){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field1"] + "</br>" +
				"Periodico: " + manifestation["journalActs"] + "</br>" +
				"Numero: " + manifestation["field2"] + "</br>" +
				"Volume: " + manifestation["field3"] + "</br>" +
				"Pagine: " + manifestation["field4"] + "</br>" +
				"ISBN: " + manifestation["field9"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: " + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field5"] + "</br>" +
				"</div>"
	
	}
	
	// Pubblicazione in atti di congresso
	if(manifestation["idType"] == 7 || manifestation["idType"] == 35){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field4"] + "</br>" +
				"Atto: " + manifestation["journalActs"] + "</br>" +
				"Luogo: " + manifestation["field5"] + "</br>" +
				"Volume: " + manifestation["field1"] + "</br>" +
				"Numero: " + manifestation["field10"] + "</br>" +
				"Pagine: " + manifestation["field2"] + "</br>" +
				"ISBN: " + manifestation["field9"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: "  + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field3"] + "</br>" +
				"</div>"
	
	}
	
	// Capitolo di libro
	if(manifestation["idType"] == 9){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Libro: " + manifestation["book"] + "</br>" +
				"Capitolo: " + manifestation["field1"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: " + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field5"] + "</br>" +
				"</div>"
	
	}
	
	// libro
	if(manifestation["idType"] == 27){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field1"] + "</br>" +
				"Indirizzo: " + manifestation["field3"] + "</br>" +
				"Volume: " + manifestation["field2"] + "</br>" +
				"Edizione: " + manifestation["field4"] + "</br>" +
				"ISBN: " + manifestation["field9"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: "  + manifestation["year"] + "</br>" +
				"Note: " + manifestation["field5"] + "</br>" +
				"</div>"
	
	}
	
	// Tesi
	if(manifestation["idType"] == 18){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field1"] + "</br>" +
				"Scuola: " + manifestation["field2"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: "  + manifestation["year"] + "</br>" +
				"</div>"
	
	}
	
	// Rapporto tecnico, doc d'archivio, unpublished, altro, lettera, trascrizione
	if(manifestation["idType"] == 19 || manifestation["idType"] == 20 || manifestation["idType"] == 25 || manifestation["idType"] == 26 || manifestation["idType"] == 22 || manifestation["idType"] == 21){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field1"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: "  + manifestation["year"] + "</br>" +
				"</div>"
	
	}
	
	// foto, immagine
	if(manifestation["idType"] == 24 || manifestation["idType"] == 23 ){
		result= "<button onclick='openManif(this.id);' id='"+manifestation["id"]+"'><i class='fa fa-eye'></i></button>" +
				"<div id='manifestationField"+manifestation["id"]+"' style='display:none'>" +
				"Titolo: " + manifestation["field1"] + "</br>" +
				"Risoluzione: " + manifestation["field2"] + "</br>" +
				"Forma: " + manifestation["formName"] + "</br>" +
				"Anno: "  + manifestation["year"] + "</br>" +
				"</div>"
	
	}
	
	return result

}

//format the links of items. Call in ajax (in item section)
function formatLinksItem(item, fileSecretPermission){
	result="";
	
	if(fileSecretPermission == 1){
		
		if(item["filename"] != ""){ result += "File locale: " + "<a onclick='openItemLink(this.id);' id ='itemLocalFile"+item["id"]+"' href='"+item["fileurl"]+"'>" + item["filename"] + "</a></br>";} else if(item["extlink"] != ""){ result += "Link esterno: " + "<a onclick='openItemLink(this.id);' id ='itemExtLink"+item["id"]+"' href='"+item["extlink"]+"' target='_blank'>Click qui</a></br>";}
		
	}  else if (fileSecretPermission == 0 ) {
	
		if (item["capability"] == 2 || item["capability"] == 1 || item["capability"] == 0) {
			
			if(item["filename"] != ""){result += "File locale: " + "<a onclick='openItemLink(this.id);' id ='itemLocalFile"+item["id"]+"' href='"+item["fileurl"]+"'>" + item["filename"] + "</a></br>";} else if(item["extlink"] != ""){result += "Link esterno: " + "<a onclick='openItemLink(this.id);' id ='itemExtLink"+item["id"]+"' href='"+item["extlink"]+"' target='_blank'>Click qui</a></br>";}
		
		}
	
	} else if (fileSecretPermission == 10 ){
		
		if (item["capability"] == 1 || item["capability"] == 0) {
		
			if(item["filename"] != ""){ result += "File locale: " + "<a onclick='openItemLink(this.id);' id ='itemLocalFile"+item["id"]+"' href='"+item["fileurl"]+"'>" + item["filename"] + "</a></br>";} else if(item["extlink"] != ""){result += "Link esterno: " + "<a onclick='openItemLink(this.id);' id ='itemExtLink"+item["id"]+"' href='"+item["extlink"]+"' target='_blank'>Click qui</a></br>";}
		
		}
	
	}
	
	return result;
}

//funtions to open manifestationfields and links item and modify button
function openManif(e) {
	if (document.getElementById("manifestationField" + e).style.display == "none") {
		document.getElementById("manifestationField" + e).style.display = "block";
	} else document.getElementById("manifestationField" + e).style.display = "none";
}

function openItemLink(e) {
	window.open(document.getElementById(e), "_blank");
}

function openModify(e){
	window.open(document.getElementById(e), "_blank");
}





</script>

<script>
$(document).ready(function () {


 		$.ajax({  
			type: "GET",
	 
			dataType: "JSON",					
			data: {idwork: <?php echo $_GET['idWork'];?>, modifyTree: <?php echo $treeModify;?>, fileSecretPermission: <?php echo $fileSecretPermission;?>}, //id passed from openPopup.js
			success: function(resp) {  
			
				// variable for all object to pass at trees.js
				var allObj =[];
				
				
				
				// WORK
				for(var i=0; i<resp.work.length; i++){
					var obj= {};
					
					obj.id= "w" + resp.work[i]["id"];
					obj.parent= "#";

					// array of responsability if exists
					var responsab=""
					if(resp.work[i]["resp"].length > 0){
						
						for(var j=0; j<resp.work[i]["resp"].length; j++){
							
							// add single responsabilty ($trim is for don't print null values)
							responsab = responsab + "</br><b>Responsabilità: </b>" + $.trim(resp.work[i]["resp"][j]['istitutEspr']) + $.trim(resp.work[i]["resp"][j]['persBrief']) + ", (" + resp.work[i]["resp"][j]['resp'] + ")"
						
						}
					
					
					}
					
					// add button modify if permission exist
					var buttonModify="";
					if (resp.modifyTree == 2 ) {
						
						buttonModify= "<a onclick='openModify(this.id)' id='modifYWork-"+resp.work[i]["id"]+"' href='Work/index.php?idModify="+resp.work[i]["id"]+"'>Modifica</a>";
						
						} else if (resp.modifyTree == 1){
							
							if (resp.work[i]["iduser"] == resp.userId){
							
								buttonModify= "<a onclick='openModify(this.id)' id='modifYWork-"+resp.work[i]["id"]+"' href='Work/index.php?idModify="+resp.work[i]["id"]+"'>Modifica</a>";
							
							}

						}
					
					obj.text= "<b class='levell'>Opera"+buttonModify+"</b></br><b>Titolo:</b> " + resp.work[i]["title"] + responsab
					
					// add object to arrau of objects
					allObj.push(obj)					
				
				}					
				
				
				
				// EXPRESSION
				for(var i=0; i<resp.expression.length; i++){
					
					var obj= {};
					
					// find selected expression to open the tree
					if(resp.idLevel == resp.expression[i]["id"] && resp.stringLevel == "manifestationExpression"){
						obj.state = {selected : true};
					} else obj.state = {selected : false}
					
					obj.id= "e" + resp.expression[i]["id"];
					obj.parent= "w" + resp.expression[i]["idwork"];
					
					// array of responsability if exists
					var responsab=""
					if(resp.expression[i]["resp"].length > 0){
						
						for(var j=0; j<resp.expression[i]["resp"].length; j++){
							
							// add single responsabilty ($trim is for don't print null values)
							responsab = responsab + "</br><b>Responsabilità: </b>" + $.trim(resp.expression[i]["resp"][j]['istitutEspr']) + $.trim(resp.expression[i]["resp"][j]['persBrief']) + ", (" + resp.expression[i]["resp"][j]['resp'] + ")"
						
						}
					
					
					} 
					
					// add button modify if permission exist
					var buttonModify="";
					if (resp.modifyTree == 2 ) {
						buttonModify= "<a onclick='openModify(this.id)' id='modifYExpr-"+resp.expression[i]["id"]+"' href='Expression/index.php?idModify="+resp.expression[i]["id"]+"'>Modifica</a>";
					}else if (resp.modifyTree == 1){
							
							if (resp.expression[i]["iduser"] == resp.userId){
							
								buttonModify= "<a onclick='openModify(this.id)' id='modifYExpr-"+resp.expression[i]["id"]+"' href='Expression/index.php?idModify="+resp.expression[i]["id"]+"'>Modifica</a>";
							
							}

						}
					
					
					obj.text= "<b class='levell'>Espressione"+buttonModify+"</b></br><b>Tipo:</b> " + resp.expression[i]["typeName"] + responsab
					
					// add object to arrau of objects
					allObj.push(obj)

				}
				
				// MANIFESTATION
				for(var i=0; i<resp.manifestation.length; i++){
					
					var obj= {};
					
					// find selected manifestation to open the tree
					if(resp.idLevel == resp.manifestation[i]["id"] && resp.stringLevel == "manifestationItem"){
						obj.state = {selected : true};
					} else obj.state = {selected : false}
					
					obj.id= "m" + resp.manifestation[i]["id"];
					// connect to expression or item
					if(resp.manifestation[i]["idexpression"] == 0){
						obj.parent= "i" + resp.manifestation[i]["iditem"];
					} else {obj.parent= "e" + resp.manifestation[i]["idexpression"];}
					
					// array of responsability if exists
					var responsab=""
					if(resp.manifestation[i]["resp"].length > 0){
						
						for(var j=0; j<resp.manifestation[i]["resp"].length; j++){
							
							// add single responsabilty ($trim is for don't print null values)
							responsab = responsab + "</br><b>Responsabilità: </b>" + $.trim(resp.manifestation[i]["resp"][j]['istitutEspr']) + $.trim(resp.manifestation[i]["resp"][j]['persBrief']) + ", (" + resp.manifestation[i]["resp"][j]['resp'] + ")"
						
						}
					
					
					}  
					
					var ManifFields= formatManifestationForTrees(resp.manifestation[i]);
					
					// add button modify if permission exist
					var buttonModify="";
					if (resp.modifyTree == 2 ) {
						buttonModify= "<a onclick='openModify(this.id)' id='modifYManif-"+resp.manifestation[i]["id"]+"' href='Manifestation/index.php?idModify="+resp.manifestation[i]["id"]+"'>Modifica</a>";
					}else if (resp.modifyTree == 1 ) {
						
						if (resp.manifestation[i]["iduser"] == resp.userId){
						
						buttonModify= "<a onclick='openModify(this.id)' id='modifYManif-"+resp.manifestation[i]["id"]+"' href='Manifestation/index.php?idModify="+resp.manifestation[i]["id"]+"'>Modifica</a>";
						
						}
					
					}
					
					obj.text= "<b class='levell'>Manifestazione"+buttonModify+"</b></br><b>Tipo:</b> " + resp.manifestation[i]["type"] + responsab + "</br>" + ManifFields;
					
					// add object to arrau of objects
					allObj.push(obj)

				}
				
				
				// ITEM
				for(var i=0; i<resp.item.length; i++){
					
					var obj= {};
					
					// find selected item to open the tree
					if(resp.idLevel == resp.item[i]["id"] && resp.stringLevel == "manifestationItem"){
						obj.state = {selected : true};
					} else obj.state = {selected : false}
					
					obj.id= "i" + resp.item[i]["id"];
					obj.parent= "m" + resp.item[i]["idmanifestation"];

					
					// array of responsability if exists
					var responsab=""
					if(resp.item[i]["resp"].length > 0){
						
						for(var j=0; j<resp.item[i]["resp"].length; j++){
							
							// add single responsabilty ($trim is for don't print null values)
							responsab = responsab + "</br><b>Responsabilità: </b>" + $.trim(resp.item[i]["resp"][j]['istitutEspr']) + $.trim(resp.item[i]["resp"][j]['persBrief']) + ", (" + resp.item[i]["resp"][j]['resp'] + ")"
						
						}
					
					
					}
					
					var linksItem= formatLinksItem(resp.item[i], resp.fileSecretPermission);
					
					// add button modify if permission exist
					var buttonModify="";
					if (resp.modifyTree == 2 ) {
						
						buttonModify= "<a onclick='openModify(this.id)' id='modifYItem-"+resp.item[i]["id"]+"' href='Item/index.php?idModify="+resp.item[i]["id"]+"'>Modifica</a>";
					
					} else if (resp.modifyTree == 1 ) {
					
						if (resp.item[i]["iduser"] == resp.userId){
							
								buttonModify= "<a onclick='openModify(this.id)' id='modifYItem-"+resp.item[i]["id"]+"' href='Item/index.php?idModify="+resp.item[i]["id"]+"'>Modifica</a>";
							
						}
					
					}
					
					obj.text= "<b class='levell'>Esemplare"+buttonModify+"</b></br><b>Titolo:</b> " + resp.item[i]["title"] + responsab + "</br>" + linksItem
					
					// add object to arrau of objects
					allObj.push(obj)

				}
				
				// allObj.sort(function(a, b) {
					// return parseFloat(a.parent) - parseFloat(b.parent);
				// });

				console.log(allObj)
				
				// create tree with array of object
				$('#a').jstree({ 'core' : {
					"themes" : {
					  "variant" : "large"
					},
					'data' : allObj
				} });
				
				
				
				


			
			},
			error: function(response){
				var a= JSON.stringify(response)
				alert(a)

			} 
		}); 





})
</script>

</head>
<body>
<div id="a"></div>
</body>
</html>