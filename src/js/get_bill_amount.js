$(document).ready(function(){
	$('#service_bill_id').change(function(){
		var service_bill_id = $(this).val();

		$.post('src/parking_module/get_bill_amount.php', {service_bill_id: service_bill_id}, function(data){
			$('#bill_amount').val(data);
		});
	});

	$('#bill_amount').click(function(){
		var amount = $('#bill_amount').val();
		if(amount == '' || amount == null){
			alert('Select the service bill first');
			$('#service_bill_id').focus();
		}
	});
});