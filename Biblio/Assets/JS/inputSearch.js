	$(document).ready(function () {
        
        $("#filtersearch-title").show(200);
		$("#filtersearch-intervalyear").show(200);
        
		// select size
		
		$('.idPeople').selectize({
			create: false,
			sortField: 'text'
		});
		
		$('.idPeopleResponsability').selectize({
			create: false,
			sortField: 'text'
		});
		  
		$('.idInstitution').selectize({
			create: false,
			sortField: 'text'
		});
		
		$('.idInstitutionResponsability').selectize({
			create: false,
			sortField: 'text'
		});
        
        $('#intervalyear-start').selectize({
				create: false
		});
        
        $('#intervalyear-end').selectize({
				create: false
		});
		
		//checkbox clicked
		$("#checkboxAdvanced").on("click", function() {
			if($(this).is(":checked")) {
				$("#filtersearch-people").show(200);
                $("#filtersearch-institution").show(200);
			} else {
				$("#filtersearch-people").hide(200);
                $("#filtersearch-institution").hide(200);
			}
		});
		
		$("#checkboxTitle").on("click", function() {
			if($(this).is(":checked")) {
				$("#filtersearch-title").show(200);
			} else {
				$("#filtersearch-title").hide(200);
			}
		});
		
		$("#checkboxIterval").on("click", function() {
			if($(this).is(":checked")) {
				$("#filtersearch-intervalyear").show(200);
			} else {
				$("#filtersearch-intervalyear").hide(200);
			}
		});
		
		
		// aggiungere persone
		$('#addPeople').on('click', function(){

		   $('.idPeople').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
				 var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
		   });
		   
		   $('.idPeopleResponsability').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
				 var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
		   });
		   
		   $('.selectPeople:first')
			  .clone() // copy
			  .insertAfter('.selectPeople:last'); // where
			  
			 $('.idPeople').selectize({
				create: false,
				sortField: 'text'
			});
			$('.idPeopleResponsability').selectize({
				create: false,
				sortField: 'text'
			});

		});
		
		//eliminare persone
		$(document).on('click', '.deletePeople', function(){

			
		   $('.idPeople').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
			  	var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); 
				 $(this).val(value);  // set back the value of the select/input

			  }
		   });
		   
		   $('.idPeopleResponsability').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
			  	var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
		   });
		   
		   var numPeople = $('.selectPeople').length;
		   if (numPeople > 1) {
			$(this).parent().remove();
		   } else {
			   
			   $('.idPeople').val("");
			   $('.idPeopleResponsability').val("");
			   
		   }
			
			$('.idPeople').selectize({
				create: false,
				sortField: 'text'
			});
			$('.idPeopleResponsability').selectize({
				create: false,
				sortField: 'text'
			});
		});
		
		// aggiungere istituzioni
		$('#addInstitution').on('click', function(){

		   $('.idInstitution').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
				 var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
		   });
		   
		   $('.idInstitutionResponsability').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
				 var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
		   });
		   
		   $('.selectInstitution:first')
			  .clone() // copy
			  .insertAfter('.selectInstitution:last'); // where
			  
			 $('.idInstitution').selectize({
				create: false,
				sortField: 'text'
			});
			$('.idInstitutionResponsability').selectize({
				create: false,
				sortField: 'text'
			});

		});
		
		//eliminare istituzioni
		$(document).on('click', '.deleteInstitution', function(){

			
		   $('.idInstitution').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
			  	var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); 
				 $(this).val(value);  // set back the value of the select/input

			  }
		   });
		   
		   $('.idInstitutionResponsability').each(function(){ // do this for every select with the 'idPeople' class
			  if ($(this)[0].selectize) { // requires [0] to select the proper object
			  	var value = $(this).val(); // store the current value of the select/input
				 $(this)[0].selectize.destroy(); // destroys selectize()
				 $(this).val(value);  // set back the value of the select/input
			  }
		   });
		   
		   var numPeople = $('.selectInstitution').length;
		   if (numPeople > 1) {
			$(this).parent().remove();
		   } else {
			   
			   $('.idInstitution').val("");
			   $('.idInstitutionResponsability').val("");
			   
		   }
			
			$('.idInstitution').selectize({
				create: false,
				sortField: 'text'
			});
			$('.idInstitutionResponsability').selectize({
				create: false,
				sortField: 'text'
			});
		});
		
			
		
});