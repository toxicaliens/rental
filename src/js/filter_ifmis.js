$(document).ready(function(){
	$('#head_code_id').change(function(){
		var head_code_id = $(this).val();
		
		$.post('src/RMC_module/filter_ifmis.php', { head_code_id: head_code_id }, function(data){
			$('#ifmis_options').html(data);
			// $('#show_query').text(data);
		});
	});

	$('#ifmis_options').click(function(){
		var subcode_id = $(this).val();
		if(subcode_id == '' || subcode_id == null){
			alert('Kindly choose the IFMIS Headcode first.');
			$('#head_code_id').focus();
		}
	});
});