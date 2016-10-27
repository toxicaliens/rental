//get the values of the highlighted row for each td
$('.edit_modal').click(function(){
	$(this).parent().addClass('selected_td');
	$('td.selected_td').parent().addClass('highlighted_row');	

	$('#table1').find('tr.highlighted_row').each(function (i) {
        var $tds = $(this).find('td'),
        rate_card_option_id = $tds.eq(0).text(),
        region_id = $tds.eq(2).text(),
        customer_type_id = $tds.eq(3).text();

        $('#rate_card_option_id').val(rate_card_option_id);
        $('#edit_customer_type_id').val(customer_type_id);
        $('#edit_region_id').val(region_id);
	});

	$('.highlighted_row').removeClass('highlighted_row');
	$('.selected_td').removeClass('selected_td');
});

//get the id for the highlighted row
$('.delete_modal').click(function(){
	$(this).parent().addClass('selected_td');
	$('td.selected_td').parent().addClass('highlighted_row');	

	$('#table1').find('tr.highlighted_row').each(function (i) {
        var $tds = $(this).find('td'),
        rate_card_option_id = $tds.eq(0).text();

        $('#delete_id').val(rate_card_option_id);
	});

	$('.highlighted_row').removeClass('highlighted_row');
	$('.selected_td').removeClass('selected_td');
});

//attach the band Rates
$('#submit').click(function(){
	var rate_card_id = $('#rate_card_id').val();
	var customer_type_id = $('#customer_type_id').val();
	var region_id = $('#region_id').val();

	// alert(customer_type_id+' '+region_id);
	$.post(
		'src/billing_module/attach_rate_card_option.php',
		{
			rate_card_id: rate_card_id,
			region_id: region_id,
			customer_type_id: customer_type_id
		},
		function(data){
			$('.alert-success').removeClass('hide');
			$('#myModal1').removeClass('in');
			$('#myModal1').attr('aria-hidden', 'true');
			$('.modal-backdrop').removeClass('modal-backdrop');
			$('#mess79').text(data);
		}
	);
});

//edit the band Rates
$('#edit_rate_card_option').click(function(){
	var rate_card_option_id = $('#rate_card_option_id').val();
	var customer_type_id = $('#edit_customer_type_id').val();
	var region_id = $('#edit_region_id').val();

	// alert(customer_type_id+' '+region_id);
	$.post(
		'src/billing_module/edit_rate_card_option.php',
		{
			rate_card_option_id: rate_card_option_id,
			region_id: region_id,
			customer_type_id: customer_type_id
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

//edit the band Rates
$('#confirm').click(function(){
	var rate_card_option_id = $('#delete_id').val();

	// alert(rate_card_option_id);
	$.post(
		'src/billing_module/delete_rate_card_option.php',
		{
			rate_card_option_id: rate_card_option_id
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