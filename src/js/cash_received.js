$('input[name="amount_paid"]').keyup(function(){
	// alert('working');
	var bill_amt = parseInt($('input[name="bill_balance"]').val());
	var cash_received = parseInt($(this).val());

	if(cash_received > bill_amt){
		$('#cash').addClass('error');
		$('.help-block').removeClass('hide');
		$('input[type="submit"]').attr('disabled','disabled');
	}else{
		$('.help-block').addClass('hide');
		$('#cash').removeClass('error');
		$('input[type="submit"]').removeAttr('disabled');
	}
});