$('.edit_quot').click(function(){
	var quote_id = $(this).attr('edit-id');
	var data = { 'quote_id': quote_id };
	$('#edit_id').val(quote_id);

	if(quote_id != ''){
		$.ajax({
			url: '?num=quotes',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(data){
				$('#bid_amount').val(data['bid_amount']);
				$('#add-maintenance').val(data['maintainance_id']);
			}
		})
	}
});

$('.del_quot').on('click', function(){
	var delete_id = $(this).attr('edit-id');
	$('#delete_id').val(delete_id);
})