var fv = new FormValidator();
fv.formInit({
	form: "#add_crm",
	error: "#alert-error",
	success: ".alert-success",
	fields: {
		"surname": { required: true, maxlength: 20 },
		"firstname": { required: true, maxlength: 20 },
		"username": { required: true, maxlength: 20 },
		"password": { required: true, maxlength: 15 },
		"middlename": { maxlength: 20 },
		"national_id_number": { required: true, maxlength: 10, digits: true },
		"phone": { required: true, maxlength: 20, digits: true },
		"balance": { required: true, digits: true },
		"customer_type_id": { required: true, digits: true },
		"email": { required: true },
		"status": { required: true },
		"address_id": { required: true },
		"start_date": { required: true }
	}
});

// Date picker
$('.date-picker').datepicker({
	format: 'yyyy-mm-dd'
});
