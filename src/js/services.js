$('#select2_sample3').on('change', function(){
	var revenue_channel_id = $(this).val();
     // alert('working');
	$.post('src/visits_module/get_services.php', {revenue_channel_id: revenue_channel_id}, function(data){
		if(data != ''){
			$('#select2_sample13').removeAttr('disabled').html(data);
		}else{
			alert('No services in the selected revenue channel');
			$('#select2_sample13').html("");
		}
	});
});

$('#table2 > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#table2 > tbody > tr').removeClass('info');
		}
		else {
			$('#table2 > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the symptom id
$('#table2').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#edit_id').val(edit_id);
	$('#delete_id').val(edit_id);

	//prepare to show the dialog
	$('#test_edit_btn').attr('data-toggle', 'modal');
	$('#test_del_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};
	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/visits_module/tests_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			
			$('#revenue_channel_id').val(data['revenue_channel_id']);
			$('#service_id').val(data['service_id']);
			$('#quantity').val(data['quantity']);
			$('#description').val(data['description']);
			$('#results').val(data['results']);
			$('#remarks').val(data['remarks']);			
		}
	});
});

//validation(check if a row has been selected)
$('#test_edit_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first!');
	}
});

$('#test_del_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first!');
	}
});
