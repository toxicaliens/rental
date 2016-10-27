
	$('#plot').change(function(){
		var plot_id = $(this).val();
		
		$.post('src/RMC_module/filter_house.php', { plot_id: plot_id }, function(data){
			$('#house').html(data);
			// $('#show_query').text(data);
		});
	});

	$('#house').click(function(){
		var product_id = $(this).val();
		if(product_id == '' || product_id == null){
			alert('Kindly choose the Plot First.');
			$('#plot').focus();
		}
	});
