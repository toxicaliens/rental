$('#send_to').on('change', function(){
	var send_to = $(this).val();

	if(send_to == 'Specific'){
		$('#specific').slideDown('slow');
		$('.specific_customers').attr('required', 'required');

		$('#client_group').slideUp('slow');
		$('.client_groups').removeAttr('required');
	}else if(send_to == 'Client Groups'){
		$('#client_group').slideDown('slow');
		$('.client_groups').attr('required', 'required');



		$('#specific').slideUp('slow');
		$('.specific_customers').removeAttr('required');
	}else{
		$('#specific').slideUp('slow');
		$('.specific_customers').removeAttr('required');
	}
});
$('#client_group').on('change',function () {
	var choice = $('#select2_sample3').val();
	switch (choice){
		case 'all_tenants':
			var data = {'action':'all_tenants'}
			$.ajax({
				url:'?num=broadcast',
				dataType:'json',
				type: 'POST',
				data:data,
				success: function (data) {
				// 	$('#client-groups').val(data);
				}
			});
			break;
	}
});

$('#message_type').on('change', function(){
	var message_type = $(this).val();

	if (message_type == 'custom') {
		$('#custom_message').slideDown('slow');
		$('#predefined_message').slideUp('slow');
	}else if(message_type == 'predefined'){
		$('#predefined_message').slideDown('slow');
		$('#custom_message').slideUp('slow');
	};
});