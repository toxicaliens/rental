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
	$('#edit_btn').attr('data-toggle', 'modal');
	$('#del_btn').attr('data-toggle', 'modal');

	var the_data = {'edit_id': edit_id};
	//get ailments details and place then on the edit modal
	$.ajax({
		type: 'POST',
		url: 'src/visits_module/visit_details.php',
		data: the_data,
		dataType: 'json',
		success: function(data){
			$('#visit_date').val(data['visit_date']);
			$('#visit_status').val(data['visit_status']);
			$('.patient_mf').val(data['mf_id']);
			$('#visit_type').val(data['visit_type_id']);
			if(data['age_in_months'] != null){
				$('#edit_age_months').val(data['age_in_months']).removeAttr('readonly');;
			}
			if(data['age_in_yrs'] != null){
				$('#edit_age_years').val(data['age_in_yrs']).removeAttr('readonly');
			}
			if(data['b_role'] == 'Customer'){
				$('.edit_policy_no').val(data['customer_policy_no']);
			}else{
				$('.edit_policy_no').val(data['dependant_policy_no']);
			}
		}
	});
});

//validation(check if a row has been selected)
$('#edit_btn').click(function(){
	var edit_id = $('#edit_id').val();
	if(edit_id == ''){
		alert('Please select a record first!');
	}
});

$('#del_btn').click(function(){
	var del_id = $('#delete_id').val();
	if(del_id == ''){
		alert('Please select a record first!');
	}
});

$('#years').click(function(){
	//set the action to the selected option
	$('#selected_option').text('Year(s)');

	//disable the year
	$('#age_months').attr('readonly', 'readonly').removeAttr('required');

	//enable the years field
	$('#age_years').removeAttr('readonly').attr('required', 'required');
});

$('#months').click(function(){
	//set the action to the selected option
	$('#selected_option').text('Month(s)');

	//disable the year
	$('#age_years').attr('readonly', 'readonly').removeAttr('required');

	//enable the years field
	$('#age_months').removeAttr('readonly').attr('required', 'required');
});

$('#edit_years').click(function(){
	//set the action to the selected option
	$('#edit_selected_option').text('Year(s)');

	//disable the year
	$('#edit_age_months').attr('readonly', 'readonly').removeAttr('required');

	//enable the years field
	$('#edit_age_years').removeAttr('readonly').attr('required', 'required');
});

$('#edit_months').click(function(){
	//set the action to the selected option
	$('#edit_selected_option').text('Month(s)');

	//disable the year
	$('#edit_age_years').attr('readonly', 'readonly').removeAttr('required');

	//enable the years field
	$('#edit_age_months').removeAttr('readonly').attr('required', 'required');
});

$('#select2_sample2').on('change', function(){
	var mf_id = $(this).val();
	var b_role = $('option:selected', this).attr('brole');

	var data = { 'mf_id': mf_id, 'b_role': b_role }

	//get the policy no of the selected patient
	$.ajax({
		url: 'src/visits_module/get_policy_no.php',
		type: 'POST',
		data: data,
		dataType: 'json',
		success: function(data){
			$('.add_policy_no').val(data['afyapoa_id']);
		}
	});
});
