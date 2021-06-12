
function format_item(object, objectInTree=1){
	

			switch(object.idManifestationTypeOriginal){
				
	 			case '6': //pubblicazione su rivista scientifica
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors + "&ldquo;" + title + "&rdquo;, ";
					var editors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 7)
					html += "in <i>" + object.journalActs + "</i>" + ", " ;
					if(object.series != null) {html += "in " + object.series + ", "}
					if(object.field3 != ""){ html += "vol. " + object.field3 + ", "}
					if(object.field2 != ""){ html += "n° " + object.field2 + ", "}
					if(editors != "") { html += editors }
					if(object.field4 != ""){ html += "p. " + object.field4 + ", "}
					if(object.field9 != ""){ html += object.field9 + ", "}
					html += object.year + ".";
					break;
					
	 			case '41': //pubblicazione su periodico
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var editors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 7)
					var html= authors + "&ldquo;" + title + "&rdquo;, ";

					html += "in <i>" + object.journalActs + "</i>" + ", " ;
					if(object.series != null) {html += "in " + object.series + ", "}
					if(object.field3 != ""){ html += "vol. " + object.field3 + ", "}
					if(object.field2 != ""){ html += "n° " + object.field2 + ", "}
					if(editors != "") { html += editors }
					if(object.field4 != ""){ html += "p. " + object.field4 + ", "}
					if(object.field9 != ""){ html += object.field9 + ", "}
					html += object.year + ".";
					break;
				
	 			case '7': //pubblicazione in atti di congresso
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field4, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors + "&ldquo;" + title + "&rdquo;,";
					var curators= format_curators(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab, 
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab, 22
					);
					var actsEditors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 18)
					var dataSE= formatData(object.daystart, object.monthstart, object.yearstart, object.dayend, object.monthend, object.yearend);
					
					html += " in <i>" + object.journalActs + "</i>" + ", " ;
					if(object.field5 != ""){ html += object.field5 + ", "}
					if(dataSE != "0"){ html += dataSE + ", "}
					if(curators != "" ) {html += curators + ", "}
					
					if(object.series != null) {html += "in " + object.series + ", "}
					if(object.field1 != ""){ html += "vol. " + object.field1 + ", "}
					if(object.field10 != ""){ html += "n° " + object.field10 + ", "}
					html += actsEditors
					if(object.field2 != ""){ html += "p. " + object.field2 + ", "}
					if(object.field9 != ""){ html += object.field9 + ", "}
					
					html += object.year + ".";
					break;
					
	 			case '35': //Poster in congresso
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field4, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors + "&ldquo;" + title + "&rdquo;, ";
					var curators= format_curators(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab, 
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab, 22
					);
					
					var actsEditors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 18)
					var dataSE= formatData(object.daystart, object.monthstart, object.yearstart, object.dayend, object.monthend, object.yearend);
					
					html += "in <i>" + object.journalActs + "</i>" + ", " ;
					if(object.field5 != ""){ html += object.field5 + ", "}
					if(dataSE != "0"){ html += dataSE + ", "}
					if(curators != "" ) {html += curators + ", "}
					if(object.series != null) {html += "in " + object.series + ", "}
					if(object.field1 != ""){ html += "vol. " + object.field1 + ", "}
					if(object.field10 != ""){ html += "n° " + object.field10 + ", "}
					html += actsEditors
					if(object.field2 != ""){ html += "p. " + object.field2 + ", "}
					if(object.field9 != ""){ html += object.field9 + ", "}
					
					html += object.year + ".";
					break;
					
	 			case '10': //intervento a congresso
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.title, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var dataSE= formatData(object.daystart, object.monthstart, object.yearstart, object.dayend, object.monthend, object.yearend);
					
					var html= authors +  title + ", ";
					if(object.field3 != ""){ html += "intervento a " + object.field3 + ", "}
					if(dataSE != ""){ html += dataSE + ", "}
					if(object.field2 != ""){ html += object.field2 + ", "}
					html += object.year + ".";
					break;
					
	 			case '11': //intervento in evento
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.title, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var dataSE= formatData(object.daystart, object.monthstart, object.yearstart, object.dayend, object.monthend, object.yearend);
					
					var html= authors  + title + ", ";
					if(object.field2 != ""){ html += "intervento a " + object.field2 + ", "}
					if(dataSE != ""){ html += dataSE + ", "}
					if(object.field1 != ""){ html += object.field1 + ", "}
					html += object.year + ".";
					break;
					
	 			case '67': //intervento in seminario
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.title, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var dataSE= formatData(object.daystart, object.monthstart, object.yearstart, object.dayend, object.monthend, object.yearend);
					
					var html= authors +  title + ", ";
					if(object.field3 != ""){ html += "intervento a " + object.field3 + ", "}
					if(dataSE != ""){ html += dataSE + ", "}
					if(object.field2 != ""){ html += object.field2 + ", "}
					html += object.year + ".";
					break;
					
				
				case '27': //Libro
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var curators= format_curators(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab, 
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab, 2
					);
					
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.title, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var editors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 7)
					var html= authors
					if(curators != "") {html += curators + ", "}
					html += title + ', ' ;
					if(object.field4 != "" ){ html += object.field4 + ". ed. "}
					if(object.series != null) {html += "in " + object.series + ", "}
					if(object.field2 != "" ){html += "vol. " + object.field2 + ", "}
					if(editors !="") {html += editors }
					if(object.field9 != "" ){html += object.field9 + ", "}
					if(object.field3 != "" ){html += object.field3 + ", "}
					html += " " + object.year + ".";
					break;
				
				case '9': //Capitolo di libro
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var curators= format_curators(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab, 
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab, 22
					);
					var editors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 7)
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors + title + ', ' + 'in ' + object.book + ', ';
					html += curators + editors + object.year + ".";
					break;
					
	 			case '19': //Rapporto tecnico
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors +  title + ", ";
					if(object.field3 != ""){ html += "" + object.field3 + ", "}
					html += object.year + ".";
					break;
					
				case '18': //tesi
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var relators= format_relators(object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab)
					var hostedBy= format_hosted_by(object.idInstitutionManifestation, object.institutionManifestationName, object.idManifInstitutionResponsab)
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors +  title + ", " + relators + hostedBy;
					html += object.year + ".";
					break;
				 
				case '80': //Pagina web
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors +  title 
					if(object.field3 != ""){ html += ", " + object.field3}
					if(object.year != 0){ html += ", " + object.year }
					if(object.dayItemVisited != 0 || object.monthItemVisited != 0 || object.yearItemVisited != 0) {html += ", visitato in data "}
					if(object.dayItemVisited != 0){html += object.dayItemVisited + "/"} 
					if(object.monthItemVisited != 0){html += object.monthItemVisited + "/"}
					if(object.yearItemVisited != 0){html += object.yearItemVisited }
					html += ".";
					break;
					
				case '79': //Lezione
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors +  title 
					if(object.field4 != ""){ html += ", " + object.field4 + ", "}
					if(object.field1 != ""){ html += " " + object.field1 + ", "}
					html += object.year + "."
					break;
					
				case '38': //installazione
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.title, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					var html= authors +  title 
					if(object.field3 != ""){ html += ", (" + object.field3 + "), "}
					if(object.field1 != ""){ html += " " + object.field1 + ", "}
					html += object.year + "."
					break;
					
				case '20': //documentazione
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var curators= format_curators(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab, 
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab, 2
					);
					
					var editors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 7)
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.field1, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					
					var html= authors + curators + title + ', ' + editors;
					html += " " + object.year + "."
				
					break;
				 
				default:
					var authors= format_authors(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleSurname, object.workPeopleName, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab,
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionForname, object.peopleExpressionName, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab																					
					
					);
					var curators= format_curators(
						object.idPeopleWork, object.idInstitutionWork, object.workPeopleBrief, object.workInstitutionName, object.idWorkPeopleResponsab, object.idWorkInstitutionResponsab, 
						object.idPeopleExpression, object.idInstitutionExpression, object.peopleExpressionBrief, object.institutionExpressionName, object.idExpressionPeopleResponsab, object.idExpressionInstitutionResponsab, 2
					);
					
					var editors= format_editors(object.idPeopleManifestation, object.idInstitutionManifestation, object.peopleManifestationForname, object.peopleManifestationName, object.institutionManifestationName, object.idManifPeopleResponsab, object.idManifInstitutionResponsab, 7)
					var title= format_title_withLinks(object.fileSecretPermission, object.capability, object.title, object.localFile, object.extLink, object.iditem, object.idmanif, object.idwork, objectInTree, object.level);
					
					var html= authors + curators + title + ', ' + editors;
					html += " " + object.year + "."
					break;
					
			} 
		
	
	
	return html

}



