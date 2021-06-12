$(document).ready(function() {
	
	$('.openDiv').on('click', function() {

		var idOpenDiv= $(this).attr('id');

		if (idOpenDiv == "openDiv-People"){
			
           /*$("#Institution-x").hide(100);
			$("#People-x").show(100); */
			$("#People-x").toggle(100);
			$("#openDiv-People").find('i').toggleClass('fa-angle-up fa-angle-down')
		
		} else if (idOpenDiv == "openDiv-Institution"){
			
			/*$("#People-x").hide(100);
			$("#Institution-x").show(100);*/
			$("#Institution-x").toggle(100);
			$("#openDiv-Institution").find('i').toggleClass('fa-angle-up fa-angle-down')
		
		} else if (idOpenDiv == "openDiv-manifestationExpression"){
	
			$("#openDiv-manifestationItem-x").hide(100);
			$("#openDiv-manifestationExpression-x").show(100);
			$('#openDiv-manifestationExpression i').attr('class', 'fa fa-angle-up');
			$('#openDiv-manifestationItem i').attr('class', 'fa fa-angle-down');
			
			// add-delete required
			$("#openDiv-manifestationItem-x :input").attr("disabled", true);
			$("#openDiv-manifestationExpression-x :input").attr("disabled", false);
			
			//delete selected expr/item of other div
			$('#manifestationItem').selectize()[0].selectize.clear();
			  
			  //hide copy type
				$('#maniftype'+17).hide();
		
		} else if (idOpenDiv == "openDiv-manifestationItem"){
			
			$("#openDiv-manifestationExpression-x").hide(100);	
			$("#openDiv-manifestationItem-x").show(100);
			$('#openDiv-manifestationExpression i').attr('class', 'fa fa-angle-down');
			$('#openDiv-manifestationItem i').attr('class', 'fa fa-angle-up');
			
			// add-delete required			
			$("#openDiv-manifestationExpression-x :input").attr("disabled", true);
			$("#openDiv-manifestationItem-x :input").attr("disabled", false);
			
			
			//delete selected expr/item of other div
			$('#manifestationExpression').selectize()[0].selectize.clear();	

            //show copy type
				$('#maniftype'+17).show();
				
		} else if (idOpenDiv == "openDiv-localFile"){
			
			$("#openDiv-extLink-x").hide(100);
			$("#extLink").val("")
			$("#openDiv-localFile-x").show(100);
			$('#openDiv-extLink i').attr('class', 'fa fa-angle-down');
			$('#openDiv-localFile i').attr('class', 'fa fa-angle-up');
		
		} else if (idOpenDiv == "openDiv-extLink"){
			
			$("#openDiv-localFile-x").hide(100);
			document.getElementById('localFile').value = ''
			$('input[type="radio"]').prop('checked', false); 
			$("#openDiv-extLink-x").show(100);
			$('#openDiv-localFile i').attr('class', 'fa fa-angle-down');
			$('#openDiv-extLink i').attr('class', 'fa fa-angle-up');
		
		}
		
		
		
	});
	
	
	
	
	
	
});