$(document).ready(function(){
	$('.selected_region').change(function(){
		var region = $(this).val();
	
		$.post('src/parking_module/filter_streets_by_region.php',
		{
			region: region
		},
		function(data){
			$('select.filtered_streets').removeAttr('disabled');
			$('select.filtered_streets').html(data);
		});
	});
});