function format_authors($idPeopleWork, $idInstitutionsWork, $surnameWork, $nameWork, $briefW, $institutionWork, $resp_peopleWork, $resp_institutionWork, $idPeopleExp, $idInstitutionsExp, $surnameExp, $nameExp, $briefE, $institutionExp, $resp_peopleExp, $resp_institutionExp){
	
	//WORK//
	
	// trasform parametres strings in array
	var $arrayIdPeopleW= String($idPeopleWork).split(",");  
	var $arrayIdInstitutionW=  String($idInstitutionsWork).split(",");
	
	// replace id of people in name/surname/brief field whit empty string
	var $arraysurnameW= String($surnameWork).replace(/[0-9]+[*]/g, ""); 
	$arraysurnameW=  $arraysurnameW.split(",");
	var $arraynameW=  String($nameWork).replace(/[0-9]+[*]/g, ""); 
	$arraynameW= $arraynameW.split(",");
	var $arraybriefW=  String($briefW).replace(/[0-9]+[*]/g, ""); 
	$arraybriefW= $arraybriefW.split(",");
	
	
	var $arrayInstitutionsW=  String($institutionWork).split(",");
	var $arrayRespPeopleW=  String($resp_peopleWork).split(",");
	var $arrayRespInstituW=  String($resp_institutionWork).split(",");
	
	//EXPRESSION//
	
	var $arrayIdPeopleE=  String($idPeopleExp).split(",");
	var $arrayIdInstitutionE=  String($idInstitutionsExp).split(",");
	
	// replace id of people in name/surname/brief field whit empty string
	var $arraysurnameE= String($surnameExp).replace(/[0-9]+[*]/g, ""); 
	$arraysurnameE= $arraysurnameE.split(",");
	var $arraynameE= String($nameExp).replace(/[0-9]+[*]/g, ""); 
	$arraynameE= $arraynameE.split(",");
	var $arraybriefE= String($briefE).replace(/[0-9]+[*]/g, ""); 
	$arraybriefE= $arraybriefE.split(",");
	
	var $arrayInstitutionsE= String($institutionExp).split(",");
	var $arrayRespPeopleE= String($resp_peopleExp).split(",");
	var $arrayRespInstitE= String($resp_institutionExp).split(",");
	
	var result= "";

	
	// find if there is authors in expression -> work
	var $authorsPeople_in_expression = String($resp_peopleExp).match(/[0-9]+[*]20/g);
	var $authorsPeople_in_work = String($resp_peopleWork).match(/[0-9]+[*]1/g);
	var $authorsInstitut_in_expression = String($resp_institutionExp).match(/[0-9]+[*]20/g);
	var $authorsInstitut_in_work = String($resp_institutionWork).match(/[0-9]+[*]1/g);
	
	// authors People
	if($authorsPeople_in_expression != null){

		for(var i=0; i < $arrayRespPeopleE.length; i++){

			if($arrayRespPeopleE[i] == $arrayIdPeopleE[i] + "*20" ){
				
				// first person
				if(i == 0){
					
					// last people with point(.); penultimate people with e (e)
					if($arraysurnameE[i] != ""){
						if(i+1 == $arraysurnameE.length){
							result += $arraysurnameE[i] + ", " + $arraynameE[i] + ", ";
						} else if(i+1 == $arraysurnameE.length -1){
							result += $arraysurnameE[i] + ", " + $arraynameE[i] + " e ";
						} else result += $arraysurnameE[i] + ", " + $arraynameE[i] + ", ";
					} else {
						if(i+1 == $arraybriefE.length){
							result += $arraybriefE[i] + ", ";
						} else if(i+1 == $arraybriefE.length -1){
							result += $arraybriefE[i] + " e ";
						} else result += $arraybriefE[i] + ", ";
					
					}
					
				// others person	
				} else if (i>0){
				
					// last people with point(.); penultimate people with e (e)
					if($arraysurnameE[i] != ""){
						if(i+1 == $arraysurnameE.length){
							result += $arraynameE[i] + " " + $arraysurnameE[i] + ", ";
						} else if(i+1 == $arraysurnameE.length - 1){
							result += $arraynameE[i] + " " + $arraysurnameE[i] + " e ";
						} else result += $arraynameE[i] + " " + $arraysurnameE[i] + ", ";
					} else {
						if(i+1 == $arraybriefE.length){
							result += $arraybriefE[i] + ", ";
						} else if(i+1 == $arraybriefE.length -1){
							result += $arraybriefE[i] + " e ";
						} else result += $arraybriefE[i] + ", ";
					
					}
				
				}
			
			}				
			
		}			
	
	} else if($authorsPeople_in_work != null){
		
		for(var i=0; i < $arrayRespPeopleW.length; i++){
			//console.log($arraysurnameW)
			if($arrayRespPeopleW[i] == $arrayIdPeopleW[i] + "*1"){
				
				// first person
				if(i == 0){
					// last people with point(.); penultimate people with e (e)
					if($arraysurnameW[i] != ""){
						if(i+1 == $arraysurnameW.length){
							result += $arraysurnameW[i] + ", " + $arraynameW[i] + ", ";
						} else if(i+1 == $arraysurnameW.length - 1){
							result += $arraysurnameW[i] + ", " + $arraynameW[i] + " e ";
						} else result += $arraysurnameW[i] + ", " + $arraynameW[i] + ", ";
					} else {
						if(i+1 == $arraybriefW.length){
							result += $arraybriefW[i] + ", ";
						} else if(i+1 == $arraybriefW.length -1){
							result += $arraybriefW[i] + " e ";
						} else result += $arraybriefW[i] + ", ";
					
					}
					
				// others person	
				} else if (i>0){
				
					// last people with point(.); penultimate people with e (e)
					if($arraysurnameW[i] != ""){
						if(i+1 == $arraysurnameW.length){
							result += $arraynameW[i] + " " + $arraysurnameW[i] + ", ";
						} else if(i+1 == $arraysurnameW.length - 1){
							result += $arraynameW[i] + " " + $arraysurnameW[i] + " e ";
						} else result += $arraynameW[i] + " " + $arraysurnameW[i] + ", ";
					} else {
						if(i+1 == $arraybriefW.length){
							result += $arraybriefW[i] + ", ";
						} else if(i+1 == $arraybriefW.length -1){
							result += $arraybriefW[i] + " e ";
						} else result += $arraybriefW[i] + ", ";
					
					}
				
				}
				
			}
		
		}
	}
	
	//authors Institutions
	else if($authorsInstitut_in_expression != null){
	
		for(var i=0; i < $arrayInstitutionsE.length; i++){
			
			if($arrayRespInstitE[i] == $arrayIdInstitutionE[i] + "*20"){
				
				result += $arrayInstitutionsE[i] + ", ";
			
			}
		
		}
	} else if ($authorsInstitut_in_work != null){
		
		for(var i=0; i < $arrayInstitutionsW.length; i++){
			
			if($arrayRespInstituW[i] == $arrayIdInstitutionW[i] + "*1"){
				
				result += $arrayInstitutionsW[i] + ", ";
			
			}
		
		}	
	
	}
	

	return result;

}

																																		  //22(curatori degli atti); 2(curatori)
