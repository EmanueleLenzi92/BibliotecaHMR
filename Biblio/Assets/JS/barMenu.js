function appendBiblioMenu(level, currentLink){
		
	var levelTree = climbTreeStr(level);
	
	var work = ""; var expression = ""; var manifestation = ""; 
	var item = ""; var levelsList = ""; var people = ""; var institution = "";
	
	switch(currentLink){
	
		case 1:
			work = "active";  
			break;
		case 2:
			expression = "active";  
			break;
		case 3:
			manifestation = "active";  
			break;
		case 4:
			item = "active";  
			break;
		case 5:
			levelsList = "active"; 
			break;
		case 6:
			people = "active";  
			break;
		case 7:
			institution = "active"; 
			break;
	}
	
	$('#barBiblioMenu').append( "" +
	
		"<ul>" +
			
			"<li> <a href='" + levelTree + "Work/' class='" + work + "'>Opera</a> </li>" + 
			"<li> " +
				"<a href='" + levelTree + "Expression/' class='" + expression + "'>Espressione</a> "+
				"<ul class='dropdown'>" +
					'<li><a href="'+ levelTree +'Expression/expressionType.php">Tipi</a></li>' +
				'</ul>' +
			"</li>" + 
			"<li> <a href='" + levelTree + "Manifestation/' class='" + manifestation + "'>Manifestazione</a> </li>" + 
			"<li> <a href='" + levelTree + "Item/' class='" + item + "'>Esemplare</a> </li>" + 
			"<li>" +
				"<a href='#'>Lista oggetti</a>" +
				"<ul class='dropdown'>" +
					'<li><a href="'+ levelTree +'LevelsList/?level=work">Opere</a></li>' +
					'<li><a href="'+ levelTree +'LevelsList/?level=expression">Espressioni</a></li>' +
					'<li><a href="'+ levelTree +'LevelsList/?level=manifestation">Manifestazioni</a></li>' +
					'<li><a href="'+ levelTree +'LevelsList/?level=item">Esemplari</a></li>' +
				'</ul>' +
			'</li>' +
			"<li>" +
				'<a href="#">Responsabilità</a>' +
				"<ul class='dropdown'>" +
					"<li> <a href='" + levelTree + "Responsability/people.php' class='" + people + "'>Persone</a> </li>" + 
					"<li> <a href='" + levelTree + "Responsability/institution.php' class='" + institution + "'>Istituzioni</a> </li>" + 
					"<li> <a href='" + levelTree + "Responsability/responsabilityType.php'>Tipi</a> </li>" + 
				"<ul>" +
			"<li>" +
		"</ul>"
		)

}





