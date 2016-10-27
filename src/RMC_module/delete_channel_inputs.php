<?php
	require '../connection/config.php';
	if(isset($_POST['delete_id'])){
		$delete_id = $_POST['delete_id'];

		$delete = "DELETE FROM service_channel_inputs WHERE input_id = '".$delete_id."'";
    	if(pg_query($delete)){
    		echo "Input has been successfully deleted";
    	}else{
    		echo pg_last_error();
    	}
	}
?>