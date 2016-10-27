$(document).ready(function(){
	$('#department_id').change(function(){
		var department_id = $(this).val();
		
		$.post('src/staff_module/filter_jobs.php', { department_id: department_id }, function(data){
			$('#job_options').html(data);
		});
	});

	$('#job_options').click(function(){
		var job_id = $(this).val();
		if(job_id == '' || job_id == null){
			alert('Kindly choose the Department first.');
			$('#department_id').focus();
		}
	});

	var department_id = $('#department_id').val();
	// alert(department_id);
	$.post('src/staff_module/filter_jobs.php', { department_id: department_id }, function(data){
		$('#job_options').html(data);
	});
});