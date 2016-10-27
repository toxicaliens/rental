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

//get the address id
$('.live_table').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#edit_id').val(edit_id);
	$('#delete_id').val(edit_id);

	//prepare to show the dialog
	$('#edit_btn').attr('data-toggle', 'modal');
	$('#del_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};

	//get address details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/masterfile_module/addressDetails.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#postal_address').val(data['postal_address']);
			$('#select2_sample80').val(data['county']);
			$('#town').val(data['town']);
			$('#select2_sample81').val(data['address_type_id']);
			$('#ward').val(data['ward']);
			$('#street').val(data['street']);
			$('#building').val(data['building']);
			$('#house_no').val(data['house_no']);
			$('#phone').val(data['phone']);
			$('#postal_addr').text(data['postal_address']);

		}
	});
});

//validation(check if a row has been selected)
$('#edit_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first');
	}
});

$('#del_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first');
	}
});

