// JavaScript Document
 
	//initiate validator on load
	$(function() {
		// validate contact form on keyup and submit		
		$("#process_contact").validate({
			//set the rules for the fild names
			rules: {
				name: {
					required: true,
					},
				phone: {
					required: true,
					digits: true,
					minlength: 5
					},
			}				
		});
		
				
		$("#form2").validate({
			//set the rules for the fild names
			rules: {
				comment: {
					required: true
				}
			}				
		});
	});
	