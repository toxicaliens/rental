$('#close_ticket').on('click', function(e){
	e.preventDefault();

	if(confirm('Are you sure you want to close the ticket?')){
		var ticket_id = $(this).attr('ticket_id');
		var recipient = $(this).attr('recipient');
		var customer_account_id = $(this).attr('customer_account_id');

		var data = { 
			'ticket_id': ticket_id, 
			'reported_by': recipient,
			'customer_account_id': customer_account_id
		};

		//perform ajax to close the ticket
		$.ajax({
			url: 'src/support_module/close_ticket.php',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(data){
				if(data['status'] == 1){
					location.reload(true);
				}
			}
		});
	}else{
		return false;
	}
});

$('#open_ticket').on('click', function(e){
	e.preventDefault();

	if(confirm('Are you sure you want to close the ticket?')){
		var ticket_id = $(this).attr('ticket_id');
		var data = { 'ticket_id': ticket_id };

		//perform ajax to close the ticket
		$.ajax({
			url: 'src/support_module/open_ticket.php',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(data){
				if(data['status'] == 1){
					location.reload(true);
				}
			}
		});
	}else{
		return false;
	}
});