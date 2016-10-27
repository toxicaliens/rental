$('#rate_type').change(function(){
	var rate_type = $(this).val();

	if(rate_type != 'Fixed'){
		$('#unit_rate').val(0).attr('readonly', 'readonly');
	}else{
		$('#unit_rate').val("").removeAttr('readonly');
	}
});

$('#edit_rate_type').change(function(){
	var rate_type = $(this).val();

	if(rate_type != 'Fixed'){
		$('#edit_unit_rate').val(0).attr('readonly', 'readonly');
	}else{
		$('#edit_unit_rate').val('').removeAttr('readonly');
	}
});