function format_curators($idPeopleWork, $idInstitutionsWork, $briefWork, $institutionWork, $resp_peopleWork, $resp_institutionWork, $idPeopleExp, $idInstitutionsExp, $briefExp, $institutionExp, $resp_peopleExp, $resp_institutionExp, $id_typeOfCurators){
	
	// trasform parametres strings in array
	var $arrayIdPeopleW= String($idPeopleWork).split(",");  
	var $arrayIdInstitutionW=  String($idInstitutionsWork).split(",");
	
	// replace id of people in brief field whit empty string
	var $arrayBriefW= String($briefWork).replace(/[0-9]+[*]/g, ""); 
	$arrayBriefW=  $arrayBriefW.split(",");

	
	var $arrayInstitutionsW=  String($institutionWork).split(",");
	var $arrayRespPeopleW=  String($resp_peopleWork).split(",");
	var $arrayRespInstituW=  String($resp_institutionWork).split(",");
	
	
	
	
	var $arrayIdPeopleE=  String($idPeopleExp).split(",");
	var $arrayIdInstitutionE=  String($idInstitutionsExp).split(",");
	
	// replace id of people in name/surname field whit empty string
	var $arrayBriefE= String($briefExp).replace(/[0-9]+[*]/g, ""); 
	$arrayBriefE= $arrayBriefE.split(",");
	
	var $arrayInstitutionsE= String($institutionExp).split(",");
	var $arrayRespPeopleE= String($resp_peopleExp).split(",");
	var $arrayRespInstitE= String($resp_institutionExp).split(",");
	
	var result= "";

	
	// find if there is curators in expression -> work
	let re = new RegExp("[0-9]+[*]" + $id_typeOfCurators + "$|[0-9]+[*]" + $id_typeOfCurators + ",", 'g') 
	var $curatorsPeople_in_expression = String($resp_peopleExp).match(re);
	var $curatorsPeople_in_work = String($resp_peopleWork).match(/[0-9]+[*]34$|[0-9]+[*]34,/g);
	var $curatorsInstitut_in_expression = String($resp_institutionExp).match(re);
	var $curatorsInstitut_in_work = String($resp_institutionWork).match(/[0-9]+[*]34$|[0-9]+[*]34,/g);

	// curators People
	if($curatorsPeople_in_expression != null ){ 
		//console.log("sei in curatori persone ESPRESSIONE")
		//console.log($curatorsPeople_in_expression)
		
		result += " (a cura di ";
		var comma= ", "
		
		for(i=0; i < $arrayBriefE.length; i++){
		
			if($arrayRespPeopleE[i] == $arrayIdPeopleE[i] + ("*" + $id_typeOfCurators)){	
				
				if(i==$arrayBriefE.length-1){comma= "";}
			
				if( $arrayBriefE[i] != "" ) {result += " " + $arrayBriefE[i] + comma;}
				
			}			
		
		}

		result += ")"	
	
	} else if($curatorsPeople_in_work != null){ 
			//console.log("sei in curatori persone OPERA")
			//console.log($curatorsPeople_in_work)
		
		result += " (a cura di ";
		var comma= ", "
		
		for(i=0; i < $arrayBriefW.length; i++){
		
			if($arrayRespPeopleW[i] == $arrayIdPeopleW[i] + "*34"){	
				
				if(i==$arrayBriefW.length-1){comma=""}
			
				if( $arrayBriefW[i] != "" ) {result += " " + $arrayBriefW[i] + comma;}
				
			}			
		
		}
		
		result += ")"

	}
	
	//curators Institutions
	else if($curatorsInstitut_in_expression != null ){ 
			//console.log("sei in curatori istituzi ESPRESSIONE")
			//console.log($curatorsInstitut_in_expression)
		
		result += " (a cura di ";
		var comma= ", "
		
		for(i=0; i < $arrayInstitutionsE.length; i++){
		
			if($arrayRespInstitE[i] == $arrayIdInstitutionE[i] + ("*" + $id_typeOfCurators)){	
				
				if(i==$arrayInstitutionsE.length-1){comma= "";}
			
				if( $arrayInstitutionsE[i] != "" ) {result += " " + $arrayInstitutionsE[i] + comma;}
				
			}			
		
		}
		
		result += ")"
	

	} else if ($curatorsInstitut_in_work != null){ 
			//console.log("sei in curatori istituzi OPERA")
			//console.log($curatorsInstitut_in_work)
		
		result += " (a cura di ";
		var comma= ", "
		
		for(i=0; i < $arrayInstitutionsW.length; i++){
		
			if($arrayRespInstituW[i] == $arrayIdInstitutionW[i] + "*34"){	
				
				if(i==$arrayInstitutionsW.length-1){comma= "";}
			
				if( $arrayInstitutionsW[i] != "" ) {result += " " + $arrayInstitutionsW[i] + comma;}
				
			}			
		
		}
		
		result += ")"
	
	}
	

	return result;

}

																																						//7(editore), 18(editore degli atti)
