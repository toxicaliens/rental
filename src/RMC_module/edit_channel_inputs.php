<?php
	require '../connection/config.php';
	if(isset($_POST['input_id'])){
		$input_id = $_POST['input_id'];
		$service_id = $_POST['service_id'];
		$data_source = $_POST['data_source'];
		$input_category = $_POST['input_category'];
		$input_type = $_POST['input_type'];
		$input_label = $_POST['input_label'];
		$default_value = $_POST['default_value'];

		$update = "UPDATE service_channel_inputs SET service_id = '".$service_id."', data_source = '".$data_source."', input_category = '".$input_category."', input_type = '".$input_type."', input_label = '".$input_label."', default_value = '".$default_value."' WHERE input_id = '".$input_id."'";
    	if(pg_query($update)){
    		echo "Inputs successfully updated";
    	}else{
    		echo pg_last_error();
    	}
	}
?>