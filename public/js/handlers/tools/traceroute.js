$(document).ready(function() { 
	$(':input[placeholder]').placeholder();
	$("#performTraceroute").validate({  
		messages: {  
		    hostname: { 
		        required: "You need to provide a hostname to trace" 
			}	    	    
		}, 
		errorContainer: '#errorMsg',
        errorLabelContainer: "#errorMsg",
        wrapper: 'li',
	}); 
});
