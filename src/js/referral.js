$('#ref_table > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#ref_table > tbody > tr').removeClass('info');
		}
		else {
			$('#ref_table > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the id
$('#ref_table').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#ref_edit_id').val(edit_id);
	$('#ref_delete_id').val(edit_id);

	//prepare to show the dialog
	$('#ref_edit_btn').attr('data-toggle', 'modal');
	$('#ref_del_btn').attr('data-toggle', 'modal');
	var the_data = {'edit_id': edit_id};

	//get referral details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/visits_module/referral_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#description').val(data['description']);
		}
	});
});

//validation(check if a row has been selected)
$('#ref_edit_btn').click(function(){
	var edit_id = $('#ref_edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first!');
	}
});

$('#ref_del_btn').click(function(){
	var del_id = $('#ref_delete_id').val();
	if(del_id == ''){
		alert('Please select a record first!');
	}
});