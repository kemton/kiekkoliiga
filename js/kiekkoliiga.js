/**
 * Kiekkoliiga Javascript Library
 * © Kiekkoliiga 2012
 * 
 */

$(document).ready(function(){
	
	// Tabs
	$(function() {
		$( "#tabs" ).tabs({ cookie : 1, cancelSelection : false });
	});
	// Tabs end
	
	// Tablesorter
	$("#tablesorter").tablesorter();
	// Tablesorter end
	
	// Dialog
	$( "#dialog:ui-dialog" ).dialog( "destroy" );	
	$( "#dialog-message" ).dialog({
		resizable: false,
			modal: true,
			width: 460,
		buttons: {
			Ok: function() {
				window.location.replace("/siirto/");
				$( this ).dialog( "close" );
				
			}
		}
	});
	// Dialog end
	
});
