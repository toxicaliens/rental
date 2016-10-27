//get the values of the highlighted row for each td
$('.edit_modal').click(function(){
	$(this).parent().addClass('selected_td');
	$('td.selected_td').parent().addClass('highlighted_row');	

	$('#table1').find('tr.highlighted_row').each(function (i) {
        var $tds = $(this).find('td'),
        band_rate_id = $tds.eq(0).text(),
        band_from = $tds.eq(2).text(),
        band_to = $tds.eq(3).text(),
        unit_rate = $tds.eq(4).text();

        // alert(band_rate_id+' '+band_from+' '+band_to+' '+unit_rate);
        $('#band_rate_id').val(band_rate_id);
        $('#edit_from').val(band_from);
        $('#edit_to').val(band_to);
        $('#unit_rate97').val(unit_rate);
	});

	$('.selected_td').removeClass('selected_td');
	$('.highlighted_row').removeClass('highlighted_row');
});

$('.delete_modal').click(function(){
	$(this).parent().addClass('selected_td');
	$('td.selected_td').parent().addClass('highlighted_row');	

	$('#table1').find('tr.highlighted_row').each(function (i) {
        var $tds = $(this).find('td'),
        band_rate_id = $tds.eq(0).text();

        // alert(band_rate_id+' '+band_from+' '+band_to+' '+unit_rate);
        $('#delete_id').val(band_rate_id);
	});

	$('.selected_td').removeClass('selected_td');
	$('.highlighted_row').removeClass('highlighted_row');
});

//attach the band Rates
$('#submit').click(function(){
	var rate_card_option_id = $('#rate_card_option_id').val();
	var from = $('#from').val();
	var to = $('#to').val();
	var unit_rate = $('#unit_rate79').val();
	
	$.post(
		'src/billing_module/attach_band_rates.php',
		{
			rate_card_option_id: rate_card_option_id,
			from: from,
			to: to,
			unit_rate, unit_rate
		},
		function(data){
			$('.alert-success').removeClass('hide');
			$('#myModal1').removeClass('in');
			$('#myModal1').attr('aria-hidden', 'true');
			$('.modal-backdrop').removeClass('modal-backdrop');
			$('#mess79').text(data);
		}
	);

	// $.ajax({
	// 	type: 'POST',
	// 	url: 'src/billing_module/attach_band_rates.php',
	// 	data: 'rate_card_option_id' + rate_card_option_id + 'from'+ from + 'to' + to + 'unit_rate' + unit_rate,
	// 	dataType: 'json',
	// 	success: function(){
	// 		$('.alert-success').removeClass('hide');
	// 		$('#myModal1').removeClass('in');
	// 		$('#myModal1').attr('aria-hidden', 'true');
	// 		$('.modal-backdrop').removeClass('modal-backdrop');
	// 		$('#mess79').text('Band Rates have been successfully attached');
	// 	}
	// });
});

//edit the band Rates
$('#edit_band_rates').click(function(){
	var band_rate_id = $('#band_rate_id').val();
	var from = $('#edit_from').val();
	var to = $('#edit_to').val();
	var unit_rate = $('#unit_rate97').val();
	
	$.post(
		'src/billing_module/edit_band_rate.php',
		{
			band_rate_id: band_rate_id,
			from: from,
			to: to,
			unit_rate, unit_rate
		},
		function(data){
			$('.alert-success').removeClass('hide');
			$('#myModal2').removeClass('in');
			$('#myModal2').attr('aria-hidden', 'true');
			$('.modal-backdrop').removeClass('modal-backdrop');
			$('#mess79').text(data);
		}
	);
});

//delete the band Rates
$('#confirm').click(function(){
	var band_rate_id = $('#delete_id').val();
	
	$.post(
		'src/billing_module/delete_band_rate.php',
		{
			band_rate_id: band_rate_id
		},
		function(data){
			$('.alert-success').removeClass('hide');
			$('#myModal3').removeClass('in');
			$('#myModal3').attr('aria-hidden', 'true');
			$('.modal-backdrop').removeClass('modal-backdrop');
			$('#mess79').text(data);
		}
	);
});