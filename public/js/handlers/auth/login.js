$(document).ready(function() { 
	$(':input[placeholder]').placeholder();
	$("#userLoginForm").validate({  
		messages: {  
		    email: { 
		        required: "Please enter a valid email address", 
		    },
		    password: { 
		        required: "Please enter your account password", 
		    }		    
		}, 
		errorContainer: '#errorMsg',
        errorLabelContainer: "#errorMsg",
        wrapper: 'li',
	}); 
});
