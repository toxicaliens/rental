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

//get the report id
$('#table1').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#med_edit_id').val(edit_id);
	$('#med_delete_id').val(edit_id);

	//prepare to show the dialog
	$('#med_edit_btn').attr('data-toggle', 'modal');
	$('#med_del_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};
	//get Medical report and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/visits_module/medical_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('.ailment_id').val(data['ailment_id']);
			$('#remarks').val(data['remarks']);
		}
	});
});

//validation(check if a row has been selected)
$('#med_edit_btn').click(function(){
	var edit_id = $('#med_edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first!');
	}
});

$('#med_del_btn').click(function(){
	var del_id = $('#med_delete_id').val();
	if(del_id == ''){
		alert('Please select a record first!');
	}
});
