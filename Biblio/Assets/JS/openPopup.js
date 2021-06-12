
$(document).ready(function(){
	
	$('.selectTitle').change(function(){
		
		//get idSelecttitle for pass level to popup (for blue selected trees)
		var levelString = $(this).attr('id')
		
		var value= $(this).val();
		//key=0 otherAllIds  key=1 id work. Pass idwork
		var key= value.split('-');
		$(".seeCatalogCard").attr("id", "../catalogCard.php?idWork=" + key[1] + "&idlevel=" + key[0] + "&levelName=" + levelString);
		
	})
	
	
	$('.seeCatalogCard').click(function(){
		
		var url= $(this).attr('id')
	
		window.open(url,'win2','status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=1076,height=768,directories=no,location=no')
	
	})
	
});