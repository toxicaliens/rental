$('.edit_btn').on('click', function(){
	var edit_id = $(this).attr('edit-id');

	var data = { 'edit_id': edit_id };
	$.ajax({
		url: 'src/system_manager/get_setting_details.php',
		type: 'POST',
		data: data,
		dataType: 'json',
		success: function(data){
			$('#setting_name').val(data['setting_name']);
			$('#setting_value').val(data['setting_value']);
			$('#setting_code').val(data['setting_code']);
			$('#edit_id').val(data['setting_id']);
		}
	});
});

$('.delete_btn').on('click', function(){
	var delete_id = $(this).attr('delete-id');

	var data = { 'edit_id': delete_id };
	$.ajax({
		url: 'src/system_manager/get_setting_details.php',
		type: 'POST',
		data: data,
		dataType: 'json',
		success: function(data){
			$('#setting_name').val(data['setting_name']);
			$('#setting_value').val(data['setting_value']);
			$('#setting_code').val(data['setting_code']);
			$('#delete_id').val(data['setting_id']);
		}
	});
});