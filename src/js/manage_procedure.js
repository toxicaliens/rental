$('#pro_table > tbody > tr').live('click', function(event){
	if(event.ctrlKey) {
		$(this).toggleClass('info');
	}
	else {
		if ( $(this).hasClass('info') ) {
			$('#pro_table > tbody > tr').removeClass('info');
		}
		else {
			$('#pro_table > tbody > tr').removeClass('info');
			$(this).toggleClass('info');
		}
	}
});

//get the id of the coloumn to delete
$('#pro_table').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#pro_edit_id').val(edit_id);
	$('#pro_delete_id').val(edit_id);

	//prepare to show the dialog
	$('#pro_edit_btn').attr('data-toggle', 'modal');
	$('#pro_delete_btn').attr('data-toggle', 'modal');
	var the_data = {'edit_id': edit_id};

	//get referral details and place then on the edit modal	
	$.ajax({
		type: 'POST',
		url: 'src/visits_module/procedure_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#description').val(data['description']);
		}
	});
});

//validation(check if a row has been selected)
$('#pro_edit_btn').click(function(){
	var edit_id = $('#pro_edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first!');
	}
});

$('#pro_del_btn').click(function(){
	var del_id = $('#pro_delete_id').val();
	if(del_id == ''){
		alert('Please select a record first!');
	}
});

$('#select2_sample21').on('change', function(){
	var rev_id = $(this).val();

	//perform ajax request to retrieve the services attached to the selected revenue channel
	$.ajax({
		url: 'src/visits_module/get_procedure_services.php',
		type: 'POST',
		data: { 'revenue_channel_id': rev_id },
		success: function(data){
			// alert(data);
			if(data == ""){
				alert('No services in the selected revenue channel!');
			}else{
				$('#select2_sample22').html(data);
			}
		}
	});
});