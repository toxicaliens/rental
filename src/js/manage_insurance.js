$('#table1 > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#table1 > tbody > tr').removeClass('info');
		}
		else {
			$('#table1 > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the ailment id
$('#table1').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#edit_id').val(edit_id);

	//prepare to show the dialog
	$('#edit_policy_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};

	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/device_module/insurance_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#insurance_policy').val(data['insurance_policy']);
			$('#insurance_term_in_years').val(data['insurance_term_in_years']);
			$('#start_date').val(data['start_date']);
			$('#status').val(data['status']);
		}
	});
});

//validation(check if a row has been selected)
$('#edit_policy_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first');
	}
});

// getting the mf_id of the customer
$('#select_customer').on('change', function(){
	$('.insuarance_policy').val('');
	var mf_id = $(this).val();
	// alert(mf_id);

	// converting the mf_id into an object
	var data = { 'mf_id': mf_id }

	$.ajax({
		type: 'POST',
		url: 'src/crm_module/get_customer_accounts.php',
		data: data,
		dataType: 'json',
		success: function(data){
			// alert(data.length);
			var html = "<option value=''>--Choose Phone--</option>";
			for (var i = 0; i < data.length; i++) { //loop through all the cusomer accounts
				html += "<option value=\""+ data[i].customer_account_id +"\">"+ data[i].model +" - "+ data[i].imei +"</option>";
			}
			$('#select_phone').html(html);
		}
	});
});

$('#select_phone').on('change', function(){
	var customer_account_id = $(this).val();
	$('.insuarance_policy').val('');
	// alert(customer_account_id);

	var data = { 'customer_account_id': customer_account_id }

	$.ajax({
		type: 'POST',
		url: 'src/crm_module/get_policy_by_model_no.php',
		data: data,
		dataType: 'json',
		success: function(data){
			// alert(data.length);
			$('.insurance_policy, #policy').val(data['service_id']);
		}
	});

});
