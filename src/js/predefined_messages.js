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
	$('#edit_mess_btn').attr('data-toggle', 'modal');
	$('#del_mess_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};

	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/device_module/getpredefinedmessage.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#pre_message').val(data['predefined_message']);
		}
	});
});

//validation(check if a row has been selected)
$('#edit_mess_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first');
	}
});

$('#del_mess_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first');
	}
});