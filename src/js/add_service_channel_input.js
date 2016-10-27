$(document).ready(function(){
	//attach inputs to a service option
	$('#submit').click(function(){
		var service_id = $('#service_id').val();
		var input_category = $('#input_category').val();
		var input_type = $('#input_type').val();
		var input_label = $('#input_label').val();
		var default_value = $('#default_value').val();
		var data_source = $('#data_source').val();

		// alert(service_id+' '+input_category+' '+input_type+' '+input_label+' '+default_value+' '+data_source);
		
		$.post('src/RMC_module/process_channel_inputs.php',
		{
			service_id: service_id,
			data_source: data_source,
			input_category: input_category,
			input_type: input_type,
			input_label: input_label,
			default_value: default_value
		}, 
		function(data){
			$('.alert-success').removeClass('hide');
			$('#myModal1').removeClass('in');
			$('#myModal1').attr('aria-hidden', 'true');
			$('.modal-backdrop').removeClass('modal-backdrop');
			$('#mess79').text(data);
		});
	});

	//get the values of the highlighted row for each td
	$('.edit_modal').click(function(){
		$(this).parent().addClass('selected_td');
			$('td.selected_td').parent().addClass('highlighted_row');	

			$('#table1').find('tr.highlighted_row').each(function (i) {
		        var $tds = $(this).find('td'),
		            input_id = $tds.eq(0).text(),
		            service_id = $tds.eq(1).text(),
		            data_source = $tds.eq(2).text(),
		            input_category = $tds.eq(3).text(),
		            input_type = $tds.eq(4).text(),
		            input_label = $tds.eq(5).text(),
		            default_value = $tds.eq(6).text();

		            $('#input_id2').val(input_id);
		            $('#input_category2').val(input_category);
		            $('#input_type2').val(input_type);
		            $('#data_source2').val(data_source);
		            $('#input_label2').val(input_label);
		            $('#default_value2').val(default_value);
		   
		        // alert(input_id+' '+service_id+' '+input_category+' '+input_type+' '+input_label+' '+default_value+' '+data_source);

			});
	});

	$('.edit_inputs').click(function(){	
		var input_id = $('#input_id2').val();
        var input_category = $('#input_category2').val();
        var input_type = $('#input_type2').val();
        var data_source = $('#data_source2').val();
        var input_label = $('#input_label2').val();
        var default_value = $('#default_value2').val();
        var service_id = $('#service_id2').val();
        
        //alert(input_id+' '+service_id+' '+input_category+' '+input_type+' '+input_label+' '+default_value+' '+data_source);
        // ajax
        $.post('src/RMC_module/edit_channel_inputs.php',
		{
			input_id: input_id,
			service_id: service_id,
			data_source: data_source,
			input_category: input_category,
			input_type: input_type,
			input_label: input_label,
			default_value: default_value
		}, 
		function(data){
			$('.alert-success').removeClass('hide');
			$('#myModal2').removeClass('in');
			$('#myModal2').attr('aria-hidden', 'true');
			$('.modal-backdrop').removeClass('modal-backdrop');
			$('#mess79').text(data);
		});
	});

	$('.delete_modal').click(function(){
		$(this).parent().addClass('selected_td');
		$('td.selected_td').parent().addClass('highlighted_row');	

		$('#table1').find('tr.highlighted_row').each(function (i) {
	        var $tds = $(this).find('td'),
	            input_id = $tds.eq(0).text();

	        $('#delete_id').val(input_id);

		});
	});

	//delete the selected inputs of a service option
	$('#confirm').click(function(){
		var delete_id = $('#delete_id').val();

		$.post('src/RMC_module/delete_channel_inputs.php',
		{
			delete_id: delete_id
		}, 
		function(data){
			$('.alert-success').removeClass('hide');
			$('#myModal3').removeClass('in');
			$('#myModal3').attr('aria-hidden', 'true');
			$('.modal-backdrop').removeClass('modal-backdrop');
			$('#mess79').text(data);
		});
	});
});