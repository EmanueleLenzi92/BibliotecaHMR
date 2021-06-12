	$(document).ready(function () {	
		
		$(".confirmResp").click(function(){
			
			// get id of clicked button
			var idConfirm= $(this).attr('id');
			var key= idConfirm.split('-') //key[0]= People/Institution
			
				
			var idPeopleInstitut= $('#' + key[0] + ' option').filter(':selected').val();
			var respId= $('#' + key[0] + '-Responsability option').filter(':selected').val();
			var namePeopleInstitut= $('#' + key[0] + ' option').filter(':selected').text();
			var respName= $('#' + key[0] + '-Responsability option').filter(':selected').text();
			
	
			if((respId != "") && (idPeopleInstitut != "")){
			
				// create table
				$('#' + key[0] + "-table table").append(""+
					"<tr id='riga-" + key[0] + "-"+idPeopleInstitut+"-"+respId+"'>" +
					"<td>" + idPeopleInstitut + "</td>" +
					"<td>" + namePeopleInstitut + "</td>" +
					"<td>" + respName + "</td>" +
					"<td><button type='button' class='delete-responsab btn' id='delete-"+key[0]+"-"+idPeopleInstitut+"-"+respId+"'><i class='fa fa-trash'></i></button></td>" + 
					"</tr>" 
				).on('click', "#delete-"+key[0]+"-"+idPeopleInstitut+"-"+respId, deletResp);
				
				$('#' + key[0] + "-table table").show();
				
				// append input to send to dDB
				if(key[0] == "People"){
					
					$("#People-Data").append(""+
					"<span id='data-People-" + idPeopleInstitut + "-" + respId + "'>" +
					"<input type='hidden' name='inputIdPeople[]' value='"+ idPeopleInstitut +"'>" +
					"<input type='hidden' name='inputIdPeopleResponsability[]' value='"+ respId +"'>" +
					"</span>"
					)
				
				} else {
					
					$("#Institution-Data").append(""+
					"<span id='data-Institution-" + idPeopleInstitut + "-" + respId + "'>" +
					"<input type='hidden' name='inputIdInstitution[]' value='"+ idPeopleInstitut +"'>" +
					"<input type='hidden' name='inputIdInstitutionResponsability[]' value='"+ respId +"'>" +
					"</span>"
					)				
				
				}
				
				// clear selected text in input
				$('#' + key[0]).selectize()[0].selectize.clear();
			
			} else alert("seleziona la responsabilità e la persona/istituzione")
		
		});
	
		
		// DELETE RESP FOR RESPONSABILITY NEW
		$(".delete-responsab").click(function(){
			
			var id= $(this).attr('id');
			var key= id.split('-') //key[0]= delete key[1]= People/Institution key[2]= idPeop/instit key[3]= idResp

			// remove table
			$('#data-' + key[1] + "-" + key[2] + "-" + key[3]).remove()
			
			// remove input
			$('#' + key[1] + "-table table #riga-" + key[1] + "-" + key[2] + "-" + key[3]).remove()
			
			// hide first row table (the titles row)
			var rowCount = $('#' + key[1] + '-table table tr').length;
			if (rowCount == 1){
				
				$('#' + key[1] + "-table table").hide();
			
			}
			
			
		});
	
	
	});	


// DELETE RESP FOR RESPONSABILITY old, when modify a event (append when created the button)
function deletResp(){
	
	var id= $(this).attr('id');
	var key= id.split('-') //key[0]= delete key[1]= People/Institution key[2]= idPeop/instit key[3]= idResp

	// remove table
	$('#data-' + key[1] + "-" + key[2] + "-" + key[3]).remove()
	
	// remove input
	$('#' + key[1] + "-table table #riga-" + key[1] + "-" + key[2] + "-" + key[3]).remove()
	
	// hide first row table (the titles row)
	var rowCount = $('#' + key[1] + '-table table tr').length;
	if (rowCount == 1){
		
		$('#' + key[1] + "-table table").hide();
	
	}
	

	
}
