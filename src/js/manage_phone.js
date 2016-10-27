$('#table1 > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#table1 > tbody > tr').removeClass('info');
		}
		else {
			$('#table1 > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the ailment id
$('#table1').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#edit_id').val(edit_id);
	$('#delete_id').val(edit_id);

	//prepare to show the dialog
	$('#edit_phone_btn').attr('data-toggle', 'modal');
	$('#del_phone_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};

	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/device_module/phone_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#imei').val(data['imei']);
			$('#issued_phone').val(data['issued_phone_number']);
			$('#edit_id').val(data['customer_account_id']);
		}
	});
});

//validation(check if a row has been selected)
$('#edit_phone_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first');
	}
});

$('#del_phone_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first');
	}
});

$('#select_customer').on('change', function(){
	var mf_id = $(this).val();
	var data = { 'mf_id': mf_id };

	// use ajax to get the customer's referees
	$.ajax({
		url: 'src/device_module/get_customer_id_no.php',
		type: 'POST',
		data: data,
		dataType: 'json',
		success: function(data){
			var html = '';
			if(data != false){
				html = "<option value=\""+ data['referee_mf_id'] +"\">"+ data['referee_name'] +"</option>";
				$('#referee').html(html);
			}else{
				html = "<option value=''>--Choose Referee--</option>";
				$('#referee').html(html);
			}
		}
	});
});