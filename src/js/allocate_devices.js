$('.attach_detach').on('click', function(){
	var device_id = $(this).attr('device_id');

	$('#device_id').val(device_id);
});

$('.detach_customer').on('click', function(){
	//get the attached customer name
	var customer_name = $(this).attr('cust_name');
	if(confirm('Are you sure you want to detach('+customer_name+') from the device?')){
		return true;
	}else{
		return false;
	}
});