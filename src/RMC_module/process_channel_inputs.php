<?php
	require '../connection/config.php';
	if(isset($_POST['service_id'])){
		$service_id = $_POST['service_id'];
		$data_source = $_POST['data_source'];
		$input_category = $_POST['input_category'];
		$input_type = $_POST['input_type'];
		$input_label = $_POST['input_label'];
		$default_value = $_POST['default_value'];

		$query = "INSERT INTO service_channel_inputs(service_id, data_source, input_category, input_type, input_label, default_value)
    VALUES ('".$service_id."', '".$data_source."', '".$input_category."', '".$input_type."',  '".$input_label."', '".$default_value."')";
    	if(pg_query($query)){
    		echo "Inputs successfully added";
    	}else{
    		echo pg_last_error();
    	}
	}
?>