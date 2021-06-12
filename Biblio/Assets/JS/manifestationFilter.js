$(document).ready(function () {	
	
	// FILTER PEOPLE INSTITUTION

	$('.filter').on('change', function() {

		var idFilter= $(this).attr('id');
		var key= idFilter.split('-') //key[0]= People/Institution, key[1]= filter, key[2]= Expression/Item
		
		var idPeople= $('#People-filter-' + key[2]).val();
		var idInstitution= $('#Institution-filter-' + key[2]).val();
		

		$.ajax({  
			type: "GET",
			url: "../Assets/apiDb/filterManifestation-peopleInstitution.php", 
			dataType: "JSON",					
			data: {idPeople: idPeople, idInstitution: idInstitution, level: key[2], type: key[0]},
			success: function(resp) {  
			

			
				// get works and expressions from php
				var works= resp.workByRespons;
				var express= resp.expressionsByWorks;
				var items=resp.itemsByWork;
				
				//clear first value of work (selected first)
				$('#Work-filter-' + key[2]).selectize()[0].selectize.clear();
				
				//clear all options of works
				$('#Work-filter-' + key[2]).selectize()[0].selectize.clearOptions();

				// add new options of works
				for(var i=0; i<works.length; i++){
				
					
					$('#Work-filter-' + key[2])[0].selectize.addOption({value: works[i].id + "-" + works[i].id, text: works[i].title});
				
				}
				
				
				
				//clear first value of expression (selected first)
				$('#manifestation' + key[2]).selectize()[0].selectize.clear();
				
				//clear all options of expressions
				$('#manifestation' + key[2]).selectize()[0].selectize.clearOptions();
				
				
				// add new options of expressions/items
				if (key[2] == 'Expression'){
					for(var i=0; i<express.length; i++){
					
						
						$('#manifestationExpression')[0].selectize.addOption({value: express[i].id + "-" + express[i].idwork, text: express[i].title + ", " + express[i].typeName});
					
					}
				} else {
					
					if (key[2] == 'Item'){
						for(var i=0; i<items.length; i++){
						
							
							$('#manifestationItem')[0].selectize.addOption({value: items[i].id + "-" + items[i].idwork, text: items[i].title + ', ' + items[i].maniType });
						
						}
					
					}
				}
			
			},
			error: function(response){
				var a= JSON.stringify(response)
				alert(a)

			} 
		}); 
		
	});
	
	
	
	// FILTER Work
	
	$('.filter-work').on('change', function() {
		
		var idFilter= $(this).attr('id');
		var key= idFilter.split('-') //key[0]= People/Institution, key[1]= filter, key[2]= Expression/Item
		
		// get id Work of item/expression clicked  
		var idWork= $('#Work-filter-' + key[2]).val().split('-');
		idWork = idWork[0];
		
		
		$.ajax({  
			type: "GET",
			url: "../Assets/apiDb/filterManifestation-work.php", 
			dataType: "JSON",					
			data: {idWork: idWork, level: key[2]},
			success: function(resp) {  
			

			
				// get expressions or items from php
				var result= resp.ExpressionItem;
				var level= resp.level;


				
				//clear first value of work (selected first)
				$('#manifestation' + key[2]).selectize()[0].selectize.clear();
				
				//clear all options of works
				$('#manifestation' + key[2]).selectize()[0].selectize.clearOptions();

				// add new options of items/expression
				if (key[2] == "Expression"){
					for(var i=0; i<result.length; i++){
					
						
						$('#manifestationExpression')[0].selectize.addOption({value: result[i].id + "-" + result[i].idwork, text: result[i].title + ", " + result[i].typeName});
					
					}
				} else {
						
					if (key[2] == "Item"){
						
						for(var i=0; i<result.length; i++){
						
							
							$('#manifestationItem')[0].selectize.addOption({value: result[i].id + "-" + result[i].idwork, text: result[i].title + ', ' + result[i].maniType});
						
						}
				
					}
				}
				
			
			},
			error: function(response){
				var a= JSON.stringify(response)
				alert(a)

			} 
		});
	
	});

});	