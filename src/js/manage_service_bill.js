$('#amount_type, #bill_category').on('change', function(){
	var amount_type = $('#amount_type').val();
	var bill_category = $('#bill_category').val();

	if(amount_type == 'Custom' && bill_category == 'Applied'){
		$('#amount').val(0).attr('readonly', 'readonly');
	}
});

$('#bill_category, #amount_type').on('change', function(){
	var amount_type = $('#amount_type').val();
	var bill_category = $('#bill_category').val();

	if(bill_category != 'Applied'){
		$('#amount').val('').removeAttr('readonly');
	}

	if(amount_type != 'Custom'){
		$('#amount').val('').removeAttr('readonly');
	}
});

$('#bill_type').on('change', function(){
	var bill_type = $(this).val();

	if(bill_type == 'Regular'){
		$('#interval').attr('required', 'required').removeAttr('disabled');
	}else{
		$('#interval').attr('disabled', 'disabled').removeAttr('required');
	}
});

$('#revenue_channel').on('change', function(){
	var rev_id = $(this).val();

	if(rev_id != ''){
		$('#service_option').removeAttr('disabled').attr('required', 'required');
	}else{
		$('#service_option').attr('disabled', 'disabled').removeAttr('required');
	}

	var data = { 'rev_id': rev_id }

	//perform ajax and retrieve all the service options attached to the selected revenue channel
	$.ajax({
		url: 'src/RMC_module/get_revenue_service_options.php',
		type: 'POST',
		data: data,
		dataType: 'json',
		success: function(data){
			var html = '';

			//empty the select list
			$('#service_option').empty();
			
			for (var i = 0; i <= data.length; i++) {
				html += "<option value=\""+data[i].service_channel_id+"\">"+data[i].service_option+"</option>";
				$('#service_option').append(html);
			};
		}
	});
});
