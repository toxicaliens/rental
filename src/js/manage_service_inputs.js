$('#table9 > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#table9 > tbody > tr').removeClass('info');
		}
		else {
			$('#table9 > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the ailment id
$('#table9').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#edit_id').val(edit_id);
	$('#delete_id').val(edit_id);

	//prepare to show the dialog
	$('#edit_inputs_btn').attr('data-toggle', 'modal');
	$('#del_inputs_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};

	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/RMC_module/service_channel_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#service_id').val(data['service_id']);
			$('#input_category').val(data['input_category']);
			$('#input_type').val(data['input_type']);
			$('#data_source').val(data['data_source']);
			$('#input_label').val(data['input_label']);
			$('#default_value').val(data['default_value']);
		}
	});
});
