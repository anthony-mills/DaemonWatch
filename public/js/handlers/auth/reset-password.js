$(document).ready(function() { 
	$(':input[placeholder]').placeholder();
	$("#resetPasswordForm").validate({  
		messages: {  
		    email: { 
		        required: "Please enter a valid email address", 
		    },	    
		}, 
		errorContainer: '#errorMsg',
        errorLabelContainer: "#errorMsg",
        wrapper: 'li',
	}); 
});
