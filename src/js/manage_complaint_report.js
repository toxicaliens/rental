$('#table17 > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#table17 > tbody > tr').removeClass('info');
		}
		else {
			$('#table17 > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the symptom id
$('#table17').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();

	$('#edit_id').val(edit_id);
	$('#comp_del_id').val(edit_id);

	//prepare to show the dialog
	$('#comp_edit_btn').attr('data-toggle', 'modal');
	$('#comp_del_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};
	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/visits_module/complaint_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			var count = data.complaints.length;
			for(var i = 0; i <= count; i++){
				var complaint = data.complaints[i];
				$('#select2_sample1').val(complaint);
			}
			$('#desc').val(data['description']);
		}
	});
});

//validation(check if a row has been selected)
$('#comp_edit_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first!');
	}
});

$('#comp_del_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first!');
	}
});

