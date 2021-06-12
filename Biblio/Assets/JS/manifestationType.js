
/* $(document).ready(function() {
	
 	$('#manifestationType').on('change', function() {
		
		// get id type to pass with ajax
		var idType= $('#manifestationType option').filter(':selected').val();
		
		$.ajax({  
			type: "GET",
			url: "../Assets/apiDb/manifestationTypeFields.php", 
			dataType: "JSON",					
			data: {idType: idType},
			success: function(resp) {  
				
				$("#manifestationTypeFields").empty();
				$("#manifestationTypeFields").append(resp.html);
			
			
			},
			error: function(response){
				var a= JSON.stringify(response)
				alert(a)

			} 
		}); 
		
	}); 
	
	
	
}); */


function getManifestationField(idForm, field1, field2, field3, field4, field5, field6, field7, field8, field9, field10, day, month, year, daystart, monthstart, yearstart, dayend, monthend, yearend, dayscan, monthscan, yearscan){

		// get id type to pass with ajax
		var idType= $('#manifestationType option').filter(':selected').val();
		
		$.ajax({  
			type: "GET",
			url: "../Assets/apiDb/manifestationTypeFields.php", 
			dataType: "JSON",					
			data: {idType: idType, idForm: idForm, field1: field1, field2: field2, field3: field3, field4: field4, field5: field5, field6: field6, field7: field7, field8: field8, field9: field9, field10: field10, day: day, month: month, year: year, daystart: daystart, monthstart: monthstart, yearstart: yearstart, dayend: dayend, monthend: monthend, yearend: yearend, dayscan: dayscan, monthscan: monthscan, yearscan: yearscan},
			success: function(resp) {  
				
				$("#manifestationTypeFields").empty();
				$("#manifestationTypeFields").append(resp.html);
			
			
			},
			error: function(response){
				var a= JSON.stringify(response)
				alert(a)

			} 
		}); 
		
}