function format_editors($idPeopleManif, $idInstitutionsManif, $surnameManif, $nameManif, $institutionManif, $resp_peopleManif, $resp_institutionManif, $id_typeOfEditors){
	
	
	
	// trasform parametres strings in array
	var $arrayIdPeopleM= String($idPeopleManif).split(",");    
	var $arrayIdInstitutionM= String($idInstitutionsManif).split(",");      
	
	// replace id of people in name/surname field whit empty string
	var $arraysurnameM= String($surnameManif).replace(/[0-9]+[*]/g, ""); 
	$arraysurnameM= $arraysurnameM.split(",");      
	var $arraynameM= String($nameManif).replace(/[0-9]+[*]/g, ""); 
	$arraynameM= $arraynameM.split(",");
	
	var $arrayInstitutionsM= String($institutionManif).split(",");      
	var $arrayRespPeopleM= String($resp_peopleManif).split(",");       
	var $arrayRespInstituM= String($resp_institutionManif).split(","); 

	var result= "";	
	
	if($arraysurnameM != "" || $arrayInstitutionsM != ""){
		
 		var $surnames_Institutions= $arraysurnameM.concat($arrayInstitutionsM);
		var $idP_idI= $arrayIdPeopleM.concat($arrayIdInstitutionM);
		var $respP_respI= $arrayRespPeopleM.concat($arrayRespInstituM);
		
		
 		for(i=0; i < $surnames_Institutions.length; i++){
		
			if($respP_respI[i] == $idP_idI[i] + ("*" + String($id_typeOfEditors))){	
			
				if( $surnames_Institutions[i] != "" ) {result += " " + $surnames_Institutions[i] + ", ";}
			
			}			
		
		}  
		

	
	}
	
	return result;

}

