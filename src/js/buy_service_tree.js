$(document).ready(function(){
	$('a.service_option').click(function(){
		//carried data
		var service_name = $(this).attr('service_name');
		var request_type_id = $(this).attr('req_type_id');
		var price = $(this).attr('price_am');
		var service_id = $(this).attr('serv_id');
		$('#price_label').text('('+service_name+' '+price+')');

		//inputs
		var service_account = $('#service_account').val();
		var cash_paid = $('#cash_paid').val();
		$('#save_payment').click(function(){
			$.post('src/payment_agent_module/save_buyservice_payment.php', { cash_paid: cash_paid,
				request_type_id: request_type_id,
				service_account: service_account,
				service_id: service_id
			}, 
			function(data){
				alert(data);
			});
		});
	});
});