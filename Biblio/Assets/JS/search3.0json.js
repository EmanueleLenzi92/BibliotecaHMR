//open links
function openItemLink(e) {
    window.open(document.getElementById(e), "_blank");
}

$(document).ready(function () {
    
    // Set yearE value of yearS on yearS change
    $("#intervalyear-start").change(function() {
        console.log(arrayEnd);
        var value = $("#intervalyear-start").val();
        $("#intervalyear-end")[0].selectize.destroy();
        $("#intervalyear-end option").not("option[value='']").remove();
        for (var i=0; i < arrayEnd.length; i++) {
            if (arrayEnd[i].value >= value) {
                $("#intervalyear-end").append(arrayEnd[i]);
            }
        }
        $("#intervalyear-end").val(value);
        $('#intervalyear-end').selectize({
                create: false
		});
    });
    
    //  If Enter si pressed in title input start the research
    $("#filtersearch-title").keyup(function(event) {
        if (event.keyCode === 13) {
            $("#search").click();
        }
    });
    
    // Reset search fields
    $( "#azzeraCampi" ).on('click',function() {
        $('.idPeople').each(function(){ // do this for every select with the 'idPeople' class
            if ($(this)[0].selectize) { // requires [0] to select the proper object
                var value = $(this).val(); // store the current value of the select/input
				$(this)[0].selectize.destroy(); 
				$(this).val(value);  // set back the value of the select/input
            }
        });
		$('.idPeopleResponsability').each(function(){ // do this for every select with the 'idPeopleResponsability' class
              if ($(this)[0].selectize) { // requires [0] to select the proper object
			     var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
        });
        $('.idPeople').val("");
        $('.idPeopleResponsability').val("");
        $('.idPeople').selectize({
                create: false,
				sortField: 'text'
		});
		$('.idPeopleResponsability').selectize({
				create: false,
				sortField: 'text'
		});
        // Reset institutions
        $('.idInstitution').each(function(){ // do this for every select with the 'idInstitutions' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
			  	var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); 
				 $(this).val(value);  // set back the value of the select/input
			  }
		});
		$('.idInstitutionResponsability').each(function(){ // do this for every select with the 'idInstitutinResponsability' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
			  	var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
		});
        $('.idInstitution').val("");
        $('.idInstitutionResponsability').val("");
		$('.idInstitution').selectize({
				create: false,
				sortField: 'text'
		});
		$('.idInstitutionResponsability').selectize({
				create: false,
				sortField: 'text'
		});
        $('#intervalyear-start').each(function(){ // do this for select with the 'intervalyear-start' id
              if ($(this)[0].selectize) { // requires [0] to select the proper object
			     var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
        });
        $("#intervalyear-start").val("");
        $('#intervalyear-start').selectize({
				create: false,
				sortField: 'text'
		});
        $('#intervalyear-end').each(function(){ // do this for select with the 'intervalyear-end' id
              if ($(this)[0].selectize) { // requires [0] to select the proper object
			     var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
                 for (var i=arrayEnd.length-1; i >= 0; i--) {
                    $("#intervalyear-end").prepend(arrayEnd[i]);
                 }
				 $(this).val(value);  // set back the value of the select/input
			  }
        });
        $("#intervalyear-end").val("");
        $('#intervalyear-end').selectize({
				create: false,
		});
        // Reset title
        $("#title").val("").keyup();
    });
    
    // Reset results
    $( "#azzeraRisultati" ).on('click',function() {
        $('#result').empty();
        $("#result").css("display", "none");
        $("#Risultati").css("display", "none");
        $("#azzeraRisultati").css("display", "none");
        $("#numberResults").css("display", "none");
        $("#pageNumbers").css("display", "none");
    });
    
    //search function on click
    $( "#search" ).on('click', function search(){
            
            // Reset border color of each institution/author
            $(".idInstitution").find(".selectize-input").css("border", "1px solid #E43972");
            $(".idPeople").find(".selectize-input").css("border", "1px solid #E43972");
        
            // If responsability is submitted check if relative author/institution is submitted
            var checkVal = false;
            $(".idInstitutionResponsability").each(function() {
                if (($(this).parent().find(".idInstitution").val() == "") && ($(this).val() != "")) {
                    checkVal = true;
                    $(this).parent().find(".idInstitution").find(".selectize-input").css("border", "3px solid red");
                    return;
                }
            });
            $(".idPeopleResponsability").each(function() {
                if (($(this).parent().find(".idPeople").val() == "") && ($(this).val() != "")) {
                    checkVal = true;
                    $(this).parent().find(".idPeople").find(".selectize-input").css("border", "3px solid red");
                    return;
                }
            });
            // If relative author/institution is empty stop research
            if (checkVal == true) {
                return;
            }
        
            // Display divs
            if ($("#result").css("display") == "none") {
                $("#result").css("display", "block");
                $("#Risultati").css("display", "block");
                $("#azzeraRisultati").css("display", "inline-block");
                $("#numberResults").css("display", "block");
                $("#pageNumbers").css("display", "block");
            }

            //if click a number page
            if($(this).attr('class')== "pageNumber"){

                //get previus input
                var idpeople= JSON.parse(localStorage.getItem("idpeople"));
                //var idpeople=[]
                var idPeopleResponsability= JSON.parse(localStorage.getItem("idPeopleResponsability"));
                //var idPeopleResponsability=[]
                var idinstitution= JSON.parse(localStorage.getItem("idinstitution"));
                //var idinstitution=[]
                var idInstitutionResponsability= JSON.parse(localStorage.getItem("idInstitutionResponsability"));
                //var idInstitutionResponsability=[]
                var title= localStorage.getItem("title");
                //var title=""
                var yearS= localStorage.getItem("yearS");
                //var yearS=""
                var yearE= localStorage.getItem("yearE");
                //var yearE=""

                //get page clicked for limit query
                var pageNumbers= $(this).attr('id');



            } else { 

                //if click button search

                //PERSONE
                var idpeople=[]
                if($('#checkboxAdvanced').is(":checked")) {
                    $(".idPeople option").each(function(){
						if($(this).val() != ""){
							idpeople.push($(this).val())
						}
                    });
                }
                //if(idpeople.length==1 && idpeople[0]==""){idpeople=[]}
                localStorage.setItem("idpeople", JSON.stringify(idpeople));

                var idPeopleResponsability=[]
                $(".idPeopleResponsability option").each(function(){
                    idPeopleResponsability.push($(this).val())

                });
                localStorage.setItem("idPeopleResponsability", JSON.stringify(idPeopleResponsability));


                //ISTITUZIONI
                var idinstitution=[]
                if($('#checkboxAdvanced').is(":checked")) {

                    $(".idInstitution option").each(function(){
						if($(this).val() != ""){
							idinstitution.push($(this).val())
						}

                    });
                }
                //if(idinstitution.length==1 && idinstitution[0]==""){idinstitution=[]}
                localStorage.setItem("idinstitution", JSON.stringify(idinstitution));

                var idInstitutionResponsability=[]
                $(".idInstitutionResponsability option").each(function(){
                    idInstitutionResponsability.push($(this).val())

                });
                localStorage.setItem("idInstitutionResponsability", JSON.stringify(idInstitutionResponsability));

                //TITOLO
                if($('#checkboxTitle').is(":checked")) {
                    var title= $('#title').val();
                } else var title= "";
                localStorage.setItem("title", title)

                //intervallo anni
                if($('#checkboxIterval').is(":checked")) {
                    var yearS= $('#intervalyear-start').val();
                    var yearE= $('#intervalyear-end').val();
                } else 	{
                    var yearS= "";
                    var yearE= "";
                }
                localStorage.setItem("yearS", yearS)
                localStorage.setItem("yearE", yearE)


                // page number for limit query
                var pageNumbers="0-25";
            }





             $('#result').empty();
             $("#result").jstree('destroy');			
             $("#loadingGif").fadeIn();

             $.ajax({  
                 type: "GET",
                 url: '/Biblio/Assets/apiDb/Search/search_api2.0.php',//"searchfilter2.0json.php", sul server di HMR il nuovo url dovrebbe essere '/Biblio/Assets/apiDb/Search/search_api2.0.php'
                 dataType: "JSON",					
                 data: {idPeople: idpeople, idInstitution: idinstitution, idPeopleResponsability: idPeopleResponsability, idInstitutionResponsability:idInstitutionResponsability, title: title, yearS:yearS, yearE:yearE, pageNumbers:pageNumbers},
                 success: function(risposta) {  

                     //console.log("ITEMS")
                     console.log(risposta.items)
                     //console.log(risposta.pageNumbers)
                     //console.log(risposta.pageNumbers[1])



                     $("#loadingGif").fadeOut("fast");

                    if(risposta.works.length > 0) {

                        // variable for all object to pass at trees.js
                        var allObj =[];


                        // WORK pageNumbers
                        //console.log(risposta.works)

                        if(risposta.works.length< parseInt(risposta.pageNumbers[1])){
                            var scorri= risposta.works.length;
                        } else {var scorri= parseInt(risposta.pageNumbers[1])}


                        var i= parseInt(risposta.pageNumbers[0])



                        for(i; i<scorri; i++){
                            var obj= {};

                            obj.type= "work"
                            obj.id= "w" + risposta.works[i]["idwork"];
                            obj.parent= "#";

                            if(risposta.works[i].workPeopleBrief == null){
                                var comma= ""
								var peopleW= "";
                            } else {
								var comma= ", "
								var peopleW= risposta.works[i].workPeopleBrief.replace(/[0-9]+[*]/g, "").replace(/,/g, ", "); 
							}
                            
							
							obj.text= (i + 1) + " - " + $.trim(peopleW) + comma + "<i>" + risposta.works[i].title + "</i>" + "&nbsp;<button type='button' id='idWork=" + risposta.works[i].idwork +"&idlevel="+ risposta.works[i].idwork + "&levelName=work' class='seeCatalogCard btn'><i class='fa fa-eye'></i></button>"

                            // add object to array of objects
                            allObj.push(obj)	


                            // EXPRESSION
                            for(var j=0; j<risposta.expressions[i].length; j++){


                                var objexp= {};
                                objexp.type= "expression"
                                objexp.id= "e" + risposta.expressions[i][j]["id"];
                                objexp.parent= "w" + risposta.expressions[i][j]["idwork"];

                                objexp.text= risposta.expressions[i][j]["typeName"]

                                // add object to arrau of objects
                                allObj.push(objexp)

                            }


                            // MANIFESTATION
                            for(var j=0; j<risposta.manifestations[i].length; j++){


                                var objmani= {};
                                objmani.type= "manifestation"
                                objmani.id= "m" + risposta.manifestations[i][j]["idmanif"];
                                // connect to expression or item
                                if(risposta.manifestations[i][j]["idexpr"] == 0){
                                    objmani.parent= "i" + risposta.manifestations[i][j]["iditem"];
                                } else {objmani.parent= "e" + risposta.manifestations[i][j]["idexpr"];}

                                var yearM="";
                                if(risposta.manifestations[i][j]["idManifestationType"] == 17){
                                    yearM= risposta.manifestations[i][j]["yearscan"]
                                    if(yearM==0){yearM="Data sconosciuta"}
                                } else {yearM= risposta.manifestations[i][j]["year"]}
								
								// button to add collection
                                if(risposta.addToCollection==1){
									var buttonCollection= "  <a class='addColl' id='collection-m-"+risposta.manifestations[i][j]["idmanif"]+"'><i class='fa fa-plus'></i>Aggiungi a collezione</a>"
								} else var buttonCollection= "";


                                objmani.text= risposta.manifestations[i][j]["manifType"] + "; " + $.trim(risposta.manifestations[i][j]["institutionManifestationName"]) + " (" + yearM + ")" + buttonCollection

                                // add object to arrau of objects
                                allObj.push(objmani)

                            }


                            // ITEM
                            for(var j=0; j<risposta.items[i].length; j++){
								

                                var objitem= {};
                                objitem.type= "item"
                                objitem.id= "i" + risposta.items[i][j]["iditem"];
                                objitem.parent= "m" + risposta.items[i][j]["idmanif"];
								
								// button to add collection
                                if(risposta.addToCollection==1){
									var buttonCollection= "  <a class='addColl' id='collection-i-"+risposta.items[i][j]["iditem"]+"'><i class='fa fa-plus'></i>Aggiungi a collezione</a>"
								} else var buttonCollection= "";
								
								
								if(risposta.items[i][j].peopleItemBrief == null){
                                
									var peopleItem= "";
								} else {
									
									var peopleItem= risposta.items[i][j].peopleItemBrief.replace(/[0-9]+[*]/g, "").replace(/,/g, ", "); 
								}
								

                                var texts= format_item(risposta.items[i][j],1);
                                objitem.text= texts + " [" + $.trim(risposta.items[i][j]["institutionItemName"]) + peopleItem + " - "+ $.trim(risposta.items[i][j]["itemRespName"]) +"]" + buttonCollection; 

                                // add object to arrau of objects
                                allObj.push(objitem)

                            }

                        }					

                        //console.log("Object: trees")
                        //console.log(allObj)

                        // create tree with array of object
                        $('#result').jstree({ 
                            'core' : {
                                'data' : allObj
                            },
                            'types' : {
                                "work": {
                                  "icon" : "fa fa-cloud"
                                },
                                "expression": {
                                  "icon" : "fa fa-soundcloud"
                                },
                                "manifestation": {
                                  "icon" : "fa fa-book"
                                },
                                "item": {
                                  "icon" : "fa fa-file"
                                },
                                "default" : {
                                }
                            },
                            plugins: ["search", "themes", "types"]
                        })/* .on('open_node.jstree', function (e, data) { data.instance.set_icon(data.node, "glyphicon glyphicon-minus"); 
                        }).on('close_node.jstree', function (e, data) { data.instance.set_icon(data.node, "glyphicon glyphicon-plus"); });
                         */


                        // total number of results
                        $('#numberResults').empty()
                        $('#numberResults').append("<i class='fa fa-cloud'></i> Opere: " + risposta.num_works + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-soundcloud'></i> Espressioni: " + risposta.num_expressions + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-book'></i> Manifestazioni: " + risposta.num_manifestations + "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class='fa fa-file'></i> Esemplari: " + risposta.num_items)


                        // create page number for next querys
                        var pageN="";
                        var page=1;
                        for(var i=0; i< risposta.works.length ; i=i+25){
                            if(i+25 > risposta.works.length){
                            pageN += "&nbsp;<a style='cursor:pointer' class='pageNumber' id='"+i+"-"+risposta.works.length+"'>"+page+"</a>&nbsp;"
                            } else {pageN += "&nbsp;<a style='cursor:pointer' class='pageNumber' id='"+i+"-"+(i+25)+"'>"+page+"</a>&nbsp;"}
                            page++
                        }
                        $('#pageNumbers').empty()
                        $('#pageNumbers').unbind();
                        $('#pageNumbers').append(pageN).on('click', '.pageNumber', search)
                        $( "#" +  risposta.pageNumbers[0] + "-" + scorri).addClass( "pageActive" );
                        $("#" +  risposta.pageNumbers[0] + "-" + scorri).css("pointer-events","none");
						
						

                    } else {
                        $("#pageNumbers").empty();
                        $('#numberResults').empty();
                        $('#numberResults').append('<div>Nessun risultato trovato.</div>');
                    }
					
					
					// open scheda bibliografica 
					$('#result').on('click', '.seeCatalogCard', function () {
							
                        var urlId = $(this).attr('id');
						var url= "/Biblio/Card/?"+urlId;
						window.open(url,'_blank')
					
					});



                    },
                    error: function(response){
                        var a= JSON.stringify(response)
                        alert(a)
                        alert("Qualcosa è andato storto. Riprova")
                        //console.log(response);
                    } 
                });

            });
        });