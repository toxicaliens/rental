$(document).ready(function(){
	$('#delete_button').click(function(){
		var action_code = $('#action_code').val();
		$('input[name="action"]').attr('value', action_code);
		if(confirm('Are you sure you want to delete?')){
			$('form').submit();
		}else{
			return false;
		}
	});
});