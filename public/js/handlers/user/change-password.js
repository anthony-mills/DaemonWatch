$(document).ready(function() { 
	$(':input[placeholder]').placeholder();
	$("#changePasswordForm").validate({  
		messages: {  
		    newPassword: { 
		        required: "Please enter your new password", 
		    },
		    repeatPassword: { 
		        required: "Please repeat your new password", 
		    },		    	    
		}, 
		errorContainer: '#errorMsg',
        errorLabelContainer: "#errorMsg",
        wrapper: 'li',
	}); 
});
