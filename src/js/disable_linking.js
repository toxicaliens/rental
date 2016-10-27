$("#afyapoa_role").change(function(){
	var role = $(this).val();
	
	if (role != 1) {
		$('.link_ro').attr('disabled', 'disabled');
		$('.link_champ').attr('disabled', 'disabled');
		$('.link_super_champ').attr('disabled', 'disabled');
	}else{
		$('.link_ro').removeAttr('disabled');
		$('.link_champ').removeAttr('disabled');
		$('.link_super_champ').removeAttr('disabled');
	}
});