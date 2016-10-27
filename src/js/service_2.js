$('#select2_sample4').on('change', function(){
	var revenue_channel_id = $(this).val();
     // alert('working');
	$.post('src/visits_module/get_services.php', {revenue_channel_id: revenue_channel_id}, function(data){
		if(data != ''){
			$('#select2_sample14').removeAttr('disabled').html(data);
		}else{
			alert('No services in the selected revenue channel');
			$('#select2_sample13').html("");
		}
	});
});