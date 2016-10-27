$('#services_tb > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#services_tb > tbody > tr').removeClass('info');
		}
		else {
			$('#services_tb > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the id
$('#services_tb').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#edit_id').val(edit_id);
	$('#delete_id').val(edit_id);

	//prepare to show the dialog
	$('#edit_btn').attr('data-toggle', 'modal');
	$('#del_btn').attr('data-toggle', 'modal');
	$('#pay_btn').attr('data-toggle', 'modal');
	var the_data = {'edit_id': edit_id};
	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/visits_module/visit_services_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('select.service_chan').val(data['service_channel_id']);
		}
	});
});

//validation(check if a row has been selected)
$('#edit_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first!');
	}
});

$('#del_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first!');
	}
});

var sum = 0;
$('.price').each(function(){
	sum += +$(this).text();
	$('#bill_amount').val(sum);
	$('.total_amount').text('Ksh. '+sum.toFixed(2));
});

$('form #pay_bill').on('submit', function(e){
	var cash_received = $('#cash_received').val();
	var total_paid = 0;

	$('.paid_per_bill').each(function(){
		total_paid += +$(this).val();
	});

	if(cash_received < total_paid){
		alert('The total amount entered for all the bills does not total to the cash received! Please correct! The cash received is: Ksh. '+cash_received+' but total amount per Bill is: Ksh. '+total_paid+'.');
		e.preventDefault();
	}
});

$('form #waiver_form').on('submit', function(e){
	var cash_received = $('#total_waiver_amount').val();
	var total_paid = 0;

	$('.paid_per_bill2').each(function(){
		total_paid += +$(this).val();
	});

	if(cash_received < total_paid){
		alert('The waiver amount entered for all the bills does not total to the total waiver amount! Please correct! The total waiver amount is: Ksh. '+cash_received+' but total amount per Bill is: Ksh. '+total_paid+'.');
		e.preventDefault();
	}
});

// var total_amount = $('#total_amount2').val();
// var total_amount_paid = $('#total_amount_paid').val();
// //calculate balance
// var balance = total_amount - total_amount_paid;
// $('#balance').text('Ksh. '+balance.toFixed(2));

// $('#cash_received').keyup(function(){
// 	var cash_received = $(this).val();

// 	var bill_count = $('#bill_count').val();
// 	var count = 1;
// 	while(count <= bill_count){
// 		var price += -$('.price_per_bill'+count).text();
// 		alert(price)
// 	}
// });

$('#cash_received').keyup(function(){
	var count = 1;
	var cash_received = $(this).val();
	var paid_amount = 0;

	var bill_count = $('#bill_count').val();
	while(count <= bill_count){
		paid_amount = 0;
		var label = 'tag'+count;
		var x = parseInt($('#'+label).attr('max'));
		// alert(x);

		if(cash_received < 1){
			$('#'+label).val(0);
		}else if(cash_received >= x){
			paid_amount = x;
			$('#'+label).val(paid_amount);
		}else{
			paid_amount = cash_received;
			$('#'+label).val(paid_amount);
		}

		cash_received = cash_received - paid_amount;
		count++;
	}
});

$('#total_waiver_amount').keyup(function(){
	var count = 1;
	var cash_received = $(this).val();
	var paid_amount = 0;

	var bill_count = $('#bill_count2').val();
	while(count <= bill_count){
		paid_amount = 0;
		var label = 'tag2'+count;
		var x = parseInt($('#'+label).attr('max'));
		// alert(x);

		if(cash_received < 1){
			$('#'+label).val(0);
		}else if(cash_received >= x){
			paid_amount = x;
			$('#'+label).val(paid_amount);
		}else{
			paid_amount = cash_received;
			$('#'+label).val(paid_amount);
		}

		cash_received = cash_received - paid_amount;
		count++;
	}
});

$('#payment_mode').on('change', function(){
	var mode = $(this).val();

	if(mode == 'Mpesa'){
		$('#mpesa_ref').slideDown('slow');
		$('#slide_mpesa').attr('required', 'required');
	}else{
		$('#mpesa_ref').slideUp('slow');
		$('#slide_mpesa').removeAttr('required');
	}
});