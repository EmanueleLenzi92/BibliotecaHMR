
function format_collection( itemOfCollection, typeOfCollection=0, numberOfItems=0 ) {
	//console.log(itemOfCollection)
	var item="";
    if (typeOfCollection == 0) {
        var html="<h2>" + itemOfCollection[0].collectionName + "</h2><ol>";
    } else {
        var html="";
    }
	for(var i=0; i<itemOfCollection.length; i++){
		item=format_item(itemOfCollection[i],0)
				
		if(itemOfCollection[i].level == "item"){
			var idObj= itemOfCollection[i].iditem
			var manifItem= "i"

		} else {
			var idObj= itemOfCollection[i].idmanif
			var manifItem= "m"

		}
		if (typeOfCollection == 0) {
			
			if(numberOfItems==0){
				html += "<li value='"+(itemOfCollection.length  - i)+"'><p id='"+manifItem+"-"+idObj+"'>"+ item +  "</p></li>";
			} else { html += "<li><p id='"+manifItem+"-"+idObj+"'>"+ item +  "</p></li>"; }
	    
		} else {
            html += "<p id='collection-"+manifItem+"-"+idObj+"'>"+ item +  "</p>";
        }
	}
    if (typeOfCollection == 0) {
        html += "</ol>";
    }
	
	return html
}