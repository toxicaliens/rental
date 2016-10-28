<?php
include '../connection/config.php';

$return = array();

if(!empty($_POST['service_id'])){
	$query = "SELECT price FROM service_channels WHERE service_channel_id = '".$_POST['service_id']."' AND service_option_type = 'Leaf'";
	if($result = pg_query($query)){
		if(pg_num_rows($result)){
			$rows = pg_fetch_assoc($result);
			$return = array(
				'price' => $rows['price']
			);
			echo json_encode($return);
		}
	}
}