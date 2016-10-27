$('.attach_detach').on('click', function(){
	var support_ticket_id = $(this).attr('support_ticket_id');

	$('#support_ticket_id').val(support_ticket_id);
});

$('.reassign').on('click', function(){
	var assigned_to = $(this).attr('assigned_to');
	var support_ticket_id = $(this).attr('support_ticket_id');
	
	$('#reass_staff').val(assigned_to);
	$('#origin_staff').val(assigned_to);
	$('#supp_ticket_id').val(support_ticket_id);
});
