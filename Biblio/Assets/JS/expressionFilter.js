$(document).ready(function () {	

	$('.filter').on('change', function() {
		
		var idPeople= $('#People-filter').val();
		var idInstitution= $('#Institution-filter').val();
/* 		console.log(idPeople)
		console.log(idInstitution) */
		$.ajax({  
			type: "GET",
			url: "../Assets/apiDb/filterExpression.php", 
			dataType: "JSON",					
			data: {idPeople: idPeople, idInstitution: idInstitution},
			success: function(resp) {  
			
/* 				var a= JSON.stringify(response)
				alert(a) */
				

				// get works from php
				var works= resp.workByRespons;
				
				//clear first value of work (selected first)
				$('#expressionWorks').selectize()[0].selectize.clear();
				
				//clear all options of works
				$('#expressionWorks').selectize()[0].selectize.clearOptions();

				// add new options of works
				for(var i=0; i<works.length; i++){
				
					
					$('#expressionWorks')[0].selectize.addOption({value: works[i].id + "-" + works[i].id, text: works[i].title});
				
				}
			
			
			},
			error: function(response){
				var a= JSON.stringify(response)
				alert(a)

			} 
		}); 
		
	});


});	