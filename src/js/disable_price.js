$(document).ready(function(){
	$('#service_option_type').change(function(){
        var service = $(this).val();
        if(service=="Branch" || service=="Root"){
            $('#price').attr('readonly','readonly').val(0);
        }else{
            $('#price').removeAttr('readonly');
        }
	});

	var service = $('#service_option_type').val();
	if(service=="Branch" || service=="Root"){
     $('#price').attr('readonly','readonly').val(0);
    }else{
         $('#price').removeAttr('readonly');
    }
});