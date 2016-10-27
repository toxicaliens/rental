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

//get the insurance claim id
$('#table1').on('click', 'tr', function() {
	edit_id = $(this).children('td:first').text();
	$('#edit_id').val(edit_id);
	$('#delete_id').val(edit_id);

	//prepare to show the dialog
	$('#edit_type_btn').attr('data-toggle', 'modal');
	$('#delete_claim_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};

	//get insurance claim details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/crm_module/insurance_claim_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#claim_type').val(data['claim_type']);
			$('#case_type').val(data['case_type']);
			$('#claim_date').val(data['claim_date']);
			$('#status').val(data['status']);
			$('#description').val(data['description']);
		}
	});
});

//validation(check if a row has been selected)
$('#edit_type_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first');
	}
});

$('#delete_claim_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first');
	}
});

$('.process_claim').on('click', function(){
	var claim_id = $(this).attr('claim-id');
	var case_type = $(this).attr('case-type');
	var ins_id = $(this).attr('ins_id');
	$('#progression').slideDown('slow');

	var data = { 
		'claim-id': claim_id,
		'case-type': case_type
	};

	if(claim_id != ''){
		$.ajax({
			url: 'src/crm_module/process_claim.php',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(data){
				$('#progression').slideUp('slow');
				if(data['status']){
					$('#success_mes').text(data['success']);
					$('.success_mes').slideDown('slow', function(){
						$(this).delay(5000).slideUp('slow', function(){
							window.location.href = "?num=830&ins_id="+ins_id;
						});
					});
				}else{
					$('#error_message').text(data['fail']);
					$('.error_message').slideDown('slow', function(){
						$(this).delay(5000).slideUp('slow', function(){
							window.location.href = "?num=830&ins_id="+ins_id;
						});
					});
				}
			}
		});
	}
});
