$(document).ready(function () {
			
			// get query string parametres from a link of a collection
			const urlParams = new URLSearchParams(window.location.search);
			const idWork = urlParams.get('idWork');
			
			if(urlParams.get('idItem') != 0){
				var idItem = urlParams.get('idItem');
			} else var idItem = 0;
			
			if (urlParams.get('idManif') != 0) {
				var idManif = urlParams.get('idManif')
			} else var idManif = 0
            
			$.ajax({  
                 type: "GET",
                 url: '/Biblio/Assets/apiDb/Search/search_api_link_fromCollection.php',//"searchfilter2.0json.php", sul server di HMR il nuovo url dovrebbe essere '/Biblio/Assets/apiDb/Search/search_api2.0.php'
                 dataType: "JSON",					
                 data: {idItem:idItem, idWork:idWork, idManif:idManif},
                 success: function(risposta) {  

                     //console.log("ITEMS")
                     //console.log(risposta)
                     //console.log(risposta.pageNumbers)
                     //console.log(risposta.pageNumbers[1])



							var allObj =[];
                            var obj= {};

                            obj.type= "work"
                            obj.id= "w" + risposta.work[0]["idwork"];
                            obj.parent= "#";


                            if(risposta.work[0].workPeopleBrief == null){
                                var comma= ""
								var peopleW= "";
                            } else {
								var comma= ", "
								var peopleW= risposta.work[0].workPeopleBrief.replace(/[0-9]+[*]/g, "").replace(/,/g, ", ");  
							}
                            
							obj.text=  1 + " - " + $.trim(peopleW) + comma + "<i>" + risposta.work[0].title + "</i>" + "&nbsp;<button type='button' id='idWork=" + risposta.work[0].idwork +"&idlevel="+ risposta.work[0].idwork + "&levelName=work' class='seeCatalogCard btn'><i class='fa fa-eye'></i></button>"

                            // add object to array of objects
                            allObj.push(obj)	


                            // EXPRESSION
                            for(var j=0; j<risposta.expressions.length; j++){


                                var objexp= {};
                                objexp.type= "expression"
                                objexp.id= "e" + risposta.expressions[j]["id"];
                                objexp.parent= "w" + risposta.expressions[j]["idwork"];

                                objexp.text= risposta.expressions[j]["typeName"]

                                // add object to arrau of objects
                                allObj.push(objexp)

                            }


                            // MANIFESTATION
                            for(var j=0; j<risposta.manifestations.length; j++){


                                var objmani= {};
								
								// find selected manif to open the tree
								if(risposta.idManif == risposta.manifestations[j]["idmanif"]){
									objmani.state = {selected : true};
								} else objmani.state = {selected : false}
								
                                objmani.type= "manifestation"
                                objmani.id= "m" + risposta.manifestations[j]["idmanif"];
                                // connect to expression or item
                                if(risposta.manifestations[j]["idexpr"] == 0){
                                    objmani.parent= "i" + risposta.manifestations[j]["iditem"];
                                } else {objmani.parent= "e" + risposta.manifestations[j]["idexpr"];}

                                var yearM="";
                                if(risposta.manifestations[j]["idManifestationType"] == 17){
                                    yearM= risposta.manifestations[j]["yearscan"]
                                    if(yearM==0){yearM="Data sconosciuta"}
                                } else {yearM= risposta.manifestations[j]["year"]}
								
								// button to add collection
                                if(risposta.addToCollection==1){
									var buttonCollection= "  <a class='addColl' id='collection-m-"+risposta.manifestations[j]["idmanif"]+"'><i class='fa fa-plus'></i>Aggiungi a collezione</a>"
								} else var buttonCollection= "";


                                objmani.text= risposta.manifestations[j]["manifType"] + "; " + $.trim(risposta.manifestations[j]["institutionManifestationName"]) + " (" + yearM + ")" + buttonCollection

                                // add object to arrau of objects
                                allObj.push(objmani)

                            }


                            // ITEM
                            for(var j=0; j<risposta.items.length; j++){


                                var objitem= {};
								
								// find selected item to open the tree
								if(risposta.idItem == risposta.items[j]["iditem"]){
									objitem.state = {selected : true};
								} else objitem.state = {selected : false}
								
                                objitem.type= "item"
                                objitem.id= "i" + risposta.items[j]["iditem"];
                                objitem.parent= "m" + risposta.items[j]["idmanif"];
								
								// button to add collection
                                if(risposta.addToCollection==1){
									var buttonCollection= "  <a class='addColl' id='collection-i-"+risposta.items[j]["iditem"]+"'><i class='fa fa-plus'></i>Aggiungi a collezione</a>"
								} else var buttonCollection= "";
								
								if(risposta.items[j].peopleItemBrief == null){
                                
									var peopleItem= "";
								} else {
									
									var peopleItem= risposta.items[j].peopleItemBrief.replace(/[0-9]+[*]/g, "").replace(/,/g, ", "); 
								}

                                var texts= format_item(risposta.items[j],1);
                                objitem.text= texts + " [" + $.trim(risposta.items[j]["institutionItemName"]) + peopleItem + " - "+ $.trim(risposta.items[j]["itemRespName"]) +"]" + buttonCollection; 

                                // add object to arrau of objects
                                allObj.push(objitem)

                            }

					

                        //console.log("Object: trees")
                        console.log(allObj)

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
			
						
						// Display divs
						if ($("#result").css("display") == "none") {
							$("#result").css("display", "block");
							$("#Risultati").css("display", "block");
							$("#azzeraRisultati").css("display", "inline-block");
							$("#numberResults").css("display", "block");
							$("#pageNumbers").css("display", "block");
						}
						
						// open scheda bibliografica (for seconds pages of datatable too)
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
                })


})