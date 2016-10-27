$('.respond').on('click', function(){
	var support_ticket_id = $(this).attr('support_ticket_id');
	var subject = $(this).attr('subject');

	$('#support_ticket_id').val(support_ticket_id);
	$('#subject').val("Ticket#"+support_ticket_id+" "+subject);
    //$('#subject').val(subject);
});
