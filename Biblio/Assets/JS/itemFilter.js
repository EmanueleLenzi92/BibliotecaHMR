$(document).ready(function () {	
	
	// FILTER PEOPLE INSTITUTION

	$('.filter').on('change', function() {
				
		var idFilter= $(this).attr('id');
		var key= idFilter.split('-') //key[0]= People/Institution, key[1]= filter, key[2]= Expression/Item
	
		var idPeople= $('#People-filter').val();
		var idInstitution= $('#Institution-filter').val();
		var type= key[0];
		
		
		$.ajax({  
			type: "GET",
			url: "../Assets/apiDb/filterItem-peopleInstitution.php",
			dataType: "JSON",					
			data: {idPeople: idPeople, idInstitution: idInstitution, type: type},
			success: function(resp) {  

				
				// get works and manifestations from php
				var works= resp.workByRespons;
				var manifest= resp.manifestationsByWorks;
				
				//clear first value of work (selected first)
				$('#Work-filter').selectize()[0].selectize.clear();
				
				//clear all options of works
				$('#Work-filter').selectize()[0].selectize.clearOptions();

				// add new options of works
				for(var i=0; i<works.length; i++){
				
					
					$('#Work-filter')[0].selectize.addOption({value: works[i].id + "-" + works[i].id, text: works[i].title});
				
				}
				
						
				//clear first value of expression (selected first)
				$('#manifestationItem').selectize()[0].selectize.clear();
				
				//clear all options of expressions
				$('#manifestationItem').selectize()[0].selectize.clearOptions();
				
				
				// add new options of expressions/items

				for(var i=0; i<manifest.length; i++){
					
						
					$('#manifestationItem')[0].selectize.addOption({value: manifest[i].id + "-" + manifest[i].idwork, text: manifest[i].title + ", " + manifest[i].type});
					
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
		
 
		var idWork= $('#Work-filter').val().split('-');
		idWork = idWork[0];
		
		$.ajax({  
			type: "GET",
			url: "../Assets/apiDb/filterItem-work.php", 
			dataType: "JSON",					
			data: {idWork: idWork},
			success: function(resp) {  
			

			
				// get manifestations from php
				var result= resp.manifestations;

	
				//clear first value of manif (selected first)
				$('#manifestationItem').selectize()[0].selectize.clear();
				
				//clear all options of manif
				$('#manifestationItem').selectize()[0].selectize.clearOptions();

				// add new options of items

					for(var i=0; i<result.length; i++){
					
						
						$('#manifestationItem')[0].selectize.addOption({value: result[i].id + "-" + result[i].idwork, text: result[i].title + ", " + result[i].type});
					
					}
				
				
			
			},
			error: function(response){
				var a= JSON.stringify(response)
				alert(a)

			} 
		});
	
	});

});	