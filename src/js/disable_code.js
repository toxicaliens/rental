$(document).ready(function(){
	$('#service_option_type').change(function(){
        var service= $(this).val();
        if(service=="Branch"){
         $('#code').attr('disabled','disabled');
        }else{
         $('#code').removeAttr('disabled');	
        }
	});
});