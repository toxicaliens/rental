function FormValidator () {
	var form;
	var error;
	var success;
	
	function validSuccess() {
		return (typeof(success) !== "undefined")
	}
	
	function validError() {
		return (typeof(success) !== "undefined");
	}
	
	this.formInit = function (params) {
		form = $(params.form);
		
		if ( typeof(params.error) !== "undefined" )
			error = $(params.error, form);
		
		if ( typeof(params.success) !== "undefined" )
			success = $(params.success, form);
		
		var rules = {};
		for ( var i in params.fields ) {
			rules[i] = params["fields"][i];
		}
		
		// Do the validation
		form.validate({
			errorElement: 'span', //default input error message container
			errorClass: 'help-inline', // default input error message class
			focusInvalid: false, // do not focus the last invalid input
			ignore: "",
			rules: rules,
			
			//display error alert on form submit
			invalidHandler: function (event, validator) {
				if ( validSuccess() ) success.hide();
				if ( validError() ) error.show();
			},
			
			// hightlight error inputs
			highlight: function (element) {
				// display OK icon
				$(element).closest('.help-inline').removeClass('ok');
				
				// set error class to the control group
				$(element).closest('.control-group').removeClass('success').addClass('error'); 
			},
			
			// revert the change done by hightlight
			unhighlight: function (element) {
				// set error class to the control group
				$(element).closest('.control-group').removeClass('error'); 
			},
			
			success: function (label) {
				// mark the current input as valid and display OK icon
				label.addClass('valid').addClass('help-inline ok')
				     .closest('.control-group')
				     .removeClass('error')
				     .addClass('success'); // set success class to the control group
			},
			
			submitHandler: function (form) {
				if ( validSuccess() ) success.show();
				if ( validError() ) error.hide();
				// send form
				form.submit();
			}
		});
	}
};
