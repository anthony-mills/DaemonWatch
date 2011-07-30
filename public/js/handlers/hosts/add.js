$(document).ready(function() { 
	$(':input[placeholder]').placeholder();
	$("#addHostForm").validate({  
		messages: {  
		    name: { 
		        required: "You are required to provide a name for the host", 
		    },
		    hostName: { 
		        required: "The host needs a hostname or IP address", 
		    },		    	    
		}, 
		errorContainer: '#errorMsg',
        errorLabelContainer: "#errorMsg",
        wrapper: 'li',
	}); 
});