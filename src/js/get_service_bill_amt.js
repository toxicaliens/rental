$('#service_bill_id').on('change', function(){
	var service_bill_id = $(this).val();
	var data = { 'service_bill_id': service_bill_id };

	// ajax
	$.ajax({
		url: 'src/payment_agent_module/get_service_bill_amt.php',
		type: 'POST',
		data: data,
		dataType: 'json',
		success: function(data){
			$('#bill_amount').val(data['amount']);
		}
	});
});