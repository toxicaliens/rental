$('select#select2_sample2').change(function(){
	var billing_account_id = $(this).val();

	$.post(
		'src/meter_module/populate_customer.php',
		{ billing_account_id: billing_account_id },
		function(data){
			$('select#pop_customer').html(data);
		});

	$.post(
		'src/meter_module/populate_customer_type.php',
		{ billing_account_id: billing_account_id },
		function(data){
			$('select#pop_customer_type').html(data);
		});

	$.post(
		'src/meter_module/get_previous_reading.php',
		{ billing_account_id: billing_account_id },
		function(data){
			$('#previous_reading').val(data);
		});
});

var billing_account_id = $('select#select2_sample2').val();
$.post(
	'src/meter_module/populate_customer.php',
	{ billing_account_id: billing_account_id },
	function(data){
		$('select#pop_customer').html(data);
	});

$.post(
		'src/meter_module/populate_customer_type.php',
		{ billing_account_id: billing_account_id },
		function(data){
			$('select#pop_customer_type').html(data);
		});

