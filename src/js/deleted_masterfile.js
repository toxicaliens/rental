$('.restore_masterfile').on('click', function(){
	var mf_id = $(this).attr('mf_id');
	var data = { 'mf_id': mf_id }

	if(mf_id != ''){
		//perform some ajax to restore masterfile and reactivate login account
		$.ajax({
			url: 'src/masterfile_module/restore_masterfile.php',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function(data){
				if(data['status'] = 1){
					$('#flash').slideDown('slow', function(){
						location.reload(true);
					});
				}else{
					alert('Encountered an error!');
				}
			}
		});
	}
});

$('.delete_masterfile').on('click', function(){
	var mf_id = $(this).attr('mf_id');

	$('#delete_id').val(mf_id);
});