function format_relators($idPeopleExp, $idInstitutionsExp, $surnameExp, $nameExp, $institutionExp, $resp_peopleExp, $resp_institutionExp){
	
	// trasform parametres strings in array
	var $arrayIdPeopleE= String($idPeopleExp).split(",");    
	var $arrayIdInstitutionE= String($idInstitutionsExp).split(",");      
	
	// replace id of people in name/surname field whit empty string
	if($surnameExp != null){
		var $arraysurnameE= String($surnameExp).replace(/[0-9]+[*]/g, ""); 
		$arraysurnameE= $arraysurnameE.split(",");
	} else {$arraysurnameE=null}
	
	if($nameExp != null){
		var $arraynameE= String($nameExp).replace(/[0-9]+[*]/g, "");  
		$arraynameE= $arraynameE.split(",");
	} else {$arraynameE=null}
	
	var $arrayInstitutionsE= String($institutionExp).split(",");      
	var $arrayRespPeopleE= String($resp_peopleExp).split(",");       
	var $arrayRespInstituE= String($resp_institutionExp).split(","); 
	
	var result="";
	
	if( $arraysurnameE != null ){
				
 		for(i=0; i < $arraysurnameE.length; i++){
		
			if($arrayRespPeopleE[i] == $arrayIdPeopleE[i] + "*36"){	
				
				if(i==0){result= " relatore/i ";}
			
				if( $arraysurnameE[i] != "" ) {result += " " + $arraysurnameE[i] + ", " + $arraynameE[i] + ", ";}
				
			}			
		
		} 
	
	
	}  if ( $arrayInstitutionsE != null ){
		
		for(i=0; i < $arrayInstitutionsE.length; i++){
		
			if($arrayRespInstituE[i] == $arrayIdInstitutionE[i] + "*36"){	
				
				if(i==0){result= " relatore/i ";}
			
				if( $arrayInstitutionsE[i] != "" ) {result += " " + $arrayInstitutionsE[i] + ", ";}
			
			}			
		
		} 
	
	}
	
	return result;

}

