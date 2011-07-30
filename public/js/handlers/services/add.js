$(document).ready(function() { 
	$(':input[placeholder]').placeholder();
	$("form select.styled").select_skin();
	$("#addServiceForm").validate({  
		messages: {  
		    name: { 
		        required: "You are required to provide a name for the service", 
		    },
		    port: { 
		        required: "The service needs a port to monitor", 
		        digits: "The service port needs to be a number", 
		        max: "The port number needs to be below 65535", 		        		        
		    },		    	    
		}, 
		errorContainer: '#errorMsg',
        errorLabelContainer: "#errorMsg",
        wrapper: 'li',
	}); 
});