function format_hosted_by($idInstitutionsManif, $institutionManif, $resp_institutionManif){
	
	// trasform parametres strings in array  
	var $arrayIdInstitutionM= String($idInstitutionsManif).split(",");      
	var $arrayInstitutionsM= String($institutionManif).split(",");         
	var $arrayRespInstituM= String($resp_institutionManif).split(","); 

	var result= "";	
	
	if( $arrayIdInstitutionM != null ){
				
 		for(i=0; i < $arrayIdInstitutionM.length; i++){
		
			if($arrayRespInstituM[i] == $arrayIdInstitutionM[i] + "*9" ){	
				
				if( $arrayInstitutionsM[i] != "" ) {result += " " + $arrayInstitutionsM[i] + ", " ;}
				
			}			
		
		} 
	
	
	}
	return result;

}




																																		//level is only for collection; for search, level is always null												
function format_title_withLinks($fileSecretPermission, $capability, $title, $localFile, $extLink, itemId, manifid, idWork, objectInTree, level){
	//$fileSecretPermission (1: connected people with permission; 0: connected people without permission (students); null: people not connected
	
	var $titleWithLinks="";
	
	// if is ITEM in collection or if is in search (not collection)
	if(level == "item" || level == null){ 
		
		//if is item in tree search
		if(objectInTree==1){
			var onclickOpenLink= " onclick='openItemLink(this.id);' "
			var linkhrefLocal= " href='https://www.progettohmr.it/Biblio/"+$localFile+"' "
			var linkhrefExt= $extLink;
			
			if($fileSecretPermission == 1){
				
				if($localFile != ""){ $titleWithLinks= "<a "+ onclickOpenLink +" id ='itemLocalFile"+itemId+"' " + linkhrefLocal + ">" + $title + "</a>";} else if ($extLink != "") { $titleWithLinks= "<a "+ onclickOpenLink +" id ='itemExtLink"+itemId+"' href='" +linkhrefExt+ "'>" + $title + "</a>"; } else {$titleWithLinks= $title;}
			
			} else if ($fileSecretPermission == 0 ) {
			
				if ($capability == 2 || $capability == 1 || $capability == 0) {
					
					if($localFile != ""){ $titleWithLinks= "<a "+onclickOpenLink+" id ='itemLocalFile"+itemId+"' " + linkhrefLocal + ">"+ $title + "</a>";}  else if ($extLink != "") { $titleWithLinks= "<a "+onclickOpenLink+" id ='itemExtLink"+itemId+"' href='" +linkhrefExt+ "'>" + $title + "</a>"; } else {$titleWithLinks= $title;}
					
				} else { $titleWithLinks= $title;}
			
			} else if ($fileSecretPermission == null ){
				
				if ($capability == 1 || $capability == 0) {
					
					if($localFile != ""){ $titleWithLinks= "<a "+onclickOpenLink+" id ='itemLocalFile"+itemId+"' " + linkhrefLocal + ">"+ $title + "</a>";}  else if ($extLink != "") { $titleWithLinks= "<a "+onclickOpenLink+" id ='itemExtLink"+itemId+"' href='" +linkhrefExt+ "'>"+ $title + "</a>"; } else {$titleWithLinks= $title;}	
					
				} else  {$titleWithLinks= $title;}
				
			}
		
		// if is item in collection
		} else {
	
			$titleWithLinks= "<a  id ='item"+itemId+"' href='https://www.progettohmr.it/Biblio/?idItem=" + itemId + "&idWork=" + idWork+"' target='_blank'>" + $title + "</a>";
			
			}
	 // if is MANIFESTATION in collection
	} else {
	
		$titleWithLinks= "<a  id ='manif"+manifid+"' href='https://www.progettohmr.it/Biblio/?idManif=" + manifid + "&idWork=" + idWork + "' target='_blank'>" + $title + "</a>";
			
	}
	
	return $titleWithLinks;

}


function formatData(ddS, mmS, yyS, ddE, mmE, yyE){
	
	var result="";
	
	if(ddS!=0 ){result+= ddS+"-"}
	if(mmS!=0 ){result+= mmS+"-"}
	if(yyS!=0 ){result+= yyS}
	

	
	return result;

}